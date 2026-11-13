<?php

namespace App\Services;

use App\Models\Chamado;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class EvolutionWhatsAppService
{
    /**
     * Formata um número de telefone brasileiro para o padrão internacional DDI+DDD+Número
     * Exemplo: (51) 99294-1111 -> 5551992941111
     */
    public static function formatPhoneNumber(string $phone): string
    {
        $cleaned = preg_replace('/\D/', '', $phone);
        $cleaned = ltrim($cleaned, '0');

        if (strlen($cleaned) === 10 || strlen($cleaned) === 11) {
            return '55'.$cleaned;
        }

        return $cleaned;
    }

    /**
     * Extrai apenas dígitos válidos de um telefone brasileiro ou JID do WhatsApp
     * Suporta:
     * - 5551992941111:198@s.whatsapp.net (JID Baileys multi-device)
     * - 5551992941111@s.whatsapp.net
     * - (51) 99294-1111
     * - 5551992941111
     * Rejeita identificadores curtos que não são telefones válidos (ex: 198)
     */
    public static function extractPhoneNumber(?string $raw): ?string
    {
        if (empty($raw)) {
            return null;
        }

        $withoutDomain = explode('@', (string) $raw)[0];
        $withoutDevice = explode(':', $withoutDomain)[0];
        $digits = preg_replace('/\D/', '', $withoutDevice);

        if (strlen($digits) >= 10 && strlen($digits) <= 15) {
            return $digits;
        }

        return null;
    }

    /**
     * Retorna a URL base da Evolution API
     */
    protected function getBaseUrl(): string
    {
        return rtrim(config('services.evolution.url', 'https://evolution.piccininidigitalsolutions.com.br'), '/');
    }

    /**
     * Retorna a API Key configurada
     */
    protected function getApiKey(): string
    {
        return config('services.evolution.api_key', '');
    }

    /**
     * Retorna o nome da instância configurada
     */
    protected function getInstanceName(): string
    {
        return config('services.evolution.instance', 'foco_sinalizacao');
    }

    /**
     * Retorna o número de WhatsApp atualmente conectado na instância com fallback seguro
     */
    public function getConnectedNumber(): string
    {
        $instance = $this->getInstanceName();
        $cacheKey = "evolution_connected_number_{$instance}";

        if ($cached = cache()->get($cacheKey)) {
            $extracted = self::extractPhoneNumber((string) $cached);
            if ($extracted) {
                return self::formatPhoneNumber($extracted);
            }
            cache()->forget($cacheKey);
        }

        $state = $this->getConnectionState();
        if (! empty($state['ownerNumber'])) {
            $extracted = self::extractPhoneNumber((string) $state['ownerNumber']);
            if ($extracted) {
                $formatted = self::formatPhoneNumber($extracted);
                cache()->put($cacheKey, $formatted, now()->addMinutes(15));

                return $formatted;
            }
        }

        // Fallback seguro para o número oficial da FOCO caso ainda não tenha sido detectado dinamicamente
        $fallback = config('services.evolution.admin_number') ?: env('WHATSAPP_ADMIN_NUMBER', '5551992941111');

        return self::formatPhoneNumber($fallback);
    }

    /**
     * Retorna a lista de números de administradores que devem receber as notificações de novos chamados.
     * Prioridade:
     * 1. Número(s) definidos em WHATSAPP_ADMIN_NUMBER no .env (suporta múltiplos separados por vírgula)
     * 2. Número atualmente conectado no WhatsApp da instância (se houver)
     * 3. Fallback oficial cadastrado
     *
     * @return array<int, string>
     */
    public function getAdminRecipients(): array
    {
        $configured = config('services.evolution.admin_number') ?: env('WHATSAPP_ADMIN_NUMBER');

        $recipients = [];
        if (! empty($configured)) {
            $parts = explode(',', (string) $configured);
            foreach ($parts as $part) {
                $trimmed = trim($part);
                if (! empty($trimmed)) {
                    $formatted = self::formatPhoneNumber($trimmed);
                    if (strlen($formatted) >= 10) {
                        $recipients[] = $formatted;
                    }
                }
            }
        }

        if (empty($recipients)) {
            $connected = $this->getConnectedNumber();
            if (! empty($connected)) {
                $recipients[] = $connected;
            }
        }

        return array_values(array_unique($recipients));
    }

    /**
     * Verifica o estado de conexão da instância na Evolution API
     */
    public function getConnectionState(): array
    {
        $apiKey = $this->getApiKey();
        $instance = $this->getInstanceName();
        $baseUrl = $this->getBaseUrl();

        if (empty($apiKey)) {
            return [
                'configured' => false,
                'connected' => false,
                'state' => 'disconnected',
                'instance' => $instance,
                'message' => 'Chave EVOLUTION_API_KEY não configurada no .env',
            ];
        }

        try {
            $response = Http::timeout(6)
                ->withHeaders([
                    'apikey' => $apiKey,
                ])
                ->get("{$baseUrl}/instance/connectionState/{$instance}");

            if ($response->successful()) {
                $data = $response->json();
                $state = $data['instance']['state'] ?? $data['state'] ?? $data['connectionStatus'] ?? 'close';
                $isConnected = strtolower($state) === 'open';

                $info = [
                    'configured' => true,
                    'connected' => $isConnected,
                    'state' => $state,
                    'instance' => $instance,
                ];

                // Verifica se o endpoint connectionState já informou o owner
                $rawStateOwner = $data['instance']['ownerJid'] ?? $data['instance']['owner'] ?? $data['ownerJid'] ?? $data['owner'] ?? null;
                if ($extractedOwner = self::extractPhoneNumber($rawStateOwner)) {
                    $formattedOwner = self::formatPhoneNumber($extractedOwner);
                    $info['ownerNumber'] = $formattedOwner;
                    cache()->put("evolution_connected_number_{$instance}", $formattedOwner, now()->addMinutes(15));
                }

                // Se estiver conectado e ainda não temos o número, busca no fetchInstances
                if ($isConnected && empty($info['ownerNumber'])) {
                    $instResponse = Http::timeout(5)
                        ->withHeaders(['apikey' => $apiKey])
                        ->get("{$baseUrl}/instance/fetchInstances", [
                            'instanceName' => $instance,
                        ]);

                    if ($instResponse->successful()) {
                        $instances = $instResponse->json();
                        $target = null;

                        if (is_array($instances)) {
                            // Procura a instância com o nome exato desta aplicação
                            foreach ($instances as $item) {
                                if (! is_array($item)) {
                                    continue;
                                }
                                $instData = $item['instance'] ?? $item;
                                $name = $instData['instanceName'] ?? $instData['name'] ?? $item['name'] ?? $item['instanceName'] ?? null;
                                if ($name === $instance) {
                                    $target = $instData;
                                    break;
                                }
                            }
                        }

                        if ($target) {
                            $info['profileName'] = $target['profileName'] ?? $target['name'] ?? null;
                            $info['profilePictureUrl'] = $target['profilePictureUrl'] ?? $target['profilePicUrl'] ?? null;

                            $candidates = [
                                $target['ownerJid'] ?? null,
                                $target['owner'] ?? null,
                                $target['wuid'] ?? null,
                                $target['instance']['ownerJid'] ?? null,
                                $target['instance']['owner'] ?? null,
                                $target['instance']['wuid'] ?? null,
                            ];

                            foreach ($candidates as $cand) {
                                if ($extracted = self::extractPhoneNumber($cand)) {
                                    $formatted = self::formatPhoneNumber($extracted);
                                    $info['ownerNumber'] = $formatted;
                                    cache()->put("evolution_connected_number_{$instance}", $formatted, now()->addMinutes(15));
                                    break;
                                }
                            }

                            if (empty($info['ownerNumber'])) {
                                $numCand = $target['number'] ?? $target['instance']['number'] ?? null;
                                if ($extracted = self::extractPhoneNumber($numCand)) {
                                    $formatted = self::formatPhoneNumber($extracted);
                                    $info['ownerNumber'] = $formatted;
                                    cache()->put("evolution_connected_number_{$instance}", $formatted, now()->addMinutes(15));
                                }
                            }
                        }
                    }
                }

                return $info;
            }

            // Se a instância ainda não existe (404), informa para gerar
            return [
                'configured' => true,
                'connected' => false,
                'state' => 'not_found',
                'instance' => $instance,
                'message' => 'Instância ainda não criada ou offline.',
            ];
        } catch (\Throwable $e) {
            Log::warning("Evolution API: Erro ao verificar estado da instância {$instance}: ".$e->getMessage());

            return [
                'configured' => true,
                'connected' => false,
                'state' => 'error',
                'instance' => $instance,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Cria a instância na Evolution API se ela ainda não existir
     */
    public function createInstanceIfNotExists(): array
    {
        $apiKey = $this->getApiKey();
        $instance = $this->getInstanceName();
        $baseUrl = $this->getBaseUrl();

        if (empty($apiKey)) {
            return ['success' => false, 'message' => 'API Key não configurada.'];
        }

        try {
            $response = Http::timeout(8)
                ->withHeaders([
                    'apikey' => $apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post("{$baseUrl}/instance/create", [
                    'instanceName' => $instance,
                    'qrcode' => true,
                    'integration' => 'WHATSAPP-BAILEYS',
                ]);

            return [
                'success' => $response->successful(),
                'status' => $response->status(),
                'data' => $response->json(),
            ];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Obtém o QR Code em base64 da Evolution API para o cliente escanear
     */
    public function getQrCode(): array
    {
        $apiKey = $this->getApiKey();
        $instance = $this->getInstanceName();
        $baseUrl = $this->getBaseUrl();

        if (empty($apiKey)) {
            return [
                'configured' => false,
                'connected' => false,
                'qrcode' => null,
                'message' => 'EVOLUTION_API_KEY ausente no .env',
            ];
        }

        // 1. Garante que a instância exista
        $this->createInstanceIfNotExists();

        try {
            // 2. Chama o endpoint de conexão para obter o QR Code
            $response = Http::timeout(10)
                ->withHeaders([
                    'apikey' => $apiKey,
                ])
                ->get("{$baseUrl}/instance/connect/{$instance}");

            if ($response->successful()) {
                $data = $response->json();

                // Verifica se já está conectado
                $state = $data['instance']['state'] ?? $data['state'] ?? null;
                if (strtolower((string) $state) === 'open') {
                    return [
                        'configured' => true,
                        'connected' => true,
                        'state' => 'open',
                        'qrcode' => null,
                    ];
                }

                // Extrai o base64 do QR code
                $base64 = $data['base64']
                    ?? $data['qrcode']['base64']
                    ?? $data['instance']['qrcode']
                    ?? null;

                if ($base64 && ! str_starts_with($base64, 'data:image')) {
                    $base64 = 'data:image/png;base64,'.$base64;
                }

                $code = $data['code'] ?? $data['pairingCode'] ?? null;

                return [
                    'configured' => true,
                    'connected' => false,
                    'state' => 'connecting',
                    'qrcode' => $base64,
                    'code' => $code,
                ];
            }

            return [
                'configured' => true,
                'connected' => false,
                'qrcode' => null,
                'error' => $response->body(),
            ];
        } catch (\Throwable $e) {
            Log::error('Evolution API: Erro ao obter QR Code: '.$e->getMessage());

            return [
                'configured' => true,
                'connected' => false,
                'qrcode' => null,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Desconecta o WhatsApp (logout da sessão) para poder escanear outro aparelho
     */
    public function logout(): array
    {
        $apiKey = $this->getApiKey();
        $instance = $this->getInstanceName();
        $baseUrl = $this->getBaseUrl();

        cache()->forget("evolution_connected_number_{$instance}");

        if (empty($apiKey)) {
            return ['success' => false, 'message' => 'API Key não configurada.'];
        }

        try {
            $response = Http::timeout(8)
                ->withHeaders([
                    'apikey' => $apiKey,
                ])
                ->delete("{$baseUrl}/instance/logout/{$instance}");

            return [
                'success' => $response->successful(),
                'data' => $response->json(),
            ];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Envia uma mensagem de texto usando a Evolution API instalada na VPS Hostinger
     * O envio é feito SEMPRE a partir do número conectado na instância.
     */
    public function sendMessage(string $number, string $text): array
    {
        $baseUrl = $this->getBaseUrl();
        $apiKey = $this->getApiKey();
        $instance = $this->getInstanceName();

        $formattedNumber = self::formatPhoneNumber($number);

        // Se o número não tiver formato válido de telefone (mínimo 10 dígitos)
        if (strlen($formattedNumber) < 10) {
            Log::warning("Evolution API: Número inválido para envio: '{$number}' (formatado: '{$formattedNumber}')");

            return [
                'success' => false,
                'error' => "Número de WhatsApp inválido ('{$number}'). Informe um telefone válido com DDD (ex: 51992941111).",
            ];
        }

        // Se a chave de API ainda não foi preenchida no .env, registra em log e não trava a aplicação
        if (empty($apiKey)) {
            Log::info("Evolution API: Chave não configurada no .env. Simulação de envio para {$formattedNumber}: ".substr($text, 0, 80).'...');

            return [
                'success' => false,
                'simulated' => true,
                'message' => 'API Key não configurada no .env',
            ];
        }

        $endpoint = "{$baseUrl}/message/sendText/{$instance}";

        try {
            $response = Http::timeout(12)
                ->withHeaders([
                    'apikey' => $apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($endpoint, [
                    'number' => $formattedNumber,
                    'text' => $text,
                    'textMessage' => [
                        'text' => $text,
                    ],
                    'options' => [
                        'delay' => 1200,
                        'presence' => 'composing',
                        'linkPreview' => true,
                    ],
                ]);

            if ($response->successful()) {
                Log::info("Evolution API: Mensagem enviada com sucesso para {$formattedNumber} via instância '{$instance}'");

                return [
                    'success' => true,
                    'response' => $response->json(),
                ];
            }

            Log::warning("Evolution API: Erro HTTP {$response->status()} ao enviar para {$formattedNumber}: ".$response->body());

            return [
                'success' => false,
                'status' => $response->status(),
                'error' => $response->body(),
            ];
        } catch (\Throwable $e) {
            Log::error("Evolution API: Exceção ao enviar mensagem para {$formattedNumber}: ".$e->getMessage());

            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Dispara alerta de novo chamado no WhatsApp conectado do dono da FOCO
     */
    public function notificarNovoChamado(Chamado $chamado): array
    {
        $recipients = $this->getAdminRecipients();

        if (empty($recipients)) {
            Log::info('Evolution API: Nenhum número de administrador configurado ou conectado no momento para receber alerta de novo chamado.');

            return [
                'success' => false,
                'message' => 'Nenhum WhatsApp conectado ou configurado no momento.',
            ];
        }

        $horaAbertura = $chamado->data_hora_abertura
            ? $chamado->data_hora_abertura->format('d/m/Y H:i')
            : now()->format('d/m/Y H:i');

        $urlGerenciador = route('admin.chamados.show', $chamado->id);

        $mensagem = "🚨 *NOVO CHAMADO REGISTRADO - FOCO SINALIZAÇÃO*\n\n"
            ."📋 *Protocolo:* `{$chamado->protocolo}`\n"
            ."🚦 *Tipo de Ocorrência:* *{$chamado->tipo}*\n"
            ."👤 *Solicitante:* {$chamado->nome_solicitante}\n"
            ."📱 *Contato:* {$chamado->telefone_contato}\n"
            ."📍 *Local:* {$chamado->local}\n"
            ."⚠️ *Defeito Informado:* {$chamado->defeito}\n"
            ."⏰ *Horário de Abertura:* {$horaAbertura}\n";

        if (! empty($chamado->observacao)) {
            $mensagem .= "📝 *Observação:* {$chamado->observacao}\n";
        }

        $mensagem .= "\n🔗 *Atender no Gerenciador:* {$urlGerenciador}\n\n"
            .'_Central Operacional Automática - FOCO Sinalização_';

        $lastResult = ['success' => false];
        foreach ($recipients as $recipient) {
            $lastResult = $this->sendMessage($recipient, $mensagem);
        }

        return $lastResult;
    }

    /**
     * Dispara notificação no WhatsApp do solicitante informando que o chamado foi CONCLUÍDO
     * (Enviado a partir do WhatsApp conectado do cliente)
     */
    public function notificarChamadoConcluido(Chamado $chamado): array
    {
        $numeroSolicitante = $chamado->telefone_contato;
        $horaConclusao = $chamado->data_hora_execucao
            ? $chamado->data_hora_execucao->format('d/m/Y H:i')
            : now()->format('d/m/Y H:i');

        $conserto = $chamado->conserto_executado ?: 'Conserto e calibração semafórica executados com êxito em conformidade técnica.';
        $tecnico = $chamado->tecnico_responsavel ?: 'Equipe de Manutenção FOCO';

        $mensagem = "✅ *CHAMADO CONCLUÍDO COM SUCESSO!*\n\n"
            ."Olá, *{$chamado->nome_solicitante}*!\n\n"
            ."Informamos que a sua solicitação sob o protocolo *{$chamado->protocolo}* foi *FINALIZADA E CONCLUÍDA* pela nossa equipe técnica em campo.\n\n"
            ."📌 *Resumo do Atendimento:*\n"
            ."🚦 *Tipo:* {$chamado->tipo}\n"
            ."📍 *Local:* {$chamado->local}\n"
            ."🛠️ *Conserto Executado:* {$conserto}\n"
            ."⏰ *Horário de Execução:* {$horaConclusao}\n"
            ."👷 *Técnico Responsável:* {$tecnico}\n";

        if (! empty($chamado->observacao_finalizacao)) {
            $mensagem .= "📝 *Observações:* {$chamado->observacao_finalizacao}\n";
        }

        $mensagem .= "\nVocê pode acompanhar e emitir o laudo no site:\n"
            .route('site.chamados', ['protocolo' => $chamado->protocolo])."\n\n"
            ."Agradecemos pela colaboração com a segurança viária da nossa cidade!\n"
            .'🟢 *FOCO Sinalização e Sistemas Inteligentes LTDA*';

        return $this->sendMessage($numeroSolicitante, $mensagem);
    }
}

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

        if (strlen($cleaned) === 10 || strlen($cleaned) === 11) {
            return '55' . $cleaned;
        }

        return $cleaned;
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

                // Se estiver conectado, tenta obter dados adicionais do perfil conectado
                if ($isConnected) {
                    $instResponse = Http::timeout(5)
                        ->withHeaders(['apikey' => $apiKey])
                        ->get("{$baseUrl}/instance/fetchInstances", [
                            'instanceName' => $instance,
                        ]);

                    if ($instResponse->successful()) {
                        $instances = $instResponse->json();
                        $target = is_array($instances) && isset($instances[0]) ? $instances[0] : $instances;
                        $info['profileName'] = $target['profileName'] ?? $target['owner'] ?? null;
                        $info['profilePictureUrl'] = $target['profilePictureUrl'] ?? null;
                        $info['ownerNumber'] = $target['owner'] ?? null;
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
            Log::warning("Evolution API: Erro ao verificar estado da instância {$instance}: " . $e->getMessage());
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

                if ($base64 && !str_starts_with($base64, 'data:image')) {
                    $base64 = 'data:image/png;base64,' . $base64;
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
            Log::error("Evolution API: Erro ao obter QR Code: " . $e->getMessage());
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
     */
    public function sendMessage(string $number, string $text): array
    {
        $baseUrl = $this->getBaseUrl();
        $apiKey = $this->getApiKey();
        $instance = $this->getInstanceName();

        $formattedNumber = self::formatPhoneNumber($number);

        // Se a chave de API ainda não foi preenchida no .env, registra em log e não trava a aplicação
        if (empty($apiKey)) {
            Log::info("Evolution API: Chave não configurada no .env. Simulação de envio para {$formattedNumber}: " . substr($text, 0, 80) . '...');
            return [
                'success' => false,
                'simulated' => true,
                'message' => 'API Key não configurada no .env',
            ];
        }

        $endpoint = "{$baseUrl}/message/sendText/{$instance}";

        try {
            $response = Http::timeout(10)
                ->withHeaders([
                    'apikey' => $apiKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($endpoint, [
                    'number' => $formattedNumber,
                    'text' => $text,
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

            Log::warning("Evolution API: Erro HTTP {$response->status()} ao enviar para {$formattedNumber}: " . $response->body());
            return [
                'success' => false,
                'status' => $response->status(),
                'error' => $response->body(),
            ];
        } catch (\Throwable $e) {
            Log::error("Evolution API: Exceção ao enviar mensagem para {$formattedNumber}: " . $e->getMessage());
            return [
                'success' => false,
                'error' => $e->getMessage(),
            ];
        }
    }

    /**
     * Dispara alerta de novo chamado no WhatsApp do dono da FOCO (Administrador)
     */
    public function notificarNovoChamado(Chamado $chamado): array
    {
        $adminNumber = config('services.evolution.admin_number', '5551992941111');
        $horaAbertura = $chamado->data_hora_abertura 
            ? $chamado->data_hora_abertura->format('d/m/Y H:i') 
            : now()->format('d/m/Y H:i');

        $urlGerenciador = route('admin.chamados.show', $chamado->id);

        $mensagem = "🚨 *NOVO CHAMADO REGISTRADO - FOCO SINALIZAÇÃO*\n\n"
            . "📋 *Protocolo:* `{$chamado->protocolo}`\n"
            . "🚦 *Tipo de Ocorrência:* *{$chamado->tipo}*\n"
            . "👤 *Solicitante:* {$chamado->nome_solicitante}\n"
            . "📱 *Contato:* {$chamado->telefone_contato}\n"
            . "📍 *Local:* {$chamado->local}\n"
            . "⚠️ *Defeito Informado:* {$chamado->defeito}\n"
            . "⏰ *Horário de Abertura:* {$horaAbertura}\n";

        if (!empty($chamado->observacao)) {
            $mensagem .= "📝 *Observação:* {$chamado->observacao}\n";
        }

        $mensagem .= "\n🔗 *Atender no Gerenciador:* {$urlGerenciador}\n\n"
            . "_Central Operacional Automática - FOCO Sinalização_";

        return $this->sendMessage($adminNumber, $mensagem);
    }

    /**
     * Dispara notificação no WhatsApp do solicitante informando que o chamado foi CONCLUÍDO
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
            . "Olá, *{$chamado->nome_solicitante}*!\n\n"
            . "Informamos que a sua solicitação sob o protocolo *{$chamado->protocolo}* foi *FINALIZADA E CONCLUÍDA* pela nossa equipe técnica em campo.\n\n"
            . "📌 *Resumo do Atendimento:*\n"
            . "🚦 *Tipo:* {$chamado->tipo}\n"
            . "📍 *Local:* {$chamado->local}\n"
            . "🛠️ *Conserto Executado:* {$conserto}\n"
            . "⏰ *Horário de Execução:* {$horaConclusao}\n"
            . "👷 *Técnico Responsável:* {$tecnico}\n";

        if (!empty($chamado->observacao_finalizacao)) {
            $mensagem .= "📝 *Observações:* {$chamado->observacao_finalizacao}\n";
        }

        $mensagem .= "\nVocê pode acompanhar e emitir o laudo no site:\n"
            . route('site.chamados', ['protocolo' => $chamado->protocolo]) . "\n\n"
            . "Agradecemos pela colaboração com a segurança viária da nossa cidade!\n"
            . "🟢 *FOCO Sinalização e Sistemas Inteligentes LTDA*";

        return $this->sendMessage($numeroSolicitante, $mensagem);
    }
}

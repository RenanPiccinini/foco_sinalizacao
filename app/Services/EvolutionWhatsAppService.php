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
        // Remove qualquer caractere que não seja número
        $cleaned = preg_replace('/\D/', '', $phone);

        // Se tiver 10 ou 11 dígitos (DDD + número), adiciona o DDI do Brasil (55)
        if (strlen($cleaned) === 10 || strlen($cleaned) === 11) {
            return '55' . $cleaned;
        }

        return $cleaned;
    }

    /**
     * Envia uma mensagem de texto usando a Evolution API instalada na VPS Hostinger
     */
    public function sendMessage(string $number, string $text): array
    {
        $baseUrl = config('services.evolution.url', 'https://evolution.piccininidigitalsolutions.com.br');
        $apiKey = config('services.evolution.api_key', '');
        $instance = config('services.evolution.instance', 'foco_sinalizacao');

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

        $endpoint = rtrim($baseUrl, '/') . "/message/sendText/{$instance}";

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

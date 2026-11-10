<?php

namespace App\Services;

use App\Mail\NovaSolicitacaoContatoMail;
use App\Models\Contato;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class OrcamentoMailerService
{
    /**
     * Envia o e-mail de nova solicitação/orçamento para a caixa configurada.
     *
     * @return array{success: bool, message: string}
     */
    public function enviarSolicitacao(Contato $contato): array
    {
        $destinatario = $this->resolverDestinatario();

        if (! $destinatario) {
            $msg = 'Nenhum destinatário configurado em MAIL_DEMANDAS_ADDRESS ou MAIL_FROM_ADDRESS.';
            $this->registrarDiagnostico('erro', $msg, $contato->protocolo);

            return ['success' => false, 'message' => $msg];
        }

        $mailable = new NovaSolicitacaoContatoMail($contato);

        return $this->enviarComFallback(
            $destinatario,
            fn (Mailer $mailer) => $mailer->to($destinatario)->send($mailable),
            fn () => Mail::to($destinatario)->send($mailable),
            $contato->protocolo
        );
    }

    /**
     * Envia um e-mail de teste SMTP e retorna o resultado detalhado.
     *
     * @return array{success: bool, message: string}
     */
    public function enviarTeste(): array
    {
        $mailer = (string) config('mail.default');
        $destinatario = $this->resolverDestinatario();

        if ($mailer === 'log') {
            $msg = 'O sistema ainda está com MAIL_MAILER=log no .env (modo simulação). Altere para MAIL_MAILER=smtp, informe MAIL_PASSWORD entre aspas simples no .env e clique em "Recarregar .env".';
            $this->registrarDiagnostico('aviso', $msg);

            return ['success' => false, 'message' => $msg];
        }

        if (! $destinatario) {
            $msg = 'Nenhum destinatário configurado em MAIL_DEMANDAS_ADDRESS ou MAIL_FROM_ADDRESS.';
            $this->registrarDiagnostico('erro', $msg);

            return ['success' => false, 'message' => $msg];
        }

        $corpo = "Teste de conexão SMTP Hostinger — FOCO Sinalização.\n\n"
            ."Se você recebeu este e-mail em {$destinatario}, o envio automático dos orçamentos e contatos do site está funcionando corretamente.\n\n"
            .'Data/Hora: '.now()->format('d/m/Y H:i:s');

        $assunto = '[TESTE SMTP] FOCO Sinalização - E-mail Configurado';

        return $this->enviarComFallback(
            $destinatario,
            fn (Mailer $customMailer) => $customMailer->raw($corpo, function ($message) use ($destinatario, $assunto): void {
                $message->to($destinatario)->subject($assunto);
            }),
            fn () => Mail::raw($corpo, function ($message) use ($destinatario, $assunto): void {
                $message->to($destinatario)->subject($assunto);
            }),
        );
    }

    /**
     * Retorna o último status de envio registrado pelo sistema.
     *
     * @return array{status: string, mensagem: string, protocolo: string|null, registrado_em: string}|null
     */
    public function obterUltimoDiagnostico(): ?array
    {
        $path = $this->caminhoDiagnostico();

        if (! is_file($path)) {
            return null;
        }

        $conteudo = @file_get_contents($path);
        if (! is_string($conteudo) || $conteudo === '') {
            return null;
        }

        $dados = json_decode($conteudo, true);

        return is_array($dados) ? $dados : null;
    }

    /**
     * Executa o envio principal e aplica fallback automático entre as portas Hostinger (465 <-> 587).
     *
     * @return array{success: bool, message: string}
     */
    private function enviarComFallback(
        string $destinatario,
        callable $envioCustomMailer,
        callable $envioPadrao,
        ?string $protocolo = null
    ): array {
        $mailerAtivo = (string) config('mail.default');
        $host = (string) config('mail.mailers.smtp.host');
        $porta = (int) config('mail.mailers.smtp.port');

        if ($mailerAtivo === 'log') {
            Log::warning('MAIL_MAILER está em modo log: o e-mail foi salvo apenas no arquivo de log.', [
                'protocolo' => $protocolo,
                'destinatario' => $destinatario,
            ]);
            $envioPadrao();
            $msg = 'E-mail registrado apenas no log local porque MAIL_MAILER=log está ativo no .env.';
            $this->registrarDiagnostico('aviso', $msg, $protocolo);

            return ['success' => true, 'message' => $msg];
        }

        try {
            $envioPadrao();

            $msg = "E-mail enviado com sucesso para {$destinatario} (porta {$porta}).";
            $this->registrarDiagnostico('sucesso', $msg, $protocolo);

            return ['success' => true, 'message' => $msg];
        } catch (Throwable $erroPrincipal) {
            if ($this->deveTentarPortaAlternativa($mailerAtivo, $host, $porta, $erroPrincipal)) {
                $portaAlternativa = $porta === 465 ? 587 : 465;
                $schemeAlternativo = $portaAlternativa === 465 ? 'smtps' : 'smtp';

                try {
                    $fallbackMailer = $this->criarMailerSmtp($host, $portaAlternativa, $schemeAlternativo);
                    $envioCustomMailer($fallbackMailer);

                    $msg = "E-mail enviado para {$destinatario} via porta alternativa {$portaAlternativa} ({$schemeAlternativo}). Recomenda-se atualizar MAIL_PORT={$portaAlternativa} e MAIL_SCHEME={$schemeAlternativo} no .env.";
                    $this->registrarDiagnostico('sucesso', $msg, $protocolo);

                    return ['success' => true, 'message' => $msg];
                } catch (Throwable $erroFallback) {
                    $erroPrincipal = $erroFallback;
                }
            }

            $mensagemErro = $this->formatarErroSmtp($host, $porta, $erroPrincipal);

            Log::error('Falha ao enviar e-mail SMTP.', [
                'protocolo' => $protocolo,
                'destinatario' => $destinatario,
                'host' => $host,
                'port' => $porta,
                'erro' => $erroPrincipal->getMessage(),
            ]);

            $this->registrarDiagnostico('erro', $mensagemErro, $protocolo);

            return ['success' => false, 'message' => $mensagemErro];
        }
    }

    /**
     * Define se vale tentar a porta alternativa da Hostinger quando a porta principal falha na conexão/TLS.
     */
    private function deveTentarPortaAlternativa(string $mailer, string $host, int $porta, Throwable $erro): bool
    {
        if ($mailer !== 'smtp' || ! in_array($porta, [465, 587], true)) {
            return false;
        }

        if (! str_contains(strtolower($host), 'hostinger')) {
            return false;
        }

        // Erros 535 de autenticação indicam usuário/senha incorretos; trocar porta não resolve.
        if (str_contains($erro->getMessage(), '535') || str_contains(strtolower($erro->getMessage()), 'authentication')) {
            return false;
        }

        return true;
    }

    /**
     * Constrói um Mailer SMTP on-demand para tentativa na porta alternativa.
     */
    private function criarMailerSmtp(string $host, int $porta, string $scheme): Mailer
    {
        $mailer = Mail::build([
            'transport' => 'smtp',
            'scheme' => $scheme,
            'host' => $host,
            'port' => $porta,
            'username' => config('mail.mailers.smtp.username'),
            'password' => config('mail.mailers.smtp.password'),
            'timeout' => (int) config('mail.mailers.smtp.timeout', 15),
            'verify_peer' => (bool) config('mail.mailers.smtp.verify_peer', true),
            'local_domain' => config('mail.mailers.smtp.local_domain'),
        ]);

        $fromAddress = (string) config('mail.from.address');
        $fromName = (string) config('mail.from.name');
        if ($fromAddress !== '') {
            $mailer->alwaysFrom($fromAddress, $fromName);
        }

        return $mailer;
    }

    /**
     * Formata mensagem técnica com dica prática para resolução rápida no .env.
     */
    private function formatarErroSmtp(string $host, int $porta, Throwable $erro): string
    {
        $raw = $erro->getMessage();
        $dica = '';

        if (str_contains($raw, '535') || str_contains(strtolower($raw), 'failed to authenticate')) {
            $dica = ' Dica: confira a senha de demandas@focosinal.com.br. Se ela tiver "$", coloque entre aspas simples (\'...\') no .env.';
        } elseif (str_contains(strtolower($raw), 'certificate') || str_contains(strtolower($raw), 'ssl')) {
            $dica = ' Dica: tente definir MAIL_VERIFY_PEER=false ou usar MAIL_PORT=587 e MAIL_SCHEME=smtp.';
        } elseif (str_contains(strtolower($raw), 'timed out') || str_contains(strtolower($raw), 'connection refused')) {
            $dica = ' Dica: verifique se o servidor permite saída SMTP nas portas 465 ou 587.';
        }

        return "Falha ao enviar via SMTP ({$host}:{$porta}): {$raw}{$dica}";
    }

    /**
     * Resolve o e-mail de destino oficial das solicitações.
     */
    private function resolverDestinatario(): ?string
    {
        $destinatario = config('mail.demandas_address') ?: config('mail.from.address');

        return is_string($destinatario) && $destinatario !== '' ? $destinatario : null;
    }

    /**
     * Persiste o último resultado de envio para visibilidade no painel admin.
     */
    private function registrarDiagnostico(string $status, string $mensagem, ?string $protocolo = null): void
    {
        $dados = [
            'status' => $status,
            'mensagem' => $mensagem,
            'protocolo' => $protocolo,
            'registrado_em' => now()->format('d/m/Y H:i:s'),
        ];

        @file_put_contents(
            $this->caminhoDiagnostico(),
            json_encode($dados, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
        );
    }

    private function caminhoDiagnostico(): string
    {
        $nome = app()->runningUnitTests() ? 'mail_diagnostico_testing.json' : 'mail_diagnostico.json';

        return storage_path("app/{$nome}");
    }
}

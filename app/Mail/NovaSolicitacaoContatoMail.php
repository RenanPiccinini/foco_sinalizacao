<?php

namespace App\Mail;

use App\Models\Contato;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class NovaSolicitacaoContatoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Cria uma nova instância da mensagem para envio de orçamento ou solicitação.
     */
    public function __construct(public Contato $contato) {}

    /**
     * Define o cabeçalho e o assunto da mensagem.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "[{$this->contato->protocolo}] {$this->contato->assunto} - {$this->contato->empresa}",
            replyTo: [
                new Address($this->contato->email, $this->contato->responsavel),
            ],
        );
    }

    /**
     * Define a view do conteúdo do e-mail.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.nova-solicitacao-contato',
        );
    }

    /**
     * Anexa automaticamente a planilha/arquivo enviado pelo cliente no formulário.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        if (! $this->contato->arquivo_path || ! Storage::disk('public')->exists($this->contato->arquivo_path)) {
            return [];
        }

        $mime = Storage::disk('public')->mimeType($this->contato->arquivo_path) ?: 'application/octet-stream';

        $attachment = Attachment::fromStorageDisk('public', $this->contato->arquivo_path)
            ->withMime($mime);

        if ($this->contato->arquivo_nome) {
            $attachment->as($this->contato->arquivo_nome);
        }

        return [$attachment];
    }
}

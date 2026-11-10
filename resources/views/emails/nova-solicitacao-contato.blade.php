<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Solicitação / Orçamento - {{ $contato->protocolo }}</title>
</head>
<body style="margin:0; padding:0; background-color:#0b1120; font-family:Arial, Helvetica, sans-serif; color:#e2e8f0;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#0b1120; padding:24px 12px;">
        <tr>
            <td align="center">
                <table width="620" cellpadding="0" cellspacing="0" border="0" style="max-width:620px; width:100%; background-color:#111c33; border:1px solid #1e293b; border-radius:12px; overflow:hidden;">
                    <!-- Cabeçalho -->
                    <tr>
                        <td style="background-color:#080e1c; padding:20px 28px; border-bottom:2px solid #eab308;">
                            <div style="font-size:11px; text-transform:uppercase; letter-spacing:1.5px; color:#eab308; font-weight:bold;">
                                FOCO Sinalização e Sistemas Inteligentes
                            </div>
                            <h1 style="margin:6px 0 0; font-size:20px; color:#ffffff; font-weight:bold;">
                                Nova Solicitação de Orçamento / Contato
                            </h1>
                        </td>
                    </tr>

                    <!-- Badge de Protocolo & Assunto -->
                    <tr>
                        <td style="padding:20px 28px 12px;">
                            <table width="100%" cellpadding="10" cellspacing="0" border="0" style="background-color:#0b1529; border:1px solid #233250; border-radius:8px;">
                                <tr>
                                    <td style="font-size:12px; color:#94a3b8;">
                                        Protocolo: <strong style="color:#eab308; font-size:14px;">{{ $contato->protocolo }}</strong>
                                    </td>
                                    <td align="right" style="font-size:12px; color:#94a3b8;">
                                        Recebido em: <strong style="color:#e2e8f0;">{{ $contato->created_at?->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }}</strong>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="padding-top:6px; border-top:1px solid #1e293b; font-size:13px; color:#38bdf8; font-weight:bold;">
                                        Assunto: {{ $contato->assunto }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Dados do Solicitante -->
                    <tr>
                        <td style="padding:12px 28px;">
                            <table width="100%" cellpadding="8" cellspacing="0" border="0" style="border-collapse:collapse; font-size:13px;">
                                <tr>
                                    <td width="140" style="color:#94a3b8; border-bottom:1px solid #1e293b;"><strong>Empresa:</strong></td>
                                    <td style="color:#ffffff; border-bottom:1px solid #1e293b;">{{ $contato->empresa }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#94a3b8; border-bottom:1px solid #1e293b;"><strong>CNPJ:</strong></td>
                                    <td style="color:#ffffff; border-bottom:1px solid #1e293b;">{{ $contato->cnpj }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#94a3b8; border-bottom:1px solid #1e293b;"><strong>Responsável:</strong></td>
                                    <td style="color:#ffffff; border-bottom:1px solid #1e293b;">{{ $contato->responsavel }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#94a3b8; border-bottom:1px solid #1e293b;"><strong>Telefone:</strong></td>
                                    <td style="color:#ffffff; border-bottom:1px solid #1e293b;">{{ $contato->fone }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#94a3b8; border-bottom:1px solid #1e293b;"><strong>E-mail:</strong></td>
                                    <td style="color:#eab308; border-bottom:1px solid #1e293b;">
                                        <a href="mailto:{{ $contato->email }}" style="color:#eab308; text-decoration:none;">{{ $contato->email }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="color:#94a3b8; border-bottom:1px solid #1e293b;"><strong>Endereço:</strong></td>
                                    <td style="color:#ffffff; border-bottom:1px solid #1e293b;">{{ $contato->endereco }}</td>
                                </tr>
                                <tr>
                                    <td style="color:#94a3b8; border-bottom:1px solid #1e293b;"><strong>Anexo / Planilha:</strong></td>
                                    <td style="color:#10b981; border-bottom:1px solid #1e293b;">
                                        {{ $contato->arquivo_nome ? $contato->arquivo_nome . ' (anexado a este e-mail)' : 'Nenhum arquivo anexado' }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Descrição -->
                    <tr>
                        <td style="padding:12px 28px 20px;">
                            <div style="font-size:12px; text-transform:uppercase; color:#94a3b8; font-weight:bold; margin-bottom:6px;">
                                Descrição / Especificação e Quantitativos:
                            </div>
                            <div style="background-color:#0b1529; border:1px solid #233250; border-radius:8px; padding:14px; font-size:13px; line-height:1.6; color:#e2e8f0;">
                                {!! nl2br(e($contato->descricao)) !!}
                            </div>
                        </td>
                    </tr>

                    <!-- Botão de Acesso ao Painel -->
                    <tr>
                        <td align="center" style="padding:8px 28px 26px;">
                            <a href="{{ route('admin.contatos.show', $contato) }}" style="display:inline-block; background-color:#eab308; color:#0b1120; font-size:12px; font-weight:bold; text-transform:uppercase; letter-spacing:0.8px; text-decoration:none; padding:12px 24px; border-radius:8px;">
                                Abrir Solicitação no Painel Gestor
                            </a>
                        </td>
                    </tr>

                    <!-- Rodapé -->
                    <tr>
                        <td style="background-color:#080e1c; padding:14px 28px; font-size:11px; color:#64748b; text-align:center; border-top:1px solid #1e293b;">
                            Este e-mail foi enviado automaticamente pelo portal FOCO Sinalização. Clique em responder para contatar diretamente {{ $contato->responsavel }} ({{ $contato->email }}).
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ordem de Serviço {{ $chamado->protocolo }} | Foco Sinalização</title>
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-banner.jpg') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A4;
            margin: 15mm;
        }
        body {
            font-family: 'Outfit', sans-serif;
            color: #0f172a;
            background: #ffffff;
            margin: 0;
            padding: 20px;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            border-bottom: 2px solid #0f2752;
            padding-bottom: 12px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .logo-img {
            max-height: 55px;
            width: auto;
        }
        .mono {
            font-family: 'JetBrains Mono', monospace;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
        }
        .badge-tipo { background: #fef3c7; color: #92400e; border: 1px solid #fbbf24; }
        .badge-status { background: #e0f2fe; color: #0369a1; border: 1px solid #38bdf8; }
        .section-title {
            background: #0f2752;
            color: #ffffff;
            padding: 4px 8px;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 14px;
            margin-bottom: 6px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            font-size: 11px;
            text-align: left;
        }
        th {
            background: #f8fafc;
            color: #334155;
            font-weight: 600;
        }
        .checklist-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 4px 0;
            font-size: 11px;
        }
        .checkbox-box {
            width: 14px;
            height: 14px;
            border: 1.5px solid #475569;
            display: inline-block;
        }
        .signatures {
            margin-top: 35px;
            display: flex;
            justify-content: space-between;
            gap: 40px;
        }
        .sign-block {
            flex: 1;
            text-align: center;
            border-top: 1px solid #334155;
            padding-top: 6px;
            font-size: 11px;
        }
        .no-print {
            margin-bottom: 20px;
            padding: 10px;
            background: #f1f5f9;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn {
            background: #f59e0b;
            color: #020611;
            font-weight: 700;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 12px;
        }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
        }
    </style>
</head>
<body>

    <!-- Barra de Controle (Invisível na Impressão) -->
    <div class="no-print">
        <div>
            <strong>Ordem de Serviço Pronta para Impressão</strong>
            <span style="color: #64748b; margin-left: 10px;">Protocolo: {{ $chamado->protocolo }}</span>
        </div>
        <div style="display: flex; gap: 10px;">
            <button onclick="window.print()" class="btn">🖨️ Imprimir Ordem de Serviço</button>
            <button onclick="window.close()" class="btn" style="background: #94a3b8; color: #fff;">Fechar</button>
        </div>
    </div>

    <!-- Cabeçalho Oficial -->
    <div class="header">
        <div>
            <img src="{{ asset('images/logo-banner.jpg') }}" alt="FOCO Sinalização" class="logo-img">
            <div style="font-size: 9px; color: #475569; margin-top: 4px;">
                FOCO SINALIZAÇÃO E SISTEMAS INTELIGENTES LTDA — Soluções Integradas em Mobilidade Urbana
            </div>
        </div>
        <div style="text-align: right;">
            <div class="mono" style="font-size: 16px; font-weight: 800; color: #0f2752;">O.S. {{ $chamado->protocolo }}</div>
            <div style="font-size: 10px; color: #64748b; margin-top: 2px;">
                Abertura: {{ $chamado->data_hora_abertura ? $chamado->data_hora_abertura->format('d/m/Y H:i') : $chamado->created_at->format('d/m/Y H:i') }}
            </div>
            <div style="margin-top: 4px;">
                <span class="badge badge-tipo">TIPO: {{ $chamado->tipo }}</span>
                <span class="badge badge-status">{{ $chamado->status }}</span>
            </div>
        </div>
    </div>

    <!-- 1. Dados do Solicitante -->
    <div class="section-title">1. Dados do Solicitante & Contato</div>
    <table>
        <tr>
            <th width="20%">Nome Solicitante:</th>
            <td width="30%"><strong>{{ $chamado->nome_solicitante }}</strong></td>
            <th width="20%">Número para Contato:</th>
            <td width="30%">{{ $chamado->telefone_contato }}</td>
        </tr>
        <tr>
            <th>Horário Abertura (Automático):</th>
            <td>{{ $chamado->data_hora_abertura ? $chamado->data_hora_abertura->format('d/m/Y H:i:s') : $chamado->created_at->format('d/m/Y H:i:s') }}</td>
            <th>Técnico Responsável:</th>
            <td>{{ $chamado->tecnico_responsavel ?: 'Equipe Técnica FOCO' }}</td>
        </tr>
    </table>

    <!-- 2. Localização e Defeito -->
    <div class="section-title">2. Localização & Ocorrência Reportada</div>
    <table>
        <tr>
            <th width="20%">Tipo de Chamado:</th>
            <td width="30%"><strong>{{ $chamado->tipo }}</strong></td>
            <th width="20%">Status Atual:</th>
            <td width="30%">{{ $chamado->status }}</td>
        </tr>
        <tr>
            <th>Local:</th>
            <td colspan="3"><strong>{{ $chamado->local }}</strong></td>
        </tr>
    </table>

    <!-- 3. Defeito e Observação -->
    <div class="section-title">3. Detalhamento do Defeito e Observação do Solicitante</div>
    <div style="border: 1px solid #cbd5e1; padding: 10px; background: #fafafa; border-radius: 4px; font-size: 11px; margin-bottom: 8px;">
        <strong style="color: #0f2752;">Defeito:</strong>
        <p style="margin: 4px 0 0 0; color: #334155;">{{ $chamado->defeito }}</p>
    </div>
    @if($chamado->observacao)
    <div style="border: 1px solid #cbd5e1; padding: 8px 10px; background: #fafafa; border-radius: 4px; font-size: 11px;">
        <strong style="color: #0f2752;">Observação:</strong>
        <p style="margin: 4px 0 0 0; color: #475569;">{{ $chamado->observacao }}</p>
    </div>
    @endif

    <!-- 4. Finalização FOCO (Quando Finalizado ou em Campo) -->
    <div class="section-title">4. Laudo de Execução FOCO (Conserto & Horário)</div>
    <table>
        <tr>
            <th width="25%">Horário Execução:</th>
            <td width="75%">
                {{ $chamado->data_hora_execucao ? $chamado->data_hora_execucao->format('d/m/Y H:i') : '___/___/______ às ___:___' }}
            </td>
        </tr>
        <tr>
            <th>Conserto Executado:</th>
            <td>
                {{ $chamado->conserto_executado ?: '____________________________________________________________________________________' }}
            </td>
        </tr>
        <tr>
            <th>Observação Finalização:</th>
            <td>
                {{ $chamado->observacao_finalizacao ?: '____________________________________________________________________________________' }}
            </td>
        </tr>
    </table>

    <!-- 5. Checklist de Verificação Semafórica -->
    <div class="section-title">5. Checklist de Verificação Semafórica em Campo</div>
    <div style="border: 1px solid #cbd5e1; padding: 8px 12px; background: #fff;">
        <div class="checklist-item"><span class="checkbox-box"></span> Tensão e alimentação elétrica do controlador</div>
        <div class="checklist-item"><span class="checkbox-box"></span> Teste do Nobreak Senoidal Puro e Banco de Baterias</div>
        <div class="checklist-item"><span class="checkbox-box"></span> Verificação física de colunas, cabos e grupos focais LED</div>
        <div class="checklist-item"><span class="checkbox-box"></span> Sincronismo da onda verde e comunicação remota</div>
        <div class="checklist-item"><span class="checkbox-box"></span> Teste do ciclo veicular e botoeiras de pedestres</div>
    </div>

    <!-- 6. Assinaturas -->
    <div class="signatures">
        <div class="sign-block">
            <strong>{{ $chamado->tecnico_responsavel ?: 'Técnico Responsável' }}</strong><br>
            Equipe Técnica FOCO Sinalização
        </div>
        <div class="sign-block">
            <strong>{{ $chamado->nome_solicitante }}</strong><br>
            Solicitante / Fiscal Responsável
        </div>
    </div>

    <div style="text-align: center; margin-top: 25px; font-size: 9px; color: #94a3b8; font-family: monospace;">
        FOCO SINALIZAÇÃO E SISTEMAS INTELIGENTES LTDA • CNPJ Central • Nuvem de Controle Operacional
    </div>

</body>
</html>

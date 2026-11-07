<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ordem de Serviço {{ $chamado['protocolo'] }} | Foco Sinalização</title>
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
        .badge-critica { background: #fee2e2; color: #991b1b; border: 1px solid #f87171; }
        .badge-alta { background: #fef3c7; color: #92400e; border: 1px solid #fbbf24; }
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
            <span style="color: #64748b; margin-left: 10px;">Protocolo: {{ $chamado['protocolo'] }}</span>
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
            <div class="mono" style="font-size: 16px; font-weight: 800; color: #0f2752;">O.S. {{ $chamado['protocolo'] }}</div>
            <div style="font-size: 10px; color: #64748b; margin-top: 2px;">Data/Hora: {{ $chamado['created_at'] }}</div>
            <div style="margin-top: 4px;">
                <span class="badge {{ $chamado['prioridade'] === 'Crítica' ? 'badge-critica' : 'badge-alta' }}">{{ $chamado['prioridade'] }}</span>
                <span class="badge badge-status">{{ $chamado['status'] }}</span>
            </div>
        </div>
    </div>

    <!-- 1. Dados do Chamado e Solicitante -->
    <div class="section-title">1. Dados do Solicitante & Órgão Público</div>
    <table>
        <tr>
            <th width="20%">Solicitante:</th>
            <td width="30%"><strong>{{ $chamado['solicitante_nome'] }}</strong></td>
            <th width="20%">Órgão / Entidade:</th>
            <td width="30%">{{ $chamado['solicitante_orgao'] }}</td>
        </tr>
        <tr>
            <th>Telefone / WhatsApp:</th>
            <td>{{ $chamado['solicitante_telefone'] ?: 'Não informado' }}</td>
            <th>E-mail Corporativo:</th>
            <td>{{ $chamado['solicitante_email'] ?: 'Não informado' }}</td>
        </tr>
    </table>

    <!-- 2. Localização e Cruzamento -->
    <div class="section-title">2. Localização Viária & Ativos Afetados</div>
    <table>
        <tr>
            <th width="20%">Município / Trecho:</th>
            <td width="30%"><strong>{{ $chamado['municipio'] }}</strong></td>
            <th width="20%">Categoria:</th>
            <td width="30%">{{ $chamado['categoria'] }}</td>
        </tr>
        <tr>
            <th>Cruzamento / Endereço:</th>
            <td><strong>{{ $chamado['localizacao'] }}</strong></td>
            <th>Ponto de Referência:</th>
            <td>{{ $chamado['ponto_referencia'] ?: 'N/A' }}</td>
        </tr>
        <tr>
            <th>Equipamento Afetado:</th>
            <td colspan="3">{{ $chamado['equipamento_afetado'] ?: 'Controlador Semafórico / Grupo Focal LED' }}</td>
        </tr>
    </table>

    <!-- 3. Descrição da Ocorrência -->
    <div class="section-title">3. Descrição do Problema Relatado</div>
    <div style="border: 1px solid #cbd5e1; padding: 10px; background: #fafafa; border-radius: 4px; font-size: 11px;">
        <strong style="color: #0f2752;">{{ $chamado['titulo'] }}</strong>
        <p style="margin: 6px 0 0 0; color: #334155;">{{ $chamado['descricao'] }}</p>
    </div>

    <!-- 4. Checklist de Intervenção Técnica em Campo -->
    <div class="section-title">4. Checklist de Execução & Conformidade Técnica (Normas CONTRAN/DNIT)</div>
    <div style="border: 1px solid #cbd5e1; padding: 8px 12px; background: #fff;">
        <div class="checklist-item"><span class="checkbox-box"></span> Medição de Tensão e Estabilidade da Rede Elétrica Concessionária (Vac)</div>
        <div class="checklist-item"><span class="checkbox-box"></span> Teste do Nobreak Senoidal Puro Foco & Bypass Automático</div>
        <div class="checklist-item"><span class="checkbox-box"></span> Verificação de Carga e Ciclo do Banco de Baterias de Lítio LiFePO4</div>
        <div class="checklist-item"><span class="checkbox-box"></span> Inspeção dos Eletrodutos PEAD Subterrâneos e Caixas de Passagem</div>
        <div class="checklist-item"><span class="checkbox-box"></span> Integridade da Coluna e Braço Projetado em Aço Galvanizado</div>
        <div class="checklist-item"><span class="checkbox-box"></span> Calibração Óptica e Limpeza dos Grupos Focais Veiculares/Pedestres LED</div>
        <div class="checklist-item"><span class="checkbox-box"></span> Ajuste de Sensibilidade dos Laços Virtuais / Câmeras HD de Visão Computacional</div>
        <div class="checklist-item"><span class="checkbox-box"></span> Sincronismo da Onda Verde e Teste de Comunicação 4G com Central WEB DIGICON</div>
    </div>

    <!-- 5. Relatório do Técnico em Campo -->
    <div class="section-title">5. Laudo do Técnico em Campo & Peças Substituídas</div>
    <div style="border: 1px solid #cbd5e1; min-height: 60px; padding: 8px; font-size: 10px; color: #475569;">
        Técnico Responsável Designado: <strong>{{ $chamado['tecnico_responsavel'] }}</strong><br>
        SLA de Atendimento Estimado: <strong>{{ $chamado['sla_estimado'] }}</strong>
        <div style="margin-top: 15px; border-bottom: 1px dotted #cbd5e1;"></div>
        <div style="margin-top: 15px; border-bottom: 1px dotted #cbd5e1;"></div>
    </div>

    <!-- 6. Assinaturas -->
    <div class="signatures">
        <div class="sign-block">
            <strong>{{ $chamado['tecnico_responsavel'] }}</strong><br>
            Técnico / Engenheiro Responsável Foco
        </div>
        <div class="sign-block">
            <strong>Fiscal do Município / Agente DTT</strong><br>
            Recebido e Testado em Conformidade
        </div>
    </div>

    <div style="text-align: center; margin-top: 25px; font-size: 9px; color: #94a3b8; font-family: monospace;">
        Trilha de Auditoria Digital Criptografada • Central WEB DIGICON • Foco Sinalização e Sistemas Inteligentes LTDA
    </div>

</body>
</html>


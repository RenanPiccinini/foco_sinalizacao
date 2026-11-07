@extends('site.layout')

@section('title', 'Central de Chamados e Suporte Operacional | Foco Sinalização')

@section('content')
<div class="py-12 bg-foco-navy-950 relative overflow-hidden" x-data="{
    tab: '{{ $chamadoBuscado || $protocoloBusca ? 'consultar' : 'abrir' }}',
    preencherTeste() {
        document.getElementById('solicitante_nome').value = 'Inspetor Gabriel Ramos';
        document.getElementById('solicitante_orgao').value = 'DTT - Guarda Municipal de Trânsito';
        document.getElementById('solicitante_telefone').value = '(47) 99822-4411';
        document.getElementById('solicitante_email').value = 'dtt.plantao@bctransito.sc.gov.br';
        document.getElementById('municipio').value = 'Balneário Camboriú – SC';
        document.getElementById('localizacao').value = 'Av. Atlântica x Rua 1500 (Praça Almirante Tamandaré)';
        document.getElementById('ponto_referencia').value = 'Ao lado do posto de salvamento';
        document.getElementById('categoria').value = 'Sinalização Semafórica';
        document.getElementById('prioridade').value = 'Crítica';
        document.getElementById('titulo').value = 'Semáforo veicular em amarelo piscante após oscilação de energia';
        document.getElementById('descricao').value = 'O cruzamento com alto fluxo na orla entrou em modo amarelo piscante de emergência. Nobreak LiFePO4 sustentando a controladora, requer averiguação de placa de sincronismo.';
        document.getElementById('equipamento_afetado').value = 'Controlador Digicon 4G + Grupo Focal LED';
    }
}">

    <!-- Efeitos de iluminação de fundo -->
    <div class="absolute top-0 right-1/4 w-96 h-96 bg-foco-yellow-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 left-10 w-80 h-80 bg-foco-green-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <!-- Notificação de Sucesso com Confetes -->
        @if(session('success'))
        <div id="ticket-success-alert" class="mb-8 p-6 rounded-3xl glass-panel-glow border-2 border-foco-yellow-500 shadow-2xl animate-pulse-slow">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-foco-yellow-500/20 text-foco-yellow-400 flex items-center justify-center shrink-0">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Chamado Registrado na Central Foco!</h3>
                        <p class="text-slate-300 text-sm mt-0.5">
                            Protocolo Oficial: <strong class="text-foco-yellow-400 font-mono text-base">{{ session('novo_protocolo') ?? $protocoloBusca }}</strong>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('site.chamados', ['protocolo' => session('novo_protocolo') ?? $protocoloBusca]) }}" class="px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 text-foco-navy-950 hover:bg-foco-yellow-400 transition shadow-glow-yellow">
                        Acompanhar Chamado
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Cabeçalho Principal -->
        <div class="text-center max-w-3xl mx-auto mb-10">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-foco-yellow-500/10 text-foco-yellow-400 border border-foco-yellow-500/30 text-xs font-mono font-bold mb-3">
                <span class="w-2 h-2 rounded-full bg-foco-yellow-400 animate-ping"></span>
                Portal de Chamados Operacionais e Manutenção Viária
            </div>
            <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight">
                Abertura e Acompanhamento de Chamados
            </h1>
            <p class="text-slate-400 mt-3 text-base">
                Canal oficial para prefeituras, agentes de trânsito, concessionárias e cidadãos registrarem ocorrências semafóricas e solicitarem intervenções técnicas.
            </p>
        </div>

        <!-- Seletor de Abas (Abrir vs Consultar - 100% Responsivo) -->
        <div class="flex justify-center mb-8 px-2">
            <div class="glass-panel p-1.5 rounded-2xl border border-white/10 flex flex-col xs:flex-row gap-2 w-full max-w-md sm:max-w-none sm:w-auto">
                <button type="button" @click="tab = 'abrir'" :class="tab === 'abrir' ? 'bg-foco-yellow-500 text-foco-navy-950 shadow-glow-yellow font-extrabold' : 'text-slate-300 hover:text-white font-medium'" class="px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Abrir Novo Chamado</span>
                </button>
                <button type="button" @click="tab = 'consultar'" :class="tab === 'consultar' ? 'bg-foco-yellow-500 text-foco-navy-950 shadow-glow-yellow font-extrabold' : 'text-slate-300 hover:text-white font-medium'" class="px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl text-xs sm:text-sm transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <span>Consultar Protocolo</span>
                </button>
            </div>
        </div>

        <!-- ABA 1: FORMULÁRIO DE ABERTURA DE CHAMADO -->
        <div x-show="tab === 'abrir'" x-transition class="max-w-4xl mx-auto">
            <div class="glass-panel p-6 sm:p-10 rounded-3xl border border-white/10 shadow-2xl relative">
                
                <!-- Botão de preenchimento rápido para demonstração -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-white/10 gap-3">
                    <div>
                        <h2 class="text-xl font-bold text-white">Formulário de Notificação de Ocorrência</h2>
                        <p class="text-xs text-slate-400">Preencha os dados do cruzamento para acionamento imediato da equipe.</p>
                    </div>
                    <button type="button" @click="preencherTeste()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-xs font-mono text-foco-yellow-400 border border-foco-yellow-500/30 transition self-start sm:self-auto">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Preencher com Dados de Teste
                    </button>
                </div>

                <form action="{{ route('site.chamados.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- Seção 1: Dados do Solicitante -->
                    <div class="space-y-4">
                        <h3 class="text-xs font-mono font-bold text-foco-yellow-400 uppercase tracking-wider flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-foco-yellow-400"></span>
                            1. Identificação do Solicitante / Órgão
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="solicitante_nome" class="block text-xs font-medium text-slate-300 mb-1">Nome Completo *</label>
                                <input type="text" name="solicitante_nome" id="solicitante_nome" required placeholder="Ex: Inspetor Marcelo Vargas" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                            </div>

                            <div>
                                <label for="solicitante_orgao" class="block text-xs font-medium text-slate-300 mb-1">Órgão / Empresa / Secretaria *</label>
                                <input type="text" name="solicitante_orgao" id="solicitante_orgao" required placeholder="Ex: BC Trânsito / DTT / Pref. Balneário Camboriú" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                            </div>

                            <div>
                                <label for="solicitante_telefone" class="block text-xs font-medium text-slate-300 mb-1">Telefone / WhatsApp com DDD *</label>
                                <input type="text" name="solicitante_telefone" id="solicitante_telefone" required placeholder="(47) 99000-0000" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                            </div>

                            <div>
                                <label for="solicitante_email" class="block text-xs font-medium text-slate-300 mb-1">E-mail para Acompanhamento *</label>
                                <input type="email" name="solicitante_email" id="solicitante_email" required placeholder="operacoes@orgao.gov.br" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                            </div>
                        </div>
                    </div>

                    <!-- Seção 2: Localização da Ocorrência -->
                    <div class="space-y-4 pt-4 border-t border-white/10">
                        <h3 class="text-xs font-mono font-bold text-foco-green-400 uppercase tracking-wider flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-foco-green-400"></span>
                            2. Localização do Cruzamento / Rodovia
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="municipio" class="block text-xs font-medium text-slate-300 mb-1">Município ou Rodovia *</label>
                                <select name="municipio" id="municipio" required class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                                    <optgroup label="Santa Catarina (SC)">
                                        <option value="Balneário Camboriú – SC">Balneário Camboriú – SC</option>
                                        <option value="Balneário Piçarras – SC">Balneário Piçarras – SC</option>
                                    </optgroup>
                                    <optgroup label="Rio Grande do Sul (RS)">
                                        <option value="Campo Bom – RS">Campo Bom – RS</option>
                                        <option value="Canoas – RS">Canoas – RS</option>
                                        <option value="Entre-Ijuís – RS">Entre-Ijuís – RS</option>
                                        <option value="Erechim – RS">Erechim – RS</option>
                                        <option value="Guaíba – RS">Guaíba – RS</option>
                                        <option value="Guaporé – RS">Guaporé – RS</option>
                                        <option value="Ivoti – RS">Ivoti – RS</option>
                                        <option value="Lajeado – RS">Lajeado – RS</option>
                                        <option value="Nova Hartz – RS">Nova Hartz – RS</option>
                                        <option value="Novo Hamburgo – RS">Novo Hamburgo – RS</option>
                                        <option value="Palmeira das Missões – RS">Palmeira das Missões – RS</option>
                                        <option value="Passo Fundo – RS">Passo Fundo – RS</option>
                                        <option value="Portão – RS">Portão – RS</option>
                                        <option value="Rosário do Sul – RS">Rosário do Sul – RS</option>
                                        <option value="Santo Antônio da Patrulha – RS">Santo Antônio da Patrulha – RS</option>
                                        <option value="Torres – RS">Torres – RS</option>
                                        <option value="Tramandaí – RS">Tramandaí – RS</option>
                                        <option value="Três Coroas – RS">Três Coroas – RS</option>
                                        <option value="Viamão – RS">Viamão – RS</option>
                                    </optgroup>
                                    <optgroup label="Rodovias Federais">
                                        <option value="Rodovia BR 101">Rodovia BR 101</option>
                                        <option value="Rodovia BR 116">Rodovia BR 116</option>
                                        <option value="Rodovia BR 153">Rodovia BR 153</option>
                                        <option value="Rodovia BR 290">Rodovia BR 290</option>
                                    </optgroup>
                                    <optgroup label="Outras Regiões">
                                        <option value="Outro Município / Trecho de Concessão">Outro Município / Trecho de Concessão</option>
                                    </optgroup>
                                </select>
                            </div>

                            <div>
                                <label for="prioridade" class="block text-xs font-medium text-slate-300 mb-1">Grau de Urgência / Prioridade *</label>
                                <select name="prioridade" id="prioridade" required class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                                    <option value="Crítica">🚨 Crítica (Semáforo Apagado / Risco Iminente de Acidente)</option>
                                    <option value="Alta" selected>⚠️ Alta (Amarelo Piscante / Falha Nobreak / Avaria Física)</option>
                                    <option value="Média">⏱️ Média (Descompasso de Onda Verde / Pedestre Inoperante)</option>
                                    <option value="Baixa">📋 Baixa (Vistoria Preventiva / Solicitação de Alteração de Ciclo)</option>
                                </select>
                            </div>

                            <div>
                                <label for="localizacao" class="block text-xs font-medium text-slate-300 mb-1">Endereço / Cruzamento das Vias *</label>
                                <input type="text" name="localizacao" id="localizacao" required placeholder="Ex: Av. Brasil com Av. Alvin Bauer" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                            </div>

                            <div>
                                <label for="ponto_referencia" class="block text-xs font-medium text-slate-300 mb-1">Ponto de Referência / Sentido</label>
                                <input type="text" name="ponto_referencia" id="ponto_referencia" placeholder="Ex: Em frente ao Shopping, sentido Centro-Bairro" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                            </div>
                        </div>
                    </div>

                    <!-- Seção 3: Detalhes Técnicos da Ocorrência -->
                    <div class="space-y-4 pt-4 border-t border-white/10">
                        <h3 class="text-xs font-mono font-bold text-cyan-400 uppercase tracking-wider flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-cyan-400"></span>
                            3. Detalhamento da Ocorrência
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="categoria" class="block text-xs font-medium text-slate-300 mb-1">Categoria do Chamado *</label>
                                <select name="categoria" id="categoria" required class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                                    <option value="Sinalização Semafórica">Falha Semafórica (Apagado / Intermitente)</option>
                                    <option value="Sincronismo & Engenharia de Tráfego">Sincronismo & Onda Verde</option>
                                    <option value="Inteligência Semafórica & Visão Computacional">Câmeras ITS & Visão Computacional</option>
                                    <option value="Resiliência Energética & Nobreak">Nobreak Senoidal & Bateria LiFePO4</option>
                                    <option value="Infraestrutura Civil & Manutenção Física">Coluna Aço Galvanizado / Colisão Física</option>
                                    <option value="Consultoria & Obras Temporárias em Rodovias">Sinalização Temporária em Rodovias</option>
                                    <option value="Manutenção Preventiva & Microgeração">Manutenção Preventiva / Painéis Solares</option>
                                </select>
                            </div>

                            <div>
                                <label for="equipamento_afetado" class="block text-xs font-medium text-slate-300 mb-1">Equipamento Afetado (Se conhecido)</label>
                                <input type="text" name="equipamento_afetado" id="equipamento_afetado" placeholder="Ex: Controlador Digicon 4G, Lâmpada LED Vermelha, Sensor Virtual" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                            </div>
                        </div>

                        <div>
                            <label for="titulo" class="block text-xs font-medium text-slate-300 mb-1">Assunto / Título Resumido da Ocorrência *</label>
                            <input type="text" name="titulo" id="titulo" required placeholder="Ex: Semáforo Veicular apagado na via expressa sentido norte" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                        </div>

                        <div>
                            <label for="descricao" class="block text-xs font-medium text-slate-300 mb-1">Descrição Completa da Falha / Ocorrência *</label>
                            <textarea name="descricao" id="descricao" rows="4" required placeholder="Descreva os sintomas observados, horários de falha, se há retenção de tráfego ou intervenção manual da polícia/guarda." class="w-full bg-foco-navy-900 border border-white/10 rounded-xl p-4 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition"></textarea>
                        </div>
                    </div>

                    <!-- Botão de Envio do Chamado -->
                    <div class="pt-4 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-white/10">
                        <div class="flex items-center gap-2 text-xs text-slate-400">
                            <span class="w-2 h-2 rounded-full bg-foco-green-400"></span>
                            <span>Ao enviar, um código de protocolo inviolável será gerado.</span>
                        </div>

                        <button type="submit" class="w-full sm:w-auto px-8 py-4 rounded-xl font-black text-sm uppercase tracking-wider bg-gradient-to-r from-foco-yellow-500 to-amber-500 text-foco-navy-950 shadow-glow-yellow hover:from-foco-yellow-400 hover:to-amber-400 hover:scale-105 active:scale-95 transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-foco-navy-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Registrar Chamado na Central Foco</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ABA 2: CONSULTA POR PROTOCOLO E TRACKING VISUAL -->
        <div id="consulta" x-show="tab === 'consultar'" x-transition class="max-w-4xl mx-auto space-y-8">
            <!-- Barra de Busca -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-2xl">
                <form action="{{ route('site.chamados') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative flex-grow">
                        <input type="text" name="protocolo" value="{{ $protocoloBusca }}" placeholder="Digite o protocolo ex: FOC-2026-8941" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-5 py-3.5 text-base font-mono text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 uppercase">
                    </div>
                    <button type="submit" class="px-7 py-3.5 rounded-xl font-extrabold text-sm uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 shadow-glow-yellow transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Localizar</span>
                    </button>
                </form>
            </div>

            <!-- Exibição do Chamado Localizado -->
            @if($chamadoBuscado)
            <div class="glass-panel-glow p-8 sm:p-10 rounded-3xl border border-foco-yellow-500/30 shadow-2xl space-y-6">
                <!-- Cabeçalho do Chamado -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-white/10 gap-4">
                    <div>
                        <div class="flex items-center gap-3">
                            <span class="text-2xl font-black font-mono text-foco-yellow-400">{{ $chamadoBuscado['protocolo'] }}</span>
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $chamadoBuscado['status'] === 'Aberto' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : ($chamadoBuscado['status'] === 'Em Atendimento' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30') }}">
                                {{ $chamadoBuscado['status'] }}
                            </span>
                        </div>
                        <h2 class="text-xl font-bold text-white mt-2">{{ $chamadoBuscado['titulo'] }}</h2>
                        <p class="text-xs text-slate-400 font-mono mt-1">Registrado em {{ $chamadoBuscado['created_at'] }} • Categoria: {{ $chamadoBuscado['categoria'] }}</p>
                    </div>

                    <div class="p-3 rounded-2xl bg-foco-navy-900 border border-white/10 text-xs text-right font-mono">
                        <span class="text-slate-400 block">SLA Previsto:</span>
                        <strong class="text-foco-green-400 block text-sm">{{ $chamadoBuscado['sla_estimado'] }}</strong>
                    </div>
                </div>

                <!-- Timeline Gráfica Passo a Passo -->
                <div>
                    <h4 class="text-xs font-mono font-bold text-slate-400 uppercase tracking-wider mb-4">Progresso Operacional</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3 text-center">
                        <div class="p-3 rounded-xl bg-foco-green-500/10 border border-foco-green-500/30 text-foco-green-400 text-xs font-bold">
                            ✓ 1. Registrado
                        </div>
                        <div class="p-3 rounded-xl {{ in_array($chamadoBuscado['status'], ['Em Atendimento', 'Concluído']) ? 'bg-foco-green-500/10 border border-foco-green-500/30 text-foco-green-400 font-bold' : 'bg-white/5 border border-white/10 text-slate-500' }} text-xs">
                            2. Triagem Nuvem Digicon
                        </div>
                        <div class="p-3 rounded-xl {{ in_array($chamadoBuscado['status'], ['Em Atendimento', 'Concluído']) ? 'bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 font-bold' : 'bg-white/5 border border-white/10 text-slate-500' }} text-xs">
                            3. Equipe Despachada
                        </div>
                        <div class="p-3 rounded-xl {{ $chamadoBuscado['status'] === 'Concluído' ? 'bg-foco-green-500/10 border border-foco-green-500/30 text-foco-green-400 font-bold' : 'bg-white/5 border border-white/10 text-slate-500' }} text-xs">
                            4. Concluído & Testado
                        </div>
                    </div>
                </div>

                <!-- Detalhes do Local e Descrição -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-mono">
                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/10 space-y-2">
                        <span class="text-slate-400 block uppercase font-bold">Dados do Cruzamento:</span>
                        <p class="text-slate-200"><strong class="text-white">Local:</strong> {{ $chamadoBuscado['localizacao'] }}</p>
                        <p class="text-slate-200"><strong class="text-white">Município:</strong> {{ $chamadoBuscado['municipio'] }}</p>
                        <p class="text-slate-200"><strong class="text-white">Ponto Ref.:</strong> {{ $chamadoBuscado['ponto_referencia'] ?: 'Não especificado' }}</p>
                        <p class="text-slate-200"><strong class="text-white">Equipamento:</strong> {{ $chamadoBuscado['equipamento_afetado'] }}</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/10 space-y-2">
                        <span class="text-slate-400 block uppercase font-bold">Atribuição Técnica:</span>
                        <p class="text-slate-200"><strong class="text-white">Técnico/Equipe:</strong> {{ $chamadoBuscado['tecnico_responsavel'] }}</p>
                        <p class="text-slate-200"><strong class="text-white">Solicitante:</strong> {{ $chamadoBuscado['solicitante_nome'] }}</p>
                        <p class="text-slate-200"><strong class="text-white">Órgão:</strong> {{ $chamadoBuscado['solicitante_orgao'] }}</p>
                        <p class="text-slate-200"><strong class="text-white">Prioridade:</strong> <span class="text-rose-400">{{ $chamadoBuscado['prioridade'] }}</span></p>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="p-4 rounded-2xl bg-foco-navy-900/60 border border-white/10 text-sm">
                    <span class="text-xs font-mono text-slate-400 block uppercase font-bold mb-1">Descrição da Ocorrência:</span>
                    <p class="text-slate-200 leading-relaxed">{{ $chamadoBuscado['descricao'] }}</p>
                </div>

                <!-- Histórico de Eventos -->
                @if(!empty($chamadoBuscado['historico']))
                <div class="pt-4 border-t border-white/10">
                    <h4 class="text-xs font-mono font-bold text-slate-400 uppercase tracking-wider mb-3">Linha do Tempo de Atualizações</h4>
                    <div class="space-y-2 font-mono text-xs">
                        @foreach($chamadoBuscado['historico'] as $hist)
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1 sm:gap-3 p-2.5 rounded-lg bg-white/5 border border-white/5">
                            <div class="flex items-start gap-2">
                                <span class="text-foco-yellow-400 shrink-0 font-bold">{{ $hist['data'] }}</span>
                                <span class="text-slate-300">{{ $hist['evento'] }}</span>
                            </div>
                            <span class="text-slate-500 text-[11px] self-end sm:self-auto">({{ $hist['usuario'] }})</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
            @elseif($protocoloBusca)
            <div class="p-8 rounded-3xl bg-rose-500/10 border border-rose-500/30 text-center">
                <p class="text-rose-400 font-bold text-lg">Protocolo "{{ $protocoloBusca }}" não foi localizado.</p>
                <p class="text-xs text-slate-400 mt-1">Verifique a digitação ou consulte a lista de chamados abaixo.</p>
            </div>
            @endif

            <!-- Lista de Todos os Chamados Registrados na Tela (Dados Fakes) -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-white">Todos os Chamados Registrados no Portal</h3>
                        <p class="text-xs text-slate-400">Dados simulados e ocorrências recentes na rede da Foco Sinalização.</p>
                    </div>
                    <span class="text-xs font-mono px-3 py-1 rounded-full bg-white/5 text-slate-300 border border-white/10">
                        {{ count($todosChamados) }} Chamados Cadastrados
                    </span>
                </div>

                <div class="space-y-3">
                    @foreach($todosChamados as $item)
                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5 hover:border-foco-yellow-500/40 transition flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-foco-yellow-400 text-sm">{{ $item['protocolo'] }}</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $item['status'] === 'Aberto' ? 'bg-amber-500/20 text-amber-300' : ($item['status'] === 'Em Atendimento' ? 'bg-cyan-500/20 text-cyan-300' : 'bg-emerald-500/20 text-emerald-300') }}">
                                    {{ $item['status'] }}
                                </span>
                                <span class="text-xs text-slate-500 font-mono">• {{ $item['created_at'] }}</span>
                            </div>
                            <h4 class="text-sm font-semibold text-white">{{ $item['titulo'] }}</h4>
                            <p class="text-xs text-slate-400">{{ $item['municipio'] }} — {{ $item['localizacao'] }}</p>
                        </div>

                        <div class="flex items-center gap-2 self-start sm:self-auto shrink-0">
                            <a href="{{ route('site.chamados', ['protocolo' => $item['protocolo']]) }}#consulta" class="px-3.5 py-1.5 rounded-lg text-xs font-mono font-bold bg-white/5 hover:bg-foco-yellow-500 hover:text-foco-navy-950 text-slate-300 transition">
                                Ver Detalhes →
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
@endsection


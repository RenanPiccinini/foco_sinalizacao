@extends('site.layout')

@section('title', 'Central de Chamados e Suporte Operacional | Foco Sinalização')

@section('content')
<div class="py-12 bg-foco-navy-950 relative overflow-hidden" x-data="{
    tab: '{{ $chamadoBuscado || $protocoloBusca ? 'consultar' : 'abrir' }}',
    tipoSelecionado: 'AP',
    horaAtual: '',
    init() {
        const atualizarHora = () => {
            const agora = new Date();
            this.horaAtual = agora.toLocaleDateString('pt-BR') + ' às ' + agora.toLocaleTimeString('pt-BR');
        };
        atualizarHora();
        setInterval(atualizarHora, 1000);
    },
    preencherTeste() {
        this.tipoSelecionado = 'AP';
        document.getElementById('tipo').value = 'AP';
        document.getElementById('nome_solicitante').value = 'Inspetor Gabriel Ramos (DTT)';
        document.getElementById('telefone_contato').value = '(51) 99294-1111';
        document.getElementById('local').value = 'Av. Brasil cruzamento com Av. Alvin Bauer';
        document.getElementById('defeito').value = 'Semáforo veicular operando em amarelo piscante (AP) após oscilação da concessionária de energia.';
        document.getElementById('observacao').value = 'Tráfego intenso no sentido orla. Nobreak mantendo o controlador ativo, equipe de trânsito orientando motoristas.';
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
                        <h3 class="text-xl font-bold text-white">Chamado Registrado na Central FOCO!</h3>
                        <p class="text-slate-300 text-sm mt-0.5">
                            Protocolo Oficial Gerado: <strong class="text-foco-yellow-400 font-mono text-base">{{ session('novo_protocolo') ?? $protocoloBusca }}</strong>
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
                Canal direto e integrado para abertura de chamados técnicos semafóricos com registro automático de data e horário.
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

        <!-- ABA 1: FORMULÁRIO DE ABERTURA DE CHAMADO (CONFORME REQUISITOS DO CLIENTE) -->
        <div x-show="tab === 'abrir'" x-transition class="max-w-4xl mx-auto">
            <div class="glass-panel p-6 sm:p-10 rounded-3xl border border-white/10 shadow-2xl relative">
                
                <!-- Topo do formulário com botão de preenchimento rápido -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-white/10 gap-3">
                    <div>
                        <h2 class="text-xl font-bold text-white">Formulário de Abertura de Chamado</h2>
                        <p class="text-xs text-slate-400">Preencha as informações da ocorrência. O sistema registrará automaticamente o horário de abertura.</p>
                    </div>
                    <button type="button" @click="preencherTeste()" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-xs font-mono text-foco-yellow-400 border border-foco-yellow-500/30 transition self-start sm:self-auto">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        Preencher com Dados de Teste
                    </button>
                </div>

                <!-- Notificação de Horário Automático -->
                <div class="mb-6 p-4 rounded-2xl bg-foco-navy-900 border border-foco-yellow-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs font-mono">
                    <div class="flex items-center gap-2.5 text-slate-300">
                        <span class="w-2.5 h-2.5 rounded-full bg-foco-green-400 animate-ping shrink-0"></span>
                        <span>Horário de Abertura Automático:</span>
                        <strong class="text-foco-yellow-400 text-sm" x-text="horaAtual || '{{ now()->format('d/m/Y H:i:s') }}'"></strong>
                    </div>
                    <span class="text-slate-400 text-[11px]">Sincronizado com Nuvem Operacional FOCO</span>
                </div>

                <form action="{{ route('site.chamados.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <!-- 1. TIPO DE CHAMADO (SELETOR VISUAL + SELECT) -->
                    <div class="space-y-2">
                        <label for="tipo" class="block text-xs font-mono font-bold text-foco-yellow-400 uppercase tracking-wider">
                            1. Tipo de Chamado *
                        </label>
                        <p class="text-xs text-slate-400">Selecione o tipo de ocorrência detectada no cruzamento:</p>

                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-1">
                            <!-- Opção AP -->
                            <label class="cursor-pointer relative p-3 rounded-2xl border text-center transition flex flex-col items-center justify-center gap-1"
                                :class="tipoSelecionado === 'AP' ? 'bg-amber-500/20 border-foco-yellow-500 text-white shadow-glow-yellow' : 'bg-foco-navy-900 border-white/10 text-slate-400 hover:border-white/30'">
                                <input type="radio" name="tipo" value="AP" class="sr-only" x-model="tipoSelecionado" required>
                                <span class="font-mono font-black text-lg text-amber-400">AP</span>
                                <span class="text-[11px] font-medium leading-tight">Amarelo Piscante</span>
                            </label>

                            <!-- Opção FA -->
                            <label class="cursor-pointer relative p-3 rounded-2xl border text-center transition flex flex-col items-center justify-center gap-1"
                                :class="tipoSelecionado === 'FA' ? 'bg-cyan-500/20 border-cyan-400 text-white shadow-glow-blue' : 'bg-foco-navy-900 border-white/10 text-slate-400 hover:border-white/30'">
                                <input type="radio" name="tipo" value="FA" class="sr-only" x-model="tipoSelecionado" required>
                                <span class="font-mono font-black text-lg text-cyan-400">FA</span>
                                <span class="text-[11px] font-medium leading-tight">Foco Apagado</span>
                            </label>

                            <!-- Opção Acidente -->
                            <label class="cursor-pointer relative p-3 rounded-2xl border text-center transition flex flex-col items-center justify-center gap-1"
                                :class="tipoSelecionado === 'Acidente' ? 'bg-rose-500/20 border-rose-400 text-white shadow-lg' : 'bg-foco-navy-900 border-white/10 text-slate-400 hover:border-white/30'">
                                <input type="radio" name="tipo" value="Acidente" class="sr-only" x-model="tipoSelecionado" required>
                                <span class="font-mono font-black text-lg text-rose-400">Acidente</span>
                                <span class="text-[11px] font-medium leading-tight">Colisão / Dano Físico</span>
                            </label>

                            <!-- Opção Vermelho Queimado -->
                            <label class="cursor-pointer relative p-3 rounded-2xl border text-center transition flex flex-col items-center justify-center gap-1"
                                :class="tipoSelecionado === 'Vermelho Queimado' ? 'bg-red-500/20 border-red-500 text-white shadow-lg' : 'bg-foco-navy-900 border-white/10 text-slate-400 hover:border-white/30'">
                                <input type="radio" name="tipo" value="Vermelho Queimado" class="sr-only" x-model="tipoSelecionado" required>
                                <span class="font-mono font-black text-lg text-red-400">Vermelho</span>
                                <span class="text-[11px] font-medium leading-tight">Vermelho Queimado</span>
                            </label>
                        </div>

                        <!-- Fallback nativo para acessibilidade -->
                        <div class="mt-2 hidden">
                            <select id="tipo" name="tipo_hidden" x-model="tipoSelecionado" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2 text-sm text-white">
                                <option value="AP">AP (Amarelo Piscante)</option>
                                <option value="FA">FA (Foco Apagado)</option>
                                <option value="Acidente">Acidente (Colisão / Dano Físico)</option>
                                <option value="Vermelho Queimado">Vermelho Queimado</option>
                            </select>
                        </div>
                        @error('tipo')
                            <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 2. NOME SOLICITANTE E NÚMERO PARA CONTATO -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-white/10">
                        <div>
                            <label for="nome_solicitante" class="block text-xs font-mono font-bold text-slate-300 mb-1">
                                Nome Solicitante *
                            </label>
                            <input type="text" name="nome_solicitante" id="nome_solicitante" required value="{{ old('nome_solicitante') }}" placeholder="Ex: Inspetor Marcelo Vargas / Guarda Municipal" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                            @error('nome_solicitante')
                                <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="telefone_contato" class="block text-xs font-mono font-bold text-slate-300 mb-1">
                                Número para Contato (WhatsApp) *
                            </label>
                            <input type="text" name="telefone_contato" id="telefone_contato" required value="{{ old('telefone_contato') }}" placeholder="(51) 99999-9999" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                            @error('telefone_contato')
                                <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- 3. LOCAL -->
                    <div class="pt-4 border-t border-white/10">
                        <label for="local" class="block text-xs font-mono font-bold text-slate-300 mb-1">
                            Local (Cruzamento, Rua, Avenida ou Rodovia) *
                        </label>
                        <input type="text" name="local" id="local" required value="{{ old('local') }}" placeholder="Ex: Av. Brasil cruzamento com Rua 1500 / Centro / Ponto de referência" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                        @error('local')
                            <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 4. DEFEITO -->
                    <div class="pt-4 border-t border-white/10">
                        <label for="defeito" class="block text-xs font-mono font-bold text-slate-300 mb-1">
                            Defeito Observado *
                        </label>
                        <textarea name="defeito" id="defeito" rows="3" required placeholder="Descreva com detalhes o defeito apresentado (ex: foco veicular em amarelo piscante, grupo vermelho queimado no sentido sul, controlador sem sincronismo, etc.)" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl p-4 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">{{ old('defeito') }}</textarea>
                        @error('defeito')
                            <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- 5. OBSERVAÇÃO -->
                    <div class="pt-4 border-t border-white/10">
                        <label for="observacao" class="block text-xs font-mono font-bold text-slate-300 mb-1">
                            Observação (Opcional)
                        </label>
                        <textarea name="observacao" id="observacao" rows="2" placeholder="Informações adicionais relevantes: se há viatura no local, interferência no trânsito, risco iminente ou referência de acesso." class="w-full bg-foco-navy-900 border border-white/10 rounded-xl p-4 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">{{ old('observacao') }}</textarea>
                        @error('observacao')
                            <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botão de Envio do Chamado -->
                    <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 border-t border-white/10">
                        <div class="flex items-center gap-2 text-xs text-slate-400 font-mono">
                            <span class="w-2 h-2 rounded-full bg-foco-green-400"></span>
                            <span>Horário de abertura capturado automaticamente no envio.</span>
                        </div>

                        <button type="submit" class="w-full sm:w-auto px-8 py-4 rounded-xl font-black text-sm uppercase tracking-wider bg-gradient-to-r from-foco-yellow-500 to-amber-500 text-foco-navy-950 shadow-glow-yellow hover:from-foco-yellow-400 hover:to-amber-400 hover:scale-105 active:scale-95 transition-all flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-foco-navy-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span>Registrar Chamado na FOCO</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ABA 2: CONSULTA POR PROTOCOLO E TRACKING VISUAL -->
        <div id="consulta" x-show="tab === 'consultar'" x-transition class="max-w-4xl mx-auto space-y-8">
            <!-- Barra de Busca por Protocolo -->
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
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="text-2xl sm:text-3xl font-black font-mono text-foco-yellow-400">{{ $chamadoBuscado->protocolo }}</span>
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $chamadoBuscado->tipo_badge_class }}">
                                Tipo: {{ $chamadoBuscado->tipo }}
                            </span>
                            <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{ $chamadoBuscado->status_badge_class }}">
                                {{ $chamadoBuscado->status }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 font-mono mt-2">
                            Aberto em: <strong class="text-white">{{ $chamadoBuscado->data_hora_abertura ? $chamadoBuscado->data_hora_abertura->format('d/m/Y H:i') : $chamadoBuscado->created_at->format('d/m/Y H:i') }}</strong>
                        </p>
                    </div>

                    <div class="p-3 rounded-2xl bg-foco-navy-900 border border-white/10 text-xs sm:text-right font-mono">
                        <span class="text-slate-400 block">Solicitante:</span>
                        <strong class="text-slate-200 block text-sm">{{ $chamadoBuscado->nome_solicitante }}</strong>
                        <span class="text-slate-400 text-[11px]">{{ $chamadoBuscado->telefone_contato }}</span>
                    </div>
                </div>

                <!-- Timeline de Status Operacional -->
                <div>
                    <h4 class="text-xs font-mono font-bold text-slate-400 uppercase tracking-wider mb-4">Progresso Operacional</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-center text-xs font-mono">
                        <div class="p-3 rounded-xl bg-foco-green-500/10 border border-foco-green-500/30 text-foco-green-400 font-bold">
                            ✓ 1. Aberto / Registrado
                        </div>
                        <div class="p-3 rounded-xl {{ in_array($chamadoBuscado->status, ['Em Atendimento', 'Finalizado']) ? 'bg-cyan-500/10 border border-cyan-500/30 text-cyan-400 font-bold' : 'bg-white/5 border border-white/10 text-slate-500' }}">
                            2. Em Atendimento
                        </div>
                        <div class="p-3 rounded-xl {{ $chamadoBuscado->status === 'Finalizado' ? 'bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 font-bold' : 'bg-white/5 border border-white/10 text-slate-500' }}">
                            3. Finalizado pela FOCO
                        </div>
                    </div>
                </div>

                <!-- Detalhes do Local e Defeito -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-mono">
                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/10 space-y-2">
                        <span class="text-slate-400 block uppercase font-bold text-[11px]">Local da Ocorrência:</span>
                        <p class="text-slate-200 text-sm font-sans font-semibold">{{ $chamadoBuscado->local }}</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/10 space-y-2">
                        <span class="text-slate-400 block uppercase font-bold text-[11px]">Contato & Atribuição:</span>
                        <p class="text-slate-200"><strong class="text-white">Solicitante:</strong> {{ $chamadoBuscado->nome_solicitante }}</p>
                        <p class="text-slate-200"><strong class="text-white">Telefone:</strong> {{ $chamadoBuscado->telefone_contato }}</p>
                        @if($chamadoBuscado->tecnico_responsavel)
                        <p class="text-slate-200"><strong class="text-white">Técnico Responsável:</strong> {{ $chamadoBuscado->tecnico_responsavel }}</p>
                        @endif
                    </div>
                </div>

                <!-- Defeito Relatado -->
                <div class="p-4 rounded-2xl bg-foco-navy-900/60 border border-white/10 text-sm">
                    <span class="text-xs font-mono text-slate-400 block uppercase font-bold mb-1">Defeito Informado:</span>
                    <p class="text-slate-200 leading-relaxed">{{ $chamadoBuscado->defeito }}</p>
                </div>

                <!-- Observação do Solicitante -->
                @if($chamadoBuscado->observacao)
                <div class="p-4 rounded-2xl bg-foco-navy-900/40 border border-white/5 text-sm">
                    <span class="text-xs font-mono text-slate-400 block uppercase font-bold mb-1">Observações do Solicitante:</span>
                    <p class="text-slate-300 leading-relaxed">{{ $chamadoBuscado->observacao }}</p>
                </div>
                @endif

                <!-- ======================================================== -->
                <!-- DESTAQUE: QUANDO A FOCO FINALIZAR INFORMAÇÃO COMPLETA     -->
                <!-- ======================================================== -->
                @if($chamadoBuscado->status === 'Finalizado')
                <div class="p-6 rounded-3xl bg-gradient-to-br from-emerald-950/60 via-foco-navy-900 to-foco-navy-950 border-2 border-emerald-500/50 shadow-2xl space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-emerald-500/20">
                        <div class="flex items-center gap-2.5">
                            <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                            <h3 class="text-lg font-black text-emerald-400">Finalização do Chamado pela Equipe FOCO</h3>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold font-mono bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 uppercase">
                            Serviço Concluído
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-mono">
                        <div class="p-3.5 rounded-xl bg-black/30 border border-white/5">
                            <span class="text-emerald-400 font-bold block uppercase text-[11px] mb-1">Horário de Execução:</span>
                            <p class="text-white text-sm font-semibold">
                                {{ $chamadoBuscado->data_hora_execucao ? $chamadoBuscado->data_hora_execucao->format('d/m/Y H:i') : 'Registrado pela central' }}
                            </p>
                        </div>

                        <div class="p-3.5 rounded-xl bg-black/30 border border-white/5">
                            <span class="text-emerald-400 font-bold block uppercase text-[11px] mb-1">Técnico Responsável:</span>
                            <p class="text-white text-sm font-semibold">
                                {{ $chamadoBuscado->tecnico_responsavel ?: 'Equipe Técnica FOCO' }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <span class="text-emerald-400 font-mono font-bold block uppercase text-xs">Conserto Executado:</span>
                        <div class="p-4 rounded-2xl bg-black/40 border border-white/10 text-sm text-slate-100 leading-relaxed font-sans">
                            {{ $chamadoBuscado->conserto_executado ?: 'Conserto e calibração concluídos conforme normas técnicas viárias.' }}
                        </div>
                    </div>

                    @if($chamadoBuscado->observacao_finalizacao)
                    <div class="space-y-1">
                        <span class="text-slate-400 font-mono font-bold block uppercase text-xs">Observação Técnica da Finalização:</span>
                        <div class="p-4 rounded-2xl bg-black/20 border border-white/5 text-xs text-slate-300 leading-relaxed font-mono">
                            {{ $chamadoBuscado->observacao_finalizacao }}
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Histórico de Eventos / Trilha de Auditoria -->
                @if(!empty($chamadoBuscado->historico))
                <div class="pt-4 border-t border-white/10">
                    <h4 class="text-xs font-mono font-bold text-slate-400 uppercase tracking-wider mb-3">Linha do Tempo de Atualizações</h4>
                    <div class="space-y-2 font-mono text-xs">
                        @foreach($chamadoBuscado->historico as $hist)
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
                <p class="text-xs text-slate-400 mt-1">Verifique o código ou consulte a lista abaixo.</p>
            </div>
            @endif

            <!-- Lista de Chamados Registrados -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-lg font-bold text-white">Todos os Chamados Registrados no Portal</h3>
                        <p class="text-xs text-slate-400">Ocorrências registradas na central FOCO.</p>
                    </div>
                    <span class="text-xs font-mono px-3 py-1 rounded-full bg-white/5 text-slate-300 border border-white/10">
                        {{ $todosChamados->count() }} Chamados Cadastrados
                    </span>
                </div>

                <div class="space-y-3">
                    @forelse($todosChamados as $item)
                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5 hover:border-foco-yellow-500/40 transition flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="font-mono font-bold text-foco-yellow-400 text-sm">{{ $item->protocolo }}</span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $item->tipo_badge_class }}">
                                    {{ $item->tipo }}
                                </span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $item->status_badge_class }}">
                                    {{ $item->status }}
                                </span>
                                <span class="text-xs text-slate-500 font-mono">• {{ $item->data_hora_abertura ? $item->data_hora_abertura->format('d/m/Y H:i') : $item->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <h4 class="text-sm font-semibold text-white">{{ $item->defeito }}</h4>
                            <p class="text-xs text-slate-400">{{ $item->local }} • Solicitante: {{ $item->nome_solicitante }}</p>
                        </div>

                        <div class="flex items-center gap-2 self-start sm:self-auto shrink-0">
                            <a href="{{ route('site.chamados', ['protocolo' => $item->protocolo]) }}#consulta" class="px-3.5 py-1.5 rounded-lg text-xs font-mono font-bold bg-white/5 hover:bg-foco-yellow-500 hover:text-foco-navy-950 text-slate-300 transition">
                                Ver Detalhes →
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="py-8 text-center text-slate-400">
                        Nenhum chamado registrado no momento.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

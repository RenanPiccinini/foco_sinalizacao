<x-app-layout>
    <div class="space-y-6 max-w-5xl mx-auto">
        
        <!-- Breadcrumb e Voltar -->
        <div class="flex items-center justify-between pb-4 border-b border-white/10">
            <div class="flex items-center gap-2 text-xs font-mono">
                <a href="{{ route('admin.chamados.index') }}" class="text-foco-yellow-400 hover:underline flex items-center gap-1">
                    ← Voltar para Chamados
                </a>
                <span class="text-slate-600">/</span>
                <span class="text-slate-300 font-bold">{{ $chamado['protocolo'] }}</span>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-400 font-mono">Cadastrado em: {{ $chamado['created_at'] }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Coluna Esquerda: Detalhes do Chamado e Histórico -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Card Principal -->
                <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-2xl space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-6 border-b border-white/10">
                        <div>
                            <span class="text-xs font-mono font-bold text-foco-yellow-400 block">{{ $chamado['categoria'] }}</span>
                            <h1 class="text-2xl font-black text-white mt-1">{{ $chamado['titulo'] }}</h1>
                        </div>
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold font-mono uppercase tracking-wider self-start sm:self-auto {{ $chamado['status'] === 'Aberto' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : ($chamado['status'] === 'Em Atendimento' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30' : ($chamado['status'] === 'Pendente Peça' ? 'bg-purple-500/20 text-purple-300' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30')) }}">
                            {{ $chamado['status'] }}
                        </span>
                    </div>

                    <!-- Dados do Cruzamento -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-mono">
                        <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-1.5">
                            <span class="text-slate-500 block uppercase font-bold text-[10px]">Localização / Cruzamento:</span>
                            <p class="text-slate-200 text-sm font-sans font-bold">{{ $chamado['localizacao'] }}</p>
                            <p class="text-foco-yellow-400">{{ $chamado['municipio'] }}</p>
                            @if($chamado['ponto_referencia'])
                            <p class="text-slate-400 font-sans text-xs">Ref: {{ $chamado['ponto_referencia'] }}</p>
                            @endif
                        </div>

                        <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-1.5">
                            <span class="text-slate-500 block uppercase font-bold text-[10px]">Solicitante & Órgão:</span>
                            <p class="text-slate-200 text-sm font-sans font-bold">{{ $chamado['solicitante_nome'] }}</p>
                            <p class="text-cyan-400">{{ $chamado['solicitante_orgao'] }}</p>
                            <p class="text-slate-400">{{ $chamado['solicitante_telefone'] }} • {{ $chamado['solicitante_email'] }}</p>
                        </div>
                    </div>

                    <!-- Descrição da Ocorrência -->
                    <div class="space-y-2">
                        <span class="text-xs font-mono uppercase font-bold text-slate-400">Descrição Detalhada do Chamado:</span>
                        <div class="p-4 rounded-2xl bg-foco-navy-900/80 border border-white/5 text-sm text-slate-200 leading-relaxed">
                            {{ $chamado['descricao'] }}
                        </div>
                    </div>

                    <!-- Equipamento Afetado -->
                    <div class="p-4 rounded-2xl bg-foco-navy-900/60 border border-white/5 flex items-center justify-between text-xs font-mono">
                        <span class="text-slate-400">Ativo / Hardware Relatado:</span>
                        <strong class="text-white">{{ $chamado['equipamento_afetado'] }}</strong>
                    </div>
                </div>

                <!-- Linha do Tempo / Histórico de Auditoria Digital -->
                <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-2xl">
                    <h3 class="text-sm font-mono font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                        Trilha de Auditoria Digital (Audit Trail)
                    </h3>

                    <div class="space-y-3 font-mono text-xs">
                        @foreach($chamado['historico'] as $h)
                        <div class="p-3.5 rounded-xl bg-foco-navy-900 border border-white/5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div class="flex items-start gap-2.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-foco-yellow-400 mt-1.5 shrink-0"></span>
                                <div>
                                    <span class="text-slate-200 block font-medium">{{ $h['evento'] }}</span>
                                    <span class="text-[11px] text-slate-500">Autor: {{ $h['usuario'] }}</span>
                                </div>
                            </div>
                            <span class="text-foco-yellow-400 font-bold text-[11px] shrink-0">{{ $h['data'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Coluna Direita: Painel de Atualização do Status (Ação do Admin) -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Formulário de Alteração de Status -->
                <div class="glass-panel-glow p-6 rounded-3xl border border-foco-yellow-500/30 shadow-2xl space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-foco-yellow-400"></span>
                        <h3 class="text-base font-bold text-white">Despacho & Atualização</h3>
                    </div>
                    <p class="text-xs text-slate-400">Altere o status operacional e notifique o solicitante na nuvem.</p>

                    <form action="{{ route('admin.chamados.update', $chamado['id']) }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-mono text-slate-300 mb-1">Status Operacional *</label>
                            <select name="status" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-3 py-2.5 text-xs text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                                <option value="Aberto" {{ $chamado['status'] === 'Aberto' ? 'selected' : '' }}>🟡 Aberto (Triagem Inicial)</option>
                                <option value="Em Atendimento" {{ $chamado['status'] === 'Em Atendimento' ? 'selected' : '' }}>🔵 Em Atendimento (Equipe Despachada)</option>
                                <option value="Pendente Peça" {{ $chamado['status'] === 'Pendente Peça' ? 'selected' : '' }}>🟣 Pendente Peça / Reposição</option>
                                <option value="Concluído" {{ $chamado['status'] === 'Concluído' ? 'selected' : '' }}>🟢 Concluído (Normalizado)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-mono text-slate-300 mb-1">Técnico / Equipe em Campo</label>
                            <input type="text" name="tecnico_responsavel" value="{{ $chamado['tecnico_responsavel'] }}" placeholder="Ex: Eng. Ricardo Silveira (Equipe Alpha)" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-3 py-2 text-xs text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                        </div>

                        <div>
                            <label class="block text-xs font-mono text-slate-300 mb-1">Nota Operacional / Evento</label>
                            <textarea name="observacao" rows="3" placeholder="Ex: Substituída fonte do nobreak e efetuado teste de carga." class="w-full bg-foco-navy-900 border border-white/10 rounded-xl p-3 text-xs text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500"></textarea>
                        </div>

                        <button type="submit" class="w-full py-3 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition shadow-glow-yellow">
                            Salvar Atualização
                        </button>
                    </form>
                </div>

                <!-- Cartão com SLA e Prioridade -->
                <div class="glass-panel p-5 rounded-2xl border border-white/10 text-xs font-mono space-y-3">
                    <span class="text-slate-400 block uppercase font-bold text-[10px]">Parâmetros do Contrato:</span>
                    <div class="flex items-center justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-400">Prioridade:</span>
                        <strong class="{{ $chamado['prioridade'] === 'Crítica' ? 'text-rose-400' : 'text-amber-400' }}">{{ $chamado['prioridade'] }}</strong>
                    </div>
                    <div class="flex items-center justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-400">SLA Previsto:</span>
                        <strong class="text-foco-green-400">{{ $chamado['sla_estimado'] }}</strong>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Telemetria 4G:</span>
                        <strong class="text-cyan-400">Sinal Forte</strong>
                    </div>
                </div>

            </div>

        </div>

    </div>
</x-app-layout>


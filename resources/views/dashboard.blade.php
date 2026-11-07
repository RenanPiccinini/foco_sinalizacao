<x-app-layout>
    <div class="space-y-8">
        
        <!-- Cabeçalho do Dashboard -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
            <div>
                <span class="text-xs font-mono text-foco-yellow-400 uppercase tracking-widest font-bold">Painel de Controle Viário</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Central de Operações Integradas (ITS)</h1>
                <p class="text-xs text-slate-400 mt-1">Monitoramento em tempo real de controladores, chamados públicos e telemetria em nuvem.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.chamados.index') }}" class="px-4 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition shadow-glow-yellow flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                    <span>Gerenciar Chamados ({{ $stats['total_chamados'] }})</span>
                </a>
            </div>
        </div>

        <!-- Grid de Cards de Estatísticas e KPIs -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            
            <!-- KPI 1: Chamados em Aberto -->
            <div class="glass-panel p-5 rounded-2xl border-l-4 border-l-amber-500 relative overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-mono font-bold text-slate-400 uppercase">Chamados em Aberto</span>
                    <span class="p-2 rounded-xl bg-amber-500/10 text-amber-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black font-mono text-white">{{ $stats['abertos'] }}</span>
                    <span class="text-xs text-amber-400 font-medium">Requerem Triagem</span>
                </div>
                <a href="{{ route('admin.chamados.index', ['status' => 'Aberto']) }}" class="mt-3 block text-xs text-foco-yellow-400 hover:underline">Ver fila de abertos →</a>
            </div>

            <!-- KPI 2: Chamados em Atendimento -->
            <div class="glass-panel p-5 rounded-2xl border-l-4 border-l-cyan-400 relative overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-mono font-bold text-slate-400 uppercase">Em Atendimento</span>
                    <span class="p-2 rounded-xl bg-cyan-400/10 text-cyan-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black font-mono text-white">{{ $stats['em_atendimento'] }}</span>
                    <span class="text-xs text-cyan-400 font-medium">Equipes Despachadas</span>
                </div>
                <a href="{{ route('admin.chamados.index', ['status' => 'Em Atendimento']) }}" class="mt-3 block text-xs text-cyan-400 hover:underline">Ver chamados ativos →</a>
            </div>

            <!-- KPI 3: Controladores Ativos & Onda Verde -->
            <div class="glass-panel p-5 rounded-2xl border-l-4 border-l-foco-green-500 relative overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-mono font-bold text-slate-400 uppercase">Controladores IoT</span>
                    <span class="p-2 rounded-xl bg-foco-green-500/10 text-foco-green-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black font-mono text-white">{{ $stats['controladores_online'] }}</span>
                    <span class="text-xs text-foco-green-400 font-medium">{{ $stats['eficiencia_onda_verde'] }} Onda Verde</span>
                </div>
                <span class="mt-3 block text-xs text-slate-400 font-mono">Digicon 4G/GPS Conectados</span>
            </div>

            <!-- KPI 4: Uptime Nobreaks LiFePO4 -->
            <div class="glass-panel p-5 rounded-2xl border-l-4 border-l-emerald-400 relative overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <span class="text-xs font-mono font-bold text-slate-400 uppercase">Autonomia Nobreaks</span>
                    <span class="p-2 rounded-xl bg-emerald-400/10 text-emerald-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </span>
                </div>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-black font-mono text-white">{{ $stats['uptime_nobreaks'] }}</span>
                    <span class="text-xs text-emerald-400 font-medium">Zero Apagões</span>
                </div>
                <span class="mt-3 block text-xs text-slate-400 font-mono">Bancos de Lítio LiFePO4</span>
            </div>

        </div>

        <!-- Seção de Chamados Recentes com Link Direto para o Menu Chamados -->
        <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-white/10 shadow-2xl">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-foco-yellow-400 animate-ping"></span>
                        <h2 class="text-xl font-bold text-white">Chamados Registrados no Portal</h2>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Visualização rápida das ocorrências abertas por clientes, cidadãos e prefeituras.</p>
                </div>

                <a href="{{ route('admin.chamados.index') }}" class="px-4 py-2 rounded-xl text-xs font-mono font-bold bg-white/5 hover:bg-foco-yellow-500 hover:text-foco-navy-950 text-foco-yellow-400 border border-foco-yellow-500/30 transition self-start sm:self-auto">
                    Acessar Menu "Chamados" Completo →
                </a>
            </div>

            <div class="overflow-x-auto mt-4">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="text-slate-400 font-mono uppercase tracking-wider border-b border-white/10">
                            <th class="py-3 px-4 font-bold">Protocolo</th>
                            <th class="py-3 px-4 font-bold">Título / Assunto</th>
                            <th class="py-3 px-4 font-bold">Município / Local</th>
                            <th class="py-3 px-4 font-bold">Prioridade</th>
                            <th class="py-3 px-4 font-bold">Status</th>
                            <th class="py-3 px-4 font-bold">Data</th>
                            <th class="py-3 px-4 font-bold text-right">Ação</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($recentes as $c)
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-foco-yellow-400">{{ $c['protocolo'] }}</td>
                            <td class="py-3.5 px-4 font-medium text-white max-w-xs truncate">{{ $c['titulo'] }}</td>
                            <td class="py-3.5 px-4 text-slate-300">{{ $c['municipio'] }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $c['prioridade'] === 'Crítica' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : ($c['prioridade'] === 'Alta' ? 'bg-amber-500/20 text-amber-300' : 'bg-slate-500/20 text-slate-300') }}">
                                    {{ $c['prioridade'] }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $c['status'] === 'Aberto' ? 'bg-amber-500/20 text-amber-300' : ($c['status'] === 'Em Atendimento' ? 'bg-cyan-500/20 text-cyan-300' : 'bg-emerald-500/20 text-emerald-300') }}">
                                    {{ $c['status'] }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-400">{{ $c['created_at'] }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('admin.chamados.show', $c['id']) }}" class="px-2.5 py-1 rounded bg-white/5 hover:bg-foco-yellow-500 hover:text-foco-navy-950 text-slate-300 transition font-mono">
                                    Ver Detalhes
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Seção: Controladores em Destaque & Onda Verde -->
        <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-white/10 shadow-2xl">
            <div class="flex items-center justify-between pb-4 border-b border-white/10 mb-4">
                <div>
                    <h3 class="text-lg font-bold text-white">Nós Semafóricos em Monitoramento Direto</h3>
                    <p class="text-xs text-slate-400">Telemetria 4G / Baterias de Lítio LiFePO4 / Onda Verde</p>
                </div>
                <span class="text-xs font-mono text-foco-green-400 flex items-center gap-1.5">
                    <span class="w-2 h-2 rounded-full bg-foco-green-400 animate-ping"></span>
                    Central DIGICON Nuvem Sincronizada
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($controladoresDestaque as $ctl)
                <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-2 text-xs font-mono">
                    <div class="flex items-center justify-between">
                        <span class="font-bold text-foco-yellow-400">{{ $ctl['tag'] }}</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold {{ $ctl['status'] === 'Online' ? 'bg-foco-green-500/20 text-foco-green-400' : 'bg-amber-500/20 text-amber-400' }}">
                            {{ $ctl['status'] }}
                        </span>
                    </div>
                    <p class="text-slate-200 font-sans font-semibold text-xs truncate">{{ $ctl['local'] }}</p>
                    <div class="pt-2 border-t border-white/5 flex items-center justify-between text-[11px] text-slate-400">
                        <span>Modo: <strong class="text-slate-200">{{ $ctl['modo'] }}</strong></span>
                        <span class="text-cyan-400">{{ $ctl['bateria'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>

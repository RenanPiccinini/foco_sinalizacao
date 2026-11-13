<x-app-layout>
    <div class="space-y-8">
        
        <!-- Cabeçalho do Dashboard -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
            <div>
                <span class="text-xs font-mono text-foco-yellow-400 uppercase tracking-widest font-bold">Painel de Controle Viário</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Central de Operações Integradas (ITS)</h1>
                <p class="text-xs text-slate-400 mt-1">Monitoramento em tempo real de controladores, chamados públicos e telemetria em nuvem.</p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('admin.conexao.index') }}" class="px-3.5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-emerald-500/10 hover:bg-emerald-500 hover:text-foco-navy-950 text-emerald-400 border border-emerald-500/30 transition flex items-center gap-2">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    <span>Conexão WhatsApp</span>
                </a>
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
                <span class="mt-3 block text-xs text-slate-400 font-mono">Controladores 4G/GPS Conectados</span>
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

            <!-- VISUALIZAÇÃO DESKTOP: Tabela com Rolagem Suave -->
            <div class="hidden md:block overflow-x-auto mt-4">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="text-slate-400 font-mono uppercase tracking-wider border-b border-white/10">
                            <th class="py-3 px-4 font-bold">Protocolo</th>
                            <th class="py-3 px-4 font-bold">Tipo</th>
                            <th class="py-3 px-4 font-bold">Local</th>
                            <th class="py-3 px-4 font-bold">Defeito</th>
                            <th class="py-3 px-4 font-bold">Status</th>
                            <th class="py-3 px-4 font-bold">Abertura</th>
                            <th class="py-3 px-4 font-bold text-right">Ação</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @foreach($recentes as $c)
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-foco-yellow-400">{{ $c->protocolo }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $c->tipo_badge_class }}">
                                    {{ $c->tipo }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-300 max-w-xs truncate">{{ $c->local }}</td>
                            <td class="py-3.5 px-4 font-medium text-white max-w-xs truncate">{{ $c->defeito }}</td>
                            <td class="py-3.5 px-4">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $c->status_badge_class }}">
                                    {{ $c->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 font-mono text-slate-400">{{ $c->data_hora_abertura ? $c->data_hora_abertura->format('d/m/Y H:i') : $c->created_at->format('d/m/Y H:i') }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('admin.chamados.show', $c->id) }}" class="px-2.5 py-1 rounded bg-white/5 hover:bg-foco-yellow-500 hover:text-foco-navy-950 text-slate-300 transition font-mono">
                                    Ver Detalhes
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- VISUALIZAÇÃO MOBILE: Cards 100% Responsivos com Todos os Dados Visíveis -->
            <div class="block md:hidden divide-y divide-white/5 mt-4">
                @foreach($recentes as $c)
                <div class="py-3.5 space-y-2">
                    <div class="flex items-center justify-between gap-2">
                        <span class="font-mono font-bold text-xs text-foco-yellow-400">{{ $c->protocolo }}</span>
                        <div class="flex items-center gap-1.5">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $c->tipo_badge_class }}">
                                {{ $c->tipo }}
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $c->status_badge_class }}">
                                {{ $c->status }}
                            </span>
                        </div>
                    </div>

                    <div>
                        <p class="font-medium text-white text-xs leading-snug">{{ $c->defeito }}</p>
                        <p class="text-[11px] text-slate-400 mt-0.5">{{ $c->local }}</p>
                    </div>

                    <div class="flex items-center justify-between pt-1 text-[11px] font-mono text-slate-400">
                        <span>{{ $c->data_hora_abertura ? $c->data_hora_abertura->format('d/m/Y H:i') : $c->created_at->format('d/m/Y H:i') }}</span>
                        <a href="{{ route('admin.chamados.show', $c->id) }}" class="px-2.5 py-1 rounded bg-white/5 hover:bg-foco-yellow-500 hover:text-foco-navy-950 text-foco-yellow-400 font-bold transition">
                            Ver Detalhes →
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Seção: Controladores em Destaque & Onda Verde -->
        <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-white/10 shadow-2xl">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pb-4 border-b border-white/10 mb-4">
                <div>
                    <h3 class="text-lg font-bold text-white">Nós Semafóricos em Monitoramento Direto</h3>
                    <p class="text-xs text-slate-400">Telemetria 4G / Baterias de Lítio LiFePO4 / Onda Verde</p>
                </div>
                <span class="text-xs font-mono text-foco-green-400 flex items-center gap-1.5 self-start sm:self-auto">
                    <span class="w-2 h-2 rounded-full bg-foco-green-400 animate-ping"></span>
                    <span>Central em Nuvem Sincronizada</span>
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

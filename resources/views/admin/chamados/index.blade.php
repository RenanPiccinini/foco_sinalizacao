<x-app-layout>
    <div class="space-y-6">

        <!-- Topo da Página -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-foco-yellow-400 animate-ping"></span>
                    <span class="text-xs font-mono text-foco-yellow-400 uppercase tracking-widest font-bold">Menu Principal de Operações</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Chamados de Suporte & Manutenção</h1>
                <p class="text-xs text-slate-400 mt-1">Todos os chamados registrados no portal pelos clientes, agentes de trânsito e prefeituras.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('site.chamados') }}" target="_blank" class="px-4 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition shadow-glow-yellow flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Abrir Novo no Site</span>
                </a>
            </div>
        </div>

        <!-- Badges de Métricas do Menu Chamados -->
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
            <a href="{{ route('admin.chamados.index') }}" class="p-4 rounded-2xl glass-panel hover:border-white/20 transition {{ $status === 'todos' ? 'border-foco-yellow-500/50 bg-white/5' : '' }}">
                <span class="text-[11px] font-mono uppercase text-slate-400 block">Total</span>
                <span class="text-2xl font-black font-mono text-white mt-1 block">{{ $stats['total'] }}</span>
            </a>

            <a href="{{ route('admin.chamados.index', ['status' => 'Aberto']) }}" class="p-4 rounded-2xl glass-panel hover:border-amber-500/50 transition {{ $status === 'Aberto' ? 'border-amber-500 bg-amber-500/10' : '' }}">
                <span class="text-[11px] font-mono uppercase text-amber-400 block">Abertos</span>
                <span class="text-2xl font-black font-mono text-amber-400 mt-1 block">{{ $stats['abertos'] }}</span>
            </a>

            <a href="{{ route('admin.chamados.index', ['status' => 'Em Atendimento']) }}" class="p-4 rounded-2xl glass-panel hover:border-cyan-500/50 transition {{ $status === 'Em Atendimento' ? 'border-cyan-500 bg-cyan-500/10' : '' }}">
                <span class="text-[11px] font-mono uppercase text-cyan-400 block">Em Atendimento</span>
                <span class="text-2xl font-black font-mono text-cyan-400 mt-1 block">{{ $stats['em_atendimento'] }}</span>
            </a>

            <a href="{{ route('admin.chamados.index', ['status' => 'Concluído']) }}" class="p-4 rounded-2xl glass-panel hover:border-foco-green-500/50 transition {{ $status === 'Concluído' ? 'border-foco-green-500 bg-foco-green-500/10' : '' }}">
                <span class="text-[11px] font-mono uppercase text-foco-green-400 block">Concluídos</span>
                <span class="text-2xl font-black font-mono text-foco-green-400 mt-1 block">{{ $stats['concluidos'] }}</span>
            </a>

            <a href="{{ route('admin.chamados.index', ['prioridade' => 'Crítica']) }}" class="p-4 rounded-2xl glass-panel hover:border-rose-500/50 transition {{ $prioridade === 'Crítica' ? 'border-rose-500 bg-rose-500/10' : '' }}">
                <span class="text-[11px] font-mono uppercase text-rose-400 block">Críticos</span>
                <span class="text-2xl font-black font-mono text-rose-400 mt-1 block">{{ $stats['criticos'] }}</span>
            </a>
        </div>

        <!-- Filtros e Barra de Pesquisa -->
        <div class="glass-panel p-4 rounded-2xl border border-white/10">
            <form action="{{ route('admin.chamados.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                
                <!-- Busca textual -->
                <div class="sm:col-span-4">
                    <input type="text" name="busca" value="{{ $busca }}" placeholder="Buscar por protocolo, rua, solicitante..." class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2 text-xs text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                </div>

                <!-- Filtro Status -->
                <div class="sm:col-span-3">
                    <select name="status" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-3 py-2 text-xs text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                        <option value="todos" {{ $status === 'todos' ? 'selected' : '' }}>Todos os Status</option>
                        <option value="Aberto" {{ $status === 'Aberto' ? 'selected' : '' }}>Abertos</option>
                        <option value="Em Atendimento" {{ $status === 'Em Atendimento' ? 'selected' : '' }}>Em Atendimento</option>
                        <option value="Pendente Peça" {{ $status === 'Pendente Peça' ? 'selected' : '' }}>Pendente Peça</option>
                        <option value="Concluído" {{ $status === 'Concluído' ? 'selected' : '' }}>Concluídos</option>
                    </select>
                </div>

                <!-- Filtro Prioridade -->
                <div class="sm:col-span-2">
                    <select name="prioridade" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-3 py-2 text-xs text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                        <option value="todas" {{ $prioridade === 'todas' ? 'selected' : '' }}>Prioridades</option>
                        <option value="Crítica" {{ $prioridade === 'Crítica' ? 'selected' : '' }}>Crítica</option>
                        <option value="Alta" {{ $prioridade === 'Alta' ? 'selected' : '' }}>Alta</option>
                        <option value="Média" {{ $prioridade === 'Média' ? 'selected' : '' }}>Média</option>
                        <option value="Baixa" {{ $prioridade === 'Baixa' ? 'selected' : '' }}>Baixa</option>
                    </select>
                </div>

                <!-- Botões Filtrar e Limpar -->
                <div class="sm:col-span-3 flex items-center gap-2">
                    <button type="submit" class="w-full px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition">
                        Filtrar
                    </button>
                    @if($status !== 'todos' || $prioridade !== 'todas' || $busca)
                    <a href="{{ route('admin.chamados.index') }}" class="px-3 py-2 rounded-xl text-xs text-slate-400 hover:text-white bg-white/5 transition">
                        Limpar
                    </a>
                    @endif
                </div>

            </form>
        </div>

        <!-- Tabela Principal de Chamados Abertos no Site -->
        <div class="glass-panel rounded-3xl border border-white/10 overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-foco-navy-900/90 border-b border-white/10 text-slate-400 font-mono uppercase tracking-wider">
                            <th class="py-4 px-5 font-bold">Protocolo</th>
                            <th class="py-4 px-5 font-bold">Título / Ocorrência</th>
                            <th class="py-4 px-5 font-bold">Município & Cruzamento</th>
                            <th class="py-4 px-5 font-bold">Solicitante</th>
                            <th class="py-4 px-5 font-bold">Prioridade</th>
                            <th class="py-4 px-5 font-bold">Status</th>
                            <th class="py-4 px-5 font-bold">Data</th>
                            <th class="py-4 px-5 font-bold text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($chamados as $item)
                        <tr class="hover:bg-white/5 transition">
                            <!-- Protocolo -->
                            <td class="py-4 px-5 font-mono font-bold text-foco-yellow-400">
                                <a href="{{ route('admin.chamados.show', $item['id']) }}" class="hover:underline">
                                    {{ $item['protocolo'] }}
                                </a>
                            </td>

                            <!-- Título e Categoria -->
                            <td class="py-4 px-5 max-w-xs">
                                <span class="font-bold text-white block truncate">{{ $item['titulo'] }}</span>
                                <span class="text-[11px] text-slate-400 block truncate">{{ $item['categoria'] }}</span>
                            </td>

                            <!-- Município e Cruzamento -->
                            <td class="py-4 px-5 max-w-xs">
                                <span class="text-slate-200 font-medium block truncate">{{ $item['municipio'] }}</span>
                                <span class="text-[11px] text-slate-400 block truncate">{{ $item['localizacao'] }}</span>
                            </td>

                            <!-- Solicitante -->
                            <td class="py-4 px-5">
                                <span class="text-slate-200 block">{{ $item['solicitante_nome'] }}</span>
                                <span class="text-[11px] text-slate-400 block">{{ $item['solicitante_orgao'] }}</span>
                            </td>

                            <!-- Prioridade -->
                            <td class="py-4 px-5">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $item['prioridade'] === 'Crítica' ? 'bg-rose-500/20 text-rose-300 border border-rose-500/30' : ($item['prioridade'] === 'Alta' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : ($item['prioridade'] === 'Média' ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' : 'bg-slate-500/20 text-slate-300')) }}">
                                    {{ $item['prioridade'] }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-5">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $item['status'] === 'Aberto' ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : ($item['status'] === 'Em Atendimento' ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30' : ($item['status'] === 'Pendente Peça' ? 'bg-purple-500/20 text-purple-300' : 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30')) }}">
                                    {{ $item['status'] }}
                                </span>
                            </td>

                            <!-- Data -->
                            <td class="py-4 px-5 font-mono text-slate-400 text-[11px]">
                                {{ $item['created_at'] }}
                            </td>

                            <!-- Ações Rápidas -->
                            <td class="py-4 px-5 text-right space-x-1">
                                <a href="{{ route('admin.chamados.show', $item['id']) }}" class="px-3 py-1.5 rounded-lg text-xs font-mono font-bold bg-white/5 hover:bg-foco-yellow-500 hover:text-foco-navy-950 text-slate-300 transition">
                                    Ver Detalhes →
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400">
                                <div class="max-w-xs mx-auto space-y-2">
                                    <svg class="w-8 h-8 text-slate-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="font-medium text-white">Nenhum chamado encontrado para os filtros selecionados.</p>
                                    <a href="{{ route('admin.chamados.index') }}" class="text-xs text-foco-yellow-400 hover:underline block">Limpar filtros</a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>

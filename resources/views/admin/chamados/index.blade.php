<x-app-layout>
    <div class="space-y-6" x-data="{ modalInterno: false }">

        <!-- Topo da Página -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-foco-yellow-400 animate-ping"></span>
                    <span class="text-xs font-mono text-foco-yellow-400 uppercase tracking-widest font-bold">Menu Principal de Operações</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Chamados de Suporte & Manutenção</h1>
                <p class="text-xs text-slate-400 mt-1">Todos os chamados registrados no portal pelos clientes e pela equipe técnica.</p>
            </div>

            <div class="flex flex-wrap items-center gap-2.5">
                <!-- Exportar CSV -->
                <a href="{{ route('admin.chamados.export.csv') }}" class="px-3.5 py-2 rounded-xl font-bold text-xs font-mono bg-white/5 hover:bg-white/10 text-slate-200 border border-white/10 transition flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span>Exportar CSV</span>
                </a>

                <!-- Abrir Chamado Interno -->
                <button type="button" @click="modalInterno = true" class="px-3.5 py-2 rounded-xl font-bold text-xs font-mono bg-white/5 hover:bg-white/10 text-cyan-300 border border-cyan-500/30 transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                    <span>+ Chamado Interno</span>
                </button>

                <!-- Abrir no Site -->
                <a href="{{ route('site.chamados') }}" target="_blank" class="px-4 py-2 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition shadow-glow-yellow flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span>Abrir no Site</span>
                </a>
            </div>
        </div>

        <!-- Badges de Métricas por Status e por Tipo (100% Responsivas) -->
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-8 gap-2.5 sm:gap-3">
            <a href="{{ route('admin.chamados.index') }}" class="p-3 rounded-2xl glass-panel hover:border-white/20 transition {{ $status === 'todos' && $tipo === 'todos' ? 'border-foco-yellow-500/50 bg-white/5' : '' }}">
                <span class="text-[10px] font-mono uppercase text-slate-400 block">Total</span>
                <span class="text-lg sm:text-xl font-black font-mono text-white mt-0.5 block">{{ $stats['total'] }}</span>
            </a>

            <a href="{{ route('admin.chamados.index', ['status' => 'Aberto']) }}" class="p-3 rounded-2xl glass-panel hover:border-amber-500/50 transition {{ $status === 'Aberto' ? 'border-amber-500 bg-amber-500/10' : '' }}">
                <span class="text-[10px] font-mono uppercase text-amber-400 block">Abertos</span>
                <span class="text-lg sm:text-xl font-black font-mono text-amber-400 mt-0.5 block">{{ $stats['abertos'] }}</span>
            </a>

            <a href="{{ route('admin.chamados.index', ['status' => 'Em Atendimento']) }}" class="p-3 rounded-2xl glass-panel hover:border-cyan-500/50 transition {{ $status === 'Em Atendimento' ? 'border-cyan-500 bg-cyan-500/10' : '' }}">
                <span class="text-[10px] font-mono uppercase text-cyan-400 block">Atendimento</span>
                <span class="text-lg sm:text-xl font-black font-mono text-cyan-400 mt-0.5 block">{{ $stats['em_atendimento'] }}</span>
            </a>

            <a href="{{ route('admin.chamados.index', ['status' => 'Finalizado']) }}" class="p-3 rounded-2xl glass-panel hover:border-foco-green-500/50 transition {{ $status === 'Finalizado' ? 'border-foco-green-500 bg-foco-green-500/10' : '' }}">
                <span class="text-[10px] font-mono uppercase text-foco-green-400 block">Finalizados</span>
                <span class="text-lg sm:text-xl font-black font-mono text-foco-green-400 mt-0.5 block">{{ $stats['finalizados'] }}</span>
            </a>

            <a href="{{ route('admin.chamados.index', ['tipo' => 'AP']) }}" class="p-3 rounded-2xl glass-panel hover:border-amber-400/50 transition {{ $tipo === 'AP' ? 'border-amber-400 bg-amber-500/10' : '' }}">
                <span class="text-[10px] font-mono uppercase text-amber-300 block">Tipo AP</span>
                <span class="text-lg sm:text-xl font-black font-mono text-amber-300 mt-0.5 block">{{ $stats['ap'] }}</span>
            </a>

            <a href="{{ route('admin.chamados.index', ['tipo' => 'FA']) }}" class="p-3 rounded-2xl glass-panel hover:border-cyan-400/50 transition {{ $tipo === 'FA' ? 'border-cyan-400 bg-cyan-500/10' : '' }}">
                <span class="text-[10px] font-mono uppercase text-cyan-300 block">Tipo FA</span>
                <span class="text-lg sm:text-xl font-black font-mono text-cyan-300 mt-0.5 block">{{ $stats['fa'] }}</span>
            </a>

            <a href="{{ route('admin.chamados.index', ['tipo' => 'Acidente']) }}" class="p-3 rounded-2xl glass-panel hover:border-rose-400/50 transition {{ $tipo === 'Acidente' ? 'border-rose-400 bg-rose-500/10' : '' }}">
                <span class="text-[10px] font-mono uppercase text-rose-300 block">Acidentes</span>
                <span class="text-lg sm:text-xl font-black font-mono text-rose-300 mt-0.5 block">{{ $stats['acidentes'] }}</span>
            </a>

            <a href="{{ route('admin.chamados.index', ['tipo' => 'Vermelho Queimado']) }}" class="p-3 rounded-2xl glass-panel hover:border-red-500/50 transition {{ $tipo === 'Vermelho Queimado' ? 'border-red-500 bg-red-500/10' : '' }}">
                <span class="text-[10px] font-mono uppercase text-red-400 block">Verm. Queimado</span>
                <span class="text-lg sm:text-xl font-black font-mono text-red-400 mt-0.5 block">{{ $stats['vermelho_queimado'] }}</span>
            </a>
        </div>

        <!-- Filtros e Barra de Pesquisa -->
        <div class="glass-panel p-4 rounded-2xl border border-white/10">
            <form action="{{ route('admin.chamados.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                
                <!-- Busca textual -->
                <div class="sm:col-span-5">
                    <input type="text" name="busca" value="{{ $busca }}" placeholder="Buscar por protocolo, solicitante, local, contato ou defeito..." class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2 text-xs text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                </div>

                <!-- Filtro Status -->
                <div class="sm:col-span-3">
                    <select name="status" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-3 py-2 text-xs text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                        <option value="todos" {{ $status === 'todos' ? 'selected' : '' }}>Todos os Status</option>
                        <option value="Aberto" {{ $status === 'Aberto' ? 'selected' : '' }}>Abertos</option>
                        <option value="Em Atendimento" {{ $status === 'Em Atendimento' ? 'selected' : '' }}>Em Atendimento</option>
                        <option value="Finalizado" {{ $status === 'Finalizado' ? 'selected' : '' }}>Finalizados</option>
                    </select>
                </div>

                <!-- Filtro Tipo -->
                <div class="sm:col-span-2">
                    <select name="tipo" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-3 py-2 text-xs text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                        <option value="todos" {{ $tipo === 'todos' ? 'selected' : '' }}>Todos os Tipos</option>
                        <option value="AP" {{ $tipo === 'AP' ? 'selected' : '' }}>AP (Amarelo Piscante)</option>
                        <option value="FA" {{ $tipo === 'FA' ? 'selected' : '' }}>FA (Foco Apagado)</option>
                        <option value="Acidente" {{ $tipo === 'Acidente' ? 'selected' : '' }}>Acidente</option>
                        <option value="Vermelho Queimado" {{ $tipo === 'Vermelho Queimado' ? 'selected' : '' }}>Vermelho Queimado</option>
                    </select>
                </div>

                <!-- Botões Filtrar e Limpar -->
                <div class="sm:col-span-2 flex items-center gap-2">
                    <button type="submit" class="w-full px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition">
                        Filtrar
                    </button>
                    @if($status !== 'todos' || $tipo !== 'todos' || $busca)
                    <a href="{{ route('admin.chamados.index') }}" class="px-3 py-2 rounded-xl text-xs text-slate-400 hover:text-white bg-white/5 transition">
                        Limpar
                    </a>
                    @endif
                </div>

            </form>
        </div>

        <!-- Lista Principal de Chamados (100% Responsiva: Tabela no Desktop e Cards no Celular) -->
        <div class="glass-panel rounded-3xl border border-white/10 overflow-hidden shadow-2xl">
            
            <!-- VISUALIZAÇÃO DESKTOP / TABLET (Tabela Completa) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-foco-navy-900/90 border-b border-white/10 text-slate-400 font-mono uppercase tracking-wider">
                            <th class="py-4 px-5 font-bold">Protocolo</th>
                            <th class="py-4 px-5 font-bold">Tipo</th>
                            <th class="py-4 px-5 font-bold">Solicitante & Contato</th>
                            <th class="py-4 px-5 font-bold">Local</th>
                            <th class="py-4 px-5 font-bold">Defeito</th>
                            <th class="py-4 px-5 font-bold">Abertura (Auto)</th>
                            <th class="py-4 px-5 font-bold">Status</th>
                            <th class="py-4 px-5 font-bold text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($chamados as $item)
                        <tr class="hover:bg-white/5 transition">
                            <!-- Protocolo -->
                            <td class="py-4 px-5 font-mono font-bold text-foco-yellow-400">
                                <a href="{{ route('admin.chamados.show', $item->id) }}" class="hover:underline">
                                    {{ $item->protocolo }}
                                </a>
                            </td>

                            <!-- Tipo de Chamado -->
                            <td class="py-4 px-5">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold font-mono {{ $item->tipo_badge_class }}">
                                    {{ $item->tipo }}
                                </span>
                            </td>

                            <!-- Solicitante & Contato -->
                            <td class="py-4 px-5">
                                <span class="text-white font-medium block">{{ $item->nome_solicitante }}</span>
                                <span class="text-[11px] text-cyan-400 font-mono block">{{ $item->telefone_contato }}</span>
                            </td>

                            <!-- Local -->
                            <td class="py-4 px-5 max-w-xs">
                                <span class="text-slate-200 block truncate" title="{{ $item->local }}">{{ $item->local }}</span>
                            </td>

                            <!-- Defeito -->
                            <td class="py-4 px-5 max-w-xs">
                                <span class="text-slate-300 block truncate" title="{{ $item->defeito }}">{{ $item->defeito }}</span>
                            </td>

                            <!-- Horário de Abertura Automático -->
                            <td class="py-4 px-5 font-mono text-slate-400 text-[11px] whitespace-nowrap">
                                {{ $item->data_hora_abertura ? $item->data_hora_abertura->format('d/m/Y H:i') : $item->created_at->format('d/m/Y H:i') }}
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-5">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $item->status_badge_class }}">
                                    {{ $item->status }}
                                </span>
                            </td>

                            <!-- Ações -->
                            <td class="py-4 px-5 text-right space-x-1 whitespace-nowrap">
                                <a href="{{ route('admin.chamados.imprimir-os', $item->id) }}" target="_blank" title="Imprimir Ordem de Serviço" class="p-1.5 rounded-lg text-slate-400 hover:text-white bg-white/5 inline-flex items-center">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                                </a>

                                <a href="{{ route('admin.chamados.show', $item->id) }}" class="px-3 py-1.5 rounded-lg text-xs font-mono font-bold bg-white/5 hover:bg-foco-yellow-500 hover:text-foco-navy-950 text-slate-300 transition">
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

            <!-- VISUALIZAÇÃO MOBILE (Cards 100% Responsivos Sem Rolagem Lateral) -->
            <div class="block md:hidden divide-y divide-white/10">
                @forelse($chamados as $item)
                <div class="p-4 sm:p-5 space-y-3 hover:bg-white/5 transition">
                    <!-- Topo do Card Mobile -->
                    <div class="flex items-center justify-between gap-2">
                        <a href="{{ route('admin.chamados.show', $item->id) }}" class="font-mono font-bold text-sm text-foco-yellow-400 hover:underline flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-foco-yellow-400 animate-ping"></span>
                            <span>{{ $item->protocolo }}</span>
                        </a>

                        <div class="flex items-center gap-1.5">
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold font-mono {{ $item->tipo_badge_class }}">
                                {{ $item->tipo }}
                            </span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $item->status_badge_class }}">
                                {{ $item->status }}
                            </span>
                        </div>
                    </div>

                    <!-- Defeito e Local -->
                    <div class="space-y-1">
                        <h3 class="text-sm font-bold text-white leading-snug">{{ $item->defeito }}</h3>
                        <p class="text-xs text-slate-300 flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-foco-yellow-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>{{ $item->local }}</span>
                        </p>
                    </div>

                    <!-- Solicitante & Telefone -->
                    <div class="p-2.5 rounded-xl bg-foco-navy-900 border border-white/5 text-xs text-slate-400 space-y-1">
                        <div class="flex items-center justify-between">
                            <span>Solicitante: <strong class="text-white">{{ $item->nome_solicitante }}</strong></span>
                            <span class="text-cyan-400 font-mono">{{ $item->telefone_contato }}</span>
                        </div>
                        @if($item->status === 'Finalizado' && $item->conserto_executado)
                        <div class="pt-1.5 border-t border-white/5 text-[11px] text-emerald-300">
                            <strong>Conserto:</strong> {{ Str::limit($item->conserto_executado, 75) }}
                        </div>
                        @endif
                    </div>

                    <!-- Rodapé do Card Mobile: Horário + Ações -->
                    <div class="flex items-center justify-between pt-1 text-xs">
                        <span class="text-[11px] font-mono text-slate-400 flex items-center gap-1">
                            <svg class="w-3 h-3 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $item->data_hora_abertura ? $item->data_hora_abertura->format('d/m/Y H:i') : $item->created_at->format('d/m/Y H:i') }}
                        </span>

                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.chamados.imprimir-os', $item->id) }}" target="_blank" title="Imprimir OS" class="p-2 rounded-lg text-slate-300 hover:text-white bg-white/5 border border-white/10 inline-flex items-center">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            </a>

                            <a href="{{ route('admin.chamados.show', $item->id) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-mono font-bold bg-foco-yellow-500 text-foco-navy-950 hover:bg-foco-yellow-400 transition shadow-glow-yellow">
                                Ver Detalhes →
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="py-12 px-4 text-center text-slate-400 space-y-2">
                    <svg class="w-8 h-8 text-slate-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="font-medium text-white">Nenhum chamado encontrado para os filtros selecionados.</p>
                    <a href="{{ route('admin.chamados.index') }}" class="text-xs text-foco-yellow-400 hover:underline block">Limpar filtros</a>
                </div>
                @endforelse
            </div>

        </div>

        <!-- MODAL: REGISTRAR CHAMADO INTERNO PELA CENTRAL FOCO -->
        <div x-show="modalInterno" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
            <div class="flex items-center justify-center min-h-screen p-4 text-center">
                <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" @click="modalInterno = false"></div>

                <div class="relative bg-foco-navy-900 border border-white/10 rounded-3xl p-6 sm:p-8 max-w-2xl w-full text-left shadow-2xl space-y-5">
                    <div class="flex items-center justify-between pb-4 border-b border-white/10">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-cyan-400"></span>
                            <h3 class="text-lg font-bold text-white">Registrar Chamado Interno (Central FOCO)</h3>
                        </div>
                        <button type="button" @click="modalInterno = false" class="text-slate-400 hover:text-white">✕</button>
                    </div>

                    <form action="{{ route('admin.chamados.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Tipo de Chamado -->
                        <div>
                            <label class="block text-xs font-mono text-slate-300 mb-1">Tipo de Chamado *</label>
                            <select name="tipo" required class="w-full bg-foco-navy-950 border border-white/10 rounded-xl px-3 py-2 text-xs text-white">
                                <option value="AP">AP (Amarelo Piscante)</option>
                                <option value="FA">FA (Foco Apagado)</option>
                                <option value="Acidente">Acidente (Colisão / Dano Físico)</option>
                                <option value="Vermelho Queimado">Vermelho Queimado</option>
                            </select>
                        </div>

                        <!-- Solicitante e Contato -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-mono text-slate-300 mb-1">Nome Solicitante *</label>
                                <input type="text" name="nome_solicitante" required value="{{ auth()->user()->name }}" class="w-full bg-foco-navy-950 border border-white/10 rounded-xl px-3 py-2 text-xs text-white">
                            </div>
                            <div>
                                <label class="block text-xs font-mono text-slate-300 mb-1">Número para Contato *</label>
                                <input type="text" name="telefone_contato" required value="(51) 99294-1111" class="w-full bg-foco-navy-950 border border-white/10 rounded-xl px-3 py-2 text-xs text-white">
                            </div>
                        </div>

                        <!-- Local -->
                        <div>
                            <label class="block text-xs font-mono text-slate-300 mb-1">Local (Cruzamento / Logradouro) *</label>
                            <input type="text" name="local" required placeholder="Ex: Av. Brasil x Alvin Bauer - Balneário Camboriú" class="w-full bg-foco-navy-950 border border-white/10 rounded-xl px-3 py-2 text-xs text-white">
                        </div>

                        <!-- Defeito -->
                        <div>
                            <label class="block text-xs font-mono text-slate-300 mb-1">Defeito Observado *</label>
                            <textarea name="defeito" rows="3" required placeholder="Relato técnico da falha no semáforo ou controlador..." class="w-full bg-foco-navy-950 border border-white/10 rounded-xl p-3 text-xs text-white"></textarea>
                        </div>

                        <!-- Observação -->
                        <div>
                            <label class="block text-xs font-mono text-slate-300 mb-1">Observação (Opcional)</label>
                            <textarea name="observacao" rows="2" placeholder="Observações operacionais da central..." class="w-full bg-foco-navy-950 border border-white/10 rounded-xl p-3 text-xs text-white"></textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-3 border-t border-white/10">
                            <button type="button" @click="modalInterno = false" class="px-4 py-2 rounded-xl text-xs text-slate-400 hover:text-white">Cancelar</button>
                            <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition shadow-glow-yellow">
                                Salvar Chamado
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>

<x-app-layout>
    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <!-- Topo da Gestão de Usuários -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-white/10 gap-4">
            <div>
                <div class="flex items-center gap-2 text-foco-yellow-400 font-mono text-xs uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-foco-yellow-400 animate-pulse"></span>
                    <span>Controle de Acesso & Credenciais</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Gestão de Usuários</h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-1">
                    Cadastre, edite, bloqueie ou libere o acesso de administradores e clientes autorizados a solicitar orçamentos.
                </p>
            </div>

            <a href="{{ route('admin.users.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition shadow-glow-yellow self-start sm:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Novo Usuário</span>
            </a>
        </div>

        <!-- Alertas de Feedback -->
        @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/40 text-emerald-300 text-xs font-mono flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-400 hover:text-white">✕</button>
        </div>
        @endif

        @if(session('error'))
        <div class="p-4 rounded-2xl bg-rose-500/15 border border-rose-500/40 text-rose-300 text-xs font-mono flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-rose-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                <span>{{ session('error') }}</span>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-rose-400 hover:text-white">✕</button>
        </div>
        @endif

        <!-- Cards de Estatísticas -->
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
            <div class="p-3.5 rounded-2xl glass-panel">
                <span class="text-[10px] font-mono uppercase text-slate-400 block">Total</span>
                <span class="text-xl font-black font-mono text-white mt-0.5 block">{{ $stats['total'] }}</span>
            </div>

            <div class="p-3.5 rounded-2xl glass-panel border border-emerald-500/20">
                <span class="text-[10px] font-mono uppercase text-emerald-400 block">Ativos / Liberados</span>
                <span class="text-xl font-black font-mono text-emerald-400 mt-0.5 block">{{ $stats['ativos'] }}</span>
            </div>

            <div class="p-3.5 rounded-2xl glass-panel border border-rose-500/20">
                <span class="text-[10px] font-mono uppercase text-rose-400 block">Bloqueados</span>
                <span class="text-xl font-black font-mono text-rose-400 mt-0.5 block">{{ $stats['bloqueados'] }}</span>
            </div>

            <div class="p-3.5 rounded-2xl glass-panel">
                <span class="text-[10px] font-mono uppercase text-foco-yellow-400 block">Administradores</span>
                <span class="text-xl font-black font-mono text-foco-yellow-400 mt-0.5 block">{{ $stats['admins'] }}</span>
            </div>

            <div class="p-3.5 rounded-2xl glass-panel">
                <span class="text-[10px] font-mono uppercase text-cyan-400 block">Clientes (Orçamentos)</span>
                <span class="text-xl font-black font-mono text-cyan-400 mt-0.5 block">{{ $stats['clientes'] }}</span>
            </div>
        </div>

        <!-- Filtros e Barra de Pesquisa -->
        <div class="glass-panel p-4 rounded-2xl border border-white/10">
            <form action="{{ route('admin.users.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
                <!-- Busca textual -->
                <div class="sm:col-span-6">
                    <input type="text" name="busca" value="{{ $busca }}" placeholder="Buscar por nome ou e-mail do usuário..." class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2 text-xs text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                </div>

                <!-- Filtro Status -->
                <div class="sm:col-span-2">
                    <select name="status" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-3 py-2 text-xs text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                        <option value="todos" {{ $status === 'todos' || $status === null ? 'selected' : '' }}>Todos os Status</option>
                        <option value="ativo" {{ $status === 'ativo' ? 'selected' : '' }}>Liberados (Ativos)</option>
                        <option value="bloqueado" {{ $status === 'bloqueado' ? 'selected' : '' }}>Bloqueados</option>
                    </select>
                </div>

                <!-- Filtro Perfil -->
                <div class="sm:col-span-2">
                    <select name="role" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-3 py-2 text-xs text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                        <option value="todos" {{ $role === 'todos' || $role === null ? 'selected' : '' }}>Todos os Perfis</option>
                        <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Administrador</option>
                        <option value="cliente" {{ $role === 'cliente' ? 'selected' : '' }}>Cliente (Orçamentos)</option>
                    </select>
                </div>

                <!-- Botões Filtrar e Limpar -->
                <div class="sm:col-span-2 flex items-center gap-2">
                    <button type="submit" class="w-full px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition">
                        Filtrar
                    </button>
                    @if($busca || ($status && $status !== 'todos') || ($role && $role !== 'todos'))
                    <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-xl text-xs text-slate-400 hover:text-white bg-white/5 transition">
                        Limpar
                    </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Tabela de Usuários -->
        <div class="glass-panel rounded-3xl border border-white/10 overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-foco-navy-900/90 border-b border-white/10 text-slate-400 font-mono uppercase tracking-wider text-[11px]">
                            <th class="py-3.5 px-4 font-bold">Usuário</th>
                            <th class="py-3.5 px-4 font-bold">E-mail</th>
                            <th class="py-3.5 px-3 font-bold">Perfil / Função</th>
                            <th class="py-3.5 px-3 font-bold text-center">Status</th>
                            <th class="py-3.5 px-4 font-bold">Data de Cadastro</th>
                            <th class="py-3.5 px-4 font-bold text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($users as $u)
                        <tr class="hover:bg-white/[0.02] transition">
                            <!-- Nome com avatar -->
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl flex items-center justify-center font-bold text-xs uppercase shrink-0 border {{ $u->isAdmin() ? 'bg-foco-yellow-500/20 text-foco-yellow-400 border-foco-yellow-500/30' : 'bg-cyan-500/20 text-cyan-300 border-cyan-500/30' }}">
                                        {{ substr($u->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-white block">{{ $u->name }}</span>
                                        @if($u->isMasterAdmin())
                                        <span class="inline-flex items-center gap-1 text-[10px] font-mono text-foco-yellow-400">
                                            ★ Admin Master
                                        </span>
                                        @elseif($u->id === auth()->id())
                                        <span class="inline-flex items-center gap-1 text-[10px] font-mono text-cyan-400">
                                            ● Sua Sessão
                                        </span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- E-mail -->
                            <td class="py-3.5 px-4 font-mono text-slate-300">
                                {{ $u->email }}
                            </td>

                            <!-- Perfil -->
                            <td class="py-3.5 px-3">
                                @if($u->isAdmin())
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-mono font-bold bg-foco-yellow-500/20 text-foco-yellow-300 border border-foco-yellow-500/30">
                                    Administrador
                                </span>
                                @else
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-mono font-bold bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">
                                    Cliente (Orçamentos)
                                </span>
                                @endif
                            </td>

                            <!-- Status (Ativo / Bloqueado) -->
                            <td class="py-3.5 px-3 text-center">
                                @if($u->isActive())
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-mono font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                    Liberado
                                </span>
                                @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-mono font-bold bg-rose-500/20 text-rose-300 border border-rose-500/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-400"></span>
                                    Bloqueado
                                </span>
                                @endif
                            </td>

                            <!-- Data -->
                            <td class="py-3.5 px-4 font-mono text-slate-400 text-[11px]">
                                {{ $u->created_at ? $u->created_at->format('d/m/Y H:i') : '-' }}
                            </td>

                            <!-- Ações -->
                            <td class="py-3.5 px-4 text-right">
                                <div class="inline-flex items-center gap-1.5 justify-end">
                                    <!-- Editar -->
                                    <a href="{{ route('admin.users.edit', $u->id) }}" class="p-1.5 rounded-lg bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white transition" title="Editar Usuário">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </a>

                                    <!-- Alternar Status (Bloquear / Liberar) -->
                                    @if(!$u->isMasterAdmin() && $u->id !== auth()->id())
                                    <form action="{{ route('admin.users.toggle-status', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Deseja realmente {{ $u->isActive() ? 'BLOQUEAR' : 'LIBERAR' }} o acesso do usuário {{ $u->name }}?');">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="p-1.5 rounded-lg transition {{ $u->isActive() ? 'bg-amber-500/10 hover:bg-amber-500/20 text-amber-400' : 'bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400' }}" title="{{ $u->isActive() ? 'Bloquear Acesso' : 'Liberar Acesso' }}">
                                            @if($u->isActive())
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                            @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            @endif
                                        </button>
                                    </form>

                                    <!-- Excluir -->
                                    <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="inline" onsubmit="return confirm('Atenção: Deseja realmente EXCLUIR o usuário {{ $u->name }}? Esta ação não pode ser desfeita.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-lg bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 transition" title="Excluir Usuário">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 px-4 text-center text-slate-400">
                                Nenhum usuário encontrado para os critérios pesquisados.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
            <div class="p-4 border-t border-white/10">
                {{ $users->links() }}
            </div>
            @endif
        </div>

    </div>
</x-app-layout>


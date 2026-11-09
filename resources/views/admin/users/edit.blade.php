<x-app-layout>
    <div class="py-8 max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <div class="flex items-center justify-between pb-6 border-b border-white/10">
            <div>
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-1.5 text-xs font-mono text-foco-yellow-400 hover:underline mb-2">
                    ← Voltar para lista de usuários
                </a>
                <h1 class="text-2xl font-extrabold text-white">Editar Usuário: {{ $user->name }}</h1>
                <p class="text-xs text-slate-400 mt-1">Atualize os dados cadastrais, perfil de acesso ou status do usuário.</p>
            </div>

            @if($user->isMasterAdmin())
            <span class="px-3 py-1 rounded-full text-xs font-mono font-bold bg-foco-yellow-500/20 text-foco-yellow-400 border border-foco-yellow-500/40">
                ★ Admin Master Protegido
            </span>
            @endif
        </div>

        <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-2xl">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-5">
                @csrf
                @method('PUT')

                <!-- Nome -->
                <div>
                    <label for="name" class="block text-xs font-mono font-bold text-slate-300 mb-1">Nome Completo / Órgão / Solicitante *</label>
                    <input type="text" name="name" id="name" required value="{{ old('name', $user->name) }}" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                    @error('name')
                        <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- E-mail -->
                <div>
                    <label for="email" class="block text-xs font-mono font-bold text-slate-300 mb-1">E-mail Corporativo *</label>
                    <input type="email" name="email" id="email" required value="{{ old('email', $user->email) }}" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500" {{ $user->isMasterAdmin() ? 'readonly' : '' }}>
                    @error('email')
                        <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Perfil e Status -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="role" class="block text-xs font-mono font-bold text-slate-300 mb-1">Perfil de Acesso *</label>
                        @if($user->isMasterAdmin())
                            <input type="hidden" name="role" value="admin">
                            <input type="text" disabled value="Administrador Master" class="w-full bg-foco-navy-950 border border-white/5 rounded-xl px-3 py-2.5 text-xs text-foco-yellow-400 font-mono font-bold">
                        @else
                            <select name="role" id="role" required class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-3 py-2.5 text-xs text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                                <option value="cliente" {{ old('role', $user->role) === 'cliente' ? 'selected' : '' }}>Cliente (Pode solicitar orçamentos)</option>
                                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrador (Acesso ao painel completo)</option>
                            </select>
                        @endif
                        @error('role')
                            <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="is_active" class="block text-xs font-mono font-bold text-slate-300 mb-1">Status de Acesso *</label>
                        @if($user->isMasterAdmin())
                            <input type="hidden" name="is_active" value="1">
                            <input type="text" disabled value="Liberado Permanente" class="w-full bg-foco-navy-950 border border-white/5 rounded-xl px-3 py-2.5 text-xs text-emerald-400 font-mono font-bold">
                        @else
                            <select name="is_active" id="is_active" required class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-3 py-2.5 text-xs text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                                <option value="1" {{ old('is_active', (string)(int)$user->is_active) == '1' ? 'selected' : '' }}>Liberado (Ativo com acesso)</option>
                                <option value="0" {{ old('is_active', (string)(int)$user->is_active) == '0' ? 'selected' : '' }}>Bloqueado (Acesso restrito)</option>
                            </select>
                        @endif
                        @error('is_active')
                            <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Alterar Senha (Opcional) -->
                <div class="pt-4 border-t border-white/10 space-y-3">
                    <p class="text-xs font-mono text-slate-400">
                        Alterar senha (deixe em branco se desejar manter a senha atual):
                    </p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-xs font-mono font-bold text-slate-300 mb-1">Nova Senha</label>
                            <input type="password" name="password" id="password" placeholder="Nova senha (opcional)" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                            @error('password')
                                <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-xs font-mono font-bold text-slate-300 mb-1">Confirmar Nova Senha</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Repita a nova senha" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-xs text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/10">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2.5 rounded-xl text-xs text-slate-400 hover:text-white transition">Cancelar</a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition shadow-glow-yellow">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>

    </div>
</x-app-layout>

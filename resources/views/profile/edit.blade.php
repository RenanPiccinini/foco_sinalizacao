<x-app-layout>
    <div class="space-y-6 max-w-4xl mx-auto">
        <!-- Topo do Perfil -->
        <div class="pb-6 border-b border-white/10">
            <span class="text-xs font-mono text-foco-yellow-400 uppercase tracking-widest font-bold">Configurações de Conta</span>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Perfil do Administrador</h1>
            <p class="text-xs text-slate-400 mt-1">Atualize seus dados cadastrais, e-mail e credenciais de segurança do sistema.</p>
        </div>

        <!-- Seção 1: Informações do Perfil -->
        <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 space-y-4">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-foco-yellow-400"></span>
                <h2 class="text-lg font-bold text-white">Dados de Identificação</h2>
            </div>
            <p class="text-xs text-slate-400">Informações utilizadas para carimbo na Trilha de Auditoria Digital (Audit Trail) dos chamados.</p>

            <form method="post" action="{{ route('profile.update') }}" class="space-y-4 max-w-xl">
                @csrf
                @method('patch')

                <div>
                    <label for="name" class="block text-xs font-mono text-slate-300 mb-1">Nome Completo</label>
                    <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                    <x-input-error class="mt-1 text-xs text-rose-400" :messages="$errors->get('name')" />
                </div>

                <div>
                    <label for="email" class="block text-xs font-mono text-slate-300 mb-1">E-mail Corporativo</label>
                    <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" required class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                    <x-input-error class="mt-1 text-xs text-rose-400" :messages="$errors->get('email')" />
                </div>

                <div class="pt-2 flex items-center gap-4">
                    <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition shadow-glow-yellow">
                        Salvar Alterações
                    </button>
                    @if (session('status') === 'profile-updated')
                        <span class="text-xs font-mono text-foco-green-400">✓ Salvo com sucesso!</span>
                    @endif
                </div>
            </form>
        </div>

        <!-- Seção 2: Atualização de Senha -->
        <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 space-y-4">
            <div class="flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-cyan-400"></span>
                <h2 class="text-lg font-bold text-white">Alteração de Senha</h2>
            </div>
            <p class="text-xs text-slate-400">Utilize uma senha forte para manter a segurança das operações viárias.</p>

            <form method="post" action="{{ route('password.update') }}" class="space-y-4 max-w-xl">
                @csrf
                @method('put')

                <div>
                    <label for="current_password" class="block text-xs font-mono text-slate-300 mb-1">Senha Atual</label>
                    <input id="current_password" name="current_password" type="password" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500" autocomplete="current-password">
                    <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-1 text-xs text-rose-400" />
                </div>

                <div>
                    <label for="password" class="block text-xs font-mono text-slate-300 mb-1">Nova Senha</label>
                    <input id="password" name="password" type="password" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500" autocomplete="new-password">
                    <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-1 text-xs text-rose-400" />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-mono text-slate-300 mb-1">Confirmar Nova Senha</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500" autocomplete="new-password">
                    <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-1 text-xs text-rose-400" />
                </div>

                <div class="pt-2 flex items-center gap-4">
                    <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-cyan-500 hover:bg-cyan-400 text-foco-navy-950 transition shadow-glow-blue">
                        Atualizar Senha
                    </button>
                    @if (session('status') === 'password-updated')
                        <span class="text-xs font-mono text-foco-green-400">✓ Senha atualizada!</span>
                    @endif
                </div>
            </form>
        </div>

    </div>
</x-app-layout>

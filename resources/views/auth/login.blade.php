<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <h2 class="text-xl font-bold text-white">Autenticação do Administrador</h2>
        <p class="text-xs text-slate-400 mt-1">Insira suas credenciais de acesso para gerenciar os chamados e sistemas viários.</p>
    </div>

    <!-- Banner com Credenciais Pré-definidas de Demonstração -->
    <div class="mb-6 p-3.5 rounded-2xl bg-foco-navy-900 border border-foco-yellow-500/30 font-mono text-xs space-y-1.5" x-data="{
        preencherDemo() {
            document.getElementById('email').value = 'admin@focosinalizacao.com.br';
            document.getElementById('password').value = 'admin1234';
        }
    }">
        <div class="flex items-center justify-between">
            <span class="text-foco-yellow-400 font-bold uppercase text-[10px]">Credenciais do Sistema:</span>
            <button type="button" @click="preencherDemo()" class="text-[10px] text-foco-yellow-400 hover:text-white underline font-sans">
                Preencher Automaticamente
            </button>
        </div>
        <p class="text-slate-300">Email: <span class="text-white font-bold">admin@focosinalizacao.com.br</span></p>
        <p class="text-slate-300">Senha: <span class="text-white font-bold">admin1234</span></p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-medium text-slate-300 mb-1">E-mail Corporativo</label>
            <input id="email" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition" type="email" name="email" value="{{ old('email', 'admin@focosinalizacao.com.br') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-rose-400 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-medium text-slate-300 mb-1">Senha de Acesso</label>
            <input id="password" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition"
                            type="password"
                            name="password"
                            value="admin1234"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-rose-400 text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between text-xs">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded bg-foco-navy-900 border-white/10 text-foco-yellow-500 focus:ring-foco-yellow-500" name="remember" checked>
                <span class="ms-2 text-slate-400">Lembrar sessão</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-slate-400 hover:text-foco-yellow-400 transition" href="{{ route('password.request') }}">
                    Esqueceu a senha?
                </a>
            @endif
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition shadow-glow-yellow flex items-center justify-center gap-2">
                <svg class="w-4 h-4 text-foco-navy-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                <span>Entrar no Gerenciador</span>
            </button>
        </div>
    </form>
</x-guest-layout>

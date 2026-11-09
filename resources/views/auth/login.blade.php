<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    @if(session('info'))
    <div class="mb-5 p-3.5 rounded-2xl bg-foco-yellow-500/15 border border-foco-yellow-500/40 text-xs text-amber-200 flex items-start gap-2.5">
        <svg class="w-4 h-4 text-foco-yellow-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span>{{ session('info') }}</span>
    </div>
    @endif

    <div class="mb-6">
        <h2 class="text-xl font-bold text-white">Acesso ao Sistema</h2>
        <p class="text-xs text-slate-400 mt-1">
            Entre com suas credenciais para gerenciar a plataforma ou solicitar orçamentos técnicos de engenharia.
        </p>
    </div>

    <!-- Aviso de Acesso Credenciado -->
    <div class="mb-5 p-3.5 rounded-2xl bg-foco-navy-900 border border-white/10 text-xs text-slate-300 space-y-1">
        <div class="flex items-center gap-1.5 text-foco-yellow-400 font-mono font-bold text-[11px] uppercase">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            <span>Área de Acesso Restrito</span>
        </div>
        <p class="text-[11px] text-slate-400 leading-relaxed">
            A criação de novos acessos e liberação de permissões é gerenciada unicamente pela administração central da FOCO.
        </p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-mono font-semibold text-slate-300 mb-1">E-mail Corporativo</label>
            <input id="email" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="seuemail@empresa.com.br" />
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-rose-400 text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-xs font-mono font-semibold text-slate-300 mb-1">Senha de Acesso</label>
            <input id="password" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-1 text-rose-400 text-xs" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between text-xs pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded bg-foco-navy-900 border-white/10 text-foco-yellow-500 focus:ring-foco-yellow-500" name="remember" checked>
                <span class="ms-2 text-slate-400 text-xs">Lembrar minha sessão</span>
            </label>
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition shadow-glow-yellow flex items-center justify-center gap-2">
                <svg class="w-4 h-4 text-foco-navy-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                <span>Acessar o Sistema</span>
            </button>
        </div>
    </form>
</x-guest-layout>

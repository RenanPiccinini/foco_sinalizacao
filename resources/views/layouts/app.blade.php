<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Foco Sinalização') }} | Gerenciador Operacional</title>

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-banner.jpg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts e Estilos -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-foco-navy-950 text-slate-100 font-sans antialiased selection:bg-foco-yellow-500 selection:text-foco-navy-950 overflow-x-hidden" x-data="{ sidebarOpen: false }">

    @php
        $chamadosAbertosCount = \App\Models\Chamado::where('status', 'Aberto')->count();
    @endphp

    <div class="min-h-screen flex">
        
        <!-- ============================================== -->
        <!-- MENU NA ESQUERDA (SIDEBAR LATERAL COM A LOGO)  -->
        <!-- ============================================== -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'" class="fixed inset-y-0 left-0 z-50 w-72 bg-gradient-to-b from-foco-navy-900 via-foco-navy-950 to-foco-navy-950 border-r border-white/10 transition-transform duration-300 ease-in-out flex flex-col shadow-2xl">
            
            <!-- Topo da Barra Lateral: Logo Oficial e Marca -->
            <div class="p-5 border-b border-white/10 bg-foco-navy-950/60">
                <a href="{{ route('dashboard') }}" class="block group">
                    <div class="relative overflow-hidden rounded-xl border border-white/15 bg-foco-navy-900 p-1.5 shadow-lg group-hover:border-foco-yellow-500/50 transition">
                        <img src="{{ asset('images/logo-banner.jpg') }}" alt="FOCO Sinalização e Sistemas Inteligentes" class="w-full h-auto object-contain rounded">
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <div>
                            <span class="block text-xs font-mono font-bold uppercase tracking-widest text-foco-yellow-400">
                                Gerenciador Central
                            </span>
                            <span class="text-[11px] text-slate-400">Nuvem WEB DIGICON</span>
                        </div>
                        <span class="w-2.5 h-2.5 rounded-full bg-foco-green-400 animate-pulse"></span>
                    </div>
                </a>
            </div>

            <!-- Navegação Lateral -->
            <nav class="flex-1 px-4 py-6 space-y-1.5 overflow-y-auto">
                <div class="px-3 pb-2 text-[10px] font-mono uppercase tracking-widest text-slate-500">
                    Operações & Tráfego
                </div>

                <!-- Item 1: Dashboard -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-foco-yellow-500 text-foco-navy-950 font-bold shadow-glow-yellow' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-foco-navy-950' : 'text-foco-yellow-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span>Visão Geral</span>
                </a>

                <!-- Item 2: CHAMADOS (DESTAQUE OBRIGATÓRIO) -->
                <a href="{{ route('admin.chamados.index') }}" class="flex items-center justify-between px-3.5 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.chamados.*') ? 'bg-foco-yellow-500 text-foco-navy-950 font-extrabold shadow-glow-yellow' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.chamados.*') ? 'text-foco-navy-950' : 'text-foco-yellow-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                        <span>Chamados</span>
                    </div>
                    @if($chamadosAbertosCount > 0)
                    <span class="px-2 py-0.5 rounded-full text-xs font-mono font-bold {{ request()->routeIs('admin.chamados.*') ? 'bg-foco-navy-950 text-foco-yellow-400' : 'bg-foco-yellow-500 text-foco-navy-950 shadow-glow-yellow' }}">
                        {{ $chamadosAbertosCount }}
                    </span>
                    @endif
                </a>

                <!-- Item 3: Conexão WhatsApp (Evolution API) -->
                <a href="{{ route('admin.conexao.index') }}" class="flex items-center justify-between px-3.5 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.conexao.*') ? 'bg-foco-yellow-500 text-foco-navy-950 font-extrabold shadow-glow-yellow' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.conexao.*') ? 'text-foco-navy-950' : 'text-emerald-400' }}" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        <span>Conexão</span>
                    </div>
                    <span class="text-[10px] font-mono px-2 py-0.5 rounded-full {{ request()->routeIs('admin.conexao.*') ? 'bg-foco-navy-950 text-foco-yellow-400 font-bold' : 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' }}">
                        WhatsApp
                    </span>
                </a>

                <!-- Item 3: Controladores & Semáforos -->
                <a href="{{ route('admin.controladores') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.controladores') ? 'bg-foco-yellow-500 text-foco-navy-950 font-bold shadow-glow-yellow' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.controladores') ? 'text-foco-navy-950' : 'text-foco-green-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"/></svg>
                    <span>Controladores & ITS</span>
                </a>

                <!-- Item 4: Central WEB DIGICON -->
                <a href="{{ route('admin.central-nuvem') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.central-nuvem') ? 'bg-foco-yellow-500 text-foco-navy-950 font-bold shadow-glow-yellow' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.central-nuvem') ? 'text-foco-navy-950' : 'text-cyan-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>
                    <span>Central DIGICON Nuvem</span>
                </a>

                <!-- Item 5: Municípios & Rodovias -->
                <a href="{{ route('admin.cidades') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('admin.cidades') ? 'bg-foco-yellow-500 text-foco-navy-950 font-bold shadow-glow-yellow' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 {{ request()->routeIs('admin.cidades') ? 'text-foco-navy-950' : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <span>Municípios & Rodovias</span>
                </a>

                <div class="pt-6 px-3 pb-2 text-[10px] font-mono uppercase tracking-widest text-slate-500">
                    Sistema & Atalhos
                </div>

                <!-- Perfil -->
                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3.5 py-3 rounded-xl text-sm font-medium transition {{ request()->routeIs('profile.edit') ? 'bg-foco-yellow-500 text-foco-navy-950 font-bold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Meu Perfil</span>
                </a>

                <!-- Ver Site Público -->
                <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-between px-3.5 py-3 rounded-xl text-sm font-medium text-slate-300 hover:text-white hover:bg-white/5 transition">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>Ver Site Público</span>
                    </div>
                    <span class="text-xs text-slate-500">↗</span>
                </a>

                <!-- WhatsApp Plantão Oficial 24h -->
                <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+preciso+de+suporte+no+Plant%C3%A3o+Vi%C3%A1rio" target="_blank" rel="noopener noreferrer" class="flex items-center justify-between px-3.5 py-3 rounded-xl text-sm font-medium text-emerald-400 hover:bg-emerald-500/10 transition">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        <span>WhatsApp (51) 99294-1111</span>
                    </div>
                    <span class="text-xs text-emerald-400">↗</span>
                </a>
            </nav>

            <!-- Rodapé da Barra Lateral: Perfil do Administrador e Logout -->
            <div class="p-4 border-t border-white/10 bg-foco-navy-950/80">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="w-9 h-9 rounded-xl bg-foco-yellow-500/20 text-foco-yellow-400 flex items-center justify-center font-bold text-sm shrink-0 border border-foco-yellow-500/30">
                            {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                        </div>
                        <div class="truncate">
                            <span class="block text-xs font-bold text-white truncate">{{ auth()->user()->name ?? 'Administrador' }}</span>
                            <span class="block text-[11px] text-slate-400 font-mono truncate">{{ auth()->user()->email ?? 'admin@focosinalizacao.com.br' }}</span>
                        </div>
                    </div>

                    <!-- Botão Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="shrink-0 ml-2">
                        @csrf
                        <button type="submit" title="Encerrar Sessão" class="p-2 rounded-lg text-slate-400 hover:text-rose-400 hover:bg-rose-500/10 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Overlay para mobile -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-40 bg-black/60 backdrop-blur-sm lg:hidden" x-transition></div>

        <!-- ============================================== -->
        <!-- ÁREA DE CONTEÚDO PRINCIPAL (DIREITA)           -->
        <!-- ============================================== -->
        <div class="flex-1 flex flex-col min-w-0 lg:pl-72">
            
            <!-- Barra Superior do Gerenciador (100% Responsiva) -->
            <header class="sticky top-0 z-30 glass-panel border-b border-white/10 px-3 sm:px-6 lg:px-8 py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                <div class="flex items-center justify-between sm:justify-start gap-3 w-full sm:w-auto">
                    <!-- Botão Toggle Mobile Sidebar -->
                    <button @click="sidebarOpen = !sidebarOpen" type="button" class="p-2 rounded-xl bg-white/5 text-slate-300 hover:text-white lg:hidden border border-white/10 shrink-0" aria-label="Abrir Menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>

                    <!-- Telemetria & Status Nuvem Digicon (Visível no Computador e no Celular) -->
                    <div class="flex items-center gap-2 text-[11px] sm:text-xs font-mono">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-foco-green-500/10 text-foco-green-400 border border-foco-green-500/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-foco-green-400 animate-ping"></span>
                            <span class="font-bold">Digicon Nuvem:</span>
                            <span>100% Online</span>
                        </span>
                        <span class="text-slate-600 hidden xs:inline">•</span>
                        <span class="text-slate-400 hidden xs:inline">Onda Verde Ativa</span>
                    </div>

                    <!-- Botão Mobile para Novo Chamado no Site -->
                    <div class="flex sm:hidden items-center gap-2 shrink-0">
                        <a href="{{ route('site.chamados') }}" target="_blank" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-[10px] font-mono font-bold bg-foco-yellow-500/10 hover:bg-foco-yellow-500 text-foco-yellow-400 hover:text-foco-navy-950 border border-foco-yellow-500/30 transition">
                            <span>+ Chamado</span>
                        </a>
                    </div>
                </div>

                <div class="flex items-center justify-between sm:justify-end gap-3 w-full sm:w-auto pt-1 sm:pt-0 border-t border-white/5 sm:border-t-0">
                    <!-- Link Rápido para Novo Chamado no Site (Desktop/Tablet) -->
                    <a href="{{ route('site.chamados') }}" target="_blank" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-mono font-bold bg-white/5 hover:bg-foco-yellow-500 hover:text-foco-navy-950 text-foco-yellow-400 border border-foco-yellow-500/30 transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>+ Abrir Chamado no Site</span>
                    </a>

                    <!-- Sub-info no mobile sobre Onda Verde se tela for muito pequena -->
                    <span class="text-[10px] font-mono text-slate-400 xs:hidden">Onda Verde Ativa</span>

                    <!-- Status e Nome do Administrador (Visível no Computador e no Celular) -->
                    <div class="flex items-center gap-2 pl-2 sm:border-l sm:border-white/10 shrink-0">
                        <div class="w-2.5 h-2.5 rounded-full bg-foco-green-400"></div>
                        <span class="text-xs font-medium text-slate-200 max-w-[130px] sm:max-w-none truncate" title="{{ auth()->user()->name ?? 'Administrador' }}">
                            {{ auth()->user()->name ?? 'Administrador' }}
                        </span>
                    </div>
                </div>
            </header>

            <!-- Conteúdo da Página -->
            <main class="flex-1 p-4 sm:p-6 lg:p-8">
                <!-- Mensagens Flash -->
                @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-foco-green-500/10 border border-foco-green-500/30 text-foco-green-400 text-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-400 text-sm flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
                @endif

                {{ $slot ?? '' }}
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Botão Flutuante do WhatsApp em Todas as Telas -->
    <x-whatsapp-button />
</body>
</html>

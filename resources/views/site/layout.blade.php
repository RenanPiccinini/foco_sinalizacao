<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Foco Sinalização e Sistemas Inteligentes | Soluções Integradas em Mobilidade Urbana')</title>
    <meta name="description" content="Engenharia de tráfego, sinalização semafórica adaptativa, centrais em nuvem WEB Segura, nobreaks solares híbridos e sistemas inteligentes para cidades do futuro.">

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('images/logo-banner.jpg') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;700&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Scripts & Styles via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-foco-navy-950 text-slate-100 min-h-screen flex flex-col antialiased selection:bg-foco-yellow-500 selection:text-foco-navy-950 overflow-x-hidden">

    <!-- Barra de Notificação Superior (Telemetria & Plantão 24h) 100% Responsiva -->
    <div class="bg-gradient-to-r from-foco-navy-900 via-foco-navy-850 to-foco-navy-900 border-b border-white/5 py-1.5 px-3 sm:px-4 text-[11px] sm:text-xs font-mono">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-1.5 sm:gap-2">
            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-foco-green-500/10 text-foco-green-400 border border-foco-green-500/30">
                    <span class="w-1.5 h-1.5 rounded-full bg-foco-green-400 animate-ping"></span>
                    Central Operacional 24h Ativa
                </span>
                <span class="text-slate-400">
                    Onda Verde: <strong class="text-slate-200">99.8% Uptime</strong>
                </span>
                <span class="text-slate-600">•</span>
                <span class="text-slate-400">
                    Nuvem: <strong class="text-cyan-400">Online</strong>
                </span>
            </div>

            <div class="flex items-center justify-center gap-3 text-slate-300">
                <a href="{{ route('site.contato') }}" class="hover:text-foco-yellow-400 transition flex items-center gap-1.5 font-bold text-slate-200">
                    <svg class="w-3.5 h-3.5 text-foco-yellow-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>Atendimento & Orçamentos</span>
                </a>
                <span class="text-slate-600">|</span>
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="text-foco-yellow-400 hover:text-white transition font-semibold flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                            <span>Painel Gestor</span>
                        </a>
                    @else
                        <span class="text-slate-300 text-xs flex items-center gap-1">
                            <svg class="w-3.5 h-3.5 text-foco-yellow-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>{{ auth()->user()->name }}</span>
                        </span>
                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-xs text-rose-400 hover:text-rose-300 ml-1 font-mono hover:underline">Sair</button>
                        </form>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-slate-300 hover:text-foco-yellow-400 transition flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        <span>Gerenciador</span>
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Navegação Principal com Efeito Glassmorphism -->
    <header class="sticky top-0 z-50 glass-panel border-b border-white/10 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo Oficial da Foco -->
                <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3 group">
                    <div class="relative overflow-hidden rounded-xl border border-white/15 bg-foco-navy-900/80 p-1 shadow-lg shadow-black/40 group-hover:border-foco-yellow-500/50 transition shrink-0">
                        <img src="{{ asset('images/logo-banner.jpg') }}" alt="FOCO Sinalização e Sistemas Inteligentes" class="h-10 sm:h-12 w-auto object-contain">
                    </div>
                    <div class="block">
                        <span class="block text-sm sm:text-base font-extrabold tracking-wider text-white group-hover:text-foco-yellow-400 transition leading-tight">
                            FOCO <span class="text-[9px] sm:text-xs font-semibold text-foco-yellow-400 uppercase tracking-widest block">Sistemas Inteligentes</span>
                        </span>
                    </div>
                </a>

                <!-- Menu de Navegação Desktop -->
                <nav class="hidden lg:flex items-center gap-1 xl:gap-2 text-sm font-medium">
                    <a href="{{ route('home') }}" class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('home') ? 'text-foco-yellow-400 bg-white/5 font-semibold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Início
                    </a>
                    <a href="{{ route('site.solucoes') }}" class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('site.solucoes') ? 'text-foco-yellow-400 bg-white/5 font-semibold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Serviços & Soluções
                    </a>
                    <a href="{{ route('site.cidades') }}" class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('site.cidades') ? 'text-foco-yellow-400 bg-white/5 font-semibold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Cidades & Rodovias
                    </a>
                    <a href="{{ route('site.sobre') }}" class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('site.sobre') ? 'text-foco-yellow-400 bg-white/5 font-semibold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Nossa História
                    </a>
                    <a href="{{ route('site.contato') }}" class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('site.contato') ? 'text-foco-yellow-400 bg-white/5 font-semibold' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                        Contato
                    </a>

                    <!-- BOTÃO SOLICITAR ORÇAMENTO (FORMULÁRIO PÚBLICO) -->
                    <a href="{{ route('site.orcamento') }}" class="px-3.5 py-2 rounded-lg border border-foco-yellow-500/40 text-foco-yellow-400 hover:bg-foco-yellow-500/10 hover:border-foco-yellow-400 transition font-semibold text-xs tracking-wide uppercase flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-foco-yellow-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        <span>Solicitar Orçamento</span>
                    </a>

                    <!-- BOTÃO DESTACADO: MENU DE CHAMADOS -->
                    <a href="{{ route('site.chamados') }}" class="ml-1 relative inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-gradient-to-r from-foco-yellow-500 to-amber-500 text-foco-navy-950 shadow-glow-yellow hover:from-foco-yellow-400 hover:to-amber-400 hover:scale-105 active:scale-95 transition-all">
                        <span class="relative flex h-2.5 w-2.5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-foco-navy-950 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-foco-navy-950"></span>
                        </span>
                        <span>Abrir Chamado</span>
                        <svg class="w-4 h-4 ml-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </nav>

                <!-- Menu Mobile Trigger via Alpine -->
                <div class="flex items-center gap-2 lg:hidden" x-data="{ mobileOpen: false }">
                    <a href="{{ route('site.chamados') }}" class="px-3 py-1.5 text-xs font-bold rounded-lg bg-foco-yellow-500 text-foco-navy-950">
                        Chamados
                    </a>
                    <button @click="mobileOpen = !mobileOpen" type="button" class="p-2 rounded-lg bg-white/5 text-slate-300 hover:text-white">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                    </button>

                    <!-- Drawer Mobile 100% Completo -->
                    <div x-show="mobileOpen" @click.away="mobileOpen = false" x-transition class="fixed inset-x-0 top-20 bg-foco-navy-950/98 backdrop-blur-2xl border-b border-white/10 p-6 shadow-2xl z-50 flex flex-col gap-2.5 max-h-[85vh] overflow-y-auto">
                        <a href="{{ route('home') }}" class="py-2.5 px-3 rounded-xl text-slate-200 hover:bg-white/5 flex items-center justify-between">
                            <span>Início</span>
                            <span class="text-xs text-slate-500">→</span>
                        </a>
                        <a href="{{ route('site.solucoes') }}" class="py-2.5 px-3 rounded-xl text-slate-200 hover:bg-white/5 flex items-center justify-between">
                            <span>Serviços & Soluções</span>
                            <span class="text-xs text-slate-500">→</span>
                        </a>
                        <a href="{{ route('site.cidades') }}" class="py-2.5 px-3 rounded-xl text-slate-200 hover:bg-white/5 flex items-center justify-between">
                            <span>Cidades & Rodovias (+25)</span>
                            <span class="text-xs text-slate-500">→</span>
                        </a>
                        <a href="{{ route('site.sobre') }}" class="py-2.5 px-3 rounded-xl text-slate-200 hover:bg-white/5 flex items-center justify-between">
                            <span>Nossa História & Quem Somos</span>
                            <span class="text-xs text-slate-500">→</span>
                        </a>
                        <a href="{{ route('site.contato') }}" class="py-2.5 px-3 rounded-xl text-slate-200 hover:bg-white/5 flex items-center justify-between">
                            <span>Contato & Formulário</span>
                            <span class="text-xs text-slate-500">→</span>
                        </a>
                        <a href="{{ route('site.orcamento') }}" class="py-2.5 px-3 rounded-xl text-foco-yellow-400 hover:bg-white/5 flex items-center justify-between font-semibold">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-foco-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span>Solicitar Orçamento</span>
                            </span>
                            <span class="text-xs text-foco-yellow-400">→</span>
                        </a>

                        <div class="pt-2 flex flex-col gap-2">
                            <a href="{{ route('site.chamados') }}" class="py-3 px-4 rounded-xl text-center font-black text-xs uppercase tracking-wider bg-foco-yellow-500 text-foco-navy-950 shadow-glow-yellow flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                                <span>Abrir Novo Chamado</span>
                            </a>
                            <a href="{{ route('site.chamados') }}#consulta" class="py-2.5 px-4 rounded-xl text-center font-bold text-xs uppercase tracking-wider glass-card text-slate-200 hover:text-white flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 text-foco-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                <span>Consultar Protocolo</span>
                            </a>
                        </div>

                        <div class="border-t border-white/10 pt-3 mt-1 flex flex-col gap-2 text-xs font-mono">
                            <div class="flex items-center justify-between text-slate-400">
                                <span>Atendimento:</span>
                                <a href="{{ route('site.contato') }}" class="text-foco-yellow-400 font-bold hover:underline">
                                    Formulário Online →
                                </a>
                            </div>
                            <div class="flex items-center justify-between text-slate-400">
                                <span>Central em Nuvem:</span>
                                <strong class="text-foco-green-400 font-bold">100% Online</strong>
                            </div>
                            <div class="pt-2 border-t border-white/5 text-center">
                                @auth
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('dashboard') }}" class="text-foco-yellow-400 font-bold block py-1">Ir para o Painel do Gestor →</a>
                                    @else
                                        <div class="text-slate-300 text-xs py-1 flex items-center justify-center gap-2">
                                            <span>Conectado como <strong>{{ auth()->user()->name }}</strong></span>
                                            <form method="POST" action="{{ route('logout') }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-rose-400 font-mono hover:underline">Sair</button>
                                            </form>
                                        </div>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="text-slate-300 hover:text-white block py-1">Acesso Restrito do Gerenciador →</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Conteúdo Principal com suporte a Parallax e 3D -->
    <main class="flex-grow relative">
        @yield('content')
    </main>

    <!-- Rodapé Corporativo de Alto Padrão -->
    <footer class="bg-foco-navy-900 border-t border-white/10 pt-16 pb-10 relative overflow-hidden">
        <!-- Luz de fundo semafórica suave -->
        <div class="absolute -top-32 -left-32 w-96 h-96 bg-foco-green-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-foco-yellow-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10 pb-12 border-b border-white/10">
                <!-- Coluna 1 & 2: Identidade e Missão -->
                <div class="lg:col-span-2 space-y-4">
                    <img src="{{ asset('images/logo-banner.jpg') }}" alt="FOCO Sinalização" class="h-14 w-auto object-contain rounded-lg border border-white/10 bg-foco-navy-950/80 p-1">
                    <p class="text-sm text-slate-400 leading-relaxed max-w-md">
                        <strong>FOCO Sinalização e Sistemas Inteligentes LTDA</strong> — Engenharia de ponta dedicada a projetar, implantar e integrar a mobilidade das cidades do futuro, com sinalização adaptativa, autonomia energética híbrida e segurança em nuvem.
                    </p>
                    <div class="flex items-center gap-3 pt-2">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mono bg-foco-green-500/10 text-foco-green-400 border border-foco-green-500/30">
                            <span class="w-2 h-2 rounded-full bg-foco-green-400"></span>
                            Central WEB Conectada
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-mono bg-foco-yellow-500/10 text-foco-yellow-400 border border-foco-yellow-500/30">
                            Nobreak LiFePO4
                        </span>
                    </div>
                </div>

                <!-- Coluna 3: Serviços Prestados -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-l-2 border-foco-yellow-500 pl-2">Serviços Prestados</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('site.solucoes') }}#sinalizacao" class="hover:text-foco-yellow-400 transition">Sinalização Semafórica, Vertical e Horizontal</a></li>
                        <li><a href="{{ route('site.solucoes') }}#energia" class="hover:text-foco-yellow-400 transition">Energia Alternativa (Solar e Eólica)</a></li>
                        <li><a href="{{ route('site.solucoes') }}#eletrica" class="hover:text-foco-yellow-400 transition">Elétrica de Baixa Tensão</a></li>
                        <li><a href="{{ route('site.solucoes') }}#seguranca" class="hover:text-foco-yellow-400 transition">Câmeras & Sistemas de Alarme</a></li>
                        <li><a href="{{ route('site.solucoes') }}#cesto-aereo" class="hover:text-foco-yellow-400 transition">Aluguel Caminhão Cesto Aéreo (10m)</a></li>
                        <li><a href="{{ route('site.solucoes') }}#consultoria" class="hover:text-foco-yellow-400 transition">Consultoria & Obras em Rodovias</a></li>
                    </ul>
                </div>

                <!-- Coluna 4: Atendimento & Chamados -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-l-2 border-foco-yellow-500 pl-2">Suporte & Chamados</h4>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li><a href="{{ route('site.chamados') }}" class="text-foco-yellow-400 font-semibold hover:underline">🎫 Abertura de Chamado</a></li>
                        <li><a href="{{ route('site.chamados') }}#consulta" class="hover:text-slate-200 transition">Consultar Protocolo</a></li>
                        <li><a href="{{ route('site.cidades') }}" class="hover:text-slate-200 transition">Cidades Atendidas</a></li>
                        <li><a href="{{ route('site.sobre') }}" class="hover:text-slate-200 transition">Quem Somos / História</a></li>
                        @if(!auth()->check() || auth()->user()->isAdmin())
                            <li><a href="{{ route('login') }}" class="hover:text-slate-200 transition">Área Restrita (Gerenciador)</a></li>
                        @endif
                    </ul>
                </div>

                <!-- Coluna 5: Atendimento & Orçamentos -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-l-2 border-foco-yellow-500 pl-2">Atendimento & Orçamentos</h4>
                    <p class="text-xs text-slate-400 mb-3">Solicite orçamentos técnicos e envie suas demandas através de nosso formulário integrado:</p>
                    <div class="space-y-2">
                        <a href="{{ route('site.orcamento') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-foco-yellow-500/10 border border-foco-yellow-500/30 text-foco-yellow-400 hover:bg-foco-yellow-500/20 text-xs font-bold transition w-full justify-center">
                            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            <span>Solicitar Orçamento</span>
                        </a>
                        <a href="{{ route('site.contato') }}" class="inline-flex items-center gap-2 px-3 py-2 rounded-lg bg-white/5 border border-white/10 text-slate-200 hover:bg-white/10 text-xs font-medium transition w-full justify-center">
                            <svg class="w-4 h-4 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>Formulário de Contato</span>
                        </a>
                        <p class="text-[11px] text-slate-500 pt-1">Atendimento técnico e operacional para todo o Brasil.</p>
                    </div>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>© {{ date('Y') }} Foco Sinalização e Sistemas Inteligentes LTDA. Todos os direitos reservados.</p>
                <p class="flex items-center gap-2">
                    <span>Soluções Integradas em Mobilidade Urbana</span>
                    @if(!auth()->check() || auth()->user()->isAdmin())
                        <span>•</span>
                        <a href="{{ route('login') }}" class="text-slate-400 hover:text-foco-yellow-400 transition">Painel Administrativo</a>
                    @endif
                </p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>


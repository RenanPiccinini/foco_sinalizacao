<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Foco Sinalização e Sistemas Inteligentes | Soluções Integradas em Mobilidade Urbana')</title>
    <meta name="description" content="Engenharia de tráfego, sinalização semafórica adaptativa, centrais em nuvem WEB Digicon, nobreaks solares híbridos e sistemas inteligentes para cidades do futuro.">

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
                    Nuvem DIGICON: <strong class="text-cyan-400">Online</strong>
                </span>
            </div>

            <div class="flex items-center justify-center gap-3 text-slate-300">
                <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+preciso+de+suporte+no+Plant%C3%A3o+Vi%C3%A1rio" target="_blank" rel="noopener noreferrer" class="hover:text-[#25D366] transition flex items-center gap-1.5 font-bold text-slate-200">
                    <svg class="w-3.5 h-3.5 text-[#25D366] fill-current shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    <span>WhatsApp: (51) 99294-1111</span>
                </a>
                <span class="text-slate-600">|</span>
                @auth
                    <a href="{{ route('dashboard') }}" class="text-foco-yellow-400 hover:text-white transition font-semibold flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                        <span>Painel Gestor</span>
                    </a>
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
                    <a href="{{ route('site.contato') }}" class="px-3.5 py-2 rounded-lg transition {{ request()->routeIs('site.contato') ? 'text-foco-yellow-400 bg-white/5 font-semibold' : 'text-slate-300 hover:text-white hover:bg-white/5' }} flex items-center gap-1.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#25D366] animate-pulse"></span>
                        <span>Contato WhatsApp</span>
                    </a>

                    <!-- BOTÃO DESTACADO: MENU DE CHAMADOS -->
                    <a href="{{ route('site.chamados') }}" class="ml-2 relative inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-gradient-to-r from-foco-yellow-500 to-amber-500 text-foco-navy-950 shadow-glow-yellow hover:from-foco-yellow-400 hover:to-amber-400 hover:scale-105 active:scale-95 transition-all">
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
                            <span class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#25D366] fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                <span>Contato via WhatsApp</span>
                            </span>
                            <span class="text-xs text-slate-500">→</span>
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
                                <span>WhatsApp Plantão:</span>
                                <a href="https://wa.me/5551992941111" target="_blank" rel="noopener noreferrer" class="text-[#25D366] font-bold flex items-center gap-1 hover:underline">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                    <span>(51) 99294-1111</span>
                                </a>
                            </div>
                            <div class="flex items-center justify-between text-slate-400">
                                <span>Central DIGICON:</span>
                                <strong class="text-foco-green-400 font-bold">100% Online</strong>
                            </div>
                            <div class="pt-2 border-t border-white/5 text-center">
                                @auth
                                    <a href="{{ route('dashboard') }}" class="text-foco-yellow-400 font-bold block py-1">Ir para o Painel do Gestor →</a>
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
                            Central WEB Digicon Conectada
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
                        <li><a href="{{ route('login') }}" class="hover:text-slate-200 transition">Área Restrita (Gerenciador)</a></li>
                    </ul>
                </div>

                <!-- Coluna 5: Contato Operacional (Plantão Viário Exclusivo via WhatsApp) -->
                <div>
                    <h4 class="text-sm font-bold text-white uppercase tracking-wider mb-4 border-l-2 border-foco-yellow-500 pl-2">Plantão Viário</h4>
                    <p class="text-xs text-slate-400 mb-2">Suporte a agentes de trânsito, prefeituras e concessionárias de rodovias:</p>
                    <div class="space-y-2 text-sm text-slate-300 font-mono">
                        <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+preciso+de+suporte+no+Plant%C3%A3o+Vi%C3%A1rio" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-[#25D366] hover:text-white font-bold text-base transition">
                            <svg class="w-5 h-5 fill-current shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span>(51) 99294-1111</span>
                        </a>
                        <p class="text-xs text-slate-400">Atendimento 24 horas por dia, 7 dias por semana</p>
                    </div>
                </div>
            </div>

            <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-500">
                <p>© {{ date('Y') }} Foco Sinalização e Sistemas Inteligentes LTDA. Todos os direitos reservados.</p>
                <p class="flex items-center gap-2">
                    <span>Soluções Integradas em Mobilidade Urbana</span>
                    <span>•</span>
                    <a href="{{ route('login') }}" class="text-slate-400 hover:text-foco-yellow-400 transition">Painel Administrativo</a>
                </p>
            </div>
        </div>
    </footer>

    <!-- Botão Flutuante do WhatsApp em Todas as Telas -->
    <x-whatsapp-button />

    @stack('scripts')
</body>
</html>


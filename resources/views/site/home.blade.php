@extends('site.layout')

@section('title', 'Foco Sinalização e Sistemas Inteligentes LTDA | Mobilidade Urbana e Engenharia de Tráfego')

@section('content')
<!-- SEÇÃO HERO 3D COM THREE.JS E PARALLAX -->
<section class="relative min-h-[92vh] flex items-center justify-center overflow-hidden bg-foco-navy-950 pt-10 pb-20">
    <!-- Canvas 3D Interativo (Three.js) -->
    <div id="hero-3d-canvas" class="absolute inset-0 z-0 pointer-events-auto opacity-75"></div>

    <!-- Gradiente de sobreposição para leitura de texto perfeita -->
    <div class="absolute inset-0 bg-gradient-to-b from-foco-navy-950/40 via-foco-navy-950/70 to-foco-navy-950 z-0 pointer-events-none"></div>

    <!-- Efeito de Luzes Semafóricas Flutuantes com Parallax -->
    <div data-parallax-speed="0.15" class="absolute top-24 left-10 w-72 h-72 rounded-full bg-foco-green-500/15 blur-3xl pointer-events-none"></div>
    <div data-parallax-speed="0.25" class="absolute bottom-20 right-10 w-80 h-80 rounded-full bg-foco-yellow-500/15 blur-3xl pointer-events-none"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center lg:text-left">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Coluna de Texto de Alto Impacto -->
            <div class="lg:col-span-7 space-y-6">
                <!-- Badge de Status de Inovação -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full glass-panel border border-foco-yellow-500/30 text-xs sm:text-sm font-semibold text-foco-yellow-400 shadow-glow-yellow">
                    <span class="w-2.5 h-2.5 rounded-full bg-foco-green-400 animate-pulse"></span>
                    <span>Infraestrutura Semafórica Adaptativa & Nuvem Segura</span>
                </div>

                <!-- Título Principal -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight">
                    Mobilidade Urbana <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-foco-yellow-400 via-amber-300 to-foco-yellow-500 drop-shadow-sm">
                        Inteligente & Resiliente
                    </span>
                </h1>

                <!-- Subtítulo -->
                <p class="text-lg sm:text-xl text-slate-300 font-light leading-relaxed max-w-2xl">
                    Soluções completas viárias <em>turnkey</em> integrando inteligência artificial para otimização de fluxo, sincronismo com <strong>onda verde</strong>, segurança cibernética em nuvem DIGICON e total autonomia energética híbrida com baterias LiFePO4.
                </p>

                <!-- Ações / CTAs de Alto Impacto -->
                <div class="pt-2 flex flex-col sm:flex-row items-center gap-4 justify-center lg:justify-start">
                    <!-- CTA Primário: Abrir Chamado -->
                    <a href="{{ route('site.chamados') }}" class="w-full sm:w-auto px-7 py-4 rounded-xl font-extrabold text-sm uppercase tracking-wider bg-gradient-to-r from-foco-yellow-500 to-amber-500 text-foco-navy-950 shadow-glow-yellow hover:from-foco-yellow-400 hover:to-amber-400 hover:scale-105 active:scale-95 transition-all flex items-center justify-center gap-3">
                        <svg class="w-5 h-5 text-foco-navy-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Abrir Chamado Técnico</span>
                    </a>

                    <!-- CTA Secundário: Explorar Serviços e Engenharia -->
                    <a href="{{ route('site.solucoes') }}" class="w-full sm:w-auto px-6 py-4 rounded-xl font-bold text-sm text-slate-200 glass-card hover:bg-white/10 hover:text-white transition flex items-center justify-center gap-2">
                        <span>Conhecer Nossos Serviços</span>
                        <svg class="w-4 h-4 text-foco-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>

                    <!-- CTA Consulta de Protocolo Rápido -->
                    <a href="{{ route('site.chamados') }}#consulta" class="text-xs text-slate-400 hover:text-foco-yellow-400 transition underline underline-offset-4 flex items-center gap-1 sm:ml-2">
                        <span>Consultar chamado aberto</span>
                        <span>→</span>
                    </a>
                </div>

                <!-- Métricas Operacionais em Destaque -->
                <div class="pt-6 grid grid-cols-2 sm:grid-cols-4 gap-4 border-t border-white/10">
                    <div>
                        <span class="block text-2xl sm:text-3xl font-black text-foco-yellow-400 font-mono">+25</span>
                        <span class="text-xs text-slate-400">Cidades & Rodovias</span>
                    </div>
                    <div>
                        <span class="block text-2xl sm:text-3xl font-black text-foco-green-400 font-mono">100%</span>
                        <span class="text-xs text-slate-400">Autonomia LiFePO4</span>
                    </div>
                    <div>
                        <span class="block text-2xl sm:text-3xl font-black text-cyan-400 font-mono">24/7</span>
                        <span class="text-xs text-slate-400">Telemetria em Nuvem</span>
                    </div>
                    <div>
                        <span class="block text-2xl sm:text-3xl font-black text-slate-100 font-mono">99.8%</span>
                        <span class="text-xs text-slate-400">Uptime Semafórico</span>
                    </div>
                </div>
            </div>

            <!-- Coluna Visual 3D: Semáforo Foco com Luzes e Holograma de Telemetria -->
            <div class="lg:col-span-5 flex justify-center">
                <div data-tilt class="relative w-full max-w-md glass-panel-glow p-6 sm:p-8 rounded-3xl transform-3d transition-transform duration-300">
                    <!-- Detalhe superior da placa -->
                    <div class="flex flex-wrap items-center justify-between gap-2 pb-4 border-b border-white/10">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-foco-green-500 animate-ping"></span>
                            <span class="text-xs font-mono font-bold tracking-wider text-slate-300 uppercase">Sistema Foco Live</span>
                        </div>
                        <span class="text-xs font-mono px-2 py-0.5 rounded bg-foco-yellow-500/20 text-foco-yellow-400 border border-foco-yellow-500/30">
                            Central Digicon Conectada
                        </span>
                    </div>

                    <!-- Imagem Principal da Marca / Logo -->
                    <div class="my-6 relative overflow-hidden rounded-2xl border border-white/10 bg-foco-navy-950/90 p-2 shadow-2xl">
                        <img src="{{ asset('images/logo-banner.jpg') }}" alt="FOCO Sinalização e Sistemas Inteligentes LTDA" class="w-full h-auto object-contain rounded-lg">
                        <!-- Reflexo Dinâmico -->
                        <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/5 to-transparent pointer-events-none"></div>
                    </div>

                    <!-- Mini Widget Interativo de Status Semafórico -->
                    <div class="space-y-3 font-mono text-xs">
                        <div class="p-3 rounded-xl bg-foco-navy-900/90 border border-white/10 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full traffic-lens-green"></div>
                                <span class="text-slate-200">Sincronismo Onda Verde</span>
                            </div>
                            <span class="text-foco-green-400 font-bold">ATIVO • 55km/h</span>
                        </div>

                        <div class="p-3 rounded-xl bg-foco-navy-900/90 border border-white/10 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full traffic-lens-yellow"></div>
                                <span class="text-slate-200">Bateria LiFePO4 / Nobreak</span>
                            </div>
                            <span class="text-foco-yellow-400 font-bold">100% • Backup Pronto</span>
                        </div>

                        <div class="p-3 rounded-xl bg-foco-navy-900/90 border border-white/10 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full traffic-lens-red"></div>
                                <span class="text-slate-200">Detecção Falhas / Apagões</span>
                            </div>
                            <span class="text-slate-300 font-bold">0 Alertas Críticos</span>
                        </div>
                    </div>

                    <div class="mt-5 text-center">
                        <a href="{{ route('site.chamados') }}" class="inline-flex items-center gap-2 text-xs font-bold text-foco-yellow-400 hover:text-white transition">
                            <span>Acesso ao Portal de Abertura de Chamados</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- SEÇÃO: NARRATIVA CORPORATIVA DE ALTO IMPACTO (Nossa História & Quem Somos) -->
<section id="historia" class="py-24 bg-gradient-to-b from-foco-navy-950 via-foco-navy-900 to-foco-navy-950 relative border-t border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Cabeçalho da Seção -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-mono font-bold tracking-widest text-foco-yellow-400 uppercase bg-foco-yellow-500/10 px-3 py-1 rounded-full border border-foco-yellow-500/30">
                Narrativa Corporativa de Alto Impacto
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mt-4 tracking-tight">
                Engenharia de Tráfego Preparada Para Projetar as Cidades do Futuro
            </h2>
            <div class="w-20 h-1 bg-gradient-to-r from-foco-yellow-500 to-amber-500 mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            <!-- Card 3D 1: Nossa História -->
            <div data-tilt class="glass-card p-8 sm:p-10 rounded-3xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-40 h-40 bg-foco-yellow-500/10 rounded-full blur-2xl group-hover:bg-foco-yellow-500/20 transition-all"></div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-foco-yellow-500/10 border border-foco-yellow-500/30 flex items-center justify-center text-foco-yellow-400">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-white">Nossa História</h3>
                        <p class="text-xs font-mono text-foco-yellow-400 uppercase tracking-wider">Engenharia Integrada de Tráfego</p>
                    </div>
                </div>

                <div class="space-y-4 text-slate-300 text-sm sm:text-base leading-relaxed">
                    <p>
                        Mais do que entregar excelência técnica, esse grande projeto nos permitiu enxergar de perto uma carência latente no mercado por soluções inteligentes e integradas de engenharia de tráfego. Ao mostrarmos a programação semafórica e o estudo de fluxo de veículos, começamos a desenvolver soluções técnicas específicas, aliando os equipamentos instalados em cada cidade, diminuindo custos operacionais, sem perder eficiência e confiabilidade, otimizando a mobilidade urbana.
                    </p>
                </div>
            </div>

            <!-- Card 3D 2: Quem Somos -->
            <div data-tilt class="glass-card p-8 sm:p-10 rounded-3xl relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-40 h-40 bg-foco-green-500/10 rounded-full blur-2xl group-hover:bg-foco-green-500/20 transition-all"></div>
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-foco-green-500/10 border border-foco-green-500/30 flex items-center justify-center text-foco-green-400">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-white">Quem Somos</h3>
                        <p class="text-xs font-mono text-foco-green-400 uppercase tracking-wider">Deep Tech & Cases Consolidados</p>
                    </div>
                </div>

                <div class="space-y-4 text-slate-300 text-sm sm:text-base leading-relaxed">
                    <div class="p-4 rounded-xl bg-foco-navy-950/80 border-l-4 border-foco-green-500 text-white font-medium text-sm sm:text-base">
                        Expertise técnica em Projetos de Tecnologias Emergentes (Deep Tech), aliado a cases consolidados do mercado.
                    </div>
                    <p>
                        Os desafios na área de atuação nos impulsionam em busca de soluções precisas, levando em consideração a solicitação técnica de cada cliente, cada projeto é desenvolvido tendo esse princípio.
                    </p>
                    <p>
                        Foi nesse cenário que passamos a oferecer soluções completas em sinalização semafórica — da instalação física de postes, cabeamentos, semáforos, câmeras, nobreaks, controlador eletrônico de tráfego à inteligência de software e centralização de sistemas.
                    </p>
                    <p>
                        Ao identificarmos uma carência no setor por serviços que aliassem robustez operacional e inteligência de tráfego, fomos impulsionados a expandir nossas fronteiras.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEÇÃO: SERVIÇOS PRESTADOS PELA FOCO -->
<section id="servicos" class="py-24 bg-foco-navy-950 relative overflow-hidden">
    <!-- Luzes de fundo decorativas -->
    <div class="absolute top-1/4 left-0 w-96 h-96 bg-foco-yellow-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 right-0 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-mono font-bold tracking-widest text-foco-yellow-400 uppercase bg-foco-yellow-500/10 px-4 py-1.5 rounded-full border border-foco-yellow-500/30">
                Portfólio Operacional & Engenharia
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mt-4 tracking-tight">
                SERVIÇOS PRESTADOS PELA FOCO
            </h2>
            <p class="text-slate-400 mt-3 text-base">
                Engenharia especializada, energia limpa autossustentável, infraestrutura elétrica, segurança eletrônica e suporte operacional com cesto aéreo.
            </p>
            <div class="w-24 h-1 bg-gradient-to-r from-foco-yellow-500 to-amber-500 mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            
            <!-- SERVIÇO 1: Projetos de Sinalização semafórica, vertical e horizontal -->
            <div data-tilt class="glass-card p-8 rounded-3xl group border-t-4 border-t-foco-yellow-500 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-14 h-14 rounded-2xl bg-foco-yellow-500/10 border border-foco-yellow-500/30 flex items-center justify-center text-foco-yellow-400 group-hover:scale-110 transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                        </div>
                        <span class="text-xs font-mono font-bold text-foco-yellow-400 bg-foco-yellow-500/10 px-2.5 py-1 rounded-full border border-foco-yellow-500/20">
                            Serviço 01
                        </span>
                    </div>

                    <h3 class="text-xl font-black text-white mb-2 leading-snug">
                        Projetos de Sinalização semafórica, vertical e horizontal
                    </h3>

                    <!-- Badges do Ciclo: Planejamento - Elaboração – Assessoria – Execução -->
                    <div class="flex flex-wrap gap-1.5 my-3">
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-foco-yellow-500/20 text-foco-yellow-300 border border-foco-yellow-500/30">Planejamento</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-foco-yellow-500/20 text-foco-yellow-300 border border-foco-yellow-500/30">Elaboração</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-foco-yellow-500/20 text-foco-yellow-300 border border-foco-yellow-500/30">Assessoria</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-foco-yellow-500/20 text-foco-yellow-300 border border-foco-yellow-500/30">Execução</span>
                    </div>

                    <p class="text-sm text-slate-300 leading-relaxed mt-3">
                        Estudos de tráfego, programação e sincronismo para <strong>"onda verde"</strong>, controladores inteligentes com laços virtuais e visão computacional. Implantação de sinalização horizontal viária (faixas de pedestres, ciclofaixas, pintura termoplástica e tachões) e sinalização vertical completa (placas e pórticos conforme normas Contran/DNIT).
                    </p>
                </div>

                <div class="pt-6 mt-6 border-t border-white/10 flex items-center justify-between">
                    <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+gostaria+de+um+or%C3%A7amento+sobre+Projetos+de+Sinaliza%C3%A7%C3%A3o+Semaf%C3%B3rica%2C+Vertical+e+Horizontal" target="_blank" rel="noopener noreferrer" class="text-xs font-mono font-bold text-foco-yellow-400 hover:text-white transition flex items-center gap-1.5">
                        <span>Solicitar Orçamento</span>
                        <span>→</span>
                    </a>
                    <a href="{{ route('site.solucoes') }}#sinalizacao" class="text-xs text-slate-400 hover:text-white transition">Saiba mais</a>
                </div>
            </div>

            <!-- SERVIÇO 2: Projetos de energia alternativa auto sustentável (solar eólica) -->
            <div data-tilt class="glass-card p-8 rounded-3xl group border-t-4 border-t-emerald-400 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-14 h-14 rounded-2xl bg-emerald-400/10 border border-emerald-400/30 flex items-center justify-center text-emerald-400 group-hover:scale-110 transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <span class="text-xs font-mono font-bold text-emerald-400 bg-emerald-500/10 px-2.5 py-1 rounded-full border border-emerald-500/20">
                            Serviço 02
                        </span>
                    </div>

                    <h3 class="text-xl font-black text-white mb-2 leading-snug">
                        Projetos de energia alternativa auto sustentável (solar eólica)
                    </h3>

                    <!-- Badges do Ciclo: Planejamento - Elaboração – Assessoria – Execução -->
                    <div class="flex flex-wrap gap-1.5 my-3">
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Planejamento</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Elaboração</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Assessoria</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Execução</span>
                    </div>

                    <p class="text-sm text-slate-300 leading-relaxed mt-3">
                        Engenharia e instalação de matrizes energéticas limpas para cruzamentos semafóricos e instalações comerciais/públicas. Painéis fotovoltaicos com controladores digitais MPPT, microgeradores eólicos urbanos de alto rendimento, Nobreaks (UPS) senoidais e bancos de baterias <strong>LiFePO4</strong> (Lítio Ferro Fosfato). <strong>Autonomia 24/7 e zero apagões.</strong>
                    </p>
                </div>

                <div class="pt-6 mt-6 border-t border-white/10 flex items-center justify-between">
                    <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+gostaria+de+um+or%C3%A7amento+sobre+Projetos+de+Energia+Alternativa+Auto+Sustent%C3%A1vel" target="_blank" rel="noopener noreferrer" class="text-xs font-mono font-bold text-emerald-400 hover:text-white transition flex items-center gap-1.5">
                        <span>Solicitar Orçamento</span>
                        <span>→</span>
                    </a>
                    <a href="{{ route('site.solucoes') }}#energia" class="text-xs text-slate-400 hover:text-white transition">Saiba mais</a>
                </div>
            </div>

            <!-- SERVIÇO 3: Instalações e manutenções elétricas residenciais e comerciais de Baixa Tensão -->
            <div data-tilt class="glass-card p-8 rounded-3xl group border-t-4 border-t-cyan-400 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-14 h-14 rounded-2xl bg-cyan-400/10 border border-cyan-400/30 flex items-center justify-center text-cyan-400 group-hover:scale-110 transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <span class="text-xs font-mono font-bold text-cyan-400 bg-cyan-500/10 px-2.5 py-1 rounded-full border border-cyan-500/20">
                            Serviço 03
                        </span>
                    </div>

                    <h3 class="text-xl font-black text-white mb-2 leading-snug">
                        Instalações e manutenções elétricas residenciais e comerciais de Baixa Tensão
                    </h3>

                    <!-- Badges do Ciclo: Planejamento - Elaboração – Assessoria – Execução -->
                    <div class="flex flex-wrap gap-1.5 my-3">
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">Planejamento</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">Elaboração</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">Assessoria</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">Execução</span>
                    </div>

                    <p class="text-sm text-slate-300 leading-relaxed mt-3">
                        Execução de projetos elétricos prediais e viários rigorosamente alinhados à NR-10 e NBR 5410. Montagem e retrofit de quadros de distribuição (QDC), proteção contra surtos (DPS), sistemas de aterramento de precisão, cabeamento subterrâneo estruturado e planos de manutenção corretiva e preventiva.
                    </p>
                </div>

                <div class="pt-6 mt-6 border-t border-white/10 flex items-center justify-between">
                    <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+gostaria+de+um+or%C3%A7amento+sobre+Instala%C3%A7%C3%B5es+El%C3%A9tricas+de+Baixa+Tens%C3%A3o" target="_blank" rel="noopener noreferrer" class="text-xs font-mono font-bold text-cyan-400 hover:text-white transition flex items-center gap-1.5">
                        <span>Solicitar Orçamento</span>
                        <span>→</span>
                    </a>
                    <a href="{{ route('site.solucoes') }}#eletrica" class="text-xs text-slate-400 hover:text-white transition">Saiba mais</a>
                </div>
            </div>

            <!-- SERVIÇO 4: Instalações e manutenções de câmeras de monitoramento e sistemas de alarme -->
            <div data-tilt class="glass-card p-8 rounded-3xl group border-t-4 border-t-blue-500 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-14 h-14 rounded-2xl bg-blue-500/10 border border-blue-500/30 flex items-center justify-center text-blue-400 group-hover:scale-110 transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-xs font-mono font-bold text-blue-400 bg-blue-500/10 px-2.5 py-1 rounded-full border border-blue-500/20">
                            Serviço 04
                        </span>
                    </div>

                    <h3 class="text-xl font-black text-white mb-2 leading-snug">
                        Instalações e manutenções de câmeras de monitoramento e sistemas de alarme
                    </h3>

                    <!-- Badges do Ciclo: Planejamento - Elaboração – Assessoria – Execução -->
                    <div class="flex flex-wrap gap-1.5 my-3">
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">Planejamento</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">Elaboração</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">Assessoria</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-mono font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">Execução</span>
                    </div>

                    <p class="text-sm text-slate-300 leading-relaxed mt-3">
                        Sistemas de CFTV IP e analógico HD de alta definição com visão noturna, contagem de fluxo e laços virtuais inteligentes. Centrais de alarme monitoradas, sensores infravermelhos perimetrais, barreiras ativas e gerenciamento remoto em tempo real via nuvem ou smartphone.
                    </p>
                </div>

                <div class="pt-6 mt-6 border-t border-white/10 flex items-center justify-between">
                    <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+gostaria+de+um+or%C3%A7amento+sobre+C%C3%A2meras+de+Monitoramento+e+Alarmes" target="_blank" rel="noopener noreferrer" class="text-xs font-mono font-bold text-blue-400 hover:text-white transition flex items-center gap-1.5">
                        <span>Solicitar Orçamento</span>
                        <span>→</span>
                    </a>
                    <a href="{{ route('site.solucoes') }}#seguranca" class="text-xs text-slate-400 hover:text-white transition">Saiba mais</a>
                </div>
            </div>

            <!-- SERVIÇO 5: Aluguel de caminhão com cesto aéreo (com operador) -->
            <div data-tilt class="glass-card p-8 rounded-3xl group border-t-4 border-t-amber-500 md:col-span-2 lg:col-span-2 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-5">
                        <div class="w-14 h-14 rounded-2xl bg-amber-500/10 border border-amber-500/30 flex items-center justify-center text-amber-400 group-hover:scale-110 transition">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                        </div>
                        <span class="text-xs font-mono font-bold text-amber-400 bg-amber-500/10 px-2.5 py-1 rounded-full border border-amber-500/20">
                            Serviço 05 • Operação em Altura
                        </span>
                    </div>

                    <h3 class="text-xl font-black text-white mb-2 leading-snug">
                        Aluguel de caminhão com cesto aéreo (com operador)
                    </h3>

                    <!-- Badges do Escopo Específico -->
                    <div class="flex flex-wrap gap-1.5 my-3">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">Instalações de câmeras</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">Cabeamento</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">Podas</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">Fachadas até 10 metros</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Com Operador Capacitado (NR-35 / NR-10)</span>
                    </div>

                    <p class="text-sm text-slate-300 leading-relaxed mt-3">
                        Disponibilização de caminhão especializado equipado com cesto aéreo hidráulico articulado para trabalhos seguros em alturas de <strong>até 10 metros</strong>. A locação inclui operador técnico treinado e homologado nas normas NR-35 (trabalho em altura) e NR-10 (segurança elétrica). Atendimento perfeito para fixação e manutenção de câmeras em postes, lançamento e ancoragem de cabeamento estruturado e fibra, podas desobstrutivas de galhos junto a redes e manutenção/instalação de fachadas comerciais e luminosos.
                    </p>
                </div>

                <div class="pt-6 mt-6 border-t border-white/10 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+gostaria+de+informa%C3%A7%C3%B5es+sobre+o+Aluguel+de+Caminh%C3%A3o+com+Cesto+A%C3%A9reo" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-amber-500 hover:bg-amber-400 text-foco-navy-950 transition shadow-glow-yellow flex items-center gap-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        <span>Contratar com Operador via WhatsApp</span>
                    </a>
                    <a href="{{ route('site.solucoes') }}#cesto-aereo" class="text-xs text-slate-400 hover:text-white transition">Detalhes técnicos e especificações →</a>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- SEÇÃO: MATRIZ DE IMPACTO E RESULTADOS (CONVENCIONAL VS FOCO) -->
<section class="py-24 bg-gradient-to-b from-foco-navy-950 via-foco-navy-900 to-foco-navy-950 border-t border-b border-white/5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-mono font-bold tracking-widest text-foco-yellow-400 uppercase bg-foco-yellow-500/10 px-3 py-1 rounded-full border border-foco-yellow-500/30">
                Engenharia Comprovada
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mt-4 tracking-tight">
                Matriz de Impacto e Resultados Obtidos
            </h2>
            <p class="text-slate-400 mt-3 text-base">
                Comparativo direto entre o modelo convencional tradicional e as vantagens do ecossistema inteligente FOCO.
            </p>
            <div class="w-20 h-1 bg-foco-yellow-500 mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- Matriz Comparativa (100% Responsiva: Tabela no Desktop e Cards no Celular) -->
        <div class="glass-panel rounded-3xl overflow-hidden border border-white/10 shadow-2xl">
            
            <!-- VISUALIZAÇÃO DESKTOP / TABLET (Tabela Completa) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-foco-navy-900 border-b border-white/10 text-xs font-mono uppercase tracking-wider text-slate-400">
                            <th class="py-5 px-6 font-bold">Indicador Operacional</th>
                            <th class="py-5 px-6 font-bold text-rose-400 bg-rose-500/5">Cenário Anterior (Convencional)</th>
                            <th class="py-5 px-6 font-bold text-foco-green-400 bg-foco-green-500/10">Solução Inteligente FOCO</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5 text-sm">
                        <!-- Linha 1 -->
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-5 px-6 font-bold text-white flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                                Gestão de Fluxo
                            </td>
                            <td class="py-5 px-6 text-slate-400 bg-rose-500/5">
                                Planos fixos baseados em horários. Retenção ociosa e formação crônica de filas.
                            </td>
                            <td class="py-5 px-6 text-slate-200 bg-foco-green-500/5 font-medium">
                                <strong class="text-foco-green-400">Modo adaptativo com parametrização flexível</strong>, variação de verde dinâmica por câmeras de visão computacional. Sincronismo e onda verde em tempo real.
                            </td>
                        </tr>

                        <!-- Linha 2 -->
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-5 px-6 font-bold text-white flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
                                Resiliência Energética
                            </td>
                            <td class="py-5 px-6 text-slate-400 bg-rose-500/5">
                                Queda total em apagões da rede elétrica concessionária, exigindo presença imediata de viaturas e agentes.
                            </td>
                            <td class="py-5 px-6 text-slate-200 bg-foco-green-500/5 font-medium">
                                <strong class="text-foco-green-400">Autonomia contínua garantida</strong> via Nobreak Senoidal Puro e bancos de baterias de Lítio (LiFePO4). Zero apagões viários.
                            </td>
                        </tr>

                        <!-- Linha 3 -->
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-5 px-6 font-bold text-white flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full bg-foco-yellow-400"></span>
                                Consumo Energético
                            </td>
                            <td class="py-5 px-6 text-slate-400 bg-rose-500/5">
                                Dependência total da rede da concessionária com custo fixo mensal elevado aos cofres públicos.
                            </td>
                            <td class="py-5 px-6 text-slate-200 bg-foco-green-500/5 font-medium">
                                <strong class="text-foco-yellow-400">Redução drástica do consumo</strong> através de captação híbrida auto sustentável (painéis solares fotovoltaicos MPPT e microgeradores eólicos urbanos).
                            </td>
                        </tr>

                        <!-- Linha 4 -->
                        <tr class="hover:bg-white/5 transition">
                            <td class="py-5 px-6 font-bold text-white flex items-center gap-3">
                                <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                                Gestão e Manutenção
                            </td>
                            <td class="py-5 px-6 text-slate-400 bg-rose-500/5">
                                Manutenção puramente reativa e fiscalização presencial lenta com chamados via papel ou telefone manual.
                            </td>
                            <td class="py-5 px-6 text-slate-200 bg-foco-green-500/5 font-medium">
                                <strong class="text-cyan-400">Plataforma WEB em Nuvem Segura DIGICON</strong> com telemetria em tempo real, ordens de serviço automatizadas por app e controle centralizado.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- VISUALIZAÇÃO MOBILE (Cards 100% Responsivos: Sem Rolagem Horizontal Forçada) -->
            <div class="block md:hidden divide-y divide-white/10">
                <!-- Card 1: Gestão de Fluxo -->
                <div class="p-5 space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-400"></span>
                        <h3 class="text-base font-bold text-white">Gestão de Fluxo</h3>
                    </div>

                    <div class="space-y-2 text-xs">
                        <div class="p-3 rounded-xl bg-rose-500/10 border border-rose-500/20">
                            <span class="text-[10px] font-mono uppercase font-bold text-rose-400 block mb-1">Cenário Anterior (Convencional):</span>
                            <p class="text-slate-300 leading-relaxed">Planos fixos baseados em horários. Retenção ociosa e formação crônica de filas.</p>
                        </div>

                        <div class="p-3 rounded-xl bg-foco-green-500/10 border border-foco-green-500/30">
                            <span class="text-[10px] font-mono uppercase font-bold text-foco-green-400 block mb-1">Solução Inteligente FOCO:</span>
                            <p class="text-slate-200 leading-relaxed">
                                <strong class="text-foco-green-400">Modo adaptativo com parametrização flexível</strong>, variação de verde dinâmica por câmeras de visão computacional. Sincronismo e onda verde em tempo real.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 2: Resiliência Energética -->
                <div class="p-5 space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                        <h3 class="text-base font-bold text-white">Resiliência Energética</h3>
                    </div>

                    <div class="space-y-2 text-xs">
                        <div class="p-3 rounded-xl bg-rose-500/10 border border-rose-500/20">
                            <span class="text-[10px] font-mono uppercase font-bold text-rose-400 block mb-1">Cenário Anterior (Convencional):</span>
                            <p class="text-slate-300 leading-relaxed">Queda total em apagões da rede elétrica concessionária, exigindo presença imediata de viaturas e agentes.</p>
                        </div>

                        <div class="p-3 rounded-xl bg-foco-green-500/10 border border-foco-green-500/30">
                            <span class="text-[10px] font-mono uppercase font-bold text-foco-green-400 block mb-1">Solução Inteligente FOCO:</span>
                            <p class="text-slate-200 leading-relaxed">
                                <strong class="text-foco-green-400">Autonomia contínua garantida</strong> via Nobreak Senoidal Puro e bancos de baterias de Lítio (LiFePO4). Zero apagões viários.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 3: Consumo Energético -->
                <div class="p-5 space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-foco-yellow-400"></span>
                        <h3 class="text-base font-bold text-white">Consumo Energético</h3>
                    </div>

                    <div class="space-y-2 text-xs">
                        <div class="p-3 rounded-xl bg-rose-500/10 border border-rose-500/20">
                            <span class="text-[10px] font-mono uppercase font-bold text-rose-400 block mb-1">Cenário Anterior (Convencional):</span>
                            <p class="text-slate-300 leading-relaxed">Dependência total da rede da concessionária com custo fixo mensal elevado aos cofres públicos.</p>
                        </div>

                        <div class="p-3 rounded-xl bg-foco-green-500/10 border border-foco-green-500/30">
                            <span class="text-[10px] font-mono uppercase font-bold text-foco-yellow-400 block mb-1">Solução Inteligente FOCO:</span>
                            <p class="text-slate-200 leading-relaxed">
                                <strong class="text-foco-yellow-400">Redução drástica do consumo</strong> através de captação híbrida auto sustentável (painéis solares fotovoltaicos MPPT e microgeradores eólicos urbanos).
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 4: Gestão e Manutenção -->
                <div class="p-5 space-y-3">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-cyan-400"></span>
                        <h3 class="text-base font-bold text-white">Gestão e Manutenção</h3>
                    </div>

                    <div class="space-y-2 text-xs">
                        <div class="p-3 rounded-xl bg-rose-500/10 border border-rose-500/20">
                            <span class="text-[10px] font-mono uppercase font-bold text-rose-400 block mb-1">Cenário Anterior (Convencional):</span>
                            <p class="text-slate-300 leading-relaxed">Manutenção puramente reativa e fiscalização presencial lenta com chamados via papel ou telefone manual.</p>
                        </div>

                        <div class="p-3 rounded-xl bg-foco-green-500/10 border border-foco-green-500/30">
                            <span class="text-[10px] font-mono uppercase font-bold text-cyan-400 block mb-1">Solução Inteligente FOCO:</span>
                            <p class="text-slate-200 leading-relaxed">
                                <strong class="text-cyan-400">Plataforma WEB em Nuvem Segura DIGICON</strong> com telemetria em tempo real, ordens de serviço automatizadas por app e controle centralizado.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- SEÇÃO: PORTAL & MENU DE CHAMADOS TÉCNICOS (DESTAQUE PRINCIPAL) -->
<section id="chamados" class="py-24 bg-foco-navy-950 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="glass-panel-glow p-8 sm:p-12 rounded-3xl relative overflow-hidden">
            <!-- Efeito de Luz Amarela Semafórica de fundo -->
            <div class="absolute -right-20 -bottom-20 w-80 h-80 rounded-full bg-foco-yellow-500/20 blur-3xl pointer-events-none"></div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-8 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-foco-yellow-500/10 text-foco-yellow-400 border border-foco-yellow-500/30 text-xs font-mono font-bold">
                        <span class="w-2 h-2 rounded-full bg-foco-yellow-400 animate-ping"></span>
                        Central de Chamados para Prefeituras, DTT e Agentes
                    </div>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white">
                        Precisa Reportar uma Ocorrência ou Solicitar Ajuste Semafórico?
                    </h2>
                    <p class="text-slate-300 text-base leading-relaxed">
                        Abra seu chamado técnico diretamente na plataforma. Nossa equipe de engenharia e campo recebe a notificação georreferenciada instantaneamente na nuvem DIGICON com acompanhamento em tempo real via protocolo.
                    </p>
                    
                    <div class="flex flex-wrap items-center gap-3 pt-2 text-xs font-mono text-slate-400">
                        <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-foco-green-400"></span> Plantão 24/7</span>
                        <span>•</span>
                        <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-foco-green-400"></span> SLA Prioritário</span>
                        <span>•</span>
                        <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-foco-green-400"></span> Protocolo Instantâneo</span>
                    </div>
                </div>

                <div class="lg:col-span-4 flex flex-col gap-3 justify-center">
                    <a href="{{ route('site.chamados') }}" class="w-full px-6 py-4 rounded-xl font-black text-sm uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 shadow-glow-yellow text-center transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        <span>Abrir Novo Chamado Agora</span>
                    </a>

                    <a href="{{ route('site.chamados') }}#consulta" class="w-full px-6 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider glass-card text-slate-200 hover:text-white text-center transition-all flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-foco-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>Consultar Por Protocolo</span>
                    </a>
                </div>
            </div>

            <!-- Preview dos Últimos Chamados Fakes Simulados -->
            <div class="mt-8 pt-6 border-t border-white/10">
                <div class="flex items-center justify-between mb-4">
                    <span class="text-xs font-mono font-bold text-slate-400 uppercase tracking-wider">Últimos Registros em Monitoramento:</span>
                    <a href="{{ route('site.chamados') }}" class="text-xs text-foco-yellow-400 hover:underline">Ver todos no portal →</a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach($ultimosChamados as $c)
                    <div class="p-3.5 rounded-xl bg-foco-navy-900/90 border border-white/5 text-xs font-mono space-y-1.5">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-foco-yellow-400">{{ $c->protocolo }}</span>
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $c->tipo_badge_class }}">
                                {{ $c->tipo }}
                            </span>
                        </div>
                        <p class="text-slate-200 font-sans font-medium line-clamp-1">{{ $c->defeito }}</p>
                        <div class="flex items-center justify-between text-[11px] text-slate-400">
                            <span class="truncate max-w-[170px]">{{ $c->local }}</span>
                            <span class="px-1.5 py-0.5 rounded text-[10px] {{ $c->status_badge_class }}">{{ $c->status }}</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEÇÃO: MUNICÍPIOS E RODOVIAS ATENDIDAS -->
<section id="cidades" class="py-24 bg-foco-navy-900 relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-mono font-bold tracking-widest text-foco-green-400 uppercase bg-foco-green-500/10 px-3 py-1 rounded-full border border-foco-green-500/30">
                Presença e Cobertura Viária
            </span>
            <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white mt-4 tracking-tight">
                Municípios e Rodovias Conectadas
            </h2>
            <p class="text-slate-400 mt-3 text-base">
                A Foco executa serviços e fornece equipamentos de engenharia diretamente para prefeituras ou através de concessões viárias.
            </p>
            <div class="w-20 h-1 bg-foco-green-500 mx-auto mt-4 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card Santa Catarina -->
            <div class="glass-card p-6 rounded-3xl">
                <div class="flex items-center gap-3 mb-4 pb-3 border-b border-white/10">
                    <span class="w-3 h-3 rounded-full bg-cyan-400"></span>
                    <h3 class="text-lg font-bold text-white">Santa Catarina (SC)</h3>
                </div>
                <ul class="space-y-2 text-sm text-slate-300">
                    @foreach($municipiosSC as $m)
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-foco-yellow-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        <span>{{ $m }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Card Rio Grande do Sul -->
            <div class="glass-card p-6 rounded-3xl">
                <div class="flex items-center gap-3 mb-4 pb-3 border-b border-white/10">
                    <span class="w-3 h-3 rounded-full bg-foco-green-400"></span>
                    <h3 class="text-lg font-bold text-white">Rio Grande do Sul (RS)</h3>
                </div>
                <div class="max-h-64 overflow-y-auto pr-2 space-y-2 text-sm text-slate-300">
                    @foreach($municipiosRS as $m)
                    <li class="flex items-center gap-2 list-none">
                        <svg class="w-4 h-4 text-foco-green-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        <span>{{ $m }}</span>
                    </li>
                    @endforeach
                </div>
            </div>

            <!-- Card Rodovias Federais & Consultoria -->
            <div class="glass-card p-6 rounded-3xl">
                <div class="flex items-center gap-3 mb-4 pb-3 border-b border-white/10">
                    <span class="w-3 h-3 rounded-full bg-foco-yellow-400"></span>
                    <h3 class="text-lg font-bold text-white">Rodovias & Obras Críticas</h3>
                </div>
                <ul class="space-y-2 text-sm text-slate-300 mb-6">
                    @foreach($rodovias as $r)
                    <li class="flex items-center gap-2 font-mono text-xs font-semibold text-foco-yellow-300">
                        <span class="px-2 py-0.5 rounded bg-foco-yellow-500/20 border border-foco-yellow-500/30">BR</span>
                        <span>{{ $r }}</span>
                    </li>
                    @endforeach
                </ul>

                <div class="p-3.5 rounded-xl bg-foco-navy-950/80 border border-white/10 text-xs text-slate-300 leading-relaxed">
                    <strong>Consultoria & Assessoria:</strong> Projetos semafóricos em obras temporárias de pontes, queda de barreiras ou bloqueios por eventos climatológicos.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SEÇÃO: PARCEIROS E CLIENTES CORPORATIVOS -->
<section class="py-20 bg-foco-navy-950 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <p class="text-center text-xs font-mono font-bold tracking-widest text-slate-400 uppercase mb-10">
            Parcerias em Serviços, Equipamentos e Engenharia Integrada
        </p>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
            @foreach($parceiros as $p)
            <div class="p-4 rounded-2xl glass-card flex flex-col justify-center items-center text-center group">
                <span class="text-sm font-bold text-white group-hover:text-foco-yellow-400 transition">{{ $p['nome'] }}</span>
                <span class="text-[11px] text-slate-400 mt-0.5">{{ $p['tipo'] }}</span>
            </div>
            @endforeach
            <div class="p-4 rounded-2xl glass-card flex flex-col justify-center items-center text-center group border border-dashed border-foco-yellow-500/30">
                <span class="text-xs font-mono font-bold text-foco-yellow-400">Prefeituras & Concessões</span>
                <span class="text-[11px] text-slate-400">+25 Contratos Ativos</span>
            </div>
        </div>
    </div>
</section>
@endsection


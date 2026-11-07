@extends('site.layout')

@section('title', 'Soluções e Engenharia de Tráfego ITS | Foco Sinalização')

@section('content')
<div class="py-16 bg-foco-navy-950 relative overflow-hidden">
    <!-- Luzes decorativas com Parallax -->
    <div data-parallax-speed="0.2" class="absolute top-10 right-10 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div data-parallax-speed="0.1" class="absolute bottom-10 left-10 w-96 h-96 bg-foco-yellow-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Cabeçalho -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-mono font-bold tracking-widest text-cyan-400 uppercase bg-cyan-500/10 px-3 py-1 rounded-full border border-cyan-500/30">
                Solução Turnkey Viária
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-white mt-4 tracking-tight">
                Engenharia de Tráfego e Tecnologias de Ponta
            </h1>
            <p class="text-slate-400 mt-4 text-base leading-relaxed">
                A Foco Sinalização integra hardware robusto, inteligência artificial preditiva, segurança cibernética em nuvem e autonomia energética híbrida em uma malha viária conectada.
            </p>
            <div class="w-24 h-1 bg-gradient-to-r from-cyan-500 to-foco-yellow-500 mx-auto mt-6 rounded-full"></div>
        </div>

        <!-- O Desafio Urbano Encontrado -->
        <div class="glass-panel p-8 sm:p-10 rounded-3xl mb-16 border border-white/10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                <div class="lg:col-span-8 space-y-4">
                    <span class="text-xs font-mono font-bold text-rose-400 uppercase tracking-wider">O Desafio Urbano Encontrado</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white">
                        Gargalos no Trânsito Moderno e a Vulnerabilidade da Rede Elétrica
                    </h2>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                        As redes de tráfego das cidades modernas enfrentam dois gargalos principais: o <strong>congestionamento crônico</strong> gerado por controladores com planos de tempos fixos (insensíveis à demanda real) e a <strong>extrema vulnerabilidade dos cruzamentos</strong> diante de apagões, oscilações ou falhas na rede de distribuição elétrica concessionária.
                    </p>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                        A interrupção de um semáforo em cruzamentos críticos resulta imediatamente em travamento da malha viária, aumento exponencial de colisões e acidentes e sobrecarga imediata das equipes de agentes de trânsito em campo.
                    </p>
                </div>
                <div class="lg:col-span-4 p-6 rounded-2xl bg-foco-navy-900 border border-white/10 font-mono text-xs space-y-3">
                    <div class="text-foco-yellow-400 font-bold uppercase tracking-wider">Impacto do Sistema FOCO:</div>
                    <div class="flex items-center justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-400">Tempo de Parada:</span>
                        <span class="text-foco-green-400 font-bold">-35% Retenção</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-400">Autonomia em Apagão:</span>
                        <span class="text-foco-green-400 font-bold">100% Ininterrupta</span>
                    </div>
                    <div class="flex items-center justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-400">Intervenções de Emergência:</span>
                        <span class="text-cyan-400 font-bold">Via Smartphone</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Auditoria & Segurança:</span>
                        <span class="text-slate-200 font-bold">Nuvem Criptografada</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalhamento dos 5 Pilares Fundamentais -->
        <div class="space-y-12">
            
            <!-- Pilar 1: Infraestrutura Civil -->
            <div id="infraestrutura" class="glass-card p-8 sm:p-10 rounded-3xl border-l-4 border-l-blue-500">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <span class="text-xs font-mono font-bold text-blue-400 uppercase tracking-wider">Seção 2.1</span>
                        <h3 class="text-2xl font-bold text-white mt-1">Engenharia e Infraestrutura Civil Viária</h3>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-mono bg-blue-500/10 text-blue-400 border border-blue-500/30 self-start">
                        Hardware & Construção Pesada
                    </span>
                </div>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-4">
                    Fornecimento e instalação completa dos leitos de cabos subterrâneos utilizando <strong>eletrodutos de PEAD</strong> de alta resistência química e mecânica, caixas de passagem e de inspeção subterrâneas padronizadas conforme normas do Contran/DNIT, além de <strong>colunas e braços projetados em aço galvanizado</strong> a fogo com durabilidade comprovada sob intempéries e maresia litorânea.
                </p>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Os cruzamentos recebem <strong>grupos focais veiculares e de pedestres</strong> dotados de iluminadores a LED de altíssima intensidade luminosa (visibilidade perfeita mesmo sob incidência solar direta) e consumo energético reduzido em até 80% comparado às lâmpadas halógenas antigas.
                </p>
            </div>

            <!-- Pilar 2: ITS e Visão Computacional -->
            <div id="its" class="glass-card p-8 sm:p-10 rounded-3xl border-l-4 border-l-foco-yellow-500">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <span class="text-xs font-mono font-bold text-foco-yellow-400 uppercase tracking-wider">Seção 2.2</span>
                        <h3 class="text-2xl font-bold text-white mt-1">Inteligência de Tráfego Adaptativo (ITS)</h3>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-mono bg-foco-yellow-500/10 text-foco-yellow-400 border border-foco-yellow-500/30 self-start">
                        Visão Computacional & IA
                    </span>
                </div>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-4">
                    Substituição completa de laços indutivos magnéticos tradicionais (que exigem cortes destrutivos no pavimento e quebram com o tráfego pesado) por <strong>câmeras sensoriais de visão computacional de alta definição</strong>.
                </p>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    O sistema realiza o sensoriamento viário através de <strong>laços virtuais</strong> com contagem volumétrica contínua e classificação de veículos (leves, pesados, transporte coletivo). Esses dados alimentam em tempo real os algoritmos de otimização dinâmica do controlador semafórico inteligente, ajustando instantaneamente os tempos de verde, ciclos e a sincronização precisa das <strong>"ondas verdes"</strong> nas principais avenidas.
                </p>
            </div>

            <!-- Pilar 3: Central Semafórica WEB DIGICON em Nuvem Segura -->
            <div id="digicon" class="glass-card p-8 sm:p-10 rounded-3xl border-l-4 border-l-cyan-400">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <span class="text-xs font-mono font-bold text-cyan-400 uppercase tracking-wider">Seção 2.3</span>
                        <h3 class="text-2xl font-bold text-white mt-1">Central Semafórica WEB DIGICON em Nuvem Segura</h3>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-mono bg-cyan-400/10 text-cyan-400 border border-cyan-400/30 self-start">
                        Cybersecurity & Cloud
                    </span>
                </div>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-4">
                    Centralização digital de todos os ativos semafóricos através de uma plataforma baseada em nuvem segura, acessível via navegador WEB por qualquer dispositivo autorizado de secretarias de trânsito. A comunicação entre os controladores (equipados com módulos 4G e GPS) opera sob rígidos protocolos:
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5">
                        <strong class="text-white block mb-1">Controle de Acesso RBAC:</strong>
                        <p class="text-xs text-slate-400">Restrição estrita de privilégios. Apenas engenheiros e operadores credenciados alteram matrizes de tempo.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5">
                        <strong class="text-white block mb-1">Trilha de Auditoria (Audit Trail):</strong>
                        <p class="text-xs text-slate-400">Registro digital inviolável com carimbo de data, hora e identificação de cada operador.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5">
                        <strong class="text-white block mb-1">Proteção Ativa WAF/DDoS:</strong>
                        <p class="text-xs text-slate-400">Firewalls de aplicação em nuvem e mitigação ativa contra negação de serviço.</p>
                    </div>
                </div>
            </div>

            <!-- Pilar 4: Ecossistema Mobile para Equipes de Campo -->
            <div id="mobile" class="glass-card p-8 sm:p-10 rounded-3xl border-l-4 border-l-foco-green-500">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <span class="text-xs font-mono font-bold text-foco-green-400 uppercase tracking-wider">Seção 2.4</span>
                        <h3 class="text-2xl font-bold text-white mt-1">Ecossistema Mobile para Equipes de Campo</h3>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-mono bg-foco-green-500/10 text-foco-green-400 border border-foco-green-500/30 self-start">
                        App Nativo Agentes & DTT
                    </span>
                </div>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-4">
                    Disponibilização de aplicativo móvel nativo e integrado para os agentes de trânsito em campo. A ferramenta permite que as equipes realizem intervenções imediatas e autorizadas no cruzamento (como acionamento manual de planos de emergência, desvios ou modo intermitente amarelo) diretamente pelo smartphone.
                </p>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Além disso, a telemetria do controlador gera <strong>ordens de serviço automatizadas com a geolocalização exata da ocorrência</strong>, agilizando as rotas da equipe técnica de manutenção em caso de avarias físicas ou elétricas.
                </p>
            </div>

            <!-- Pilar 5: Autonomia Energética Híbrida (Nobreak & LiFePO4) -->
            <div id="nobreak" class="glass-card p-8 sm:p-10 rounded-3xl border-l-4 border-l-emerald-400">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
                    <div>
                        <span class="text-xs font-mono font-bold text-emerald-400 uppercase tracking-wider">Seção 2.5</span>
                        <h3 class="text-2xl font-bold text-white mt-1">Autonomia Energética Auto Sustentável Híbrida</h3>
                    </div>
                    <span class="px-3 py-1 rounded-full text-xs font-mono bg-emerald-400/10 text-emerald-400 border border-emerald-400/30 self-start">
                        Baterias LiFePO4 • Solar MPPT • Eólica Urbana
                    </span>
                </div>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-4">
                    Desenvolvimento de um sistema de energia resiliente outdoor acoplado ao controlador semafórico:
                </p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-2">
                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5">
                        <strong class="text-white block mb-1">Nobreak (UPS) Senoidal Puro:</strong>
                        <p class="text-xs text-slate-400">Inversores de alta eficiência e bypass estático/manual automático, permitindo manutenção técnica sem desativar a sinalização da via.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5">
                        <strong class="text-white block mb-1">Baterias LiFePO4:</strong>
                        <p class="text-xs text-slate-400">Bancos de Lítio Ferro Fosfato com estabilidade térmica extrema, milhares de ciclos e suporte a descargas profundas.</p>
                    </div>
                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5">
                        <strong class="text-white block mb-1">Captação Solar & Eólica:</strong>
                        <p class="text-xs text-slate-400">Painéis fotovoltaicos com controladores digitais MPPT e microgeradores eólicos urbanos de partida ultrarrápida.</p>
                    </div>
                </div>
            </div>

            <!-- Seção de Consultoria e Rodovias -->
            <div id="consultoria" class="glass-panel-glow p-8 sm:p-10 rounded-3xl border border-foco-yellow-500/30">
                <span class="text-xs font-mono font-bold text-foco-yellow-400 uppercase tracking-wider">Consultoria Especializada</span>
                <h3 class="text-2xl font-bold text-white mt-2 mb-3">Assessoria Semafórica em Rodovias e Obras Temporárias</h3>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed mb-6">
                    A Foco Sinalização possui expertise técnica consagrada em serviços de <strong>Consultoria e Assessoria de projetos semafóricos</strong> em rodovias federais e estaduais (BR 101, BR 116, BR 153, BR 290), atuando com equipamentos móveis tecnológicos em:
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs font-mono text-slate-300">
                    <div class="p-4 rounded-xl bg-foco-navy-950/80 border border-white/10">
                        <span class="text-foco-yellow-400 font-bold block mb-1">🌉 Obras de Pontes & Viadutos</span>
                        Planos semafóricos dinâmicos de fluxo alternado ("pare e siga") automatizados.
                    </div>
                    <div class="p-4 rounded-xl bg-foco-navy-950/80 border border-white/10">
                        <span class="text-rose-400 font-bold block mb-1">⚠️ Queda de Barreiras & Encostas</span>
                        Conjuntos semafóricos móveis alimentados por solar/LiFePO4 sem necessidade de rede.
                    </div>
                    <div class="p-4 rounded-xl bg-foco-navy-950/80 border border-white/10">
                        <span class="text-cyan-400 font-bold block mb-1">⛈️ Eventos Climatológicos</span>
                        Planos de contingência imediata com sincronismo e desvios de tráfego temporários.
                    </div>
                </div>

                <div class="mt-8 flex flex-col sm:flex-row items-center gap-4">
                    <a href="{{ route('site.chamados') }}" class="px-6 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 text-foco-navy-950 hover:bg-foco-yellow-400 transition shadow-glow-yellow">
                        Solicitar Vistoria ou Chamado Técnico
                    </a>
                    <a href="{{ route('site.contato') }}" class="px-6 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider glass-card text-white hover:bg-white/10 transition">
                        Falar com Engenharia de Tráfego
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection

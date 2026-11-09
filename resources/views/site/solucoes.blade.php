@extends('site.layout')

@section('title', 'Serviços Prestados e Soluções em Engenharia | Foco Sinalização')

@section('content')
<div class="py-16 bg-foco-navy-950 relative overflow-hidden">
    <!-- Luzes decorativas com Parallax -->
    <div data-parallax-speed="0.2" class="absolute top-10 right-10 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div data-parallax-speed="0.1" class="absolute bottom-10 left-10 w-96 h-96 bg-foco-yellow-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Cabeçalho -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-mono font-bold tracking-widest text-foco-yellow-400 uppercase bg-foco-yellow-500/10 px-4 py-1.5 rounded-full border border-foco-yellow-500/30">
                Portfólio Operacional & Engenharia
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-white mt-4 tracking-tight">
                SERVIÇOS PRESTADOS PELA FOCO
            </h1>
            <p class="text-slate-400 mt-4 text-base leading-relaxed">
                Engenharia de tráfego integrada, fontes de energia alternativa limpa, instalações elétricas em baixa tensão, segurança patrimonial eletrônica e suporte em altura com cesto aéreo.
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

        <!-- SIMULADOR INTERATIVO: ONDA VERDE ADAPTATIVA (TECNOLOGIA FOCO) -->
        <div class="glass-panel-glow p-8 sm:p-10 rounded-3xl mb-16 border border-foco-yellow-500/30 shadow-2xl" x-data="{
            modo: 'foco', // 'foco' ou 'convencional'
            velocidade: 50,
            simulando: true,
            progresso: 15,
            interval: null,
            init() {
                this.interval = setInterval(() => {
                    this.progresso = (this.progresso + (this.modo === 'foco' ? 1.4 : 0.7)) % 100;
                }, 100);
            }
        }">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 pb-6 border-b border-white/10">
                <div>
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-foco-green-500/10 text-foco-green-400 border border-foco-green-500/30 text-xs font-mono font-bold mb-2">
                        <span class="w-2 h-2 rounded-full bg-foco-green-400 animate-ping"></span>
                        Laboratório Virtual de Engenharia de Tráfego
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-white">Simulador Comparativo de Onda Verde</h2>
                    <p class="text-xs sm:text-sm text-slate-300 mt-1">Veja em tempo real a diferença de retenção e fluidez viária entre sistemas convencionais e a engenharia adaptativa Foco.</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <button type="button" @click="modo = 'foco'" :class="modo === 'foco' ? 'bg-foco-green-500 text-foco-navy-950 font-black shadow-glow-green' : 'bg-white/5 text-slate-300 hover:text-white'" class="px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider transition-all flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-foco-navy-950"></span>
                        <span>Onda Verde FOCO</span>
                    </button>

                    <button type="button" @click="modo = 'convencional'" :class="modo === 'convencional' ? 'bg-rose-500 text-white font-black shadow-glow-red' : 'bg-white/5 text-slate-300 hover:text-white'" class="px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider transition-all flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-white"></span>
                        <span>Planos Fixos Antigos</span>
                    </button>
                </div>
            </div>

            <!-- Pista de Simulação Interativa -->
            <div class="my-8 p-6 rounded-2xl bg-foco-navy-950 border border-white/10 relative overflow-hidden">
                <!-- Vias e Faixas de Trânsito -->
                <div class="space-y-4">
                    <div class="grid grid-cols-4 gap-2 text-center text-[10px] sm:text-xs font-mono text-slate-400 px-1 sm:px-2 pb-1">
                        <div>
                            <span class="block font-bold text-slate-300">Cruz. 1</span>
                            <span class="block text-[9px] sm:text-[11px] text-slate-400">Av. Brasil</span>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-300">Cruz. 2</span>
                            <span class="block text-[9px] sm:text-[11px] text-slate-400">Rua 1500</span>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-300">Cruz. 3</span>
                            <span class="block text-[9px] sm:text-[11px] text-slate-400">Av. Central</span>
                        </div>
                        <div>
                            <span class="block font-bold text-slate-300">Cruz. 4</span>
                            <span class="block text-[9px] sm:text-[11px] text-slate-400">Rua 2000</span>
                        </div>
                    </div>

                    <!-- Linha com os 4 nós semafóricos -->
                    <div class="relative py-8 border-y-2 border-dashed border-white/20 bg-slate-900/60 rounded-xl">
                        
                        <!-- Carrinho em deslocamento na via -->
                        <div class="absolute top-1/2 -translate-y-1/2 transition-all duration-100 flex items-center gap-1 z-20" :style="'left: ' + progresso + '%'">
                            <div class="px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-md text-[9px] sm:text-[10px] font-mono font-bold shadow-lg" :class="modo === 'foco' ? 'bg-foco-yellow-500 text-foco-navy-950' : 'bg-slate-300 text-slate-900'">
                                🚗 Fluxo
                            </div>
                            <span class="w-2 h-2 rounded-full" :class="modo === 'foco' ? 'bg-foco-green-400 animate-ping' : 'bg-rose-400 animate-ping'"></span>
                        </div>

                        <!-- 4 Postes Semafóricos Posicionados na Via -->
                        <div class="grid grid-cols-4 gap-2 sm:gap-4 relative z-10 px-2 sm:px-8">
                            <!-- Semáforo 1 -->
                            <div class="flex flex-col items-center">
                                <div class="w-8 p-1.5 rounded-xl bg-slate-950 border border-white/20 space-y-1.5 shadow-xl">
                                    <div class="w-5 h-5 rounded-full" :class="modo === 'foco' ? 'bg-rose-950' : 'traffic-lens-red'"></div>
                                    <div class="w-5 h-5 rounded-full bg-amber-950"></div>
                                    <div class="w-5 h-5 rounded-full" :class="modo === 'foco' ? 'traffic-lens-green' : 'bg-emerald-950'"></div>
                                </div>
                                <span class="text-[10px] font-mono mt-2" :class="modo === 'foco' ? 'text-foco-green-400 font-bold' : 'text-rose-400 font-bold'">
                                    <span x-text="modo === 'foco' ? 'VERDE (Onda)' : 'VERMELHO'"></span>
                                </span>
                            </div>

                            <!-- Semáforo 2 -->
                            <div class="flex flex-col items-center">
                                <div class="w-8 p-1.5 rounded-xl bg-slate-950 border border-white/20 space-y-1.5 shadow-xl">
                                    <div class="w-5 h-5 rounded-full" :class="modo === 'foco' ? 'bg-rose-950' : 'bg-rose-950'"></div>
                                    <div class="w-5 h-5 rounded-full" :class="modo === 'foco' ? 'bg-amber-950' : 'traffic-lens-yellow'"></div>
                                    <div class="w-5 h-5 rounded-full" :class="modo === 'foco' ? 'traffic-lens-green' : 'bg-emerald-950'"></div>
                                </div>
                                <span class="text-[10px] font-mono mt-2" :class="modo === 'foco' ? 'text-foco-green-400 font-bold' : 'text-amber-400 font-bold'">
                                    <span x-text="modo === 'foco' ? 'VERDE (Onda)' : 'AMARELO'"></span>
                                </span>
                            </div>

                            <!-- Semáforo 3 -->
                            <div class="flex flex-col items-center">
                                <div class="w-8 p-1.5 rounded-xl bg-slate-950 border border-white/20 space-y-1.5 shadow-xl">
                                    <div class="w-5 h-5 rounded-full" :class="modo === 'foco' ? 'bg-rose-950' : 'traffic-lens-red'"></div>
                                    <div class="w-5 h-5 rounded-full bg-amber-950"></div>
                                    <div class="w-5 h-5 rounded-full" :class="modo === 'foco' ? 'traffic-lens-green' : 'bg-emerald-950'"></div>
                                </div>
                                <span class="text-[10px] font-mono mt-2" :class="modo === 'foco' ? 'text-foco-green-400 font-bold' : 'text-rose-400 font-bold'">
                                    <span x-text="modo === 'foco' ? 'VERDE (Onda)' : 'VERMELHO'"></span>
                                </span>
                            </div>

                            <!-- Semáforo 4 -->
                            <div class="flex flex-col items-center">
                                <div class="w-8 p-1.5 rounded-xl bg-slate-950 border border-white/20 space-y-1.5 shadow-xl">
                                    <div class="w-5 h-5 rounded-full" :class="modo === 'foco' ? 'bg-rose-950' : 'bg-rose-950'"></div>
                                    <div class="w-5 h-5 rounded-full bg-amber-950"></div>
                                    <div class="w-5 h-5 rounded-full" :class="modo === 'foco' ? 'traffic-lens-green' : 'traffic-lens-green'"></div>
                                </div>
                                <span class="text-[10px] font-mono mt-2 text-foco-green-400 font-bold">
                                    VERDE
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Indicadores em Tempo Real da Simulação (100% Responsivo) -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 font-mono text-xs">
                <div class="p-3 sm:p-4 rounded-xl bg-foco-navy-900 border border-white/5">
                    <span class="text-slate-400 block text-[10px] sm:text-[11px]">Paradas no Corredor:</span>
                    <strong class="text-xs sm:text-base block mt-0.5" :class="modo === 'foco' ? 'text-foco-green-400' : 'text-rose-400'" x-text="modo === 'foco' ? '0 Paradas (Fluxo)' : '3 Retenções'"></strong>
                </div>

                <div class="p-3 sm:p-4 rounded-xl bg-foco-navy-900 border border-white/5">
                    <span class="text-slate-400 block text-[10px] sm:text-[11px]">Velocidade Comercial:</span>
                    <strong class="text-xs sm:text-base block mt-0.5" :class="modo === 'foco' ? 'text-cyan-400' : 'text-amber-400'" x-text="modo === 'foco' ? '52 km/h (Média)' : '18 km/h'"></strong>
                </div>

                <div class="p-3 sm:p-4 rounded-xl bg-foco-navy-900 border border-white/5">
                    <span class="text-slate-400 block text-[10px] sm:text-[11px]">Economia Combustível:</span>
                    <strong class="text-xs sm:text-base block mt-0.5" :class="modo === 'foco' ? 'text-emerald-400' : 'text-slate-400'" x-text="modo === 'foco' ? '+28% Eficiência' : 'Desperdício Alto'"></strong>
                </div>

                <div class="p-3 sm:p-4 rounded-xl bg-foco-navy-900 border border-white/5">
                    <span class="text-slate-400 block text-[10px] sm:text-[11px]">Emissão Poluentes:</span>
                    <strong class="text-xs sm:text-base block mt-0.5" :class="modo === 'foco' ? 'text-foco-yellow-400' : 'text-rose-400'" x-text="modo === 'foco' ? '-35% CO₂' : 'Pico de Emissões'"></strong>
                </div>
            </div>
        </div>

        <!-- DETALHAMENTO: SERVIÇOS PRESTADOS PELA FOCO -->
        <div class="space-y-12">
            
            <!-- SERVIÇO 1: Projetos de Sinalização semafórica, vertical e horizontal -->
            <div id="sinalizacao" class="glass-card p-8 sm:p-10 rounded-3xl border-l-4 border-l-foco-yellow-500 space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-white/10">
                    <div>
                        <span class="text-xs font-mono font-bold text-foco-yellow-400 uppercase tracking-wider">Serviço 01 • Engenharia de Tráfego</span>
                        <h3 class="text-2xl sm:text-3xl font-black text-white mt-1">Projetos de Sinalização semafórica, vertical e horizontal</h3>
                    </div>
                    <div class="flex flex-wrap gap-1.5 self-start md:self-auto">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-foco-yellow-500/20 text-foco-yellow-300 border border-foco-yellow-500/30">Planejamento</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-foco-yellow-500/20 text-foco-yellow-300 border border-foco-yellow-500/30">Elaboração</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-foco-yellow-500/20 text-foco-yellow-300 border border-foco-yellow-500/30">Assessoria</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-foco-yellow-500/20 text-foco-yellow-300 border border-foco-yellow-500/30">Execução</span>
                    </div>
                </div>

                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    A Foco Sinalização atua em todas as etapas — do diagnóstico preliminar de engenharia à implantação física e comissionamento de sistemas integrados de tráfego:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="p-5 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-2">
                        <strong class="text-foco-yellow-400 block text-sm font-bold">🚦 Sinalização Semafórica Inteligente:</strong>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Controladores adaptativos, laços virtuais de visão computacional, sincronismo de onda verde, central WEB DIGICON em nuvem e telemetria 4G/GPS com monitoramento em tempo real.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-2">
                        <strong class="text-foco-yellow-400 block text-sm font-bold">🛣️ Sinalização Horizontal Viária:</strong>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Pinturas com tintas acrílicas e termoplásticas retrorrefletivas de alta durabilidade, demarcação de faixas de pedestres, ciclovias, linhas de canalização, setas e aplicação de tachas e tachões viários bidirecionais.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-2">
                        <strong class="text-foco-yellow-400 block text-sm font-bold">🛑 Sinalização Vertical Regulamentar:</strong>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Fabricação, fornecimento e instalação de placas regulamentares, de advertência e indicativas com películas refletivas prismáticas, postes, semi-pórticos e pórticos em aço galvanizado a fogo conformes Contran/DNIT.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+gostaria+de+solicitar+uma+proposta+sobre+Projetos+de+Sinaliza%C3%A7%C3%A3o+Semaf%C3%B3rica%2C+Vertical+e+Horizontal" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-foco-yellow-500 text-foco-navy-950 hover:bg-foco-yellow-400 transition shadow-glow-yellow">
                        Solicitar Proposta de Sinalização
                    </a>
                </div>
            </div>

            <!-- SERVIÇO 2: Projetos de energia alternativa auto sustentável (solar eólica) -->
            <div id="energia" class="glass-card p-8 sm:p-10 rounded-3xl border-l-4 border-l-emerald-400 space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-white/10">
                    <div>
                        <span class="text-xs font-mono font-bold text-emerald-400 uppercase tracking-wider">Serviço 02 • Matriz Limpa & Autonomia</span>
                        <h3 class="text-2xl sm:text-3xl font-black text-white mt-1">Projetos de energia alternativa auto sustentável (solar eólica)</h3>
                    </div>
                    <div class="flex flex-wrap gap-1.5 self-start md:self-auto">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Planejamento</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Elaboração</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Assessoria</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-emerald-500/20 text-emerald-300 border border-emerald-500/30">Execução</span>
                    </div>
                </div>

                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Desenvolvimento e implantação de ecossistemas energéticos autônomos e limpos para erradicar a vulnerabilidade viária e comercial diante de apagões ou picos da rede elétrica:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="p-5 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-2">
                        <strong class="text-emerald-400 block text-sm font-bold">☀️ Geração Solar Fotovoltaica MPPT:</strong>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Módulos solares de alto rendimento combinados com controladores de carga digitais com rastreamento MPPT, otimizando o aproveitamento da irradiação mesmo sob céu encoberto.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-2">
                        <strong class="text-emerald-400 block text-sm font-bold">💨 Microgeração Eólica Urbana:</strong>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Turbinas eólicas compactas de partida ultrarrápida sob brisas leves para complementação energética híbrida contínua 24h, ideal para litorais e áreas com corredores de vento.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-2">
                        <strong class="text-emerald-400 block text-sm font-bold">🔋 Nobreaks & Baterias LiFePO4:</strong>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Nobreaks senoidais puros com bypass automático estático e bancos de Lítio Ferro Fosfato (LiFePO4) com milhares de ciclos úteis. Autonomia total ininterrupta.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+gostaria+de+solicitar+uma+proposta+sobre+Projetos+de+Energia+Alternativa+Auto+Sustent%C3%A1vel" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-emerald-500 hover:bg-emerald-400 text-foco-navy-950 transition shadow-glow-green">
                        Solicitar Proposta de Energia Limpa
                    </a>
                </div>
            </div>

            <!-- SERVIÇO 3: Instalações e manutenções elétricas residenciais e comerciais de Baixa Tensão -->
            <div id="eletrica" class="glass-card p-8 sm:p-10 rounded-3xl border-l-4 border-l-cyan-400 space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-white/10">
                    <div>
                        <span class="text-xs font-mono font-bold text-cyan-400 uppercase tracking-wider">Serviço 03 • Elétrica Predial & Comercial</span>
                        <h3 class="text-2xl sm:text-3xl font-black text-white mt-1">Instalações e manutenções elétricas residenciais e comerciais de Baixa Tensão</h3>
                    </div>
                    <div class="flex flex-wrap gap-1.5 self-start md:self-auto">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">Planejamento</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">Elaboração</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">Assessoria</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-cyan-500/20 text-cyan-300 border border-cyan-500/30">Execução</span>
                    </div>
                </div>

                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Execução de infraestrutura elétrica predial e comercial com rigor técnico absoluto em consonância com as normas <strong>NR-10</strong> e <strong>NBR 5410</strong>:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="p-5 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-2">
                        <strong class="text-cyan-400 block text-sm font-bold">⚡ Quadros de Distribuição (QDC):</strong>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Montagem, balanceamento de fases, adequação e reforma de quadros elétricos de comando e distribuição, com disjuntores, dispositivos DR e proteção contra sobretensões (DPS).
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-2">
                        <strong class="text-cyan-400 block text-sm font-bold">🔌 Cabeamento & Infraestrutura Subterrânea:</strong>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Lançamento de circuitos em eletrodutos de PEAD e perfilados metálicos, caixas de passagem e aterramento elétrico com medição de resistividade de baixa impedância.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-2">
                        <strong class="text-cyan-400 block text-sm font-bold">🛠️ Manutenção Preventiva e Corretiva:</strong>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Inspeções termográficas para detecção precoce de pontos quentes, laudos técnicos de conformidade, correção de curto-circuitos e modernização de luminárias LED.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+gostaria+de+solicitar+uma+proposta+sobre+Instala%C3%A7%C3%B5es+El%C3%A9tricas+de+Baixa+Tens%C3%A3o" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-cyan-500 hover:bg-cyan-400 text-foco-navy-950 transition">
                        Solicitar Proposta Elétrica
                    </a>
                </div>
            </div>

            <!-- SERVIÇO 4: Instalações e manutenções de câmeras de monitoramento e sistemas de alarme -->
            <div id="seguranca" class="glass-card p-8 sm:p-10 rounded-3xl border-l-4 border-l-blue-500 space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-white/10">
                    <div>
                        <span class="text-xs font-mono font-bold text-blue-400 uppercase tracking-wider">Serviço 04 • Segurança Patrimonial & Eletrônica</span>
                        <h3 class="text-2xl sm:text-3xl font-black text-white mt-1">Instalações e manutenções de câmeras de monitoramento e sistemas de alarme</h3>
                    </div>
                    <div class="flex flex-wrap gap-1.5 self-start md:self-auto">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">Planejamento</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">Elaboração</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">Assessoria</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30">Execução</span>
                    </div>
                </div>

                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Segurança de alta confiabilidade para órgãos públicos, empresas e residências com tecnologias de monitoramento visual inteligente e controle perimetral ativo:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div class="p-5 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-2">
                        <strong class="text-blue-400 block text-sm font-bold">📹 CFTV IP e Analógico de Alta Resolução:</strong>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Câmeras Full HD e 4K com visão noturna infravermelha, tecnologia ColorVu com iluminação noturna colorida, lentes varifocais e gravadores NVR/DVR seguros.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-2">
                        <strong class="text-blue-400 block text-sm font-bold">🧠 Inteligência Artificial & Laços Virtuais:</strong>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Detecção de movimento inteligente, cerca virtual perimetral, contagem e classificação de pessoas e veículos, com notificações instantâneas no smartphone.
                        </p>
                    </div>

                    <div class="p-5 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-2">
                        <strong class="text-blue-400 block text-sm font-bold">🚨 Centrais de Alarme & Sensores Ativos:</strong>
                        <p class="text-xs text-slate-300 leading-relaxed">
                            Centrais de alarme conectadas via Wi-Fi/4G, sensores infravermelhos perimetrais com imunidade a pequenos animais e barreiras infravermelhas de longo alcance.
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+gostaria+de+solicitar+uma+proposta+sobre+C%C3%A2meras+de+Monitoramento+e+Alarmes" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-blue-500 hover:bg-blue-400 text-white transition">
                        Solicitar Proposta de Monitoramento
                    </a>
                </div>
            </div>

            <!-- SERVIÇO 5: Aluguel de caminhão com cesto aéreo (com operador) -->
            <div id="cesto-aereo" class="glass-card p-8 sm:p-10 rounded-3xl border-l-4 border-l-amber-500 space-y-6">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 pb-4 border-b border-white/10">
                    <div>
                        <span class="text-xs font-mono font-bold text-amber-400 uppercase tracking-wider">Serviço 05 • Operações Críticas em Altura</span>
                        <h3 class="text-2xl sm:text-3xl font-black text-white mt-1">Aluguel de caminhão com cesto aéreo (com operador)</h3>
                    </div>
                    <div class="flex flex-wrap gap-1.5 self-start md:self-auto">
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">Instalações de câmeras</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">Cabeamento</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">Podas</span>
                        <span class="px-2.5 py-1 rounded-lg text-xs font-mono font-bold bg-amber-500/20 text-amber-300 border border-amber-500/30">Fachadas até 10 metros</span>
                    </div>
                </div>

                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Solução profissional e homologada para trabalhos aéreos de até <strong>10 metros de altura</strong>, com caminhão especializado e operador técnico credenciado:
                </p>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-1.5">
                        <span class="text-amber-400 font-mono text-xs font-bold block">📹 Instalação de Câmeras</span>
                        <p class="text-xs text-slate-300 leading-relaxed">Montagem e ajuste de câmeras de segurança, domos e sensores em postes e pontos elevados com máxima precisão.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-1.5">
                        <span class="text-amber-400 font-mono text-xs font-bold block">🌐 Passagem de Cabeamento</span>
                        <p class="text-xs text-slate-300 leading-relaxed">Lançamento, amarração e ancoragem aérea de cabeamentos elétricos, de telecomunicação e fibra óptica.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-1.5">
                        <span class="text-amber-400 font-mono text-xs font-bold block">🌳 Podas Desobstrutivas</span>
                        <p class="text-xs text-slate-300 leading-relaxed">Corte seguro de galhos e copas que ameaçam fiações ou bloqueiam a visibilidade da sinalização semafórica.</p>
                    </div>

                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-1.5">
                        <span class="text-amber-400 font-mono text-xs font-bold block">🏢 Fachadas até 10 Metros</span>
                        <p class="text-xs text-slate-300 leading-relaxed">Instalação e reparo de letreiros comerciais, luminosos, pintura e manutenção de fachadas prediais com total segurança.</p>
                    </div>
                </div>

                <div class="p-4 rounded-2xl bg-foco-navy-950 border border-amber-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div class="text-xs text-slate-300">
                            <strong class="text-white block">Equipe 100% Capacitada e Certificada:</strong>
                            Operador habilitado com certificações ativas de segurança nas normas <strong>NR-35</strong> (Trabalho em Altura) e <strong>NR-10</strong> (Segurança em Instalações Elétricas).
                        </div>
                    </div>
                    <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+gostaria+de+or%C3%A7ar+o+Aluguel+de+Caminh%C3%A3o+com+Cesto+A%C3%A9reo" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 rounded-xl text-xs font-bold uppercase tracking-wider bg-amber-500 hover:bg-amber-400 text-foco-navy-950 transition shadow-glow-yellow shrink-0 text-center">
                        Contratar Cesto Aéreo
                    </a>
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


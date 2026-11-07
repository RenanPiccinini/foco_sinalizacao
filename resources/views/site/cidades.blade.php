@extends('site.layout')

@section('title', 'Cidades Atendidas e Rodovias | Foco Sinalização')

@section('content')
<div class="py-16 bg-foco-navy-950 relative overflow-hidden" x-data="{ filtro: 'todos' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Cabeçalho -->
        <div class="text-center max-w-3xl mx-auto mb-12">
            <span class="text-xs font-mono font-bold tracking-widest text-foco-green-400 uppercase bg-foco-green-500/10 px-3 py-1 rounded-full border border-foco-green-500/30">
                Atuação Regional & Federal
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-white mt-4 tracking-tight">
                Municípios e Rodovias Atendidas
            </h1>
            <p class="text-slate-400 mt-4 text-base leading-relaxed">
                A Foco Sinalização executa serviços e fornece equipamentos de engenharia diretamente para as Prefeituras Municipais ou indiretamente através de contratações e concessionárias viárias.
            </p>
            <div class="w-24 h-1 bg-foco-green-500 mx-auto mt-6 rounded-full"></div>
        </div>

        <!-- Filtros Rápidos -->
        <div class="flex justify-center mb-10">
            <div class="glass-panel p-1.5 rounded-2xl border border-white/10 flex flex-wrap gap-2 justify-center">
                <button type="button" @click="filtro = 'todos'" :class="filtro === 'todos' ? 'bg-foco-yellow-500 text-foco-navy-950 font-bold' : 'text-slate-300 hover:text-white'" class="px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider transition">
                    Todos (+25)
                </button>
                <button type="button" @click="filtro = 'sc'" :class="filtro === 'sc' ? 'bg-cyan-500 text-foco-navy-950 font-bold' : 'text-slate-300 hover:text-white'" class="px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider transition">
                    Santa Catarina (SC)
                </button>
                <button type="button" @click="filtro = 'rs'" :class="filtro === 'rs' ? 'bg-foco-green-500 text-foco-navy-950 font-bold' : 'text-slate-300 hover:text-white'" class="px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider transition">
                    Rio Grande do Sul (RS)
                </button>
                <button type="button" @click="filtro = 'rodovias'" :class="filtro === 'rodovias' ? 'bg-amber-400 text-foco-navy-950 font-bold' : 'text-slate-300 hover:text-white'" class="px-5 py-2.5 rounded-xl text-xs uppercase tracking-wider transition">
                    Rodovias Federais
                </button>
            </div>
        </div>

        <!-- Grid de Cidades e Trechos -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
            
            <!-- Santa Catarina -->
            <div x-show="filtro === 'todos' || filtro === 'sc'" x-transition class="glass-card p-6 rounded-3xl border-t-2 border-t-cyan-400">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-mono font-bold text-cyan-400">SANTA CATARINA</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-cyan-500/20 text-cyan-300">SC</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Balneário Camboriú</h3>
                <p class="text-xs text-slate-300">Implantação de controladores adaptativos, onda verde na orla e avenidas centrais, centrais integradas com a DTT.</p>
            </div>

            <div x-show="filtro === 'todos' || filtro === 'sc'" x-transition class="glass-card p-6 rounded-3xl border-t-2 border-t-cyan-400">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-mono font-bold text-cyan-400">SANTA CATARINA</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-cyan-500/20 text-cyan-300">SC</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Balneário Piçarras</h3>
                <p class="text-xs text-slate-300">Sinalização semafórica LED, manutenção preventiva e modernização de cruzamentos litorâneos com proteção à maresia.</p>
            </div>

            <!-- Rodovias Federais -->
            <div x-show="filtro === 'todos' || filtro === 'rodovias'" x-transition class="glass-card p-6 rounded-3xl border-t-2 border-t-amber-400">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-mono font-bold text-amber-400">RODOVIA FEDERAL</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-amber-500/20 text-amber-300">BR 101</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Rodovia BR 101</h3>
                <p class="text-xs text-slate-300">Sistemas semafóricos móveis de contingência, controle de tráfego em obras de contenção de encostas e interseções de alto tráfego.</p>
            </div>

            <div x-show="filtro === 'todos' || filtro === 'rodovias'" x-transition class="glass-card p-6 rounded-3xl border-t-2 border-t-amber-400">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-mono font-bold text-amber-400">RODOVIA FEDERAL</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-amber-500/20 text-amber-300">BR 116</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Rodovia BR 116</h3>
                <p class="text-xs text-slate-300">Interligação semafórica em cruzamentos urbanos e marginais, sincronismo para redução de retenção de caminhões.</p>
            </div>

            <div x-show="filtro === 'todos' || filtro === 'rodovias'" x-transition class="glass-card p-6 rounded-3xl border-t-2 border-t-amber-400">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-mono font-bold text-amber-400">RODOVIA FEDERAL</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-amber-500/20 text-amber-300">BR 153</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Rodovia BR 153</h3>
                <p class="text-xs text-slate-300">Projetos especiais de travessias de pedestres seguras com botoneiras inteligentes e nobreaks de alta capacidade.</p>
            </div>

            <div x-show="filtro === 'todos' || filtro === 'rodovias'" x-transition class="glass-card p-6 rounded-3xl border-t-2 border-t-amber-400">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-mono font-bold text-amber-400">RODOVIA FEDERAL</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-amber-500/20 text-amber-300">BR 290</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Rodovia BR 290</h3>
                <p class="text-xs text-slate-300">Soluções semafóricas adaptativas de corredor logístico, suporte em eventos climatológicos e obras de restauração.</p>
            </div>

            <!-- Rio Grande do Sul -->
            @php
            $cidadesRSList = [
                ['nome' => 'Novo Hamburgo', 'desc' => 'Corredores centrais, programação de onda verde em horários de pico e cabeamento subterrâneo em PEAD.'],
                ['nome' => 'Canoas', 'desc' => 'Nobreaks com baterias de lítio LiFePO4, garantindo continuidade semafórica em situações de apagão elétrico.'],
                ['nome' => 'Passo Fundo', 'desc' => 'Infraestrutura com colunas de aço galvanizado, braços projetados e semáforos a LED de alta intensidade.'],
                ['nome' => 'Torres', 'desc' => 'Autonomia energética com nobreaks e monitoramento inteligente na orla marítima gaúcha.'],
                ['nome' => 'Tramandaí', 'desc' => 'Gestão de fluxo sazonal de veraneio com reprogramação dinâmica de planos de tempos via nuvem.'],
                ['nome' => 'Campo Bom', 'desc' => 'Cruzamentos semafóricos adaptativos integrados e laços virtuais de detecção de veículos.'],
                ['nome' => 'Entre-Ijuís', 'desc' => 'Sinalização viária segura e assessoria técnica em pontos de confluência rodoviária.'],
                ['nome' => 'Erechim', 'desc' => 'Modernização do parque semafórico com tecnologia Digicon e telemetria 4G/GPS.'],
                ['nome' => 'Guaíba', 'desc' => 'Sistemas de sincronismo veicular para otimização do fluxo de acesso à região metropolitana.'],
                ['nome' => 'Guaporé', 'desc' => 'Sinalização semafórica eficiente com grupos focais de baixíssimo consumo.'],
                ['nome' => 'Ivoti', 'desc' => 'Projetos semafóricos integrados à malha urbana com ênfase na segurança dos pedestres.'],
                ['nome' => 'Lajeado', 'desc' => 'Sistemas semafóricos resilientes adaptados a áreas de risco e cruzamentos de grande fluxo.'],
                ['nome' => 'Nova Hartz', 'desc' => 'Implantação completa com infraestrutura civil subterrânea e controladores eletrônicos.'],
                ['nome' => 'Palmeira das Missões', 'desc' => 'Assessoria técnica e instalação de conjuntos semafóricos completos.'],
                ['nome' => 'Portão', 'desc' => 'Interligação de cruzamentos rodoviários urbanos com suporte técnico contínuo.'],
                ['nome' => 'Rosário do Sul', 'desc' => 'Instalação e manutenção corretiva/preventiva de controladores semafóricos.'],
                ['nome' => 'Santo Antônio da Patrulha', 'desc' => 'Infraestrutura de tráfego integrada ao corredor viário litorâneo.'],
                ['nome' => 'Três Coroas', 'desc' => 'Sinalização e engenharia de tráfego com controladores adaptativos.'],
                ['nome' => 'Viamão', 'desc' => 'Sincronismo de avenidas de grande extensão e integração de telemetria semafórica.'],
            ];
            @endphp

            @foreach($cidadesRSList as $cidade)
            <div x-show="filtro === 'todos' || filtro === 'rs'" x-transition class="glass-card p-6 rounded-3xl border-t-2 border-t-foco-green-500">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-mono font-bold text-foco-green-400">RIO GRANDE DO SUL</span>
                    <span class="px-2 py-0.5 rounded-full text-[10px] bg-foco-green-500/20 text-foco-green-300">RS</span>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">{{ $cidade['nome'] }}</h3>
                <p class="text-xs text-slate-300">{{ $cidade['desc'] }}</p>
            </div>
            @endforeach

        </div>

        <!-- Seção de Consultoria e Obras Temporárias -->
        <div class="glass-panel-glow p-8 sm:p-12 rounded-3xl border border-foco-yellow-500/30 text-center max-w-4xl mx-auto">
            <span class="text-xs font-mono font-bold text-foco-yellow-400 uppercase tracking-widest bg-foco-yellow-500/10 px-3 py-1 rounded-full border border-foco-yellow-500/30">
                Consultoria & Assessoria Especializada
            </span>
            <h2 class="text-2xl sm:text-3xl font-bold text-white mt-4 mb-3">
                Expertise em Projetos para Obras e Eventos Climatológicos
            </h2>
            <p class="text-slate-300 text-sm sm:text-base leading-relaxed max-w-2xl mx-auto mb-6">
                A Foco Sinalização possui equipe especializada em estudos de viabilidade, planos semafóricos temporários para pontes em obras, contingência após queda de barreiras e liberação segura de fluxo veicular.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('site.chamados') }}" class="px-6 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 text-foco-navy-950 hover:bg-foco-yellow-400 transition shadow-glow-yellow">
                    Abrir Chamado Operacional
                </a>
                <a href="{{ route('site.contato') }}" class="px-6 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider glass-card text-white hover:bg-white/10 transition">
                    Solicitar Consultoria Técnica
                </a>
            </div>
        </div>

    </div>
</div>
@endsection

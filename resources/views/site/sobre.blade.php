@extends('site.layout')

@section('title', 'Nossa História e Quem Somos | Foco Sinalização e Sistemas Inteligentes')

@section('content')
<div class="py-16 bg-foco-navy-950 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Cabeçalho -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-mono font-bold tracking-widest text-foco-yellow-400 uppercase bg-foco-yellow-500/10 px-3 py-1 rounded-full border border-foco-yellow-500/30">
                Narrativa Corporativa
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-white mt-4 tracking-tight">
                Construindo a Mobilidade Urbana do Futuro
            </h1>
            <p class="text-slate-400 mt-4 text-base leading-relaxed">
                Da infraestrutura crítica de nobreaks semafóricos às cidades inteligentes integradas via nuvem e inteligência artificial.
            </p>
            <div class="w-24 h-1 bg-foco-yellow-500 mx-auto mt-6 rounded-full"></div>
        </div>

        <!-- Banner com a Identidade Visual da Marca -->
        <div class="mb-16 rounded-3xl overflow-hidden glass-panel-glow p-4 sm:p-6 border border-white/10 shadow-2xl">
            <img src="{{ asset('images/logo-banner.jpg') }}" alt="FOCO Sinalização e Sistemas Inteligentes LTDA" class="w-full h-auto max-h-[380px] object-cover rounded-2xl mx-auto">
        </div>

        <!-- Conteúdo Completo: História & Quem Somos -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 mb-16">
            
            <div class="glass-card p-8 sm:p-10 rounded-3xl space-y-4">
                <span class="text-xs font-mono font-bold text-foco-yellow-400 uppercase tracking-wider">A Jornada</span>
                <h2 class="text-2xl font-extrabold text-white">Nossa História</h2>
                
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Mais do que entregar excelência técnica, esse grande projeto nos permitiu enxergar de perto uma carência latente no mercado por soluções inteligentes e integradas de engenharia de tráfego. Ao mostrarmos a programação semafórica e o estudo de fluxo de veículos, começamos a desenvolver soluções técnicas específicas, aliando os equipamentos instalados em cada cidade, diminuindo custos operacionais, sem perder eficiência e confiabilidade, otimizando a mobilidade urbana.
                </p>
            </div>

            <div class="glass-card p-8 sm:p-10 rounded-3xl space-y-4">
                <span class="text-xs font-mono font-bold text-foco-green-400 uppercase tracking-wider">Propósito & Vocação</span>
                <h2 class="text-2xl font-extrabold text-white">Quem Somos</h2>

                <div class="p-4 rounded-xl bg-foco-navy-950/80 border-l-4 border-foco-green-500 text-white font-medium text-sm sm:text-base">
                    Expertise técnica em Projetos de Tecnologias Emergentes (Deep Tech), aliado a cases consolidados do mercado.
                </div>

                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Os desafios na área de atuação nos impulsionam em busca de soluções precisas, levando em consideração a solicitação técnica de cada cliente, cada projeto é desenvolvido tendo esse princípio.
                </p>

                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Foi nesse cenário que passamos a oferecer soluções completas em sinalização semafórica — da instalação física de postes, cabeamentos, semáforos, câmeras, nobreaks, controlador eletrônico de tráfego à inteligência de software e centralização de sistemas.
                </p>

                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Ao identificarmos uma carência no setor por serviços que aliassem robustez operacional e inteligência de tráfego, fomos impulsionados a expandir nossas fronteiras.
                </p>
            </div>

        </div>

        <!-- Pilares Institucionais: Missão, Visão, Valores -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="glass-panel p-6 rounded-2xl border-t-2 border-t-foco-yellow-500">
                <h3 class="text-lg font-bold text-white mb-2">Nossa Missão</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Prover soluções integradas e inteligentes em sinalização viária e engenharia de tráfego, garantindo fluxo seguro, sincronismo contínuo e autonomia energética ininterrupta para salvar vidas e modernizar as cidades.
                </p>
            </div>

            <div class="glass-panel p-6 rounded-2xl border-t-2 border-t-cyan-400">
                <h3 class="text-lg font-bold text-white mb-2">Nossa Visão</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Ser a referência nacional em implantação <em>turnkey</em> de cidades inteligentes conectadas, liderando a transição energética sustentável e a digitalização com visão computacional em cruzamentos viários.
                </p>
            </div>

            <div class="glass-panel p-6 rounded-2xl border-t-2 border-t-foco-green-500">
                <h3 class="text-lg font-bold text-white mb-2">Nossos Valores</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Rigor técnico de engenharia, resiliência operacional absoluta, transparência cibernética com trilha de auditoria digital, sustentabilidade e compromisso com o cidadão.
                </p>
            </div>
        </div>

    </div>
</div>
@endsection


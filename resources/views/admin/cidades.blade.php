<x-app-layout>
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
            <div>
                <span class="text-xs font-mono text-foco-yellow-400 uppercase tracking-widest font-bold">Cobertura Operacional</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Municípios e Rodovias Monitoradas</h1>
                <p class="text-xs text-slate-400 mt-1">Rede de cidades e concessões com contratos e infraestrutura ativa da Foco Sinalização.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1.5 rounded-xl bg-foco-yellow-500/10 text-foco-yellow-400 border border-foco-yellow-500/30 text-xs font-mono">
                    25 Regiões Atendidas
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Santa Catarina -->
            <div class="glass-panel p-6 rounded-3xl border border-white/10 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-white/10">
                    <h3 class="text-base font-bold text-white">Santa Catarina (SC)</h3>
                    <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-cyan-500/20 text-cyan-300">2 Cidades</span>
                </div>
                <div class="space-y-2 text-xs font-mono">
                    <div class="p-3 rounded-xl bg-foco-navy-900 border border-white/5 flex items-center justify-between">
                        <span class="text-white">Balneário Camboriú</span>
                        <span class="text-foco-green-400 font-bold">Ativo (DTT)</span>
                    </div>
                    <div class="p-3 rounded-xl bg-foco-navy-900 border border-white/5 flex items-center justify-between">
                        <span class="text-white">Balneário Piçarras</span>
                        <span class="text-foco-green-400 font-bold">Ativo</span>
                    </div>
                </div>
            </div>

            <!-- Rodovias -->
            <div class="glass-panel p-6 rounded-3xl border border-white/10 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-white/10">
                    <h3 class="text-base font-bold text-white">Rodovias Federais (BRs)</h3>
                    <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-amber-500/20 text-amber-300">4 Malhas</span>
                </div>
                <div class="space-y-2 text-xs font-mono">
                    <div class="p-3 rounded-xl bg-foco-navy-900 border border-white/5 flex items-center justify-between">
                        <span class="text-white">Rodovia BR 101</span>
                        <span class="text-cyan-400 font-bold">Móvel & Fixo</span>
                    </div>
                    <div class="p-3 rounded-xl bg-foco-navy-900 border border-white/5 flex items-center justify-between">
                        <span class="text-white">Rodovia BR 116</span>
                        <span class="text-cyan-400 font-bold">Marginais</span>
                    </div>
                    <div class="p-3 rounded-xl bg-foco-navy-900 border border-white/5 flex items-center justify-between">
                        <span class="text-white">Rodovia BR 153</span>
                        <span class="text-cyan-400 font-bold">Travessias</span>
                    </div>
                    <div class="p-3 rounded-xl bg-foco-navy-900 border border-white/5 flex items-center justify-between">
                        <span class="text-white">Rodovia BR 290</span>
                        <span class="text-cyan-400 font-bold">Corredor</span>
                    </div>
                </div>
            </div>

            <!-- Rio Grande do Sul -->
            <div class="glass-panel p-6 rounded-3xl border border-white/10 space-y-4">
                <div class="flex items-center justify-between pb-3 border-b border-white/10">
                    <h3 class="text-base font-bold text-white">Rio Grande do Sul (RS)</h3>
                    <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-foco-green-500/20 text-foco-green-300">19 Municípios</span>
                </div>
                <div class="max-h-80 overflow-y-auto space-y-1.5 pr-2 text-xs font-mono">
                    @php
                    $rsList = ['Campo Bom', 'Canoas', 'Entre-Ijuís', 'Erechim', 'Guaíba', 'Guaporé', 'Ivoti', 'Lajeado', 'Nova Hartz', 'Novo Hamburgo', 'Palmeira das Missões', 'Passo Fundo', 'Portão', 'Rosário do Sul', 'Santo Antônio da Patrulha', 'Torres', 'Tramandaí', 'Três Coroas', 'Viamão'];
                    @endphp
                    @foreach($rsList as $city)
                    <div class="p-2 rounded-lg bg-foco-navy-900 border border-white/5 flex items-center justify-between">
                        <span class="text-slate-200">{{ $city }}</span>
                        <span class="text-foco-green-400 text-[10px]">Conectado</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

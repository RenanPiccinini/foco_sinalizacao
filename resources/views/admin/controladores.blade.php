<x-app-layout>
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
            <div>
                <span class="text-xs font-mono text-foco-green-400 uppercase tracking-widest font-bold">Hardware & Telemetria</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Controladores & Semáforos Conectados</h1>
                <p class="text-xs text-slate-400 mt-1">Status em tempo real das controladoras de tráfego, nobreaks LiFePO4 e câmeras de visão computacional.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1.5 rounded-xl bg-foco-green-500/10 text-foco-green-400 border border-foco-green-500/30 text-xs font-mono">
                    348 Ativos Operando
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $controladoresList = [
                ['tag' => 'CTL-BC-01', 'local' => 'Av. Brasil x Av. Alvin Bauer (Balneário Camboriú – SC)', 'ip' => '10.24.11.101', 'plano' => 'Onda Verde Norte', 'bateria' => '98% LiFePO4', 'temp' => '28°C', 'status' => 'Online', 'cam' => 'HD Virtual Loop Ativo'],
                ['tag' => 'CTL-BC-02', 'local' => 'Av. Atlântica x Rua 1500 (Balneário Camboriú – SC)', 'ip' => '10.24.11.102', 'plano' => 'Adaptativo Orla', 'bateria' => '100% LiFePO4', 'temp' => '27°C', 'status' => 'Online', 'cam' => 'HD Virtual Loop Ativo'],
                ['tag' => 'CTL-NH-14', 'local' => 'Av. Pedro Adams Filho x Bento Gonçalves (Novo Hamburgo – RS)', 'ip' => '10.51.02.14', 'plano' => 'Plano Pico Tarde', 'bateria' => '95% Solar/LiFePO4', 'temp' => '29°C', 'status' => 'Online', 'cam' => 'Contagem Volumétrica'],
                ['tag' => 'CTL-CAN-08', 'local' => 'Av. Getúlio Vargas x Domingos Martins (Canoas – RS)', 'ip' => '10.51.03.08', 'plano' => 'Bypass UPS Ativo', 'bateria' => '94% LiFePO4', 'temp' => '31°C', 'status' => 'Alerta UPS', 'cam' => 'Câmera Operando'],
                ['tag' => 'CTL-PF-03', 'local' => 'Av. Brasil Leste x Rua Moron (Passo Fundo – RS)', 'ip' => '10.54.01.03', 'plano' => 'Adaptativo Centro', 'bateria' => '100% LiFePO4', 'temp' => '24°C', 'status' => 'Online', 'cam' => 'Visão Computacional'],
                ['tag' => 'CTL-BR101-19', 'local' => 'Km 142 Morro do Boi (Rodovia BR 101 – SC)', 'ip' => '10.48.09.19', 'plano' => 'Móvel Pare & Siga', 'bateria' => '96% Híbrido Solar', 'temp' => '26°C', 'status' => 'Online', 'cam' => 'Detecção Óptica'],
            ];
            @endphp

            @foreach($controladoresList as $item)
            <div class="glass-panel p-6 rounded-3xl border border-white/10 space-y-4 hover:border-foco-yellow-500/40 transition">
                <div class="flex items-center justify-between pb-3 border-b border-white/10">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full {{ $item['status'] === 'Online' ? 'bg-foco-green-400' : 'bg-amber-400' }}"></span>
                        <strong class="font-mono text-foco-yellow-400 text-sm">{{ $item['tag'] }}</strong>
                    </div>
                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold {{ $item['status'] === 'Online' ? 'bg-foco-green-500/10 text-foco-green-400 border border-foco-green-500/30' : 'bg-amber-500/10 text-amber-400 border border-amber-500/30' }}">
                        {{ $item['status'] }}
                    </span>
                </div>

                <div class="space-y-1">
                    <p class="text-white font-medium text-xs">{{ $item['local'] }}</p>
                    <p class="text-slate-400 font-mono text-[11px]">IP: {{ $item['ip'] }} • Módulo 4G/GPS Homologado</p>
                </div>

                <div class="grid grid-cols-2 gap-2 text-[11px] font-mono pt-2 border-t border-white/5">
                    <div class="p-2 rounded bg-foco-navy-900 border border-white/5">
                        <span class="text-slate-500 block text-[9px] uppercase">Bateria / Nobreak</span>
                        <span class="text-emerald-400 font-bold">{{ $item['bateria'] }}</span>
                    </div>
                    <div class="p-2 rounded bg-foco-navy-900 border border-white/5">
                        <span class="text-slate-500 block text-[9px] uppercase">Modo Atual</span>
                        <span class="text-cyan-400 font-bold truncate block">{{ $item['plano'] }}</span>
                    </div>
                </div>

                <div class="flex items-center justify-between text-[11px] text-slate-400 pt-1">
                    <span>{{ $item['cam'] }}</span>
                    <span class="text-slate-500">{{ $item['temp'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</x-app-layout>


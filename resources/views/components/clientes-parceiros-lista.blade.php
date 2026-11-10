@props(['parceiros'])

<ol class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-2 text-xs text-slate-400">
    @foreach($parceiros as $index => $parceiro)
        <li class="flex items-baseline gap-2 py-1.5 border-b border-white/5 min-w-0">
            <span class="font-mono text-[10px] text-slate-600 w-5 shrink-0">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}.</span>
            <div class="min-w-0 flex-1 leading-snug">
                <span class="font-medium text-slate-300">{{ $parceiro['nome'] }}</span>
                @if(! empty($parceiro['tipo']))
                    <span class="text-[11px] text-slate-500"> — {{ $parceiro['tipo'] }}</span>
                @endif
            </div>
        </li>
    @endforeach
    <li class="flex items-baseline gap-2 py-1.5 border-b border-white/5 min-w-0">
        <span class="font-mono text-[10px] text-slate-600 w-5 shrink-0">{{ str_pad((string) (count($parceiros) + 1), 2, '0', STR_PAD_LEFT) }}.</span>
        <div class="min-w-0 flex-1 leading-snug">
            <span class="font-medium text-slate-300">Prefeituras &amp; Concessões</span>
            <span class="text-[11px] text-slate-500"> — +25 Contratos Ativos</span>
        </div>
    </li>
</ol>


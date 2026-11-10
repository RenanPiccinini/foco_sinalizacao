@props(['parceiros'])

<ol class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-8 gap-y-2 text-xs text-slate-400">
    @foreach($parceiros as $index => $parceiro)
        <li class="flex items-baseline gap-2 py-1.5 border-b border-white/5">
            <span class="font-mono text-[10px] text-slate-600 w-5 shrink-0">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}.</span>
            <span class="font-medium text-slate-300 shrink-0">{{ $parceiro['nome'] }}</span>
            <span class="text-[11px] text-slate-500 truncate">— {{ $parceiro['tipo'] }}</span>
        </li>
    @endforeach
    <li class="flex items-baseline gap-2 py-1.5 border-b border-white/5">
        <span class="font-mono text-[10px] text-slate-600 w-5 shrink-0">{{ str_pad((string) (count($parceiros) + 1), 2, '0', STR_PAD_LEFT) }}.</span>
        <span class="font-medium text-slate-300 shrink-0">Prefeituras &amp; Concessões</span>
        <span class="text-[11px] text-slate-500 truncate">— +25 Contratos Ativos</span>
    </li>
</ol>

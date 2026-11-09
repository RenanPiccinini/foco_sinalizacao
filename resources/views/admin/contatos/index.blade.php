<x-app-layout>
    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <!-- Topo -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 border-b border-white/10 gap-4">
            <div>
                <div class="flex items-center gap-2 text-foco-yellow-400 font-mono text-xs uppercase tracking-widest">
                    <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span>
                    <span>Mensagens Recebidas & Orçamentos</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Solicitações & Orçamentos</h1>
                <p class="text-xs sm:text-sm text-slate-400 mt-1">
                    Gerencie orçamentos para compra direta, montagem de processos e mensagens enviadas pelo formulário oficial.
                </p>
            </div>
        </div>

        @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-500/15 border border-emerald-500/40 text-emerald-300 text-xs font-mono flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button type="button" @click="$el.parentElement.remove()" class="text-emerald-400 hover:text-white">✕</button>
        </div>
        @endif

        <!-- Métricas -->
        <div class="grid grid-cols-2 sm:grid-cols-5 gap-3">
            <div class="p-3.5 rounded-2xl glass-panel">
                <span class="text-[10px] font-mono uppercase text-slate-400 block">Total</span>
                <span class="text-xl font-black font-mono text-white mt-0.5 block">{{ $stats['total'] }}</span>
            </div>
            <div class="p-3.5 rounded-2xl glass-panel border border-amber-500/20">
                <span class="text-[10px] font-mono uppercase text-amber-400 block">Novas</span>
                <span class="text-xl font-black font-mono text-amber-400 mt-0.5 block">{{ $stats['novos'] }}</span>
            </div>
            <div class="p-3.5 rounded-2xl glass-panel border border-cyan-500/20">
                <span class="text-[10px] font-mono uppercase text-cyan-400 block">Em Análise</span>
                <span class="text-xl font-black font-mono text-cyan-400 mt-0.5 block">{{ $stats['em_analise'] }}</span>
            </div>
            <div class="p-3.5 rounded-2xl glass-panel border border-emerald-500/20">
                <span class="text-[10px] font-mono uppercase text-emerald-400 block">Respondidas</span>
                <span class="text-xl font-black font-mono text-emerald-400 mt-0.5 block">{{ $stats['respondidos'] }}</span>
            </div>
            <div class="p-3.5 rounded-2xl glass-panel border border-foco-yellow-500/20">
                <span class="text-[10px] font-mono uppercase text-foco-yellow-400 block">Orçamentos</span>
                <span class="text-xl font-black font-mono text-foco-yellow-400 mt-0.5 block">{{ $stats['orcamentos'] }}</span>
            </div>
        </div>

        <!-- Tabela -->
        <div class="glass-panel rounded-3xl border border-white/10 overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-xs">
                    <thead>
                        <tr class="bg-foco-navy-900/90 border-b border-white/10 text-slate-400 font-mono uppercase tracking-wider text-[11px]">
                            <th class="py-3.5 px-4 font-bold">Protocolo</th>
                            <th class="py-3.5 px-4 font-bold">Empresa / Responsável</th>
                            <th class="py-3.5 px-4 font-bold">Contato (Fone & E-mail)</th>
                            <th class="py-3.5 px-3 font-bold">Assunto</th>
                            <th class="py-3.5 px-3 font-bold text-center">Status</th>
                            <th class="py-3.5 px-3 font-bold text-center">Anexo</th>
                            <th class="py-3.5 px-4 font-bold text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($contatos as $c)
                        <tr class="hover:bg-white/[0.02] transition">
                            <td class="py-3.5 px-4 font-mono font-bold text-foco-yellow-400">
                                {{ $c->protocolo }}
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="font-bold text-white block">{{ $c->empresa }}</span>
                                <span class="text-[11px] text-slate-400 block">{{ $c->responsavel }} • CNPJ: {{ $c->cnpj }}</span>
                            </td>
                            <td class="py-3.5 px-4 text-slate-300">
                                <div>{{ $c->fone }}</div>
                                <div class="text-[11px] text-slate-400">{{ $c->email }}</div>
                            </td>
                            <td class="py-3.5 px-3">
                                <span class="px-2.5 py-1 rounded-lg text-[10px] font-mono font-bold {{ str_contains($c->assunto, 'COMPRA') ? 'bg-amber-500/20 text-amber-300' : (str_contains($c->assunto, 'PROCESSO') ? 'bg-purple-500/20 text-purple-300' : 'bg-cyan-500/20 text-cyan-300') }}">
                                    {{ $c->assunto }}
                                </span>
                            </td>
                            <td class="py-3.5 px-3 text-center">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-mono font-bold {{ $c->status_badge_class }}">
                                    {{ $c->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-3 text-center">
                                @if($c->arquivo_path)
                                <a href="{{ route('admin.contatos.download', $c->id) }}" class="inline-flex items-center gap-1 text-[11px] font-mono text-cyan-400 hover:underline">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    Baixar
                                </a>
                                @else
                                <span class="text-slate-600 font-mono">-</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('admin.contatos.show', $c->id) }}" class="px-3 py-1.5 rounded-lg text-xs font-mono font-bold bg-foco-yellow-500 text-foco-navy-950 hover:bg-foco-yellow-400 transition shadow-glow-yellow">
                                    Ver Detalhes →
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-12 px-4 text-center text-slate-400">
                                Nenhuma solicitação recebida até o momento.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($contatos->hasPages())
            <div class="p-4 border-t border-white/10">
                {{ $contatos->links() }}
            </div>
            @endif
        </div>

    </div>
</x-app-layout>

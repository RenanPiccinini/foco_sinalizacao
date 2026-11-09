<x-app-layout>
    <div class="py-8 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        <div class="flex items-center justify-between pb-6 border-b border-white/10">
            <div>
                <a href="{{ route('admin.contatos.index') }}" class="inline-flex items-center gap-1.5 text-xs font-mono text-foco-yellow-400 hover:underline mb-2">
                    ← Voltar para lista de solicitações
                </a>
                <h1 class="text-2xl font-extrabold text-white">Solicitação: {{ $contato->protocolo }}</h1>
                <p class="text-xs text-slate-400 mt-1">Recebida em {{ $contato->created_at->format('d/m/Y H:i') }}</p>
            </div>

            <span class="px-3 py-1 rounded-full text-xs font-mono font-bold {{ $contato->status_badge_class }}">
                Status: {{ $contato->status }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Dados Cadastrais -->
            <div class="md:col-span-2 space-y-6">
                <div class="glass-panel p-6 rounded-3xl border border-white/10 space-y-4">
                    <h3 class="text-sm font-bold text-white border-b border-white/10 pb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-foco-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Identificação da Empresa & Responsável
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <span class="text-slate-400 font-mono block">Empresa:</span>
                            <strong class="text-white text-sm block mt-0.5">{{ $contato->empresa }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 font-mono block">Responsável:</span>
                            <strong class="text-white text-sm block mt-0.5">{{ $contato->responsavel }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 font-mono block">Telefone / Fone:</span>
                            <strong class="text-cyan-300 font-mono block mt-0.5">{{ $contato->fone }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 font-mono block">E-mail:</span>
                            <strong class="text-white font-mono block mt-0.5">{{ $contato->email }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 font-mono block">CNPJ:</span>
                            <strong class="text-white font-mono block mt-0.5">{{ $contato->cnpj }}</strong>
                        </div>
                        <div>
                            <span class="text-slate-400 font-mono block">Endereço:</span>
                            <strong class="text-slate-200 block mt-0.5">{{ $contato->endereco }}</strong>
                        </div>
                    </div>
                </div>

                <!-- Detalhes do Pedido / Assunto -->
                <div class="glass-panel p-6 rounded-3xl border border-white/10 space-y-4">
                    <h3 class="text-sm font-bold text-white border-b border-white/10 pb-3 flex items-center gap-2">
                        <svg class="w-4 h-4 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Assunto & Especificações Técnicas
                    </h3>

                    <div>
                        <span class="text-xs font-mono text-slate-400 block mb-1">Assunto Selecionado:</span>
                        <span class="px-3 py-1.5 rounded-xl text-xs font-mono font-bold bg-foco-yellow-500/20 text-foco-yellow-300 border border-foco-yellow-500/40 inline-block">
                            {{ $contato->assunto }}
                        </span>
                    </div>

                    <div>
                        <span class="text-xs font-mono text-slate-400 block mb-1.5">Descrição do Orçamento / Quantitativos:</span>
                        <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/10 text-xs text-slate-200 whitespace-pre-line leading-relaxed font-sans">
                            {{ $contato->descricao }}
                        </div>
                    </div>

                    @if($contato->arquivo_path)
                    <div class="p-4 rounded-2xl bg-foco-navy-900 border border-cyan-500/30 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-cyan-500/20 text-cyan-400 flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                            </div>
                            <div>
                                <span class="text-xs font-bold text-white block">{{ $contato->arquivo_nome ?? 'Planilha/Arquivo Anexo' }}</span>
                                <span class="text-[11px] font-mono text-slate-400">Planilha ou memorial anexado pelo cliente</span>
                            </div>
                        </div>
                        <a href="{{ route('admin.contatos.download', $contato->id) }}" class="px-4 py-2 rounded-xl text-xs font-bold font-mono bg-cyan-500 text-foco-navy-950 hover:bg-cyan-400 transition">
                            Baixar Arquivo
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Painel Lateral de Ações -->
            <div class="space-y-6">
                <!-- Alterar Status -->
                <div class="glass-panel p-6 rounded-3xl border border-white/10 space-y-4">
                    <h3 class="text-sm font-bold text-white border-b border-white/10 pb-3">Atualizar Status</h3>
                    
                    <form action="{{ route('admin.contatos.status', $contato->id) }}" method="POST" class="space-y-3">
                        @csrf
                        @method('PATCH')

                        <select name="status" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-3 py-2 text-xs text-white">
                            <option value="Novo" {{ $contato->status === 'Novo' ? 'selected' : '' }}>Novo</option>
                            <option value="Em Análise" {{ $contato->status === 'Em Análise' ? 'selected' : '' }}>Em Análise</option>
                            <option value="Respondido" {{ $contato->status === 'Respondido' ? 'selected' : '' }}>Respondido</option>
                            <option value="Arquivado" {{ $contato->status === 'Arquivado' ? 'selected' : '' }}>Arquivado</option>
                        </select>

                        <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition shadow-glow-yellow">
                            Atualizar Status
                        </button>
                    </form>
                </div>

                <!-- Excluir -->
                <div class="glass-panel p-6 rounded-3xl border border-white/10 space-y-3">
                    <h3 class="text-sm font-bold text-rose-400">Excluir Solicitação</h3>
                    <p class="text-xs text-slate-400">Remove este registro e o arquivo anexo permanentemente.</p>
                    <form action="{{ route('admin.contatos.destroy', $contato->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir esta solicitação?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full py-2 rounded-xl text-xs font-mono text-rose-400 hover:text-white bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 transition">
                            Excluir Registro
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>


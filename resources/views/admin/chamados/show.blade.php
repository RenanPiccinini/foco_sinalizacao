<x-app-layout>
    <div class="space-y-6 max-w-5xl mx-auto" x-data="{
        modalConcluir: false,
        statusAtual: '{{ $chamado->status }}',
        definirAgora() {
            const agora = new Date();
            const ano = agora.getFullYear();
            const mes = String(agora.getMonth() + 1).padStart(2, '0');
            const dia = String(agora.getDate()).padStart(2, '0');
            const horas = String(agora.getHours()).padStart(2, '0');
            const minutos = String(agora.getMinutes()).padStart(2, '0');
            const valor = `${ano}-${mes}-${dia}T${horas}:${minutos}`;
            if (document.getElementById('data_hora_execucao')) {
                document.getElementById('data_hora_execucao').value = valor;
            }
            if (document.getElementById('modal_data_hora_execucao')) {
                document.getElementById('modal_data_hora_execucao').value = valor;
            }
        }
    }">
        
        <!-- Breadcrumb e Ações do Topo (100% Responsivo) -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-white/10">
            <div class="flex items-center gap-2 text-xs font-mono">
                <a href="{{ route('admin.chamados.index') }}" class="text-foco-yellow-400 hover:underline flex items-center gap-1 font-bold">
                    ← Voltar para Chamados
                </a>
                <span class="text-slate-600">/</span>
                <span class="text-slate-300 font-bold">{{ $chamado->protocolo }}</span>
            </div>

            <div class="flex flex-wrap items-center gap-2">
                <!-- Botão Destaque: Concluir Chamado (Se ainda não finalizado) -->
                @if($chamado->status !== 'Finalizado')
                <button type="button" @click="modalConcluir = true; $nextTick(() => definirAgora())" class="px-3.5 py-1.5 rounded-xl font-black text-xs uppercase tracking-wider bg-gradient-to-r from-emerald-500 to-foco-green-500 hover:from-emerald-400 hover:to-foco-green-400 text-foco-navy-950 transition shadow-glow-green flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-foco-navy-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    <span>Concluir Chamado</span>
                </button>
                @endif

                <a href="{{ route('admin.chamados.imprimir-os', $chamado->id) }}" target="_blank" class="px-2.5 py-1.5 rounded-lg text-xs font-mono font-bold bg-white/5 hover:bg-white/10 text-slate-200 border border-white/10 transition inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-foco-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Imprimir OS</span>
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            <!-- Coluna Esquerda: Detalhes do Chamado e Histórico -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Card Principal com Dados de Abertura -->
                <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-2xl space-y-6">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-6 border-b border-white/10">
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold font-mono {{ $chamado->tipo_badge_class }}">
                                    Tipo: {{ $chamado->tipo }}
                                </span>
                                <span class="text-xs font-mono text-slate-400">Protocolo {{ $chamado->protocolo }}</span>
                            </div>
                            <h1 class="text-2xl font-black text-white mt-1">{{ $chamado->defeito }}</h1>
                        </div>
                        <span class="px-3 py-1.5 rounded-full text-xs font-bold font-mono uppercase tracking-wider self-start sm:self-auto {{ $chamado->status_badge_class }}">
                            {{ $chamado->status }}
                        </span>
                    </div>

                    <!-- Dados do Local e Solicitante -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-mono">
                        <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-1.5">
                            <span class="text-slate-500 block uppercase font-bold text-[10px]">Localização:</span>
                            <p class="text-slate-200 text-sm font-sans font-bold">{{ $chamado->local }}</p>
                            <p class="text-foco-yellow-400">Horário de Abertura Automático:</p>
                            <p class="text-white font-bold">{{ $chamado->data_hora_abertura ? $chamado->data_hora_abertura->format('d/m/Y H:i:s') : $chamado->created_at->format('d/m/Y H:i:s') }}</p>
                        </div>

                        <div class="p-4 rounded-2xl bg-foco-navy-900 border border-white/5 space-y-1.5">
                            <span class="text-slate-500 block uppercase font-bold text-[10px]">Solicitante & Contato:</span>
                            <p class="text-slate-200 text-sm font-sans font-bold">{{ $chamado->nome_solicitante }}</p>
                            <p class="text-cyan-400">WhatsApp: {{ $chamado->telefone_contato }}</p>
                            @if($chamado->tecnico_responsavel)
                            <p class="text-slate-400 pt-1 border-t border-white/5">Técnico: <strong class="text-white">{{ $chamado->tecnico_responsavel }}</strong></p>
                            @endif
                        </div>
                    </div>

                    <!-- Defeito -->
                    <div class="space-y-2">
                        <span class="text-xs font-mono uppercase font-bold text-slate-400">Defeito Informado pelo Cliente:</span>
                        <div class="p-4 rounded-2xl bg-foco-navy-900/80 border border-white/5 text-sm text-slate-200 leading-relaxed">
                            {{ $chamado->defeito }}
                        </div>
                    </div>

                    <!-- Observação de Abertura -->
                    @if($chamado->observacao)
                    <div class="space-y-2">
                        <span class="text-xs font-mono uppercase font-bold text-slate-400">Observação Adicional de Abertura:</span>
                        <div class="p-4 rounded-2xl bg-foco-navy-900/50 border border-white/5 text-xs text-slate-300 leading-relaxed font-mono">
                            {{ $chamado->observacao }}
                        </div>
                    </div>
                    @endif
                </div>

                <!-- ======================================================== -->
                <!-- DESTAQUE: REGISTRO DE FINALIZAÇÃO PELA FOCO              -->
                <!-- ======================================================== -->
                @if($chamado->status === 'Finalizado')
                <div class="glass-panel p-6 sm:p-8 rounded-3xl border-2 border-emerald-500/50 bg-gradient-to-br from-emerald-950/40 via-foco-navy-900 to-foco-navy-950 shadow-2xl space-y-5">
                    <div class="flex items-center justify-between pb-3 border-b border-emerald-500/20">
                        <div class="flex items-center gap-2.5">
                            <span class="w-3 h-3 rounded-full bg-emerald-400"></span>
                            <h2 class="text-lg font-black text-emerald-400">Registro de Finalização FOCO</h2>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-bold font-mono bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 uppercase">
                            Serviço Finalizado
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-mono">
                        <div class="p-4 rounded-2xl bg-black/40 border border-white/5 space-y-1">
                            <span class="text-emerald-400 uppercase font-bold text-[10px] block">Horário Execução:</span>
                            <p class="text-white text-base font-bold">
                                {{ $chamado->data_hora_execucao ? $chamado->data_hora_execucao->format('d/m/Y H:i') : 'Não registrado' }}
                            </p>
                        </div>

                        <div class="p-4 rounded-2xl bg-black/40 border border-white/5 space-y-1">
                            <span class="text-emerald-400 uppercase font-bold text-[10px] block">Técnico Designado:</span>
                            <p class="text-white text-base font-bold">
                                {{ $chamado->tecnico_responsavel ?: 'Equipe Técnica FOCO' }}
                            </p>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <span class="text-emerald-400 font-mono font-bold block uppercase text-xs">Conserto Executado:</span>
                        <div class="p-4 rounded-2xl bg-black/50 border border-white/10 text-sm text-slate-100 font-sans leading-relaxed">
                            {{ $chamado->conserto_executado ?: 'Conserto executado e semáforo normalizado.' }}
                        </div>
                    </div>

                    @if($chamado->observacao_finalizacao)
                    <div class="space-y-1.5">
                        <span class="text-slate-400 font-mono font-bold block uppercase text-xs">Observação da Finalização:</span>
                        <div class="p-4 rounded-2xl bg-black/30 border border-white/5 text-xs text-slate-300 font-mono leading-relaxed">
                            {{ $chamado->observacao_finalizacao }}
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Linha do Tempo / Histórico de Auditoria Digital -->
                <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-2xl">
                    <h3 class="text-sm font-mono font-bold text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-cyan-400"></span>
                        Trilha de Auditoria Digital (Audit Trail)
                    </h3>

                    <div class="space-y-3 font-mono text-xs">
                        @if(!empty($chamado->historico))
                            @foreach($chamado->historico as $h)
                            <div class="p-3.5 rounded-xl bg-foco-navy-900 border border-white/5 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                                <div class="flex items-start gap-2.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-foco-yellow-400 mt-1.5 shrink-0"></span>
                                    <div>
                                        <span class="text-slate-200 block font-medium">{{ $h['evento'] }}</span>
                                        <span class="text-[11px] text-slate-500">Autor: {{ $h['usuario'] }}</span>
                                    </div>
                                </div>
                                <span class="text-foco-yellow-400 font-bold text-[11px] shrink-0">{{ $h['data'] }}</span>
                            </div>
                            @endforeach
                        @else
                            <p class="text-slate-500 text-xs">Nenhum evento registrado.</p>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Coluna Direita: Formulário de Atualização e Despacho -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Formulário de Despacho & Status -->
                <div class="glass-panel-glow p-6 rounded-3xl border border-foco-yellow-500/30 shadow-2xl space-y-4">
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-foco-yellow-400"></span>
                        <h3 class="text-base font-bold text-white">Despacho & Status</h3>
                    </div>
                    <p class="text-xs text-slate-400">Gerencie a evolução do chamado. Ao marcar como Finalizado, o solicitante é notificado no WhatsApp.</p>

                    <form action="{{ route('admin.chamados.update', $chamado->id) }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Status -->
                        <div>
                            <label class="block text-xs font-mono text-slate-300 mb-1">Status Operacional *</label>
                            <select name="status" x-model="statusAtual" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-3 py-2.5 text-xs text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                                <option value="Aberto">🟡 Aberto</option>
                                <option value="Em Atendimento">🔵 Em Atendimento</option>
                                <option value="Finalizado">🟢 Finalizado (Conclusão do Serviço)</option>
                            </select>
                        </div>

                        <!-- Técnico Responsável -->
                        <div>
                            <label class="block text-xs font-mono text-slate-300 mb-1">Técnico / Equipe FOCO</label>
                            <input type="text" name="tecnico_responsavel" value="{{ old('tecnico_responsavel', $chamado->tecnico_responsavel ?? auth()->user()->name) }}" placeholder="Ex: Eng. Ricardo Silveira (FOCO)" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-3 py-2 text-xs text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                        </div>

                        <!-- CAMPOS ESPECÍFICOS DE FINALIZAÇÃO PELA FOCO -->
                        <div class="space-y-4 pt-3 border-t border-white/10" :class="statusAtual === 'Finalizado' ? 'p-3 rounded-2xl bg-emerald-950/20 border border-emerald-500/30' : ''">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-mono font-bold uppercase tracking-wider" :class="statusAtual === 'Finalizado' ? 'text-emerald-400' : 'text-slate-400'">
                                    Dados de Finalização FOCO:
                                </span>
                                <button type="button" @click="definirAgora()" class="text-[10px] font-mono text-foco-yellow-400 hover:underline">
                                    Usar Agora
                                </button>
                            </div>

                            <!-- Horário Execução -->
                            <div>
                                <label for="data_hora_execucao" class="block text-xs font-mono text-slate-300 mb-1">Horário Execução</label>
                                <input type="datetime-local" name="data_hora_execucao" id="data_hora_execucao" value="{{ $chamado->data_hora_execucao ? $chamado->data_hora_execucao->format('Y-m-d\TH:i') : '' }}" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-3 py-2 text-xs text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                            </div>

                            <!-- Conserto Executado -->
                            <div>
                                <label for="conserto_executado" class="block text-xs font-mono text-slate-300 mb-1">Conserto Executado</label>
                                <textarea name="conserto_executado" id="conserto_executado" rows="3" placeholder="Ex: Substituição do módulo LED vermelho no foco 02, recalibração do plano semafórico e teste de nobreak." class="w-full bg-foco-navy-900 border border-white/10 rounded-xl p-3 text-xs text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">{{ old('conserto_executado', $chamado->conserto_executado) }}</textarea>
                            </div>

                            <!-- Observação da Finalização -->
                            <div>
                                <label for="observacao_finalizacao" class="block text-xs font-mono text-slate-300 mb-1">Observação da Finalização</label>
                                <textarea name="observacao_finalizacao" id="observacao_finalizacao" rows="2" placeholder="Observações operacionais para o solicitante e registros..." class="w-full bg-foco-navy-900 border border-white/10 rounded-xl p-3 text-xs text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">{{ old('observacao_finalizacao', $chamado->observacao_finalizacao) }}</textarea>
                            </div>

                            <!-- Aviso WhatsApp -->
                            <div class="p-2.5 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-[11px] text-emerald-300 flex items-center gap-2">
                                <svg class="w-4 h-4 shrink-0 text-emerald-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.187-2.59-5.771-5.764-5.771z"/></svg>
                                <span>Ao salvar como <strong>Finalizado</strong>, uma mensagem é disparada no WhatsApp do solicitante.</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full py-3 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition shadow-glow-yellow">
                            Salvar / Atualizar Chamado
                        </button>
                    </form>
                </div>

                <!-- Resumo Rápido dos Dados do Chamado -->
                <div class="glass-panel p-5 rounded-2xl border border-white/10 text-xs font-mono space-y-3">
                    <span class="text-slate-400 block uppercase font-bold text-[10px]">Resumo Rápido:</span>
                    <div class="flex items-center justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-400">Tipo:</span>
                        <strong class="text-white">{{ $chamado->tipo }}</strong>
                    </div>
                    <div class="flex items-center justify-between border-b border-white/5 pb-2">
                        <span class="text-slate-400">Abertura:</span>
                        <strong class="text-foco-green-400">{{ $chamado->data_hora_abertura ? $chamado->data_hora_abertura->format('d/m/Y H:i') : $chamado->created_at->format('d/m/Y H:i') }}</strong>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-slate-400">Telefone Solicitante:</span>
                        <strong class="text-cyan-400">{{ $chamado->telefone_contato }}</strong>
                    </div>
                </div>

            </div>

        </div>

        <!-- ======================================================== -->
        <!-- MODAL ESPECÍFICO: CONCLUIR CHAMADO & ENVIAR WHATSAPP      -->
        <!-- ======================================================== -->
        <div x-show="modalConcluir" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-transition>
            <div class="flex items-center justify-center min-h-screen p-4 text-center">
                <div class="fixed inset-0 bg-black/80 backdrop-blur-sm" @click="modalConcluir = false"></div>

                <div class="relative bg-foco-navy-900 border-2 border-emerald-500/50 rounded-3xl p-6 sm:p-8 max-w-2xl w-full text-left shadow-2xl space-y-5">
                    <div class="flex items-center justify-between pb-4 border-b border-white/10">
                        <div class="flex items-center gap-2.5">
                            <span class="w-3 h-3 rounded-full bg-emerald-400 animate-ping"></span>
                            <h3 class="text-lg font-black text-white">Concluir Chamado & Disparar WhatsApp</h3>
                        </div>
                        <button type="button" @click="modalConcluir = false" class="text-slate-400 hover:text-white text-lg">✕</button>
                    </div>

                    <!-- Card Informativo do Envio Automático -->
                    <div class="p-4 rounded-2xl bg-emerald-950/40 border border-emerald-500/30 text-xs space-y-1.5 font-mono">
                        <div class="flex items-center gap-2 text-emerald-400 font-bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766 0-3.187-2.59-5.771-5.764-5.771z"/></svg>
                            <span>Notificação Automática no WhatsApp</span>
                        </div>
                        <p class="text-slate-300">
                            Destinatário: <strong class="text-white">{{ $chamado->nome_solicitante }}</strong> 
                            • Número: <strong class="text-emerald-300">{{ $chamado->telefone_contato }}</strong>
                        </p>
                        <p class="text-[11px] text-slate-400">
                            A mensagem será disparada instantaneamente através da Evolution API conectada ao número da FOCO.
                        </p>
                    </div>

                    <form action="{{ route('admin.chamados.concluir', $chamado->id) }}" method="POST" class="space-y-4">
                        @csrf

                        <!-- Conserto Executado -->
                        <div>
                            <label class="block text-xs font-mono text-slate-300 mb-1">Conserto Executado *</label>
                            <textarea name="conserto_executado" rows="3" required placeholder="Ex: Substituição da placa de potência, alinhamento do foco veicular e teste do nobreak." class="w-full bg-foco-navy-950 border border-white/10 rounded-xl p-3 text-xs text-white placeholder-slate-500 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">{{ old('conserto_executado', $chamado->conserto_executado) }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Horário de Execução -->
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <label class="block text-xs font-mono text-slate-300">Horário Execução</label>
                                    <button type="button" @click="definirAgora()" class="text-[10px] font-mono text-foco-yellow-400 hover:underline">Agora</button>
                                </div>
                                <input type="datetime-local" name="data_hora_execucao" id="modal_data_hora_execucao" value="{{ $chamado->data_hora_execucao ? $chamado->data_hora_execucao->format('Y-m-d\TH:i') : '' }}" class="w-full bg-foco-navy-950 border border-white/10 rounded-xl px-3 py-2 text-xs text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>

                            <!-- Técnico Responsável -->
                            <div>
                                <label class="block text-xs font-mono text-slate-300 mb-1">Técnico Responsável</label>
                                <input type="text" name="tecnico_responsavel" value="{{ old('tecnico_responsavel', $chamado->tecnico_responsavel ?? auth()->user()->name) }}" placeholder="Ex: Eng. Ricardo Silveira (FOCO)" class="w-full bg-foco-navy-950 border border-white/10 rounded-xl px-3 py-2 text-xs text-white focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                        </div>

                        <!-- Observação -->
                        <div>
                            <label class="block text-xs font-mono text-slate-300 mb-1">Observação da Conclusão (Opcional)</label>
                            <textarea name="observacao_finalizacao" rows="2" placeholder="Informações adicionais para o cliente..." class="w-full bg-foco-navy-950 border border-white/10 rounded-xl p-3 text-xs text-white placeholder-slate-500 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">{{ old('observacao_finalizacao', $chamado->observacao_finalizacao) }}</textarea>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-3 border-t border-white/10">
                            <button type="button" @click="modalConcluir = false" class="px-4 py-2 rounded-xl text-xs text-slate-400 hover:text-white">Cancelar</button>
                            <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-gradient-to-r from-emerald-500 to-foco-green-500 hover:from-emerald-400 hover:to-foco-green-400 text-foco-navy-950 transition shadow-glow-green flex items-center gap-2">
                                <svg class="w-4 h-4 text-foco-navy-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span>Concluir e Enviar WhatsApp</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>

<x-app-layout>
    <div class="space-y-6 max-w-5xl mx-auto" x-data="{
        conectado: {{ $stateInfo['connected'] ? 'true' : 'false' }},
        carregandoQr: false,
        qrcode: null,
        statusTexto: '{{ $stateInfo['connected'] ? 'Conectado' : 'Aguardando Leitura' }}',
        erroMensagem: '',
        intervalId: null,

        iniciarPolling() {
            if (this.intervalId) clearInterval(this.intervalId);
            this.intervalId = setInterval(() => {
                this.verificarStatus();
            }, 3000);
        },

        async verificarStatus() {
            try {
                const res = await fetch('{{ route('admin.conexao.status') }}');
                const data = await res.json();

                if (data.connected && !this.conectado) {
                    this.conectado = true;
                    this.statusTexto = 'Conectado';
                    this.qrcode = null;
                    if (this.intervalId) clearInterval(this.intervalId);

                    // Recarrega automaticamente a página para atualizar o estado completo
                    window.location.reload();
                } else if (!data.connected && this.conectado) {
                    this.conectado = false;
                    this.statusTexto = 'Desconectado';
                }
            } catch (e) {
                console.error('Erro no polling de status:', e);
            }
        },

        async carregarQrCode() {
            this.carregandoQr = true;
            this.erroMensagem = '';
            try {
                const res = await fetch('{{ route('admin.conexao.qrcode') }}');
                const data = await res.json();

                if (data.connected) {
                    this.conectado = true;
                    if (this.intervalId) clearInterval(this.intervalId);
                    window.location.reload();
                    return;
                }

                if (data.qrcode) {
                    this.qrcode = data.qrcode;
                } else if (data.message || data.error) {
                    this.erroMensagem = data.message || data.error;
                }
            } catch (e) {
                this.erroMensagem = 'Falha ao comunicar com a Evolution API.';
            } finally {
                this.carregandoQr = false;
            }
        },

        init() {
            if (!this.conectado) {
                this.carregarQrCode();
                this.iniciarPolling();
            }
        }
    }">

        <!-- Topo da Página -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
            <div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full" :class="conectado ? 'bg-foco-green-400 animate-pulse' : 'bg-amber-400 animate-ping'"></span>
                    <span class="text-xs font-mono uppercase tracking-widest font-bold" :class="conectado ? 'text-foco-green-400' : 'text-amber-400'" x-text="conectado ? 'WHATSAPP CONECTADO' : 'CONEXÃO PENDENTE'"></span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Conexão WhatsApp</h1>
                <p class="text-xs text-slate-400 mt-1">
                    Conecte o WhatsApp oficial da FOCO para enviar alertas automáticos de novos chamados e laudos aos solicitantes.
                </p>
            </div>

            <!-- Badges Técnicas -->
            <div class="flex flex-wrap items-center gap-2 font-mono text-xs">
                <span class="px-3 py-1.5 rounded-xl bg-white/5 border border-white/10 text-slate-300">
                    Instância: <strong class="text-foco-yellow-400">{{ $instance }}</strong>
                </span>
            </div>
        </div>

        <!-- ============================================================= -->
        <!-- ESTADO 1: WHATSAPP CONECTADO COM SUCESSO                      -->
        <!-- ============================================================= -->
        <div x-show="conectado" x-transition class="space-y-6">
            
            <div class="glass-panel-glow p-6 sm:p-10 rounded-3xl border-2 border-emerald-500/50 bg-gradient-to-br from-emerald-950/40 via-foco-navy-900 to-foco-navy-950 shadow-2xl relative overflow-hidden">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6 pb-6 border-b border-emerald-500/20">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 rounded-2xl bg-emerald-500/20 text-emerald-400 border border-emerald-500/40 flex items-center justify-center shrink-0 shadow-glow-green">
                            <svg class="w-10 h-10 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-emerald-400 animate-pulse"></span>
                                <h2 class="text-xl sm:text-2xl font-black text-white">WhatsApp Conectado</h2>
                            </div>
                            <p class="text-xs text-emerald-300 mt-1 font-mono">
                                Conexão ativa com o aparelho móvel • Disparos autorizados e operacionais
                            </p>
                        </div>
                    </div>

                    <!-- Botão Desconectar -->
                    <form action="{{ route('admin.conexao.desconectar') }}" method="POST" onsubmit="return confirm('Deseja realmente desconectar este WhatsApp? Você precisará ler o QR Code novamente para reconectar.');">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-xl text-xs font-mono font-bold text-rose-300 bg-rose-500/10 hover:bg-rose-500/20 border border-rose-500/30 transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            <span>Desconectar Aparelho</span>
                        </button>
                    </form>
                </div>

                <!-- Detalhes da Conexão -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-6 text-xs font-mono">
                    <div class="p-4 rounded-2xl bg-black/40 border border-white/5 space-y-1">
                        <span class="text-slate-400 block uppercase font-bold text-[10px]">Status da Sessão:</span>
                        <strong class="text-emerald-400 text-sm block">🟢 Online / Conectado</strong>
                        <span class="text-[11px] text-slate-500">Pronto para envio imediato</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-black/40 border border-white/5 space-y-1">
                        <span class="text-slate-400 block uppercase font-bold text-[10px]">Instância Ativa:</span>
                        <strong class="text-white text-sm block">{{ $instance }}</strong>
                        <span class="text-[11px] text-slate-500">Evolution API v2 (VPS Hostinger)</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-black/40 border border-white/5 space-y-1">
                        <span class="text-slate-400 block uppercase font-bold text-[10px]">Aparelho Emissor (Conectado):</span>
                        <strong class="text-foco-yellow-400 text-sm block">{{ !empty($stateInfo['ownerNumber']) ? $stateInfo['ownerNumber'] : 'Conectado via QR Code' }}</strong>
                        <span class="text-[11px] text-slate-500">Remetente dos disparos</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-black/40 border border-white/5 space-y-1">
                        <span class="text-slate-400 block uppercase font-bold text-[10px]">Destinatário do Dono:</span>
                        <strong class="text-cyan-400 text-sm block">{{ !empty($adminRecipients) ? implode(', ', $adminRecipients) : 'Aparelho conectado' }}</strong>
                        <span class="text-[11px] text-slate-500">Recebe alertas de novos chamados</span>
                    </div>
                </div>
            </div>

            <!-- Card de Teste de Disparo Imediato -->
            <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 shadow-2xl space-y-4">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-cyan-400"></span>
                    <h3 class="text-base font-bold text-white">Testar Envio de Mensagem WhatsApp</h3>
                </div>
                <p class="text-xs text-slate-400">
                    Dispare uma mensagem de teste para comprovar que o WhatsApp conectado está entregando mensagens com sucesso.
                </p>

                <form action="{{ route('admin.conexao.teste') }}" method="POST" class="flex flex-col sm:flex-row items-center gap-3 pt-2">
                    @csrf
                    <div class="relative flex-grow w-full">
                        <input type="text" name="numero" value="{{ $stateInfo['ownerNumber'] ?? '' }}" placeholder="Deixe em branco para testar no número conectado ou digite outro ex: (51) 99294-1111" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-xs font-mono text-white placeholder-slate-500 focus:border-cyan-400 focus:ring-1 focus:ring-cyan-400">
                    </div>

                    <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-cyan-500 hover:bg-cyan-400 text-foco-navy-950 transition shadow-glow-blue flex items-center justify-center gap-2 shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span>Enviar Teste</span>
                    </button>
                </form>
            </div>

        </div>

        <!-- ============================================================= -->
        <!-- ESTADO 2: AGUARDANDO CONEXÃO / LEITURA DO QR CODE            -->
        <!-- ============================================================= -->
        <div x-show="!conectado" x-transition class="space-y-6">

            <div class="glass-panel p-6 sm:p-10 rounded-3xl border border-white/10 shadow-2xl relative">
                
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    <!-- Coluna Esquerda: Instruções Passo a Passo -->
                    <div class="lg:col-span-7 space-y-6">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-foco-yellow-500/10 text-foco-yellow-400 border border-foco-yellow-500/30 text-xs font-mono font-bold">
                            <span class="w-2 h-2 rounded-full bg-foco-yellow-400 animate-ping"></span>
                            <span>Escaneie com a câmera do seu celular</span>
                        </div>

                        <div>
                            <h2 class="text-2xl sm:text-3xl font-black text-white">Como conectar seu WhatsApp:</h2>
                            <p class="text-xs sm:text-sm text-slate-300 mt-2">
                                Todas as notificações serão enviadas diretamente do celular escaneado abaixo.
                            </p>
                        </div>

                        <!-- 4 Passos Claros -->
                        <div class="space-y-3 font-mono text-xs">
                            <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-white/5 border border-white/5">
                                <span class="w-6 h-6 rounded-lg bg-foco-yellow-500 text-foco-navy-950 font-black flex items-center justify-center shrink-0">1</span>
                                <span class="text-slate-200">Abra o aplicativo do <strong>WhatsApp</strong> no seu celular.</span>
                            </div>

                            <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-white/5 border border-white/5">
                                <span class="w-6 h-6 rounded-lg bg-foco-yellow-500 text-foco-navy-950 font-black flex items-center justify-center shrink-0">2</span>
                                <span class="text-slate-200">Toque em <strong>Mais opções (⋮)</strong> no Android ou <strong>Configurações (⚙️)</strong> no iPhone.</span>
                            </div>

                            <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-white/5 border border-white/5">
                                <span class="w-6 h-6 rounded-lg bg-foco-yellow-500 text-foco-navy-950 font-black flex items-center justify-center shrink-0">3</span>
                                <span class="text-slate-200">Selecione <strong>Aparelhos Conectados</strong> e toque em <strong>Conectar um aparelho</strong>.</span>
                            </div>

                            <div class="flex items-start gap-3 p-3.5 rounded-2xl bg-white/5 border border-white/5">
                                <span class="w-6 h-6 rounded-lg bg-foco-yellow-500 text-foco-navy-950 font-black flex items-center justify-center shrink-0">4</span>
                                <span class="text-slate-200">Aponte a câmera para o <strong>QR Code</strong> ao lado para sincronizar.</span>
                            </div>
                        </div>

                        <!-- Indicador de Atualização Automática -->
                        <div class="p-3 rounded-2xl bg-foco-green-500/10 border border-foco-green-500/20 text-xs text-foco-green-300 flex items-center gap-2.5 font-mono">
                            <span class="w-2 h-2 rounded-full bg-foco-green-400 animate-ping shrink-0"></span>
                            <span>Assim que você escanear, esta página será <strong>atualizada automaticamente</strong> para "Conectado".</span>
                        </div>
                    </div>

                    <!-- Coluna Direita: Box do QR Code -->
                    <div class="lg:col-span-5 flex flex-col items-center justify-center">
                        <div class="relative p-6 rounded-3xl bg-white text-slate-900 shadow-2xl border-4 border-foco-yellow-500/80 flex flex-col items-center justify-center min-w-[280px] min-h-[320px]">
                            
                            <!-- Loader enquanto busca QR Code -->
                            <div x-show="carregandoQr" class="text-center py-12 space-y-3">
                                <svg class="w-10 h-10 text-foco-navy-900 animate-spin mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                <span class="text-xs font-mono font-bold text-slate-700 block">Gerando QR Code...</span>
                            </div>

                            <!-- Imagem do QR Code -->
                            <div x-show="!carregandoQr && qrcode" class="text-center space-y-2">
                                <img :src="qrcode" alt="QR Code WhatsApp" class="w-60 h-60 object-contain mx-auto rounded-xl">
                                <span class="text-[11px] font-mono font-bold text-slate-600 block">Aponte a câmera do WhatsApp</span>
                            </div>

                            <!-- Caso de erro ou sem API key -->
                            <div x-show="!carregandoQr && !qrcode" class="text-center py-8 px-4 space-y-2">
                                <svg class="w-8 h-8 text-amber-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                                <p class="text-xs font-medium text-slate-700" x-text="erroMensagem || 'Clique abaixo para gerar o QR Code'"></p>
                            </div>

                            <!-- Botão Recarregar QR Code -->
                            <button type="button" @click="carregarQrCode()" class="mt-4 px-4 py-2 rounded-xl text-xs font-mono font-bold text-foco-navy-950 bg-foco-yellow-400 hover:bg-foco-yellow-300 transition flex items-center gap-1.5 shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                <span>Atualizar QR Code</span>
                            </button>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </div>
</x-app-layout>


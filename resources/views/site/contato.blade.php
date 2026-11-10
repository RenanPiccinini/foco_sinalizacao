@extends('site.layout')

@section('title', 'Formulário Oficial de Contato & Orçamentos | Foco Sinalização')

@section('content')
<div class="py-14 bg-foco-navy-950 relative overflow-hidden" x-data="{
    assuntoSelecionado: '{{ old('assunto', $assuntoPredefinido ?: 'ORÇAMENTO COMPRA DIRETA') }}',
    arquivoNome: '',
    arquivoTamanho: '',
    arquivoExtensao: '',
    arquivoErro: '',
    arrastando: false,
    formatarTamanho(bytes) {
        if (!bytes) return '';
        if (bytes < 1024) return bytes + ' B';
        if (bytes < 1024 * 1024) return (bytes / 1024).toFixed(1) + ' KB';
        return (bytes / (1024 * 1024)).toFixed(2) + ' MB';
    },
    processarArquivo(file) {
        this.arquivoErro = '';
        if (!file) {
            this.removerArquivo();
            return;
        }
        const extensoesPermitidas = ['pdf', 'xls', 'xlsx', 'xlsm', 'ods', 'csv', 'doc', 'docx', 'odt', 'txt', 'png', 'jpg', 'jpeg', 'webp', 'zip', 'rar'];
        const ext = (file.name.split('.').pop() || '').toLowerCase();
        if (!ext || !extensoesPermitidas.includes(ext)) {
            this.arquivoErro = 'Formato não suportado (' + (ext || 'desconhecido') + '). Use PDF, XLSX, XLS, CSV, DOC, DOCX, TXT, imagens, ZIP ou RAR.';
            this.removerArquivo(false);
            return;
        }
        if (file.size > 20 * 1024 * 1024) {
            this.arquivoErro = 'O arquivo excede o limite máximo de 20MB.';
            this.removerArquivo(false);
            return;
        }
        this.arquivoNome = file.name;
        this.arquivoTamanho = this.formatarTamanho(file.size);
        this.arquivoExtensao = ext.toUpperCase();
    },
    selecionarArquivo(event) {
        const file = event.target.files && event.target.files[0] ? event.target.files[0] : null;
        this.processarArquivo(file);
    },
    soltarArquivo(event) {
        this.arrastando = false;
        const files = event.dataTransfer && event.dataTransfer.files;
        if (!files || !files.length) return;
        const file = files[0];
        this.processarArquivo(file);
        if (!this.arquivoErro && this.$refs.inputArquivo) {
            const dt = new DataTransfer();
            dt.items.add(file);
            this.$refs.inputArquivo.files = dt.files;
        }
    },
    removerArquivo(limparErro = true) {
        this.arquivoNome = '';
        this.arquivoTamanho = '';
        this.arquivoExtensao = '';
        if (limparErro) {
            this.arquivoErro = '';
        }
        if (this.$refs.inputArquivo) {
            this.$refs.inputArquivo.value = '';
        }
    }
}">

    <!-- Efeitos de iluminação de fundo -->
    <div class="absolute top-10 right-10 w-96 h-96 bg-foco-yellow-500/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 left-10 w-96 h-96 bg-cyan-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

        <!-- Cabeçalho Principal -->
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-mono font-bold tracking-widest text-foco-yellow-400 uppercase bg-foco-yellow-500/10 px-3 py-1 rounded-full border border-foco-yellow-500/30">
                Canal Oficial de Atendimento
            </span>
            <h1 class="text-3xl sm:text-4xl font-black text-white mt-3 tracking-tight">
                Formulário de Contato & Orçamento
            </h1>
            <p class="text-slate-400 mt-2 text-sm leading-relaxed">
                Preencha o formulário institucional para cotações técnicas, orçamentos de engenharia, montagem de processos ou solicitações operacionais.
            </p>
            <div class="w-20 h-1 bg-foco-yellow-500 mx-auto mt-4 rounded-full"></div>
        </div>

        <!-- Alerta de Sucesso -->
        @if(session('success'))
        <div class="mb-8 p-6 rounded-3xl glass-panel-glow border-2 border-foco-yellow-500 shadow-2xl animate-pulse-slow">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-2xl bg-foco-yellow-500/20 text-foco-yellow-400 flex items-center justify-center shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-white">Solicitação Enviada com Sucesso!</h3>
                    <p class="text-slate-300 text-xs sm:text-sm mt-1">
                        {{ session('success') }}
                    </p>
                    <p class="text-xs text-slate-400 mt-2 font-mono">
                        Protocolo de Acompanhamento: <strong class="text-foco-yellow-400">{{ session('protocolo_contato') }}</strong>
                    </p>
                </div>
            </div>
        </div>
        @endif

        @if($errors->any())
        <div class="mb-8 p-5 rounded-2xl bg-rose-500/15 border border-rose-500/40 text-rose-200 text-xs sm:text-sm space-y-1.5">
            <strong class="block font-mono uppercase tracking-wider text-rose-400">Não foi possível enviar o formulário — verifique os campos abaixo:</strong>
            <ul class="list-disc list-inside space-y-0.5 text-xs">
                @foreach($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <!-- Card do Formulário Oficial (Fiel à Imagem Fornecida) -->
        <div class="glass-panel p-6 sm:p-10 rounded-3xl border border-white/10 shadow-2xl relative">

            <!-- Topo do Formulário com Marcação FORMULÁRIO -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between pb-6 mb-6 border-b border-white/10 gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-foco-yellow-500/10 border border-foco-yellow-500/30 flex items-center justify-center text-foco-yellow-400 font-black text-sm">
                        FC
                    </div>
                    <div>
                        <h2 class="text-lg sm:text-xl font-mono font-black text-white tracking-wider uppercase underline underline-offset-4 decoration-foco-yellow-500">
                            FORMULÁRIO
                        </h2>
                        <span class="text-[11px] text-slate-400">Foco Sinalização e Sistemas Inteligentes LTDA</span>
                    </div>
                </div>

                @if(auth()->check())
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-xs font-mono text-emerald-400">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>Usuário Autenticado: <strong>{{ auth()->user()->name }}</strong></span>
                </div>
                @else
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-foco-yellow-500/10 border border-foco-yellow-500/30 text-xs font-mono text-foco-yellow-400">
                    <span class="w-2 h-2 rounded-full bg-foco-yellow-400 animate-pulse"></span>
                    <span>Envio Imediato • Sem Necessidade de Cadastro</span>
                </div>
                @endif
            </div>

            <form action="{{ route('site.contato.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                <input type="hidden" name="_origin" value="{{ ! empty($isOrcamento) ? 'orcamento' : 'contato' }}">

                <!-- 1. EMPRESA -->
                <div>
                    <label for="empresa" class="block text-xs font-mono font-bold text-slate-200 uppercase tracking-wider mb-1.5">
                        EMPRESA – *
                    </label>
                    <input type="text" name="empresa" id="empresa" required value="{{ old('empresa') }}" placeholder="Nome da Empresa / Órgão Público / Concessionária" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                    @error('empresa')
                        <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 2. RESPONSÁVEL -->
                <div>
                    <label for="responsavel" class="block text-xs font-mono font-bold text-slate-200 uppercase tracking-wider mb-1.5">
                        RESPONSÁVEL – *
                    </label>
                    <input type="text" name="responsavel" id="responsavel" required value="{{ old('responsavel', auth()->user()?->name) }}" placeholder="Nome Completo do Responsável ou Solicitante" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                    @error('responsavel')
                        <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 3. FONE e E-MAIL -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="fone" class="block text-xs font-mono font-bold text-slate-200 uppercase tracking-wider mb-1.5">
                            FONE – *
                        </label>
                        <input type="text" name="fone" id="fone" required value="{{ old('fone') }}" placeholder="(00) 00000-0000" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                        @error('fone')
                            <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-xs font-mono font-bold text-slate-200 uppercase tracking-wider mb-1.5">
                            E-MAIL – *
                        </label>
                        <input type="email" name="email" id="email" required value="{{ old('email', auth()->user()?->email) }}" placeholder="contato@empresa.com.br" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                        @error('email')
                            <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- 4. ENDEREÇO -->
                <div>
                    <label for="endereco" class="block text-xs font-mono font-bold text-slate-200 uppercase tracking-wider mb-1.5">
                        ENDEREÇO – *
                    </label>
                    <input type="text" name="endereco" id="endereco" required value="{{ old('endereco') }}" placeholder="Logradouro, Número, Bairro, Município - UF" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                    @error('endereco')
                        <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 5. CNPJ -->
                <div>
                    <label for="cnpj" class="block text-xs font-mono font-bold text-slate-200 uppercase tracking-wider mb-1.5">
                        CNPJ – *
                    </label>
                    <input type="text" name="cnpj" id="cnpj" required value="{{ old('cnpj') }}" placeholder="00.000.000/0000-00" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-3 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition">
                    @error('cnpj')
                        <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 6. ANEXAR PLANILHA / ARQUIVO -->
                <div class="pt-2">
                    <label for="arquivo" class="block text-xs font-mono font-bold text-slate-200 uppercase tracking-wider mb-1.5">
                        ANEXAR PLANILHA / ARQUIVO –
                    </label>
                    <input
                        x-ref="inputArquivo"
                        id="arquivo"
                        name="arquivo"
                        type="file"
                        accept=".pdf,.xls,.xlsx,.xlsm,.ods,.csv,.doc,.docx,.odt,.txt,.png,.jpg,.jpeg,.webp,.zip,.rar"
                        class="sr-only"
                        @change="selecionarArquivo($event)"
                    />

                    <div
                        @click="$refs.inputArquivo.click()"
                        @dragover.prevent="arrastando = true"
                        @dragleave.prevent="arrastando = false"
                        @drop.prevent="soltarArquivo($event)"
                        :class="{
                            'border-emerald-400/70 bg-emerald-500/10': arquivoNome,
                            'border-foco-yellow-400 bg-foco-navy-900': arrastando && !arquivoNome,
                            'border-white/10 bg-foco-navy-900/60 hover:bg-foco-navy-900 hover:border-foco-yellow-500/50': !arquivoNome && !arrastando
                        }"
                        class="relative flex items-center justify-center w-full min-h-[7.5rem] px-4 py-4 border-2 border-dashed rounded-2xl cursor-pointer transition group"
                    >
                        <div x-show="!arquivoNome" class="flex flex-col items-center justify-center text-center">
                            <svg class="w-7 h-7 mb-1.5 text-slate-400 group-hover:text-foco-yellow-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                            <p class="text-xs text-slate-300"><span class="font-bold text-foco-yellow-400">Clique para anexar</span> ou arraste aqui sua planilha, PDF ou documento</p>
                            <p class="text-[11px] text-slate-500 mt-0.5">Formatos: PDF, XLSX, XLS, CSV, DOC, DOCX, TXT, Imagens, ZIP ou RAR (máx. 20MB)</p>
                        </div>

                        <div x-show="arquivoNome" x-cloak style="display: none;" class="w-full flex flex-col sm:flex-row items-center justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0 w-full sm:w-auto">
                                <div class="w-11 h-11 rounded-xl bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 flex flex-col items-center justify-center shrink-0">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                    <span class="text-[9px] font-mono font-black leading-none mt-0.5" x-text="arquivoExtensao"></span>
                                </div>
                                <div class="min-w-0 text-left">
                                    <p class="text-xs sm:text-sm font-bold text-white truncate" x-text="arquivoNome"></p>
                                    <p class="text-[11px] font-mono text-emerald-400 mt-0.5">
                                        Arquivo anexado (<span x-text="arquivoTamanho"></span>) • Pronto para envio
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-2 shrink-0">
                                <button type="button" @click.stop="$refs.inputArquivo.click()" class="px-3 py-1.5 rounded-lg text-[11px] font-mono font-bold bg-white/10 hover:bg-white/20 text-slate-200 transition">
                                    Trocar
                                </button>
                                <button type="button" @click.stop="removerArquivo()" class="px-3 py-1.5 rounded-lg text-[11px] font-mono font-bold bg-rose-500/15 hover:bg-rose-500/30 text-rose-300 border border-rose-500/30 transition">
                                    Remover
                                </button>
                            </div>
                        </div>
                    </div>

                    <p x-show="arquivoErro" x-cloak style="display: none;" x-text="arquivoErro" class="text-rose-400 text-xs font-mono mt-1.5"></p>
                    @error('arquivo')
                        <p class="text-rose-400 text-xs font-mono mt-1.5">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 7. ASSUNTO (CONFORME FOTO) -->
                <div class="pt-4 border-t border-white/10 space-y-3">
                    <label class="block text-xs font-mono font-black text-foco-yellow-400 uppercase tracking-widest">
                        ASSUNTO: *
                    </label>

                    <div class="space-y-2.5">
                        <!-- Opção 1: ORÇAMENTO COMPRA DIRETA -->
                        <label @click="assuntoSelecionado = 'ORÇAMENTO COMPRA DIRETA'" class="cursor-pointer relative p-3.5 rounded-2xl border transition flex items-center justify-between"
                            :class="assuntoSelecionado === 'ORÇAMENTO COMPRA DIRETA' ? 'bg-foco-yellow-500/15 border-foco-yellow-500 text-white shadow-glow-yellow' : 'bg-foco-navy-900 border-white/10 text-slate-300 hover:border-white/30'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="assunto" value="ORÇAMENTO COMPRA DIRETA" class="sr-only" x-model="assuntoSelecionado" required>
                                <span class="font-mono text-foco-yellow-400 font-bold">➤</span>
                                <span class="text-xs sm:text-sm font-bold uppercase tracking-wide">ORÇAMENTO COMPRA DIRETA</span>
                            </div>
                            <span class="font-mono text-xs text-slate-400" :class="assuntoSelecionado === 'ORÇAMENTO COMPRA DIRETA' ? 'text-foco-yellow-400 font-bold' : ''">( <span x-text="assuntoSelecionado === 'ORÇAMENTO COMPRA DIRETA' ? '✔' : ' '"></span> )</span>
                        </label>

                        <!-- Opção 2: ORÇAMENTO PARA MONTAR PROCESSO -->
                        <label @click="assuntoSelecionado = 'ORÇAMENTO PARA MONTAR PROCESSO'" class="cursor-pointer relative p-3.5 rounded-2xl border transition flex items-center justify-between"
                            :class="assuntoSelecionado === 'ORÇAMENTO PARA MONTAR PROCESSO' ? 'bg-purple-500/15 border-purple-400 text-white shadow-lg' : 'bg-foco-navy-900 border-white/10 text-slate-300 hover:border-white/30'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="assunto" value="ORÇAMENTO PARA MONTAR PROCESSO" class="sr-only" x-model="assuntoSelecionado" required>
                                <span class="font-mono text-purple-400 font-bold">➤</span>
                                <span class="text-xs sm:text-sm font-bold uppercase tracking-wide">ORÇAMENTO PARA MONTAR PROCESSO</span>
                            </div>
                            <span class="font-mono text-xs text-slate-400" :class="assuntoSelecionado === 'ORÇAMENTO PARA MONTAR PROCESSO' ? 'text-purple-400 font-bold' : ''">( <span x-text="assuntoSelecionado === 'ORÇAMENTO PARA MONTAR PROCESSO' ? '✔' : ' '"></span> )</span>
                        </label>

                        <!-- Opção 3: QUESTIONAMENTO/SOLICITAÇÃO/OUTROS -->
                        <label @click="assuntoSelecionado = 'QUESTIONAMENTO/SOLICITAÇÃO/OUTROS'" class="cursor-pointer relative p-3.5 rounded-2xl border transition flex items-center justify-between"
                            :class="assuntoSelecionado === 'QUESTIONAMENTO/SOLICITAÇÃO/OUTROS' ? 'bg-cyan-500/15 border-cyan-400 text-white shadow-glow-blue' : 'bg-foco-navy-900 border-white/10 text-slate-300 hover:border-white/30'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="assunto" value="QUESTIONAMENTO/SOLICITAÇÃO/OUTROS" class="sr-only" x-model="assuntoSelecionado" required>
                                <span class="font-mono text-cyan-400 font-bold">➤</span>
                                <span class="text-xs sm:text-sm font-bold uppercase tracking-wide">QUESTIONAMENTO / SOLICITAÇÃO / OUTROS</span>
                            </div>
                            <span class="font-mono text-xs text-slate-400" :class="assuntoSelecionado === 'QUESTIONAMENTO/SOLICITAÇÃO/OUTROS' ? 'text-cyan-400 font-bold' : ''">( <span x-text="assuntoSelecionado === 'QUESTIONAMENTO/SOLICITAÇÃO/OUTROS' ? '✔' : ' '"></span> )</span>
                        </label>
                    </div>

                    @error('assunto')
                        <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 8. DESCRIÇÃO (TEXTO EXATO CONFORME A FOTO) -->
                <div class="pt-2">
                    <label for="descricao" class="block text-xs font-mono font-bold text-slate-200 mb-1.5 leading-relaxed">
                        Descrição do orçamento com especificação em anexo do produto/equipamento ou serviço, inserindo quantitativos. *
                    </label>
                    <textarea name="descricao" id="descricao" rows="5" required placeholder="Insira aqui detalhadamente a descrição dos itens, equipamentos, serviços semafóricos, instalações elétricas, monitoramento ou quantitativos necessários para o processo..." class="w-full bg-foco-navy-900 border border-white/10 rounded-2xl p-4 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500 transition leading-relaxed">{{ old('descricao') }}</textarea>
                    @error('descricao')
                        <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- BOTÃO DE ENVIO -->
                <div class="pt-4 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <span class="text-xs text-slate-400 font-mono">
                        Seus dados serão encaminhados para a equipe técnica da FOCO.
                    </span>

                    <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition shadow-glow-yellow flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-foco-navy-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        <span>Enviar Formulário</span>
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>
@endsection

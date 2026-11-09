@extends('site.layout')

@section('title', 'Formulário Oficial de Contato & Orçamentos | Foco Sinalização')

@section('content')
<div class="py-14 bg-foco-navy-950 relative overflow-hidden" x-data="{
    assuntoSelecionado: '{{ old('assunto', $assuntoPredefinido ?: (auth()->check() ? 'ORÇAMENTO COMPRA DIRETA' : 'QUESTIONAMENTO/SOLICITAÇÃO/OUTROS')) }}',
    isLoggedIn: {{ auth()->check() ? 'true' : 'false' }},
    showLoginAlert: false,
    selecionarAssunto(opcao) {
        if ((opcao === 'ORÇAMENTO COMPRA DIRETA' || opcao === 'ORÇAMENTO PARA MONTAR PROCESSO') && !this.isLoggedIn) {
            this.showLoginAlert = true;
            this.assuntoSelecionado = opcao;
        } else {
            this.showLoginAlert = false;
            this.assuntoSelecionado = opcao;
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
                <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white/5 hover:bg-white/10 text-xs font-mono text-foco-yellow-400 border border-foco-yellow-500/30 transition self-start sm:self-auto">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    <span>Fazer Login para Orçamentos</span>
                </a>
                @endif
            </div>

            <!-- Banner Informativo quando visitante seleciona opção de Orçamento -->
            <div x-show="showLoginAlert && !isLoggedIn" x-transition class="mb-6 p-4 rounded-2xl bg-amber-500/15 border-2 border-amber-500/50 text-amber-200 text-xs font-mono space-y-2">
                <div class="flex items-center gap-2 font-bold text-amber-300">
                    <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>ATENÇÃO: LOGIN OBRIGATÓRIO PARA ORÇAMENTO</span>
                </div>
                <p class="leading-relaxed">
                    Conforme as diretrizes da FOCO, <strong>apenas usuários autorizados e cadastrados com login e senha</strong> podem solicitar orçamentos (Compra Direta ou Montar Processo).
                </p>
                <div class="pt-1">
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider bg-foco-yellow-500 text-foco-navy-950 hover:bg-foco-yellow-400 transition shadow-glow-yellow font-sans">
                        <span>Acessar Tela de Login Agora</span>
                        <span>→</span>
                    </a>
                </div>
            </div>

            <form action="{{ route('site.contato.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

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
                    <div class="relative flex items-center justify-center w-full">
                        <label for="arquivo" class="flex flex-col items-center justify-center w-full h-28 border-2 border-white/10 border-dashed rounded-2xl cursor-pointer bg-foco-navy-900/60 hover:bg-foco-navy-900 hover:border-foco-yellow-500/50 transition group">
                            <div class="flex flex-col items-center justify-center pt-3 pb-3">
                                <svg class="w-7 h-7 mb-1.5 text-slate-400 group-hover:text-foco-yellow-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                <p class="text-xs text-slate-300"><span class="font-bold text-foco-yellow-400">Clique para anexar</span> planilha, projeto ou documento</p>
                                <p class="text-[11px] text-slate-500 mt-0.5">Formatos: XLSX, XLS, CSV, PDF, DOC, DOCX ou Imagens (máx. 20MB)</p>
                            </div>
                            <input id="arquivo" name="arquivo" type="file" class="hidden" />
                        </label>
                    </div>
                    @error('arquivo')
                        <p class="text-rose-400 text-xs font-mono mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- 7. ASSUNTO (CONFORME FOTO) -->
                <div class="pt-4 border-t border-white/10 space-y-3">
                    <label class="block text-xs font-mono font-black text-foco-yellow-400 uppercase tracking-widest">
                        ASSUNTO: *
                    </label>

                    <div class="space-y-2.5">
                        <!-- Opção 1: ORÇAMENTO COMPRA DIRETA -->
                        <label @click="selecionarAssunto('ORÇAMENTO COMPRA DIRETA')" class="cursor-pointer relative p-3.5 rounded-2xl border transition flex items-center justify-between"
                            :class="assuntoSelecionado === 'ORÇAMENTO COMPRA DIRETA' ? 'bg-foco-yellow-500/15 border-foco-yellow-500 text-white shadow-glow-yellow' : 'bg-foco-navy-900 border-white/10 text-slate-300 hover:border-white/30'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="assunto" value="ORÇAMENTO COMPRA DIRETA" class="sr-only" x-model="assuntoSelecionado" required>
                                <span class="font-mono text-foco-yellow-400 font-bold">➤</span>
                                <span class="text-xs sm:text-sm font-bold uppercase tracking-wide">ORÇAMENTO COMPRA DIRETA</span>
                            </div>
                            <span class="font-mono text-xs text-slate-400" :class="assuntoSelecionado === 'ORÇAMENTO COMPRA DIRETA' ? 'text-foco-yellow-400 font-bold' : ''">( <span x-text="assuntoSelecionado === 'ORÇAMENTO COMPRA DIRETA' ? '✔' : ' '"></span> )</span>
                        </label>

                        <!-- Opção 2: ORÇAMENTO PARA MONTAR PROCESSO -->
                        <label @click="selecionarAssunto('ORÇAMENTO PARA MONTAR PROCESSO')" class="cursor-pointer relative p-3.5 rounded-2xl border transition flex items-center justify-between"
                            :class="assuntoSelecionado === 'ORÇAMENTO PARA MONTAR PROCESSO' ? 'bg-purple-500/15 border-purple-400 text-white shadow-lg' : 'bg-foco-navy-900 border-white/10 text-slate-300 hover:border-white/30'">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="assunto" value="ORÇAMENTO PARA MONTAR PROCESSO" class="sr-only" x-model="assuntoSelecionado" required>
                                <span class="font-mono text-purple-400 font-bold">➤</span>
                                <span class="text-xs sm:text-sm font-bold uppercase tracking-wide">ORÇAMENTO PARA MONTAR PROCESSO</span>
                            </div>
                            <span class="font-mono text-xs text-slate-400" :class="assuntoSelecionado === 'ORÇAMENTO PARA MONTAR PROCESSO' ? 'text-purple-400 font-bold' : ''">( <span x-text="assuntoSelecionado === 'ORÇAMENTO PARA MONTAR PROCESSO' ? '✔' : ' '"></span> )</span>
                        </label>

                        <!-- Opção 3: QUESTIONAMENTO/SOLICITAÇÃO/OUTROS -->
                        <label @click="selecionarAssunto('QUESTIONAMENTO/SOLICITAÇÃO/OUTROS')" class="cursor-pointer relative p-3.5 rounded-2xl border transition flex items-center justify-between"
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

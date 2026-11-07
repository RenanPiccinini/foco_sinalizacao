@extends('site.layout')

@section('title', 'Contato e Plantão Operacional 24h | Foco Sinalização')

@section('content')
<div class="py-16 bg-foco-navy-950 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Cabeçalho -->
        <div class="text-center max-w-3xl mx-auto mb-16">
            <span class="text-xs font-mono font-bold tracking-widest text-foco-yellow-400 uppercase bg-foco-yellow-500/10 px-3 py-1 rounded-full border border-foco-yellow-500/30">
                Atendimento Imediato
            </span>
            <h1 class="text-3xl sm:text-5xl font-black text-white mt-4 tracking-tight">
                Fale com a Foco Sinalização
            </h1>
            <p class="text-slate-400 mt-4 text-base leading-relaxed">
                Central de engenharia, plantão para órgãos de trânsito, concessionárias de rodovias e prefeituras.
            </p>
            <div class="w-24 h-1 bg-foco-yellow-500 mx-auto mt-6 rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Cards de Contato Direto -->
            <div class="lg:col-span-5 space-y-6">
                <!-- Card Plantão 24h -->
                <div class="glass-panel-glow p-8 rounded-3xl border border-foco-yellow-500/30">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-foco-yellow-500/20 text-foco-yellow-400 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                        </div>
                        <div>
                            <span class="text-xs font-mono text-foco-yellow-400 uppercase tracking-wider block">Plantão Técnico 24 Horas</span>
                            <h3 class="text-xl font-bold text-white">Central de Emergência Viária</h3>
                        </div>
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed mb-4">
                        Linha direta para despachos de equipes em emergências semafóricas, quedas de postes ou panes elétricas.
                    </p>
                    <div class="p-3.5 rounded-xl bg-foco-navy-950 font-mono text-sm space-y-1">
                        <p class="text-foco-yellow-400 font-bold text-lg">0800 000 0000</p>
                        <p class="text-slate-300">WhatsApp Plantão: (51) 99000-0000</p>
                    </div>
                </div>

                <!-- Card Chamados Online -->
                <div class="glass-card p-6 rounded-3xl space-y-3">
                    <span class="text-xs font-mono font-bold text-foco-green-400 uppercase tracking-wider block">Canal Digital Oficial</span>
                    <h4 class="text-lg font-bold text-white">Abertura de Chamados pelo Portal</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">
                        Para registrar uma nova ocorrência com acompanhamento em tempo real, utilize nosso menu de chamados.
                    </p>
                    <a href="{{ route('site.chamados') }}" class="inline-flex items-center gap-2 text-xs font-bold text-foco-yellow-400 hover:text-white transition">
                        <span>Acessar Tela de Chamados</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>

                <!-- Card Dados Corporativos -->
                <div class="glass-card p-6 rounded-3xl space-y-2 text-xs text-slate-400">
                    <h4 class="text-sm font-bold text-white mb-2">Foco Sinalização e Sistemas Inteligentes LTDA</h4>
                    <p><strong class="text-slate-300">Atividade:</strong> Engenharia e Sinalização Semafórica, ITS, Centrais de Nuvem e Autonomia Energética.</p>
                    <p><strong class="text-slate-300">Cobertura:</strong> Santa Catarina, Rio Grande do Sul e Rodovias Federais.</p>
                    <p><strong class="text-slate-300">E-mail:</strong> contato@focosinalizacao.com.br</p>
                </div>
            </div>

            <!-- Formulário de Contato / Solicitação de Proposta -->
            <div class="lg:col-span-7">
                <div class="glass-panel p-8 sm:p-10 rounded-3xl border border-white/10 shadow-2xl">
                    <h2 class="text-2xl font-bold text-white mb-2">Envie uma Mensagem para Nossa Engenharia</h2>
                    <p class="text-xs text-slate-400 mb-6">Solicitações de propostas para licitações, projetos de onda verde, orçamentos ou consultoria em rodovias.</p>

                    <form onsubmit="alert('Obrigado! Sua mensagem foi encaminhada à equipe de engenharia da Foco Sinalização.'); return false;" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-slate-300 mb-1">Seu Nome / Cargo *</label>
                                <input type="text" required placeholder="Ex: Eng. Roberto Santos" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-300 mb-1">Prefeitura ou Empresa *</label>
                                <input type="text" required placeholder="Ex: Secretaria de Trânsito / DTT" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-slate-300 mb-1">E-mail de Contato *</label>
                                <input type="email" required placeholder="roberto@orgao.gov.br" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-slate-300 mb-1">Telefone / WhatsApp *</label>
                                <input type="text" required placeholder="(00) 00000-0000" class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Assunto de Interesse *</label>
                            <select class="w-full bg-foco-navy-900 border border-white/10 rounded-xl px-4 py-2.5 text-sm text-white focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500">
                                <option>Implantação Semafórica Turnkey (Postes, Cabos, Semáforos)</option>
                                <option>Central Semafórica WEB DIGICON em Nuvem Segura</option>
                                <option>Inteligência Adaptativa (ITS) & Visão Computacional</option>
                                <option>Nobreaks Senoidais & Baterias de Lítio (LiFePO4)</option>
                                <option>Consultoria Semafórica em Obras e Rodovias (BRs)</option>
                                <option>Outros Assuntos</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-300 mb-1">Mensagem ou Detalhes do Projeto *</label>
                            <textarea rows="4" required placeholder="Conte-nos sobre a demanda da sua cidade ou rodovia..." class="w-full bg-foco-navy-900 border border-white/10 rounded-xl p-4 text-sm text-white placeholder-slate-500 focus:border-foco-yellow-500 focus:ring-1 focus:ring-foco-yellow-500"></textarea>
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full sm:w-auto px-8 py-3.5 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition shadow-glow-yellow">
                                Enviar Mensagem
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection


@extends('site.layout')

@section('title', 'Contato Oficial via WhatsApp | Foco Sinalização e Sistemas Inteligentes')

@section('content')
<div class="py-16 bg-foco-navy-950 relative overflow-hidden">
    <!-- Efeitos de iluminação verde WhatsApp e âmbar semafórico -->
    <div data-parallax-speed="0.2" class="absolute top-10 right-10 w-96 h-96 bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div data-parallax-speed="0.1" class="absolute bottom-10 left-10 w-96 h-96 bg-foco-yellow-500/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Cabeçalho Principal -->
        <div class="text-center max-w-3xl mx-auto mb-14">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 text-xs font-mono font-bold mb-3 shadow-glow-green">
                <span class="w-2.5 h-2.5 rounded-full bg-[#25D366] animate-ping"></span>
                <span>Canal Exclusivo de Atendimento via WhatsApp</span>
            </div>
            <h1 class="text-3xl sm:text-5xl font-black text-white mt-2 tracking-tight">
                Fale com a Foco Sinalização
            </h1>
            <p class="text-slate-300 mt-4 text-base sm:text-lg leading-relaxed">
                Nosso atendimento direto a prefeituras, órgãos de trânsito, concessionárias e cidadãos é centralizado <strong>exclusivamente pelo WhatsApp</strong> para garantir resposta imediata e despacho ágil de equipes.
            </p>
            <div class="w-24 h-1 bg-[#25D366] mx-auto mt-6 rounded-full shadow-lg shadow-emerald-500/50"></div>
        </div>

        <!-- Card Principal em Destaque: Contato Oficial WhatsApp -->
        <div class="max-w-3xl mx-auto mb-14">
            <div class="glass-panel-glow p-8 sm:p-12 rounded-3xl border-2 border-emerald-500/50 shadow-2xl relative overflow-hidden text-center">
                <!-- Luz de fundo interna -->
                <div class="absolute -top-24 -right-24 w-72 h-72 rounded-full bg-emerald-500/20 blur-3xl pointer-events-none"></div>

                <div class="relative z-10 space-y-6">
                    <!-- Ícone Oficial do WhatsApp com Efeito de Pulso -->
                    <div class="inline-flex relative">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl bg-[#25D366] text-white flex items-center justify-center shadow-2xl shadow-emerald-500/50 mx-auto transform hover:scale-105 transition duration-300">
                            <svg class="w-12 h-12 sm:w-14 sm:h-14 fill-current" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                        </div>
                        <span class="absolute -top-1 -right-1 flex h-5 w-5">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-300 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-5 w-5 bg-emerald-400 border-2 border-foco-navy-950"></span>
                        </span>
                    </div>

                    <div>
                        <span class="text-xs font-mono uppercase tracking-widest text-slate-400 font-bold block">
                            Plantão Viário & Operações 24 Horas
                        </span>
                        <h2 class="text-3xl sm:text-5xl font-black text-white font-mono mt-1 tracking-wider">
                            (51) 99294-1111
                        </h2>
                        <p class="text-xs sm:text-sm text-emerald-400 font-medium mt-2 flex items-center justify-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-[#25D366] animate-pulse"></span>
                            <span>Equipe de Engenharia e Campo Conectada Agora</span>
                        </p>
                    </div>

                    <!-- Botão de Ação Direta no WhatsApp -->
                    <div class="pt-2">
                        <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+gostaria+de+falar+com+a+equipe+da+Foco+Sinaliza%C3%A7%C3%A3o"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl font-black text-sm uppercase tracking-wider bg-[#25D366] hover:bg-[#20ba5a] text-white shadow-2xl shadow-emerald-500/40 hover:scale-105 active:scale-95 transition-all">
                            <svg class="w-6 h-6 fill-current shrink-0" viewBox="0 0 24 24">
                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                            </svg>
                            <span>Conversar no WhatsApp Agora</span>
                        </a>
                    </div>

                    <div class="pt-4 border-t border-white/10 text-xs font-mono text-slate-400 flex flex-wrap items-center justify-center gap-3">
                        <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Plantão 24/7</span>
                        <span>•</span>
                        <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Resposta em Minutos</span>
                        <span>•</span>
                        <span class="flex items-center gap-1.5"><span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Despacho Técnico Imediato</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3 Opções de Contato Rápido Direto no WhatsApp -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
            
            <!-- Opção 1: Emergência Viária & Plantão -->
            <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+preciso+de+suporte+de+emerg%C3%AAncia+no+Plant%C3%A3o+Vi%C3%A1rio"
               target="_blank"
               rel="noopener noreferrer"
               class="glass-card p-6 rounded-3xl border-t-2 border-t-rose-500 hover:border-emerald-500 transition group space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-rose-500/10 text-rose-400 flex items-center justify-center group-hover:bg-[#25D366]/20 group-hover:text-[#25D366] transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <span class="text-xs font-mono font-bold text-rose-400 uppercase tracking-wider block">Plantão 24h</span>
                <h3 class="text-lg font-bold text-white group-hover:text-[#25D366] transition">Central de Emergência Viária</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Semáforos apagados, pane elétrica, intermitente amarelo de falha ou colisões contra postes.
                </p>
                <span class="text-xs font-mono font-bold text-[#25D366] inline-flex items-center gap-1">
                    Chamar no WhatsApp →
                </span>
            </a>

            <!-- Opção 2: Engenharia & Prefeituras -->
            <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+gostaria+de+solicitar+uma+proposta+t%C3%A9cnica+%2F+or%C3%A7amento+para+engenharia+semaf%C3%B3rica"
               target="_blank"
               rel="noopener noreferrer"
               class="glass-card p-6 rounded-3xl border-t-2 border-t-cyan-400 hover:border-emerald-500 transition group space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-cyan-500/10 text-cyan-400 flex items-center justify-center group-hover:bg-[#25D366]/20 group-hover:text-[#25D366] transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <span class="text-xs font-mono font-bold text-cyan-400 uppercase tracking-wider block">Projetos & Licitações</span>
                <h3 class="text-lg font-bold text-white group-hover:text-[#25D366] transition">Prefeituras & Órgãos de Trânsito</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Implantações completas turnkey, projetos de onda verde, centrais DIGICON em nuvem e nobreaks LiFePO4.
                </p>
                <span class="text-xs font-mono font-bold text-[#25D366] inline-flex items-center gap-1">
                    Solicitar Proposta via WhatsApp →
                </span>
            </a>

            <!-- Opção 3: Concessões & Rodovias Federais -->
            <a href="https://wa.me/5551992941111?text=Ol%C3%A1%2C+preciso+de+informa%C3%A7%C3%B5es+sobre+sinaliza%C3%A7%C3%A3o+para+concession%C3%A1ria+%2F+rodovia"
               target="_blank"
               rel="noopener noreferrer"
               class="glass-card p-6 rounded-3xl border-t-2 border-t-amber-400 hover:border-emerald-500 transition group space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-400 flex items-center justify-center group-hover:bg-[#25D366]/20 group-hover:text-[#25D366] transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
                </div>
                <span class="text-xs font-mono font-bold text-amber-400 uppercase tracking-wider block">Rodovias Federais</span>
                <h3 class="text-lg font-bold text-white group-hover:text-[#25D366] transition">Concessionárias Viárias</h3>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Sistemas móveis de contingência, controle pare & siga em obras de encostas e interseções de alto tráfego.
                </p>
                <span class="text-xs font-mono font-bold text-[#25D366] inline-flex items-center gap-1">
                    Falar com Especialista →
                </span>
            </a>

        </div>

        <!-- Banner de Acesso à Central de Chamados (Para quem deseja abrir chamado com Protocolo) -->
        <div class="glass-panel p-6 sm:p-8 rounded-3xl border border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="space-y-1 text-center sm:text-left">
                <span class="text-xs font-mono text-foco-yellow-400 font-bold uppercase">Precisa de Protocolo Formal?</span>
                <h4 class="text-base sm:text-lg font-bold text-white">Prefere registrar uma Ordem de Serviço pelo Portal?</h4>
                <p class="text-xs text-slate-400">Você também pode abrir um chamado oficial com código de acompanhamento pelo nosso menu de chamados.</p>
            </div>
            <a href="{{ route('site.chamados') }}" class="px-6 py-3 rounded-xl font-bold text-xs uppercase tracking-wider bg-foco-yellow-500 hover:bg-foco-yellow-400 text-foco-navy-950 transition shadow-glow-yellow shrink-0">
                Acessar Menu "Chamados" →
            </a>
        </div>

    </div>
</div>
@endsection

<x-app-layout>
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-white/10">
            <div>
                <span class="text-xs font-mono text-cyan-400 uppercase tracking-widest font-bold">Cybersecurity & Cloud</span>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-white mt-1">Central Semafórica WEB DIGICON em Nuvem</h1>
                <p class="text-xs text-slate-400 mt-1">Gestão centralizada de segurança, trilhas de auditoria (Audit Trail) e políticas de acesso RBAC.</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1.5 rounded-xl bg-cyan-500/10 text-cyan-400 border border-cyan-500/30 text-xs font-mono">
                    WAF Ativo • Criptografia TLS 1.3
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="glass-panel p-6 rounded-3xl border border-white/10 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-cyan-400/10 text-cyan-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Segurança RBAC</h3>
                        <p class="text-xs text-slate-400 font-mono">Perfis de Acesso Restritos</p>
                    </div>
                </div>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Controle de Acesso Baseado em Perfis. Engenheiros e operadores possuem níveis restritos de permissão para alteração de tempos semafóricos.
                </p>
                <div class="p-3 rounded-xl bg-foco-navy-900 border border-white/5 font-mono text-[11px] text-slate-300">
                    <span class="text-foco-green-400 block font-bold">✓ 12 Operadores Credenciados</span>
                    <span class="text-slate-400">Autenticação multifator ativada</span>
                </div>
            </div>

            <div class="glass-panel p-6 rounded-3xl border border-white/10 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-foco-yellow-500/10 text-foco-yellow-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Audit Trail Digital</h3>
                        <p class="text-xs text-slate-400 font-mono">Trilha Inviolável</p>
                    </div>
                </div>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Cada ajuste de ciclo, alteração de fase verde ou intervenção de emergência é gravado com carimbo temporal criptográfico irrefutável.
                </p>
                <div class="p-3 rounded-xl bg-foco-navy-900 border border-white/5 font-mono text-[11px] text-slate-300">
                    <span class="text-foco-yellow-400 block font-bold">1.482 Registros neste mês</span>
                    <span class="text-slate-400">100% em conformidade com o Contran</span>
                </div>
            </div>

            <div class="glass-panel p-6 rounded-3xl border border-white/10 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-400/10 text-emerald-400 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">App Mobile Agentes</h3>
                        <p class="text-xs text-slate-400 font-mono">DTT & Guarda de Trânsito</p>
                    </div>
                </div>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Equipes de campo acionam planos de contingência e abrem ordens de serviço georreferenciadas diretamente pelo smartphone.
                </p>
                <div class="p-3 rounded-xl bg-foco-navy-900 border border-white/5 font-mono text-[11px] text-slate-300">
                    <span class="text-emerald-400 block font-bold">28 Agentes Conectados Hoje</span>
                    <span class="text-slate-400">Tempo médio de resposta: 18 min</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


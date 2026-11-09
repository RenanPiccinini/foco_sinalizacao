<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use App\Services\EvolutionWhatsAppService;
use Illuminate\Http\Request;

class SiteController
{
    /**
     * Página Inicial do Site.
     */
    public function index()
    {
        $municipiosSC = [
            'Balneário Camboriú – SC',
            'Balneário Piçarras – SC',
        ];

        $municipiosRS = [
            'Campo Bom – RS',
            'Canoas – RS',
            'Entre-Ijuís – RS',
            'Erechim – RS',
            'Guaíba – RS',
            'Guaporé – RS',
            'Ivoti – RS',
            'Lajeado – RS',
            'Nova Hartz – RS',
            'Novo Hamburgo – RS',
            'Palmeira das Missões – RS',
            'Passo Fundo – RS',
            'Portão – RS',
            'Rosário do Sul – RS',
            'Santo Antônio da Patrulha – RS',
            'Torres – RS',
            'Tramandaí – RS',
            'Três Coroas – RS',
            'Viamão – RS',
        ];

        $rodovias = [
            'Rodovia BR 101',
            'Rodovia BR 116',
            'Rodovia BR 153',
            'Rodovia BR 290',
        ];

        $parceiros = [
            ['nome' => 'Digicon S/A', 'tipo' => 'Controle Eletrônico para Mecânica'],
            ['nome' => 'Sinaway', 'tipo' => 'Comércio de Sinalização'],
            ['nome' => 'Signasul', 'tipo' => 'Engenharia de Sinalização'],
            ['nome' => 'Contransin', 'tipo' => 'Indústria e Comércio'],
            ['nome' => 'Pavicon', 'tipo' => 'Pavimentações Ltda'],
            ['nome' => 'Sinaltran', 'tipo' => 'Sinalizações Viárias'],
            ['nome' => 'LCM Construtora', 'tipo' => 'Obras & Infraestrutura'],
            ['nome' => 'Chiorri Informática', 'tipo' => 'Consultoria em Tráfego'],
            ['nome' => 'TR Sul Engenharia', 'tipo' => 'Projetos de Mobilidade'],
        ];

        $ultimosChamados = Chamado::latest('data_hora_abertura')->take(3)->get();

        return view('site.home', compact('municipiosSC', 'municipiosRS', 'rodovias', 'parceiros', 'ultimosChamados'));
    }

    /**
     * Página dedicada ao Menu de Chamados do Cliente.
     */
    public function chamados(Request $request)
    {
        $protocoloBusca = $request->query('protocolo');
        $chamadoBuscado = null;

        if ($protocoloBusca) {
            $chamadoBuscado = Chamado::where('protocolo', trim($protocoloBusca))->first();
        }

        $todosChamados = Chamado::latest('data_hora_abertura')->get();
        $tiposDefeitos = Chamado::DEFEITOS_RECLAMADOS;

        return view('site.chamados', compact('chamadoBuscado', 'protocoloBusca', 'todosChamados', 'tiposDefeitos'));
    }

    /**
     * Processa a abertura de um novo chamado no site.
     * Conforme tabela oficial de defeitos reclamados:
     * 01 - AP – Amarelo Piscante
     * 02 - FA – Fora de Ação (todos semáforos desligados)
     * 03 - FA – Fora de Ação (Semáforo desligado parcialmente)
     * 04 - Semáforo - abalroado/pendurado/desalinhado/danificado
     * 05 - Semáforo - com duas cores/travado
     * 06 - Acidente – Poste abalroado/danificado/cabos na via
     * 07 - Cruzamento sem sincronismo/ajuste de tempos
     * 08 - Botoeira de pedestre com defeito/danificada/sem funcionamento
     * E já pega horário de abertura automaticamente
     */
    public function storeChamado(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|string',
            'nome_solicitante' => 'required|string|max:120',
            'telefone_contato' => 'required|string|max:30',
            'local' => 'required|string|max:255',
            'defeito' => 'nullable|string|max:2000',
            'observacao' => 'nullable|string|max:2000',
        ]);

        $tipoNormalizado = Chamado::formatarTipo($validated['tipo']);
        $defeitoFinal = ! empty($validated['defeito']) ? $validated['defeito'] : $tipoNormalizado;

        $protocolo = Chamado::gerarProtocolo();

        $chamado = Chamado::create([
            'protocolo' => $protocolo,
            'tipo' => $tipoNormalizado,
            'nome_solicitante' => $validated['nome_solicitante'],
            'telefone_contato' => $validated['telefone_contato'],
            'local' => $validated['local'],
            'defeito' => $defeitoFinal,
            'observacao' => $validated['observacao'] ?? null,
            'data_hora_abertura' => now(), // Pega horário de abertura automaticamente
            'status' => 'Aberto',
            'historico' => [
                [
                    'data' => now()->format('d/m/Y H:i'),
                    'evento' => "Chamado registrado no site pelo cliente (Defeito: {$tipoNormalizado}).",
                    'usuario' => $validated['nome_solicitante'],
                ],
            ],
        ]);

        // Dispara notificação no WhatsApp do dono da FOCO via Evolution API
        app(EvolutionWhatsAppService::class)->notificarNovoChamado($chamado);

        return redirect()->route('site.chamados', ['protocolo' => $chamado->protocolo])
            ->with('success', "Chamado aberto com sucesso! Guarde o seu protocolo: {$chamado->protocolo}")
            ->with('novo_protocolo', $chamado->protocolo);
    }

    /**
     * Página de Soluções e Engenharia.
     */
    public function solucoes()
    {
        return view('site.solucoes');
    }

    /**
     * Página Sobre a Empresa.
     */
    public function sobre()
    {
        return view('site.sobre');
    }

    /**
     * Página de Cidades Atendidas.
     */
    public function cidades()
    {
        return view('site.cidades');
    }

    /**
     * Página de Contato e Plantão 24h.
     */
    public function contato()
    {
        return view('site.contato');
    }
}

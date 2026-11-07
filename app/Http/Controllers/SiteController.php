<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
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

        return view('site.chamados', compact('chamadoBuscado', 'protocoloBusca', 'todosChamados'));
    }

    /**
     * Processa a abertura de um novo chamado no site.
     * Conforme regra:
     * Tipo de chamado selecionando: AP, FA, Acidente ou vermelho queimado
     * Nome solicitante
     * Número para contato
     * Local
     * Defeito
     * Observação
     * E já pega horário de abertura automaticamente
     */
    public function storeChamado(Request $request)
    {
        $validated = $request->validate([
            'tipo' => 'required|string|in:AP,FA,Acidente,Vermelho Queimado',
            'nome_solicitante' => 'required|string|max:120',
            'telefone_contato' => 'required|string|max:30',
            'local' => 'required|string|max:255',
            'defeito' => 'required|string|max:2000',
            'observacao' => 'nullable|string|max:2000',
        ]);

        $protocolo = Chamado::gerarProtocolo();

        $chamado = Chamado::create([
            'protocolo' => $protocolo,
            'tipo' => $validated['tipo'],
            'nome_solicitante' => $validated['nome_solicitante'],
            'telefone_contato' => $validated['telefone_contato'],
            'local' => $validated['local'],
            'defeito' => $validated['defeito'],
            'observacao' => $validated['observacao'] ?? null,
            'data_hora_abertura' => now(), // E já pega horário de abertura automaticamente
            'status' => 'Aberto',
            'historico' => [
                [
                    'data' => now()->format('d/m/Y H:i'),
                    'evento' => "Chamado registrado no site pelo cliente (Tipo: {$validated['tipo']}).",
                    'usuario' => $validated['nome_solicitante'],
                ]
            ],
        ]);

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


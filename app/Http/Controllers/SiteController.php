<?php

namespace App\Http\Controllers;

use App\Services\ChamadoService;
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

        $ultimosChamados = array_slice(ChamadoService::all(), 0, 3);

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
            $chamadoBuscado = ChamadoService::find(trim($protocoloBusca));
        }

        $todosChamados = ChamadoService::all();

        return view('site.chamados', compact('chamadoBuscado', 'protocoloBusca', 'todosChamados'));
    }

    /**
     * Processa a abertura de um novo chamado no site.
     */
    public function storeChamado(Request $request)
    {
        $validated = $request->validate([
            'solicitante_nome' => 'required|string|max:120',
            'solicitante_orgao' => 'required|string|max:120',
            'solicitante_telefone' => 'required|string|max:30',
            'solicitante_email' => 'required|email|max:120',
            'municipio' => 'required|string|max:100',
            'localizacao' => 'required|string|max:200',
            'ponto_referencia' => 'nullable|string|max:200',
            'categoria' => 'required|string|max:100',
            'prioridade' => 'required|string|in:Baixa,Média,Alta,Crítica',
            'titulo' => 'required|string|max:150',
            'descricao' => 'required|string|max:1500',
            'equipamento_afetado' => 'nullable|string|max:150',
        ]);

        $chamado = ChamadoService::create($validated);

        return redirect()->route('site.chamados', ['protocolo' => $chamado['protocolo']])
            ->with('success', "Chamado aberto com sucesso! Guarde o seu protocolo: {$chamado['protocolo']}")
            ->with('novo_protocolo', $chamado['protocolo']);
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


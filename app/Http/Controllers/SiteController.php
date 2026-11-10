<?php

namespace App\Http\Controllers;

use App\Models\Chamado;
use App\Models\Contato;
use App\Services\EvolutionWhatsAppService;
use App\Services\OrcamentoMailerService;
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

        $parceiros = $this->getClientesParceiros();
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
     * Página de Cidades Atendidas e Clientes/Parceiros.
     */
    public function cidades()
    {
        $parceiros = $this->getClientesParceiros();

        return view('site.cidades', compact('parceiros'));
    }

    /**
     * Página de Contato Oficial com o Formulário Institucional.
     */
    public function contato(Request $request)
    {
        $assuntoPredefinido = $request->query('assunto', '');

        return view('site.contato', [
            'assuntoPredefinido' => $assuntoPredefinido,
            'isOrcamento' => false,
        ]);
    }

    /**
     * Tela dedicada à Solicitação de Orçamento (Exclusiva para Usuários Autenticados).
     */
    public function orcamento(Request $request)
    {
        $assuntoPredefinido = $request->query('assunto', Contato::ASSUNTO_COMPRA_DIRETA);

        return view('site.contato', [
            'assuntoPredefinido' => $assuntoPredefinido,
            'isOrcamento' => true,
        ]);
    }

    /**
     * Processa o envio do formulário de contato / solicitação de orçamento.
     * Dados conforme padrão oficial:
     * EMPRESA, RESPONSÁVEL, FONE, E-MAIL, ENDEREÇO, CNPJ, ANEXAR PLANILHA/ARQUIVO
     * ASSUNTO: ORÇAMENTO COMPRA DIRETA / ORÇAMENTO PARA MONTAR PROCESSO / QUESTIONAMENTO/SOLICITAÇÃO/OUTROS
     * Descrição do orçamento com especificação em anexo do produto/equipamento ou serviço, inserindo quantitativos.
     */
    public function storeContato(Request $request)
    {
        $validated = $request->validate([
            'empresa' => ['required', 'string', 'max:180'],
            'responsavel' => ['required', 'string', 'max:120'],
            'fone' => ['required', 'string', 'max:40'],
            'email' => ['required', 'email', 'max:120'],
            'endereco' => ['required', 'string', 'max:255'],
            'cnpj' => ['required', 'string', 'max:30'],
            'assunto' => ['required', 'string', 'in:'.implode(',', Contato::ASSUNTOS)],
            'descricao' => ['required', 'string', 'max:8000'],
            'arquivo' => ['nullable', 'file', 'max:20480', 'extensions:pdf,xls,xlsx,xlsm,ods,csv,doc,docx,odt,txt,png,jpg,jpeg,webp,zip,rar'],
        ]);

        $arquivoPath = null;
        $arquivoNome = null;

        if ($request->hasFile('arquivo') && $request->file('arquivo')->isValid()) {
            $arquivoPath = $request->file('arquivo')->store('orcamentos', 'public');
            $arquivoNome = $request->file('arquivo')->getClientOriginalName();
        }

        $protocolo = Contato::gerarProtocolo();

        $contato = Contato::create([
            'protocolo' => $protocolo,
            'user_id' => auth()->id(),
            'empresa' => $validated['empresa'],
            'responsavel' => $validated['responsavel'],
            'fone' => $validated['fone'],
            'email' => $validated['email'],
            'endereco' => $validated['endereco'],
            'cnpj' => $validated['cnpj'],
            'arquivo_path' => $arquivoPath,
            'arquivo_nome' => $arquivoNome,
            'assunto' => $validated['assunto'],
            'descricao' => $validated['descricao'],
            'status' => 'Novo',
            'ip' => $request->ip(),
        ]);

        app(OrcamentoMailerService::class)->enviarSolicitacao($contato);

        $rotaRetorno = $request->input('_origin') === 'orcamento' ? 'site.orcamento' : 'site.contato';

        return redirect()->route($rotaRetorno)
            ->with('success', "Solicitação registrada com sucesso! Protocolo gerado: {$contato->protocolo}")
            ->with('protocolo_contato', $contato->protocolo)
            ->with('novo_protocolo_contato', $contato->protocolo);
    }

    /**
     * Lista ordenada alfabeticamente (A–Z) de clientes corporativos e parceiros.
     *
     * @return list<array{nome: string, tipo: string}>
     */
    private function getClientesParceiros(): array
    {
        return [
            ['nome' => 'Chiorri Informática', 'tipo' => 'Consultoria em Tráfego'],
            ['nome' => 'Contransin', 'tipo' => 'Indústria e Comércio'],
            ['nome' => 'LCM Construtora', 'tipo' => 'Obras & Infraestrutura'],
            ['nome' => 'Pavicon', 'tipo' => 'Pavimentações Ltda'],
            ['nome' => 'Signasul', 'tipo' => 'Engenharia de Sinalização'],
            ['nome' => 'Sinaltran', 'tipo' => 'Sinalizações Viárias'],
            ['nome' => 'Sinaway', 'tipo' => 'Comércio de Sinalização'],
            ['nome' => 'TR Sul Engenharia', 'tipo' => 'Projetos de Mobilidade'],
        ];
    }
}

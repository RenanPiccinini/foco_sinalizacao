<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chamado;
use App\Services\EvolutionWhatsAppService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChamadoController extends Controller
{
    /**
     * Lista todos os chamados com filtros e busca.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $tipo = $request->query('tipo');
        $busca = $request->query('busca');

        $query = Chamado::query()->latest('data_hora_abertura');

        if ($status && $status !== 'todos') {
            $query->where('status', $status);
        }

        if ($tipo && $tipo !== 'todos') {
            $tipoBuscado = Chamado::formatarTipo($tipo);
            $query->where(function ($q) use ($tipo, $tipoBuscado) {
                $q->where('tipo', $tipo)
                    ->orWhere('tipo', $tipoBuscado)
                    ->orWhere('tipo', 'like', '%'.$tipo.'%');
            });
        }

        if ($busca) {
            $term = '%'.trim($busca).'%';
            $query->where(function ($q) use ($term) {
                $q->where('protocolo', 'like', $term)
                    ->orWhere('nome_solicitante', 'like', $term)
                    ->orWhere('telefone_contato', 'like', $term)
                    ->orWhere('local', 'like', $term)
                    ->orWhere('defeito', 'like', $term);
            });
        }

        $chamados = $query->get();
        $allTickets = Chamado::all();

        // Métricas
        $stats = [
            'total' => $allTickets->count(),
            'abertos' => $allTickets->where('status', 'Aberto')->count(),
            'em_atendimento' => $allTickets->where('status', 'Em Atendimento')->count(),
            'finalizados' => $allTickets->where('status', 'Finalizado')->count(),
            'ap' => $allTickets->filter(fn ($c) => str_contains($c->tipo, '01') || str_contains($c->tipo, 'Amarelo Piscante') || $c->tipo === 'AP')->count(),
            'fa' => $allTickets->filter(fn ($c) => str_contains($c->tipo, '02') || str_contains($c->tipo, '03') || str_contains($c->tipo, 'Fora de Ação') || $c->tipo === 'FA')->count(),
            'acidentes' => $allTickets->filter(fn ($c) => str_contains($c->tipo, '04') || str_contains($c->tipo, '06') || str_contains($c->tipo, 'Acidente') || str_contains($c->tipo, 'abalroado'))->count(),
            'outros' => $allTickets->filter(fn ($c) => ! str_contains($c->tipo, '01') && ! str_contains($c->tipo, '02') && ! str_contains($c->tipo, '03') && ! str_contains($c->tipo, '04') && ! str_contains($c->tipo, '06') && ! str_contains($c->tipo, 'Amarelo Piscante') && ! str_contains($c->tipo, 'Fora de Ação') && ! str_contains($c->tipo, 'Acidente') && ! str_contains($c->tipo, 'abalroado'))->count(),
        ];

        return view('admin.chamados.index', [
            'chamados' => $chamados,
            'stats' => $stats,
            'status' => $status ?? 'todos',
            'tipo' => $tipo ?? 'todos',
            'busca' => $busca ?? '',
            'tiposDefeitos' => Chamado::DEFEITOS_RECLAMADOS,
        ]);
    }

    /**
     * Exibe os detalhes de um chamado específico.
     */
    public function show(string $id)
    {
        $chamado = Chamado::find($id);

        if (! $chamado) {
            // Tenta localizar por protocolo caso passe protocolo em vez de ID
            $chamado = Chamado::where('protocolo', $id)->first();
        }

        if (! $chamado) {
            return redirect()->route('admin.chamados.index')->with('error', 'Chamado não encontrado.');
        }

        return view('admin.chamados.show', compact('chamado'));
    }

    /**
     * Criação de chamado interno diretamente pela equipe da central FOCO.
     */
    public function store(Request $request)
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
            'data_hora_abertura' => now(),
            'status' => 'Aberto',
            'historico' => [
                [
                    'data' => now()->format('d/m/Y H:i'),
                    'evento' => 'Chamado interno registrado pela Central de Operações FOCO.',
                    'usuario' => auth()->user()?->name ?? 'Central FOCO',
                ],
            ],
        ]);

        return redirect()->route('admin.chamados.show', $chamado->id)
            ->with('success', "Chamado interno {$chamado->protocolo} registrado com sucesso!");
    }

    /**
     * Atualiza o chamado ou finaliza pela FOCO.
     * Quando a FOCO finalizar informa:
     * - Conserto executado
     * - Horario execução
     * - Observação
     */
    public function update(Request $request, string $id)
    {
        $chamado = Chamado::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|string|in:Aberto,Em Atendimento,Finalizado',
            'conserto_executado' => 'nullable|string|max:2500',
            'data_hora_execucao' => 'nullable|date',
            'observacao_finalizacao' => 'nullable|string|max:2500',
            'tecnico_responsavel' => 'nullable|string|max:120',
        ]);

        $statusAnterior = $chamado->status;
        $novoStatus = $validated['status'];

        $chamado->status = $novoStatus;
        $chamado->tecnico_responsavel = $validated['tecnico_responsavel'] ?? $chamado->tecnico_responsavel;

        if ($novoStatus === 'Finalizado') {
            $chamado->conserto_executado = $validated['conserto_executado'] ?? $chamado->conserto_executado;
            $chamado->data_hora_execucao = $validated['data_hora_execucao'] ? Carbon::parse($validated['data_hora_execucao']) : now();
            $chamado->observacao_finalizacao = $validated['observacao_finalizacao'] ?? $chamado->observacao_finalizacao;

            $chamado->adicionarHistorico(
                'Chamado FINALIZADO pela FOCO. Conserto Executado: '.($chamado->conserto_executado ?: 'Serviço concluído com êxito.').' às '.$chamado->data_hora_execucao->format('d/m/Y H:i'),
                auth()->user()?->name ?? 'FOCO Engenharia'
            );

            // Dispara notificação no WhatsApp do solicitante via Evolution API
            app(EvolutionWhatsAppService::class)->notificarChamadoConcluido($chamado);
        } else {
            if ($statusAnterior !== $novoStatus) {
                $chamado->adicionarHistorico(
                    "Status alterado de {$statusAnterior} para {$novoStatus}.",
                    auth()->user()?->name ?? 'FOCO Engenharia'
                );
            }
        }

        $chamado->save();

        return back()->with('success', "Chamado {$chamado->protocolo} atualizado com sucesso!");
    }

    /**
     * Ação dedicada para o botão 'Concluir Chamado':
     * Define como Finalizado, registra conserto, horário de execução e
     * dispara automaticamente o WhatsApp para quem solicitou.
     */
    public function concluir(Request $request, string $id)
    {
        $chamado = Chamado::findOrFail($id);

        $validated = $request->validate([
            'conserto_executado' => 'required|string|max:2500',
            'data_hora_execucao' => 'nullable|date',
            'observacao_finalizacao' => 'nullable|string|max:2500',
            'tecnico_responsavel' => 'nullable|string|max:120',
        ]);

        $chamado->status = 'Finalizado';
        $chamado->conserto_executado = $validated['conserto_executado'];
        $chamado->data_hora_execucao = $validated['data_hora_execucao'] ? Carbon::parse($validated['data_hora_execucao']) : now();
        $chamado->observacao_finalizacao = $validated['observacao_finalizacao'] ?? null;
        $chamado->tecnico_responsavel = $validated['tecnico_responsavel'] ?? auth()->user()?->name ?? 'Técnico FOCO';

        $chamado->adicionarHistorico(
            "Chamado CONCLUÍDO pela equipe FOCO. Notificação enviada via WhatsApp para o solicitante ({$chamado->telefone_contato}).",
            auth()->user()?->name ?? 'FOCO Engenharia'
        );

        $chamado->save();

        // Dispara mensagem automática para o WhatsApp do solicitante via Evolution API
        app(EvolutionWhatsAppService::class)->notificarChamadoConcluido($chamado);

        return back()->with('success', "Chamado {$chamado->protocolo} concluído com sucesso e notificação automática enviada para o WhatsApp de {$chamado->nome_solicitante} ({$chamado->telefone_contato})!");
    }

    /**
     * Gera visão de impressão oficial de Ordem de Serviço (O.S.).
     */
    public function imprimirOs(string $id)
    {
        $chamado = Chamado::findOrFail($id);

        return view('admin.chamados.os', compact('chamado'));
    }

    /**
     * Exporta os chamados cadastrados para CSV compatível com Excel.
     */
    public function exportarCsv(): StreamedResponse
    {
        $tickets = Chamado::latest('data_hora_abertura')->get();
        $fileName = 'chamados-foco-sinalizacao-'.date('Y-m-d-His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($tickets) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM UTF-8

            fputcsv($handle, [
                'Protocolo',
                'Tipo',
                'Status',
                'Nome Solicitante',
                'Telefone Contato',
                'Local',
                'Defeito Relatado',
                'Observação do Solicitante',
                'Data/Hora Abertura',
                'Conserto Executado (FOCO)',
                'Data/Hora Execução',
                'Observação Finalização',
                'Técnico Responsável',
            ], ';');

            foreach ($tickets as $t) {
                fputcsv($handle, [
                    $t->protocolo,
                    $t->tipo,
                    $t->status,
                    $t->nome_solicitante,
                    $t->telefone_contato,
                    $t->local,
                    $t->defeito,
                    $t->observacao,
                    $t->data_hora_abertura?->format('d/m/Y H:i:s'),
                    $t->conserto_executado,
                    $t->data_hora_execucao?->format('d/m/Y H:i:s'),
                    $t->observacao_finalizacao,
                    $t->tecnico_responsavel,
                ], ';');
            }

            fclose($handle);
        }, 200, $headers);
    }
}

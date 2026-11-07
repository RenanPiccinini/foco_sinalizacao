<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ChamadoService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ChamadoController extends Controller
{
    /**
     * Lista todos os chamados abertos no site com filtros.
     */
    public function index(Request $request)
    {
        $allTickets = ChamadoService::all();

        $status = $request->query('status');
        $prioridade = $request->query('prioridade');
        $busca = $request->query('busca');
        $municipio = $request->query('municipio');
        $viewMode = $request->query('view', 'tabela'); // 'tabela' ou 'kanban'

        $filtered = array_filter($allTickets, function ($ticket) use ($status, $prioridade, $busca, $municipio) {
            if ($status && $status !== 'todos' && strcasecmp($ticket['status'], $status) !== 0) {
                return false;
            }
            if ($prioridade && $prioridade !== 'todas' && strcasecmp($ticket['prioridade'], $prioridade) !== 0) {
                return false;
            }
            if ($municipio && $municipio !== 'todos' && stripos($ticket['municipio'], $municipio) === false) {
                return false;
            }
            if ($busca) {
                $term = strtolower($busca);
                $searchable = strtolower($ticket['protocolo'] . ' ' . $ticket['titulo'] . ' ' . $ticket['localizacao'] . ' ' . $ticket['solicitante_nome'] . ' ' . $ticket['municipio']);
                if (strpos($searchable, $term) === false) {
                    return false;
                }
            }
            return true;
        });

        // Estatísticas
        $stats = [
            'total' => count($allTickets),
            'abertos' => count(array_filter($allTickets, fn($t) => $t['status'] === 'Aberto')),
            'em_atendimento' => count(array_filter($allTickets, fn($t) => $t['status'] === 'Em Atendimento')),
            'pendente_peca' => count(array_filter($allTickets, fn($t) => $t['status'] === 'Pendente Peça')),
            'concluidos' => count(array_filter($allTickets, fn($t) => $t['status'] === 'Concluído')),
            'criticos' => count(array_filter($allTickets, fn($t) => $t['prioridade'] === 'Crítica')),
        ];

        // Agrupamento para visão Kanban
        $kanban = [
            'Aberto' => array_values(array_filter($allTickets, fn($t) => $t['status'] === 'Aberto')),
            'Em Atendimento' => array_values(array_filter($allTickets, fn($t) => $t['status'] === 'Em Atendimento')),
            'Pendente Peça' => array_values(array_filter($allTickets, fn($t) => $t['status'] === 'Pendente Peça')),
            'Concluído' => array_values(array_filter($allTickets, fn($t) => $t['status'] === 'Concluído')),
        ];

        return view('admin.chamados.index', [
            'chamados' => array_values($filtered),
            'stats' => $stats,
            'kanban' => $kanban,
            'status' => $status ?? 'todos',
            'prioridade' => $prioridade ?? 'todas',
            'busca' => $busca ?? '',
            'municipio' => $municipio ?? 'todos',
            'viewMode' => $viewMode,
        ]);
    }

    /**
     * Exibe os detalhes de um chamado específico.
     */
    public function show(string $id)
    {
        $chamado = ChamadoService::find($id);

        if (!$chamado) {
            return redirect()->route('admin.chamados.index')->with('error', 'Chamado não encontrado.');
        }

        return view('admin.chamados.show', compact('chamado'));
    }

    /**
     * Criação de chamado interno diretamente pela equipe da central.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'solicitante_nome' => 'required|string|max:120',
            'solicitante_orgao' => 'required|string|max:120',
            'solicitante_telefone' => 'nullable|string|max:30',
            'solicitante_email' => 'nullable|email|max:120',
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

        return redirect()->route('admin.chamados.show', $chamado['id'])
            ->with('success', "Chamado interno {$chamado['protocolo']} criado com sucesso!");
    }

    /**
     * Atualiza o status e notas de um chamado.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:Aberto,Em Atendimento,Pendente Peça,Concluído',
            'tecnico_responsavel' => 'nullable|string|max:100',
            'observacao' => 'nullable|string|max:500',
        ]);

        $updated = ChamadoService::updateStatus(
            $id,
            $validated['status'],
            $validated['tecnico_responsavel'] ?? null,
            $validated['observacao'] ?? null
        );

        if (!$updated) {
            return back()->with('error', 'Não foi possível atualizar o chamado.');
        }

        return back()->with('success', "Status do chamado {$updated['protocolo']} atualizado para {$validated['status']}.");
    }

    /**
     * Gera visão de impressão oficial de Ordem de Serviço (O.S.).
     */
    public function imprimirOs(string $id)
    {
        $chamado = ChamadoService::find($id);

        if (!$chamado) {
            return redirect()->route('admin.chamados.index')->with('error', 'Chamado não encontrado.');
        }

        return view('admin.chamados.os', compact('chamado'));
    }

    /**
     * Exporta os chamados cadastrados para CSV compatível com Excel.
     */
    public function exportarCsv(): StreamedResponse
    {
        $tickets = ChamadoService::all();
        $fileName = 'chamados-foco-sinalizacao-' . date('Y-m-d-His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        return response()->stream(function () use ($tickets) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF)); // BOM UTF-8

            fputcsv($handle, [
                'Protocolo',
                'Status',
                'Prioridade',
                'Categoria',
                'Município',
                'Cruzamento / Localização',
                'Título',
                'Solicitante',
                'Órgão',
                'Telefone',
                'E-mail',
                'Equipamento',
                'Técnico Responsável',
                'Data Registro'
            ], ';');

            foreach ($tickets as $t) {
                fputcsv($handle, [
                    $t['protocolo'],
                    $t['status'],
                    $t['prioridade'],
                    $t['categoria'],
                    $t['municipio'],
                    $t['localizacao'],
                    $t['titulo'],
                    $t['solicitante_nome'],
                    $t['solicitante_orgao'],
                    $t['solicitante_telefone'],
                    $t['solicitante_email'],
                    $t['equipamento_afetado'],
                    $t['tecnico_responsavel'],
                    $t['created_at'],
                ], ';');
            }

            fclose($handle);
        }, 200, $headers);
    }
}

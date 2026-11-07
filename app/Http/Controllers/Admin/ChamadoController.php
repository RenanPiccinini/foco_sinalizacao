<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ChamadoService;
use Illuminate\Http\Request;

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
            'concluidos' => count(array_filter($allTickets, fn($t) => $t['status'] === 'Concluído')),
            'criticos' => count(array_filter($allTickets, fn($t) => $t['prioridade'] === 'Crítica')),
        ];

        return view('admin.chamados.index', [
            'chamados' => array_values($filtered),
            'stats' => $stats,
            'status' => $status ?? 'todos',
            'prioridade' => $prioridade ?? 'todas',
            'busca' => $busca ?? '',
            'municipio' => $municipio ?? 'todos',
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
}

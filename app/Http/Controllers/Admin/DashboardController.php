<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ChamadoService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard principal do Gerenciador Foco.
     */
    public function index()
    {
        $allTickets = ChamadoService::all();

        $stats = [
            'total_chamados' => count($allTickets),
            'abertos' => count(array_filter($allTickets, fn($t) => $t['status'] === 'Aberto')),
            'em_atendimento' => count(array_filter($allTickets, fn($t) => $t['status'] === 'Em Atendimento')),
            'concluidos' => count(array_filter($allTickets, fn($t) => $t['status'] === 'Concluído')),
            'criticos' => count(array_filter($allTickets, fn($t) => $t['prioridade'] === 'Crítica')),
            'controladores_online' => 348,
            'eficiencia_onda_verde' => '94.2%',
            'uptime_nobreaks' => '99.98%',
            'municipios_ativos' => 25,
        ];

        $recentes = array_slice($allTickets, 0, 5);

        $controladoresDestaque = [
            ['tag' => 'CTL-BC-01', 'local' => 'Av. Brasil x Alvin Bauer (BC - SC)', 'modo' => 'Adaptativo (IA)', 'status' => 'Online', 'bateria' => '98% LiFePO4', 'onda_verde' => 'Sincronizado'],
            ['tag' => 'CTL-NH-14', 'local' => 'Av. Pedro Adams x Bento Gonçalves (NH - RS)', 'modo' => 'Plano Dinâmico Pico', 'status' => 'Online', 'bateria' => '100% Solar', 'onda_verde' => 'Sincronizado'],
            ['tag' => 'CTL-CAN-08', 'local' => 'Av. Getúlio Vargas x Domingos Martins (Canoas - RS)', 'modo' => 'Bypass Nobreak Ativo', 'status' => 'Alerta UPS', 'bateria' => '94% LiFePO4', 'onda_verde' => 'Ativo'],
            ['tag' => 'CTL-PF-03', 'local' => 'Av. Brasil Leste x Rua Moron (Passo Fundo - RS)', 'modo' => 'Adaptativo', 'status' => 'Online', 'bateria' => '100% Rede/Solar', 'onda_verde' => 'Sincronizado'],
            ['tag' => 'CTL-BR101-19', 'local' => 'Km 142 Morro do Boi (Rodovia BR 101)', 'modo' => 'Móvel Pare & Siga', 'status' => 'Online', 'bateria' => '96% Híbrido', 'onda_verde' => 'Autônomo'],
        ];

        return view('dashboard', compact('stats', 'recentes', 'controladoresDestaque'));
    }
}

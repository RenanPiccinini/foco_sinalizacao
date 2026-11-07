<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\ChamadoService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiteAndAdminChamadosTest extends TestCase
{
    use RefreshDatabase;
    /**
     * Testa que as rotas públicas do site carregam com sucesso.
     */
    public function test_site_pages_are_accessible(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('FOCO');
        $response->assertSee('Mobilidade Urbana');

        $response = $this->get('/chamados');
        $response->assertStatus(200);
        $response->assertSee('Abertura e Acompanhamento de Chamados');

        $response = $this->get('/solucoes');
        $response->assertStatus(200);
        $response->assertSee('Engenharia e Infraestrutura Civil Viária');

        $response = $this->get('/sobre');
        $response->assertStatus(200);
        $response->assertSee('Nossa História');

        $response = $this->get('/cidades-e-rodovias');
        $response->assertStatus(200);
        $response->assertSee('Balneário Camboriú');

        $response = $this->get('/contato');
        $response->assertStatus(200);
        $response->assertSee('Central de Emergência Viária');
    }

    /**
     * Testa a abertura de chamado no site e redirecionamento com protocolo.
     */
    public function test_can_open_chamado_from_site(): void
    {
        $payload = [
            'solicitante_nome' => 'Agente Teste',
            'solicitante_orgao' => 'DTT Balneário',
            'solicitante_telefone' => '(47) 99999-8888',
            'solicitante_email' => 'teste@bctransito.sc.gov.br',
            'municipio' => 'Balneário Camboriú – SC',
            'localizacao' => 'Av. Brasil x Av. Alvin Bauer',
            'ponto_referencia' => 'Calçadão',
            'categoria' => 'Sinalização Semafórica',
            'prioridade' => 'Crítica',
            'titulo' => 'Semáforo intermitente na via central',
            'descricao' => 'Falha de comunicação gerando modo intermitente amarelo.',
            'equipamento_afetado' => 'Controlador 4G',
        ];

        $response = $this->post('/chamados', $payload);
        $response->assertRedirect();
        $response->assertSessionHas('success');
        $response->assertSessionHas('novo_protocolo');
    }

    /**
     * Testa o gerenciador admin com menu Chamados.
     */
    public function test_admin_can_access_dashboard_and_chamados(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Central de Operações Integradas');

        $response = $this->actingAs($user)->get('/admin/chamados');
        $response->assertStatus(200);
        $response->assertSee('Chamados de Suporte');

        // Testar detalhe de um chamado
        $tickets = ChamadoService::all();
        $this->assertNotEmpty($tickets);
        $firstTicket = $tickets[0];

        $response = $this->actingAs($user)->get("/admin/chamados/{$firstTicket['id']}");
        $response->assertStatus(200);
        $response->assertSee($firstTicket['protocolo']);

        // Testar atualização de status
        $response = $this->actingAs($user)->post("/admin/chamados/{$firstTicket['id']}/status", [
            'status' => 'Concluído',
            'tecnico_responsavel' => 'Eng. Automatizado',
            'observacao' => 'Reparo efetuado com sucesso.',
        ]);
        $response->assertRedirect();
        $response->assertSessionHas('success');
    }
}

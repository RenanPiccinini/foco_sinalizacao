<?php

namespace Tests\Feature;

use App\Models\Chamado;
use App\Models\User;
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
        $response->assertSee('99294-1111');
    }

    /**
     * Testa a abertura de chamado no site com as regras do cliente:
     * - Tipo: AP, FA, Acidente ou Vermelho Queimado
     * - Nome solicitante
     * - Número para contato
     * - Local
     * - Defeito
     * - Observação
     * - Horário de abertura capturado automaticamente
     */
    public function test_can_open_chamado_from_site(): void
    {
        $payload = [
            'tipo' => 'AP',
            'nome_solicitante' => 'Inspetor Gabriel Ramos',
            'telefone_contato' => '(51) 99294-1111',
            'local' => 'Av. Brasil cruzamento com Av. Alvin Bauer',
            'defeito' => 'Semáforo veicular em amarelo piscante após oscilação da concessionária de energia.',
            'observacao' => 'Nobreak mantendo o controlador ativo, equipe de trânsito no local.',
        ];

        $response = $this->post('/chamados', $payload);
        $response->assertRedirect();
        $response->assertSessionHas('success');
        $response->assertSessionHas('novo_protocolo');

        // Verifica se foi gravado no banco de dados com horário de abertura automático
        $this->assertDatabaseHas('chamados', [
            'tipo' => 'AP',
            'nome_solicitante' => 'Inspetor Gabriel Ramos',
            'telefone_contato' => '(51) 99294-1111',
            'local' => 'Av. Brasil cruzamento com Av. Alvin Bauer',
            'status' => 'Aberto',
        ]);

        $chamado = Chamado::where('nome_solicitante', 'Inspetor Gabriel Ramos')->first();
        $this->assertNotNull($chamado);
        $this->assertNotNull($chamado->data_hora_abertura);
        $this->assertNotNull($chamado->protocolo);
    }

    /**
     * Testa o gerenciador admin com menu Chamados, detalhe e finalização pela FOCO:
     * Quando a FOCO finalizar informa:
     * - Conserto executado
     * - Horário execução
     * - Observação
     */
    public function test_admin_can_access_dashboard_and_finalize_chamado(): void
    {
        $user = User::factory()->create();

        // Cria um chamado inicial
        $chamado = Chamado::create([
            'protocolo' => 'FOC-2026-9999',
            'tipo' => 'FA',
            'nome_solicitante' => 'Agente Souza',
            'telefone_contato' => '(51) 99294-1111',
            'local' => 'Rua Bento Gonçalves x Av. Pedro Adams',
            'defeito' => 'Foco apagado no sentido centro-bairro',
            'observacao' => 'Risco de colisão no cruzamento.',
            'data_hora_abertura' => now(),
            'status' => 'Aberto',
        ]);

        // Testa dashboard
        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Central de Operações Integradas');
        $response->assertSee('FOC-2026-9999');

        // Testa lista de chamados no admin
        $response = $this->actingAs($user)->get('/admin/chamados');
        $response->assertStatus(200);
        $response->assertSee('Chamados de Suporte');
        $response->assertSee('FOC-2026-9999');
        $response->assertSee('FA');

        // Testa detalhes do chamado
        $response = $this->actingAs($user)->get("/admin/chamados/{$chamado->id}");
        $response->assertStatus(200);
        $response->assertSee('FOC-2026-9999');
        $response->assertSee('Agente Souza');

        // Testa finalização pela FOCO
        $dataExecucao = now()->format('Y-m-d\TH:i');
        $response = $this->actingAs($user)->post("/admin/chamados/{$chamado->id}/status", [
            'status' => 'Finalizado',
            'tecnico_responsavel' => 'Eng. Ricardo Silveira (FOCO)',
            'conserto_executado' => 'Troca da placa controladora de foco e reconfiguração do ciclo verde.',
            'data_hora_execucao' => $dataExecucao,
            'observacao_finalizacao' => 'Semáforo testado e operando 100% normalizado.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        // Verifica no banco de dados que as informações de finalização foram salvas
        $chamado->refresh();
        $this->assertEquals('Finalizado', $chamado->status);
        $this->assertEquals('Eng. Ricardo Silveira (FOCO)', $chamado->tecnico_responsavel);
        $this->assertEquals('Troca da placa controladora de foco e reconfiguração do ciclo verde.', $chamado->conserto_executado);
        $this->assertNotNull($chamado->data_hora_execucao);
        $this->assertEquals('Semáforo testado e operando 100% normalizado.', $chamado->observacao_finalizacao);

        // Testa se os dados de finalização aparecem no site público ao consultar protocolo
        $response = $this->get("/chamados?protocolo={$chamado->protocolo}");
        $response->assertStatus(200);
        $response->assertSee('Finalização do Chamado pela Equipe FOCO');
        $response->assertSee('Troca da placa controladora de foco e reconfiguração do ciclo verde.');
    }

    /**
     * Testa o botão dedicado 'Concluir Chamado' que finaliza e dispara WhatsApp
     */
    public function test_admin_can_conclude_chamado_via_dedicated_endpoint(): void
    {
        $user = User::factory()->create();

        $chamado = Chamado::create([
            'protocolo' => 'FOC-2026-7777',
            'tipo' => 'Vermelho Queimado',
            'nome_solicitante' => 'Comandante Silva',
            'telefone_contato' => '(51) 99294-1111',
            'local' => 'Av. Getúlio Vargas x Domingos Martins',
            'defeito' => 'Lâmpada vermelha LED queimada',
            'data_hora_abertura' => now(),
            'status' => 'Aberto',
        ]);

        $response = $this->actingAs($user)->post("/admin/chamados/{$chamado->id}/concluir", [
            'conserto_executado' => 'Substituído módulo LED vermelho e realizado teste de tensão.',
            'data_hora_execucao' => now()->format('Y-m-d\TH:i'),
            'tecnico_responsavel' => 'Técnico Especialista FOCO',
            'observacao_finalizacao' => 'Semáforo operando em perfeitas condições.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $chamado->refresh();
        $this->assertEquals('Finalizado', $chamado->status);
        $this->assertEquals('Substituído módulo LED vermelho e realizado teste de tensão.', $chamado->conserto_executado);
        $this->assertEquals('Técnico Especialista FOCO', $chamado->tecnico_responsavel);
    }

    /**
     * Testa acesso ao menu 'Conexão' e endpoints de status e QR Code da Evolution API
     */
    public function test_admin_can_access_conexao_whatsapp_menu_and_endpoints(): void
    {
        $user = User::factory()->create();

        // 1. Acesso à página de conexão
        $response = $this->actingAs($user)->get('/admin/conexao');
        $response->assertStatus(200);
        $response->assertSee('Conexão WhatsApp (Evolution API)');
        $response->assertSee('foco_sinalizacao');

        // 2. Endpoint de verificação de status JSON
        $response = $this->actingAs($user)->getJson('/admin/conexao/status');
        $response->assertStatus(200);
        $response->assertJsonStructure(['configured', 'connected']);

        // 3. Endpoint de geração de QR Code JSON
        $response = $this->actingAs($user)->getJson('/admin/conexao/qrcode');
        $response->assertStatus(200);
        $response->assertJsonStructure(['configured', 'connected']);

        // 4. Endpoint de desconectar
        $response = $this->actingAs($user)->post('/admin/conexao/desconectar');
        $response->assertRedirect();
        $response->assertSessionHas('success');
    }
}

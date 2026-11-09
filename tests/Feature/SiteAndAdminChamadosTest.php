<?php

namespace Tests\Feature;

use App\Models\Chamado;
use App\Models\Contato;
use App\Models\User;
use App\Services\EvolutionWhatsAppService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
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
        $response->assertSee('SERVIÇOS PRESTADOS PELA FOCO');

        $response = $this->get('/chamados');
        $response->assertStatus(200);
        $response->assertSee('Abertura e Acompanhamento de Chamados');

        $response = $this->get('/solucoes');
        $response->assertStatus(200);
        $response->assertSee('SERVIÇOS PRESTADOS PELA FOCO');
        $response->assertSee('Projetos de Sinalização semafórica, vertical e horizontal');
        $response->assertSee('Aluguel de caminhão com cesto aéreo');

        $response = $this->get('/sobre');
        $response->assertStatus(200);
        $response->assertSee('Nossa História');

        $response = $this->get('/cidades-e-rodovias');
        $response->assertStatus(200);
        $response->assertSee('Balneário Camboriú');

        $response = $this->get('/contato');
        $response->assertStatus(200);
        $response->assertSee('FORMULÁRIO');
        $response->assertSee('ORÇAMENTO COMPRA DIRETA');
        $response->assertSee('ORÇAMENTO PARA MONTAR PROCESSO');
        $response->assertSee('QUESTIONAMENTO/SOLICITAÇÃO/OUTROS');
        $response->assertDontSee('99294-1111');
        $response->assertDontSee('wa.me');

        // Garante que a seção de parcerias foi removida da home
        $responseHome = $this->get('/');
        $responseHome->assertDontSee('PARCERIAS EM SERVIÇOS, EQUIPAMENTOS E ENGENHARIA INTEGRADA');
        $responseHome->assertDontSee('Digicon S/A');
        $responseHome->assertDontSee('wa.me');
        $responseHome->assertDontSee('99294-1111');
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
            'tipo' => '01 - AP – Amarelo Piscante',
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
            'tipo' => '01 - AP – Amarelo Piscante',
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

        // 5. Teste de extração de número e disparo de teste
        $this->assertEquals('5551992941111', EvolutionWhatsAppService::extractPhoneNumber('5551992941111:198@s.whatsapp.net'));
        $this->assertNull(EvolutionWhatsAppService::extractPhoneNumber('198'));
        $this->assertEquals('5551992941111', EvolutionWhatsAppService::formatPhoneNumber('(51) 99294-1111'));

        $response = $this->actingAs($user)->post('/admin/conexao/teste', [
            'numero' => '',
        ]);
        $response->assertRedirect();
    }

    /**
     * Testa se todos os 8 tipos de defeitos oficiais da foto são exibidos e aceitos
     */
    public function test_chamado_accepts_and_normalizes_all_eight_official_defect_types(): void
    {
        $this->assertCount(8, Chamado::DEFEITOS_RECLAMADOS);

        $esperados = [
            '01' => '01 - AP – Amarelo Piscante',
            '02' => '02 - FA – Fora de Ação (todos semáforos desligados)',
            '03' => '03 - FA – Fora de Ação (Semáforo desligado parcialmente)',
            '04' => '04 - Semáforo - abalroado/pendurado/desalinhado/danificado',
            '05' => '05 - Semáforo - com duas cores/travado',
            '06' => '06 - Acidente – Poste abalroado/danificado/cabos na via',
            '07' => '07 - Cruzamento sem sincronismo/ajuste de tempos',
            '08' => '08 - Botoeira de pedestre com defeito/danificada/sem funcionamento',
        ];

        foreach ($esperados as $codigo => $descricaoCompleta) {
            $this->assertEquals($descricaoCompleta, Chamado::formatarTipo($codigo));
        }

        // Testa renderização dos 8 defeitos na página pública de chamados
        $response = $this->get('/chamados');
        $response->assertStatus(200);
        foreach (Chamado::DEFEITOS_RECLAMADOS as $codigo => $descricao) {
            $response->assertSee($codigo);
            $response->assertSee($descricao);
        }

        // Testa os novos textos institucionais
        $responseHome = $this->get('/');
        $responseHome->assertStatus(200);
        $responseHome->assertSee('Mais do que entregar excelência técnica, esse grande projeto nos permitiu enxergar de perto uma carência latente no mercado por soluções inteligentes e integradas de engenharia de tráfego.');
        $responseHome->assertSee('Expertise técnica em Projetos de Tecnologias Emergentes (Deep Tech), aliado a cases consolidados do mercado');

        $responseSobre = $this->get('/sobre');
        $responseSobre->assertStatus(200);
        $responseSobre->assertSee('Mais do que entregar excelência técnica, esse grande projeto nos permitiu enxergar de perto uma carência latente no mercado por soluções inteligentes e integradas de engenharia de tráfego.');
        $responseSobre->assertSee('Expertise técnica em Projetos de Tecnologias Emergentes (Deep Tech), aliado a cases consolidados do mercado');
    }

    /**
     * Testa que "Solicitar Orçamento" redireciona convidados para login
     */
    public function test_solicitar_orcamento_requires_login(): void
    {
        $response = $this->get('/orcamento');
        $response->assertRedirect('/login');
    }

    /**
     * Testa que usuário autenticado consegue acessar a tela de solicitar orçamento
     */
    public function test_authenticated_user_can_access_solicitar_orcamento(): void
    {
        $user = User::factory()->create([
            'role' => 'cliente',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->get('/orcamento');
        $response->assertStatus(200);
        $response->assertSee('Solicitar Orçamento');
        $response->assertSee('FORMULÁRIO');
        $response->assertSee('ORÇAMENTO COMPRA DIRETA');
    }

    /**
     * Testa que usuário bloqueado não consegue fazer login
     */
    public function test_blocked_user_cannot_login(): void
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
            'is_active' => false,
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    /**
     * Testa que o Master Admin consegue acessar o menu Usuários e criar um usuário
     */
    public function test_master_admin_can_manage_users(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@focosinalizacao.com.br',
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Listagem
        $response = $this->actingAs($admin)->get('/admin/users');
        $response->assertStatus(200);
        $response->assertSee('Gestão de Usuários');

        // Criação de novo usuário
        $createResponse = $this->actingAs($admin)->post('/admin/users', [
            'name' => 'Prefeitura de Teste',
            'email' => 'prefeitura@cidade.gov.br',
            'password' => 'senha12345',
            'password_confirmation' => 'senha12345',
            'role' => 'cliente',
            'is_active' => '1',
        ]);

        $createResponse->assertRedirect('/admin/users');
        $this->assertDatabaseHas('users', [
            'email' => 'prefeitura@cidade.gov.br',
            'role' => 'cliente',
            'is_active' => 1,
        ]);
    }

    /**
     * Testa que o Master Admin pode bloquear e liberar um usuário
     */
    public function test_master_admin_can_toggle_block_user(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@focosinalizacao.com.br',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $cliente = User::factory()->create([
            'role' => 'cliente',
            'is_active' => true,
        ]);

        // Bloquear
        $response = $this->actingAs($admin)->patch("/admin/users/{$cliente->id}/toggle-status");
        $response->assertRedirect('/admin/users');
        $this->assertFalse($cliente->fresh()->is_active);

        // Liberar novamente
        $response = $this->actingAs($admin)->patch("/admin/users/{$cliente->id}/toggle-status");
        $response->assertRedirect('/admin/users');
        $this->assertTrue($cliente->fresh()->is_active);
    }

    /**
     * Testa que usuários não administradores não podem acessar o módulo de usuários
     */
    public function test_non_admin_cannot_access_user_management(): void
    {
        $cliente = User::factory()->create([
            'role' => 'cliente',
            'is_active' => true,
        ]);

        $response = $this->actingAs($cliente)->get('/admin/users');
        $response->assertStatus(403);
    }

    /**
     * Testa envio de contato com arquivo anexo
     */
    public function test_contact_form_submission_with_attachment(): void
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'role' => 'cliente',
            'is_active' => true,
        ]);

        $file = UploadedFile::fake()->create('planilha_quantitativos.xlsx', 100);

        $payload = [
            'empresa' => 'Consórcio Viário Catarinense',
            'responsavel' => 'Eng. Roberto Santos',
            'fone' => '(47) 98888-7777',
            'email' => 'roberto@consorcio.com.br',
            'endereco' => 'Rua das Flores, 500, Centro',
            'cnpj' => '12.345.678/0001-90',
            'arquivo' => $file,
            'assunto' => Contato::ASSUNTO_ORCAMENTO_COMPRA_DIRETA,
            'descricao' => 'Orçamento para 15 conjuntos semafóricos completos e 2 controladores Digicon.',
        ];

        $response = $this->actingAs($user)->post('/contato', $payload);
        $response->assertRedirect();
        $response->assertSessionHas('novo_protocolo_contato');

        $this->assertDatabaseHas('contatos', [
            'empresa' => 'Consórcio Viário Catarinense',
            'responsavel' => 'Eng. Roberto Santos',
            'assunto' => Contato::ASSUNTO_ORCAMENTO_COMPRA_DIRETA,
        ]);

        $contato = Contato::where('empresa', 'Consórcio Viário Catarinense')->first();
        $this->assertNotNull($contato);
        $this->assertNotNull($contato->arquivo_path);
        Storage::disk('public')->assertExists($contato->arquivo_path);
    }

    /**
     * Testa que convidado não autenticado é impedido de enviar opções de Orçamento
     */
    public function test_guest_cannot_submit_orcamento_options_without_login(): void
    {
        $payload = [
            'empresa' => 'Empresa Externa',
            'responsavel' => 'Fulano de Tal',
            'fone' => '(11) 99999-9999',
            'email' => 'externo@empresa.com',
            'endereco' => 'Av Paulista, 1000',
            'cnpj' => '00.000.000/0001-00',
            'assunto' => Contato::ASSUNTO_ORCAMENTO_COMPRA_DIRETA,
            'descricao' => 'Tentativa de orçamento sem login prévio',
        ];

        $response = $this->post('/contato', $payload);
        $response->assertRedirect('/login');
        $this->assertDatabaseMissing('contatos', [
            'empresa' => 'Empresa Externa',
        ]);
    }

    /**
     * Testa que o administrador pode visualizar, atualizar status e gerenciar contatos e orçamentos
     */
    public function test_admin_can_manage_contatos_and_orcamentos(): void
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'email' => 'admin@focosinalizacao.com.br',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $filePath = 'orcamentos/teste.xlsx';
        Storage::disk('public')->put($filePath, 'conteudo de teste');

        $contato = Contato::create([
            'protocolo' => 'SOL-2026-TEST',
            'empresa' => 'Prefeitura de Teste',
            'responsavel' => 'Secretário de Obras',
            'fone' => '(47) 99999-8888',
            'email' => 'obras@teste.gov.br',
            'endereco' => 'Praça Central, 1',
            'cnpj' => '11.222.333/0001-44',
            'arquivo_path' => $filePath,
            'arquivo_nome' => 'planilha_obras.xlsx',
            'assunto' => Contato::ASSUNTO_MONTAR_PROCESSO,
            'descricao' => 'Solicitação de orçamento com quantitativos para processo licitatório.',
            'status' => 'Novo',
            'ip' => '127.0.0.1',
        ]);

        // Listagem
        $response = $this->actingAs($admin)->get('/admin/contatos');
        $response->assertStatus(200);
        $response->assertSee('Prefeitura de Teste');
        $response->assertSee('SOL-2026-TEST');

        // Detalhe
        $showResponse = $this->actingAs($admin)->get("/admin/contatos/{$contato->id}");
        $showResponse->assertStatus(200);
        $showResponse->assertSee('Secretário de Obras');

        // Download do anexo
        $downloadResponse = $this->actingAs($admin)->get("/admin/contatos/{$contato->id}/download");
        $downloadResponse->assertStatus(200);

        // Atualização de status
        $statusResponse = $this->actingAs($admin)->patch("/admin/contatos/{$contato->id}/status", [
            'status' => 'Em Análise',
        ]);
        $statusResponse->assertRedirect();
        $this->assertEquals('Em Análise', $contato->fresh()->status);

        // Exclusão
        $deleteResponse = $this->actingAs($admin)->delete("/admin/contatos/{$contato->id}");
        $deleteResponse->assertRedirect('/admin/contatos');
        $this->assertDatabaseMissing('contatos', ['id' => $contato->id]);
    }
}

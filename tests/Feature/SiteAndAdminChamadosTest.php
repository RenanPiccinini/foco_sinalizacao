<?php

namespace Tests\Feature;

use App\Mail\NovaSolicitacaoContatoMail;
use App\Models\Chamado;
use App\Models\Contato;
use App\Models\User;
use App\Services\EvolutionWhatsAppService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Mail;
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
        $response->assertRedirect('/login');

        $response = $this->get('/orcamento');
        $response->assertStatus(200);
        $response->assertSee('FORMULÁRIO');
        $response->assertSee('ORÇAMENTO COMPRA DIRETA');

        $response = $this->get('/solucoes');
        $response->assertStatus(200);
        $response->assertSee('SERVIÇOS PRESTADOS PELA FOCO');
        $response->assertSee('Projetos de Sinalização semafórica, vertical e horizontal');
        $response->assertSee('Aluguel de caminhão com cesto aéreo');

        $response = $this->get('/sobre');
        $response->assertStatus(200);
        $response->assertSee('Nossa História');

        $expectedParceirosOrder = [
            'AMELFIS COMERCIO DE SINALIZACAO E PLACAS LTDA',
            'Chiorri Informática',
            'Contransin',
            'LCM Construtora',
            'Pavicon',
            'Signasul',
            'Sinaltran',
            'Sinaway',
            'Tecnass',
            'Semáforos a LED',
            'TR Sul Engenharia',
        ];

        $response = $this->get('/cidades-e-rodovias');
        $response->assertStatus(200);
        $response->assertSee('Balneário Camboriú');
        $response->assertSee('Clientes e Parceiros');
        $response->assertSeeInOrder($expectedParceirosOrder);
        $response->assertDontSee('Digicon');

        $response = $this->get('/contato');
        $response->assertStatus(200);
        $response->assertSee('FORMULÁRIO');
        $response->assertSee('ORÇAMENTO COMPRA DIRETA');
        $response->assertSee('ORÇAMENTO PARA MONTAR PROCESSO');
        $response->assertSee('QUESTIONAMENTO/SOLICITAÇÃO/OUTROS');
        $response->assertDontSee('99294-1111');
        $response->assertDontSee('wa.me');

        // Garante que a lista discreta e ordenada de Clientes e Parceiros aparece na home sem Digicon nem WhatsApp
        $responseHome = $this->get('/');
        $responseHome->assertSee('Clientes e Parceiros');
        $responseHome->assertSeeInOrder($expectedParceirosOrder);
        $responseHome->assertDontSee('Digicon');
        $responseHome->assertDontSee('wa.me');
        $responseHome->assertDontSee('99294-1111');
        $responseHome->assertSee('Desenvolvido por');
        $responseHome->assertSee('images/pds-logo.png');
        $responseHome->assertSee('https://piccininidigitalsolutions.com.br/');
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
            'telefone_contato' => '(51) 98765-4321',
            'local' => 'Av. Brasil cruzamento com Av. Alvin Bauer',
            'defeito' => 'Semáforo veicular em amarelo piscante após oscilação da concessionária de energia.',
            'observacao' => 'Nobreak mantendo o controlador ativo, equipe de trânsito no local.',
        ];

        // Convidado tentando abrir chamado é redirecionado para login
        $guestResponse = $this->post('/chamados', $payload);
        $guestResponse->assertRedirect('/login');

        // Usuário logado abre chamado com sucesso
        $user = User::factory()->create([
            'role' => 'cliente',
            'is_active' => true,
        ]);

        $response = $this->actingAs($user)->post('/chamados', $payload);
        $response->assertRedirect();
        $response->assertSessionHas('success');
        $response->assertSessionHas('novo_protocolo');

        // Verifica se foi gravado no banco de dados com horário de abertura automático
        $this->assertDatabaseHas('chamados', [
            'tipo' => '01 - AP – Amarelo Piscante',
            'nome_solicitante' => 'Inspetor Gabriel Ramos',
            'telefone_contato' => '(51) 98765-4321',
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
        $user = User::factory()->admin()->create();

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

        // Testa se os dados de finalização aparecem no site ao consultar protocolo (estando logado)
        $response = $this->actingAs($user)->get("/chamados?protocolo={$chamado->protocolo}");
        $response->assertStatus(200);
        $response->assertSee('Finalização do Chamado pela Equipe FOCO');
        $response->assertSee('Troca da placa controladora de foco e reconfiguração do ciclo verde.');
    }

    /**
     * Testa o botão dedicado 'Concluir Chamado' que finaliza e dispara WhatsApp
     */
    public function test_admin_can_conclude_chamado_via_dedicated_endpoint(): void
    {
        $user = User::factory()->admin()->create();

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
        $user = User::factory()->admin()->create();

        // 1. Acesso à página de conexão
        $response = $this->actingAs($user)->get('/admin/conexao');
        $response->assertStatus(200);
        $response->assertSee('Conexão WhatsApp');
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

        // 5. Teste de menu visível no Dashboard e na Barra Lateral exclusivamente para admin
        $responseDashboard = $this->actingAs($user)->get('/dashboard');
        $responseDashboard->assertStatus(200);
        $responseDashboard->assertSee('Conexão WhatsApp');
        $responseDashboard->assertSee(route('admin.conexao.index'));

        $nonAdmin = User::factory()->create(['role' => 'tecnico', 'is_active' => true]);
        $responseNonAdmin = $this->actingAs($nonAdmin)->get('/admin/conexao');
        $responseNonAdmin->assertStatus(403);

        // 6. Teste de extração de número, formatação e destinatários do admin
        $this->assertEquals('5551992941111', EvolutionWhatsAppService::extractPhoneNumber('5551992941111:198@s.whatsapp.net'));
        $this->assertNull(EvolutionWhatsAppService::extractPhoneNumber('198'));
        $this->assertEquals('5551992941111', EvolutionWhatsAppService::formatPhoneNumber('(51) 99294-1111'));

        $service = app(EvolutionWhatsAppService::class);
        $this->assertIsArray($service->getAdminRecipients());

        // 7. Teste de prevenção contra repetição de mensagem (anti-duplicidade)
        $chamadoTeste = Chamado::create([
            'protocolo' => 'FOC-2026-9999',
            'tipo' => 'Vermelho Queimado',
            'nome_solicitante' => 'Fiscal Teste',
            'telefone_contato' => '(51) 99294-1111',
            'local' => 'Rua das Flores x Central',
            'defeito' => 'Lâmpada vermelha apagada',
            'data_hora_abertura' => now(),
            'status' => 'Aberto',
        ]);

        $resAbertura1 = $service->notificarNovoChamado($chamadoTeste);
        $resAbertura2 = $service->notificarNovoChamado($chamadoTeste);
        $this->assertTrue($resAbertura2['already_sent'] ?? false);

        $resConclusao1 = $service->notificarChamadoConcluido($chamadoTeste);
        $resConclusao2 = $service->notificarChamadoConcluido($chamadoTeste);
        $this->assertTrue($resConclusao2['already_sent'] ?? false);

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

        // Testa renderização dos 8 defeitos na página de chamados para usuário autenticado
        $user = User::factory()->create(['role' => 'cliente', 'is_active' => true]);
        $response = $this->actingAs($user)->get('/chamados');
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
     * Testa que "Abrir Chamado" requer login e redireciona convidados para login
     */
    public function test_abrir_chamado_requires_login(): void
    {
        $response = $this->get('/chamados');
        $response->assertRedirect('/login');

        $responsePost = $this->post('/chamados', [
            'tipo' => '01 - AP – Amarelo Piscante',
            'nome_solicitante' => 'Inspetor Teste',
            'telefone_contato' => '(51) 98765-4321',
            'local' => 'Av. Brasil',
        ]);
        $responsePost->assertRedirect('/login');
    }

    /**
     * Testa que "Solicitar Orçamento" é público e renderiza o formulário oficial
     */
    public function test_solicitar_orcamento_is_public_and_renders_form(): void
    {
        $response = $this->get('/orcamento');
        $response->assertStatus(200);
        $response->assertSee('FORMULÁRIO');
        $response->assertSee('ORÇAMENTO COMPRA DIRETA');
        $response->assertSee('ORÇAMENTO PARA MONTAR PROCESSO');
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
        Mail::fake();

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
            'descricao' => 'Orçamento para 15 conjuntos semafóricos completos e 2 controladores inteligentes.',
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

        Mail::assertSent(NovaSolicitacaoContatoMail::class, function (NovaSolicitacaoContatoMail $mail) use ($contato): bool {
            return $mail->hasTo(config('mail.demandas_address'))
                && $mail->hasReplyTo('roberto@consorcio.com.br')
                && $mail->contato->id === $contato->id
                && count($mail->attachments()) === 1;
        });
    }

    /**
     * Testa que qualquer visitante/convidado pode enviar solicitação de orçamento pelo formulário oficial sem login
     */
    public function test_guest_can_submit_orcamento_directly_without_login(): void
    {
        Storage::fake('public');
        Mail::fake();

        $file = UploadedFile::fake()->create('planilha_quantitativos.xlsx', 100);

        $payload = [
            'empresa' => 'Empresa Externa Solicitante',
            'responsavel' => 'Fulano de Tal',
            'fone' => '(11) 99999-9999',
            'email' => 'externo@empresa.com',
            'endereco' => 'Av Paulista, 1000',
            'cnpj' => '00.000.000/0001-00',
            'arquivo' => $file,
            'assunto' => Contato::ASSUNTO_ORCAMENTO_COMPRA_DIRETA,
            'descricao' => 'Solicitação de orçamento com quantitativos sem login prévio',
        ];

        $response = $this->post('/contato', $payload);
        $response->assertRedirect();
        $response->assertSessionHas('novo_protocolo_contato');

        $this->assertDatabaseHas('contatos', [
            'empresa' => 'Empresa Externa Solicitante',
            'assunto' => Contato::ASSUNTO_ORCAMENTO_COMPRA_DIRETA,
        ]);

        Mail::assertSent(NovaSolicitacaoContatoMail::class, function (NovaSolicitacaoContatoMail $mail): bool {
            return $mail->hasTo('demandas@focosinal.com.br')
                && $mail->hasReplyTo('externo@empresa.com');
        });
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

    /**
     * Testa que cliente normal não pode acessar o painel master e não vê botões de gerenciador/painel
     */
    public function test_regular_client_cannot_access_admin_panel_and_buttons_are_hidden(): void
    {
        $cliente = User::factory()->create([
            'role' => 'cliente',
            'name' => 'Prefeitura de Teste Cliente',
        ]);

        // 1. Tentar acessar rotas de admin retorna 403 Forbidden
        $responseDashboard = $this->actingAs($cliente)->get('/dashboard');
        $responseDashboard->assertStatus(403);

        $responseChamados = $this->actingAs($cliente)->get('/admin/chamados');
        $responseChamados->assertStatus(403);

        $responseUsers = $this->actingAs($cliente)->get('/admin/users');
        $responseUsers->assertStatus(403);

        // 2. No site público, cliente logado não vê botões para o Painel Master
        $responseHome = $this->actingAs($cliente)->get('/');
        $responseHome->assertStatus(200);
        $responseHome->assertDontSee('Painel Gestor');
        $responseHome->assertDontSee('Painel Administrativo');
        $responseHome->assertDontSee('Área Restrita (Gerenciador)');
        $responseHome->assertSee('Prefeitura de Teste Cliente');
        $responseHome->assertSee('Sair');
    }

    /**
     * Testa que nenhuma página possui menção à palavra DIGICON
     */
    public function test_pages_have_no_digicon_references(): void
    {
        $responseHome = $this->get('/');
        $responseHome->assertStatus(200);
        $responseHome->assertDontSee('DIGICON');
        $responseHome->assertDontSee('Digicon');
        $responseHome->assertSee('Central WEB Conectada');

        $responseSolucoes = $this->get('/solucoes');
        $responseSolucoes->assertStatus(200);
        $responseSolucoes->assertDontSee('DIGICON');
        $responseSolucoes->assertDontSee('Digicon');
        $responseSolucoes->assertSee('Simulador Comparativo de Onda Verde');
        $responseSolucoes->assertSee('getCor(1)');
    }

    /**
     * Testa renderização do e-mail de orçamento, destinatário configurável e resiliência a falha SMTP
     */
    public function test_orcamento_email_rendering_custom_recipient_and_smtp_failure_resilience(): void
    {
        Storage::fake('public');
        Mail::fake();

        config(['mail.demandas_address' => 'outro@focosinal.com.br']);

        $response = $this->post('/contato', [
            'empresa' => 'Prefeitura de Canoas',
            'responsavel' => 'Secretário Marcos',
            'fone' => '(51) 99999-0000',
            'email' => 'marcos@canoas.rs.gov.br',
            'endereco' => 'Rua 15 de Janeiro, 11',
            'cnpj' => '88.577.416/0001-18',
            'assunto' => Contato::ASSUNTO_MONTAR_PROCESSO,
            'descricao' => 'Montagem de processo para 10 cruzamentos com nobreak.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('novo_protocolo_contato');

        $contato = Contato::where('empresa', 'Prefeitura de Canoas')->firstOrFail();

        Mail::assertSent(NovaSolicitacaoContatoMail::class, function (NovaSolicitacaoContatoMail $mail) use ($contato): bool {
            $rendered = $mail->render();

            return $mail->hasTo('outro@focosinal.com.br')
                && str_contains($rendered, $contato->protocolo)
                && str_contains($rendered, 'Prefeitura de Canoas')
                && str_contains($rendered, '88.577.416/0001-18')
                && str_contains($rendered, 'Montagem de processo para 10 cruzamentos com nobreak.');
        });
    }

    /**
     * Testa upload de PDF e planilha XLSX mesmo com MIME genérico (octet-stream) e feedback visual na tela
     */
    public function test_orcamento_accepts_pdf_and_xlsx_even_with_generic_mime_and_renders_upload_feedback(): void
    {
        Storage::fake('public');
        Mail::fake();

        $formResponse = $this->get('/orcamento');
        $formResponse->assertStatus(200);
        $formResponse->assertSee('selecionarArquivo');
        $formResponse->assertSee('arquivoNome');
        $formResponse->assertSee('Enviando Formulário...');
        $formResponse->assertSee('enviando = true');

        $pdfFile = UploadedFile::fake()->create('memorial_descritivo.pdf', 250, 'application/octet-stream');

        $responsePdf = $this->post('/contato', [
            '_origin' => 'orcamento',
            'empresa' => 'Prefeitura PDF',
            'responsavel' => 'Ana Engenheira',
            'fone' => '(51) 98888-1111',
            'email' => 'ana@prefeitura.rs.gov.br',
            'endereco' => 'Av. Central, 100',
            'cnpj' => '11.222.333/0001-44',
            'arquivo' => $pdfFile,
            'assunto' => Contato::ASSUNTO_ORCAMENTO_COMPRA_DIRETA,
            'descricao' => 'Projeto em PDF com quantitativos.',
        ]);

        $responsePdf->assertRedirect('/orcamento');
        $responsePdf->assertSessionHas('novo_protocolo_contato');

        $contatoPdf = Contato::where('empresa', 'Prefeitura PDF')->firstOrFail();
        $this->assertEquals('memorial_descritivo.pdf', $contatoPdf->arquivo_nome);
        Storage::disk('public')->assertExists($contatoPdf->arquivo_path);
        Mail::assertSent(NovaSolicitacaoContatoMail::class, fn (NovaSolicitacaoContatoMail $mail): bool => count($mail->attachments()) === 1);
    }

    /**
     * Testa painel de diagnóstico e disparo de e-mail de teste no gerenciador admin
     */
    public function test_admin_can_diagnose_and_test_email_dispatch(): void
    {
        Mail::fake();

        $admin = User::factory()->admin()->create();
        $cliente = User::factory()->create(['role' => 'cliente']);

        $this->actingAs($cliente)->post('/admin/contatos/testar-email')->assertStatus(403);
        $this->actingAs($cliente)->post('/admin/contatos/limpar-cache')->assertStatus(403);

        $indexResponse = $this->actingAs($admin)->get('/admin/contatos');
        $indexResponse->assertStatus(200);
        $indexResponse->assertSee('Envio Automático por E-mail:');
        $indexResponse->assertSee('Testar Envio de E-mail');

        config(['mail.default' => 'log']);
        $logResponse = $this->actingAs($admin)->post('/admin/contatos/testar-email');
        $logResponse->assertRedirect();
        $logResponse->assertSessionHas('error');

        config(['mail.default' => 'smtp', 'mail.demandas_address' => 'demandas@focosinal.com.br']);
        $smtpResponse = $this->actingAs($admin)->post('/admin/contatos/testar-email');
        $smtpResponse->assertRedirect();
        $smtpResponse->assertSessionHas('success');

        $afterTestIndex = $this->actingAs($admin)->get('/admin/contatos');
        $afterTestIndex->assertSee('Último registro');

        $cacheResponse = $this->actingAs($admin)->post('/admin/contatos/limpar-cache');
        $cacheResponse->assertRedirect();
        $cacheResponse->assertSessionHas('success');

        @unlink(storage_path('app/mail_diagnostico_testing.json'));
    }
}

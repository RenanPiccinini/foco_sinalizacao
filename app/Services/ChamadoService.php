<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class ChamadoService
{
    protected static string $storagePath = 'chamados_mock.json';

    /**
     * Retorna o caminho completo do arquivo de armazenamento mock.
     */
    protected static function getFilePath(): string
    {
        return storage_path('app/' . self::$storagePath);
    }

    /**
     * Obtém todos os chamados cadastrados (fakes + novos abertos).
     */
    public static function all(): array
    {
        $filePath = self::getFilePath();

        if (!File::exists($filePath)) {
            $defaultData = self::seedDefaultTickets();
            File::ensureDirectoryExists(dirname($filePath));
            File::put($filePath, json_encode($defaultData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            return $defaultData;
        }

        $content = File::get($filePath);
        $data = json_decode($content, true);

        return is_array($data) ? $data : self::seedDefaultTickets();
    }

    /**
     * Busca um chamado por ID ou Protocolo.
     */
    public static function find(string $idOrProtocol): ?array
    {
        $tickets = self::all();
        foreach ($tickets as $ticket) {
            if ($ticket['id'] === $idOrProtocol || strcasecmp($ticket['protocolo'], $idOrProtocol) === 0) {
                return $ticket;
            }
        }
        return null;
    }

    /**
     * Cria um novo chamado a partir do formulário do site.
     */
    public static function create(array $data): array
    {
        $tickets = self::all();

        $protocolNumber = rand(1000, 9999);
        $protocol = 'FOC-' . date('Y') . '-' . $protocolNumber;

        $newTicket = [
            'id' => (string) (count($tickets) + 1),
            'protocolo' => $protocol,
            'titulo' => $data['titulo'] ?? ('Ocorrência em ' . ($data['localizacao'] ?? 'Via Pública')),
            'categoria' => $data['categoria'] ?? 'Sinalização Semafórica',
            'municipio' => $data['municipio'] ?? 'Balneário Camboriú – SC',
            'localizacao' => $data['localizacao'] ?? 'Cruzamento Central',
            'ponto_referencia' => $data['ponto_referencia'] ?? '',
            'prioridade' => $data['prioridade'] ?? 'Alta',
            'status' => 'Aberto',
            'solicitante_nome' => $data['solicitante_nome'] ?? 'Cidadão / Agente',
            'solicitante_orgao' => $data['solicitante_orgao'] ?? 'Secretaria de Trânsito / DTT',
            'solicitante_telefone' => $data['solicitante_telefone'] ?? '',
            'solicitante_email' => $data['solicitante_email'] ?? '',
            'descricao' => $data['descricao'] ?? 'Semáforo com instabilidade após oscilação da rede.',
            'equipamento_afetado' => $data['equipamento_afetado'] ?? 'Controlador Eletrônico & Grupo Focal LED',
            'tecnico_responsavel' => 'Aguardando Atribuição',
            'created_at' => now()->format('d/m/Y H:i'),
            'updated_at' => now()->format('d/m/Y H:i'),
            'sla_estimado' => 'Até 2 horas (Urgência Operacional)',
            'historico' => [
                [
                    'data' => now()->format('d/m/Y H:i'),
                    'evento' => 'Chamado registrado no portal Foco Sinalização',
                    'usuario' => $data['solicitante_nome'] ?? 'Solicitante'
                ]
            ]
        ];

        array_unshift($tickets, $newTicket);
        self::save($tickets);

        return $newTicket;
    }

    /**
     * Atualiza o status e detalhes de um chamado (via Gerenciador Admin).
     */
    public static function updateStatus(string $id, string $status, ?string $tecnico = null, ?string $observacao = null): ?array
    {
        $tickets = self::all();
        $updated = null;

        foreach ($tickets as &$ticket) {
            if ($ticket['id'] === $id || $ticket['protocolo'] === $id) {
                $ticket['status'] = $status;
                if ($tecnico) {
                    $ticket['tecnico_responsavel'] = $tecnico;
                }
                $ticket['updated_at'] = now()->format('d/m/Y H:i');

                $ticket['historico'][] = [
                    'data' => now()->format('d/m/Y H:i'),
                    'evento' => "Status atualizado para: {$status}" . ($observacao ? " - {$observacao}" : ''),
                    'usuario' => auth()->user()->name ?? 'Administrador Central'
                ];

                $updated = $ticket;
                break;
            }
        }

        if ($updated) {
            self::save($tickets);
        }

        return $updated;
    }

    /**
     * Persiste os chamados no arquivo JSON.
     */
    protected static function save(array $tickets): void
    {
        $filePath = self::getFilePath();
        File::ensureDirectoryExists(dirname($filePath));
        File::put($filePath, json_encode($tickets, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }

    /**
     * Gera base inicial de chamados fictícios realistas com base nos dados reais dos documentos.
     */
    protected static function seedDefaultTickets(): array
    {
        return [
            [
                'id' => '1',
                'protocolo' => 'FOC-2026-8941',
                'titulo' => 'Oscilação em Nó Semafórico Adaptativo',
                'categoria' => 'Inteligência Semafórica & Visão Computacional',
                'municipio' => 'Balneário Camboriú – SC',
                'localizacao' => 'Av. Brasil x Av. Alvin Bauer',
                'ponto_referencia' => 'Em frente ao Calçadão Central',
                'prioridade' => 'Crítica',
                'status' => 'Em Atendimento',
                'solicitante_nome' => 'Capitão Marcelo Vargas',
                'solicitante_orgao' => 'BC Trânsito / DTT',
                'solicitante_telefone' => '(47) 99234-8811',
                'solicitante_email' => 'operacoes@bctransito.sc.gov.br',
                'descricao' => 'Câmera sensorial de contagem veicular reportou perda transitória de comunicação com o controlador inteligente. Equipe técnica em deslocamento com app mobile.',
                'equipamento_afetado' => 'Sensor Virtual HD & Módulo 4G Central Digicon',
                'tecnico_responsavel' => 'Eng. Ricardo Silveira (Equipe Alpha)',
                'created_at' => now()->subHours(1)->subMinutes(15)->format('d/m/Y H:i'),
                'updated_at' => now()->subMinutes(20)->format('d/m/Y H:i'),
                'sla_estimado' => 'Até 1h30m',
                'historico' => [
                    [
                        'data' => now()->subHours(1)->subMinutes(15)->format('d/m/Y H:i'),
                        'evento' => 'Chamado acionado via telemetria automática da Central WEB Digicon',
                        'usuario' => 'Sistema Automático IoT'
                    ],
                    [
                        'data' => now()->subMinutes(45)->format('d/m/Y H:i'),
                        'evento' => 'Equipe Alpha despachada com ordem de serviço georreferenciada',
                        'usuario' => 'Central de Monitoramento Foco'
                    ],
                    [
                        'data' => now()->subMinutes(20)->format('d/m/Y H:i'),
                        'evento' => 'Técnico em campo checando cabeamento subterrâneo em PEAD',
                        'usuario' => 'Eng. Ricardo Silveira'
                    ]
                ]
            ],
            [
                'id' => '2',
                'protocolo' => 'FOC-2026-8895',
                'titulo' => 'Ajuste de Onda Verde Horário de Pico',
                'categoria' => 'Sincronismo & Engenharia de Tráfego',
                'municipio' => 'Novo Hamburgo – RS',
                'localizacao' => 'Av. Pedro Adams Filho x Rua Bento Gonçalves',
                'ponto_referencia' => 'Corredor Central de Ônibus',
                'prioridade' => 'Média',
                'status' => 'Aberto',
                'solicitante_nome' => 'Engª Carla Mendonça',
                'solicitante_orgao' => 'Secretaria Municipal de Obras e Trânsito',
                'solicitante_telefone' => '(51) 98112-3344',
                'solicitante_email' => 'transito@novohamburgo.rs.gov.br',
                'descricao' => 'Solicitação de reprogramação da matriz de sincronismo semafórico para estender o tempo de verde sentido centro entre 17h30 e 19h00.',
                'equipamento_afetado' => 'Controladores Interligados 4G / Central Nuvem',
                'tecnico_responsavel' => 'Aguardando Atribuição',
                'created_at' => now()->subHours(3)->format('d/m/Y H:i'),
                'updated_at' => now()->subHours(3)->format('d/m/Y H:i'),
                'sla_estimado' => 'Até 4 horas',
                'historico' => [
                    [
                        'data' => now()->subHours(3)->format('d/m/Y H:i'),
                        'evento' => 'Solicitação registrada pelo portal institucional do cliente',
                        'usuario' => 'Engª Carla Mendonça'
                    ]
                ]
            ],
            [
                'id' => '3',
                'protocolo' => 'FOC-2026-8720',
                'titulo' => 'Queda de Rede Externa - Acionamento Nobreak LiFePO4',
                'categoria' => 'Resiliência Energética & Nobreak',
                'municipio' => 'Canoas – RS',
                'localizacao' => 'Av. Getúlio Vargas x Rua Domingos Martins (BR-116 Lateral)',
                'ponto_referencia' => 'Acesso ao Viaduto',
                'prioridade' => 'Alta',
                'status' => 'Em Atendimento',
                'solicitante_nome' => 'Agente Renato Dutra',
                'solicitante_orgao' => 'Fiscalização Municipal de Trânsito',
                'solicitante_telefone' => '(51) 99877-1234',
                'solicitante_email' => 'fiscalizacao@canoas.rs.gov.br',
                'descricao' => 'Apagão geral na concessionária local. Nobreak Senoidal Puro da Foco assumiu a operação automaticamente com banco de lítio LiFePO4 mantendo 100% dos semáforos operando sem falhas.',
                'equipamento_afetado' => 'Sistema Híbrido Nobreak Senoidal & Bateria Lítio',
                'tecnico_responsavel' => 'Téc. Fernando Costa',
                'created_at' => now()->subHours(5)->format('d/m/Y H:i'),
                'updated_at' => now()->subHours(1)->format('d/m/Y H:i'),
                'sla_estimado' => 'Monitoramento Ativo',
                'historico' => [
                    [
                        'data' => now()->subHours(5)->format('d/m/Y H:i'),
                        'evento' => 'Telemetria detectou queda de tensão da concessionária. Bypass estático acionado com sucesso.',
                        'usuario' => 'Telemetria Central Web Foco'
                    ],
                    [
                        'data' => now()->subHours(1)->format('d/m/Y H:i'),
                        'evento' => 'Carga de bateria estável em 94% com suporte fotovoltaico ativo.',
                        'usuario' => 'Téc. Fernando Costa'
                    ]
                ]
            ],
            [
                'id' => '4',
                'protocolo' => 'FOC-2026-8610',
                'titulo' => 'Colisão com Coluna Semafórica em Aço Galvanizado',
                'categoria' => 'Infraestrutura Civil & Manutenção Física',
                'municipio' => 'Passo Fundo – RS',
                'localizacao' => 'Av. Brasil Leste x Rua Moron',
                'ponto_referencia' => 'Próximo à Praça Tamandaré',
                'prioridade' => 'Crítica',
                'status' => 'Concluído',
                'solicitante_nome' => 'Tenente Borba',
                'solicitante_orgao' => 'Polícia Rodoviária / Brigada Militar',
                'solicitante_telefone' => '(54) 99120-7766',
                'solicitante_email' => 'operacoes@passofundo.rs.gov.br',
                'descricao' => 'Veículo colidiu com braço projetado de suporte focal. Troca emergencial da coluna executada, cabeamento subterrâneo e grupo focal a LED restaurados em menos de 3 horas.',
                'equipamento_afetado' => 'Coluna em Aço Galvanizado e Grupo Focal Veicular LED',
                'tecnico_responsavel' => 'Equipe de Infraestrutura Foco',
                'created_at' => now()->subDays(1)->format('d/m/Y H:i'),
                'updated_at' => now()->subHours(18)->format('d/m/Y H:i'),
                'sla_estimado' => 'Concluído em 2h45m',
                'historico' => [
                    [
                        'data' => now()->subDays(1)->format('d/m/Y H:i'),
                        'evento' => 'Chamado de emergência aberto via linha direta 24h',
                        'usuario' => 'Plantão Operacional'
                    ],
                    [
                        'data' => now()->subDays(1)->addHours(2)->format('d/m/Y H:i'),
                        'evento' => 'Nova coluna galvanizada instalada e recalibragem do grupo focal efetuada',
                        'usuario' => 'Líder Operacional Anderson'
                    ],
                    [
                        'data' => now()->subHours(18)->format('d/m/Y H:i'),
                        'evento' => 'Cruzamento restabelecido e validado no mapa de telemetria',
                        'usuario' => 'Eng. Chefe de Operações'
                    ]
                ]
            ],
            [
                'id' => '5',
                'protocolo' => 'FOC-2026-8550',
                'titulo' => 'Sinalização Semafórica Temporária em Bloqueio Rodoviário',
                'categoria' => 'Consultoria & Obras Temporárias em Rodovias',
                'municipio' => 'Rodovia BR 101 – SC',
                'localizacao' => 'Km 142 - Trecho Morro do Boi',
                'ponto_referencia' => 'Área de Escarpamento e Obras de Contenção',
                'prioridade' => 'Alta',
                'status' => 'Concluído',
                'solicitante_nome' => 'Coordenação de Tráfego Concessionária',
                'solicitante_orgao' => 'Concessionária de Rodovias / DNIT',
                'solicitante_telefone' => '(48) 98822-9900',
                'solicitante_email' => 'operacoes.br101@rodovias.com.br',
                'descricao' => 'Implantação de conjunto semafórico móvel autônomo com alimentação solar e baterias LiFePO4 para controle de tráfego "pare e siga" durante reparo de encosta.',
                'equipamento_afetado' => 'Semáforos Móveis Inteligentes Híbridos',
                'tecnico_responsavel' => 'Eng. Ricardo Silveira',
                'created_at' => now()->subDays(3)->format('d/m/Y H:i'),
                'updated_at' => now()->subDays(1)->format('d/m/Y H:i'),
                'sla_estimado' => 'Concluído dentro do cronograma',
                'historico' => [
                    [
                        'data' => now()->subDays(3)->format('d/m/Y H:i'),
                        'evento' => 'Projeto e plano de tráfego emergencial aprovado',
                        'usuario' => 'Eng. Consultor Foco'
                    ],
                    [
                        'data' => now()->subDays(1)->format('d/m/Y H:i'),
                        'evento' => 'Operação concluída com liberação integral da pista',
                        'usuario' => 'Equipe Técnica de Rodovias'
                    ]
                ]
            ],
            [
                'id' => '6',
                'protocolo' => 'FOC-2026-8490',
                'titulo' => 'Vistoria Preventiva Sistema Solar e Nobreak',
                'categoria' => 'Manutenção Preventiva & Microgeração',
                'municipio' => 'Torres – RS',
                'localizacao' => 'Av. Beira-Mar x Av. Silva Jardim',
                'ponto_referencia' => 'Acesso à Praia Grande',
                'prioridade' => 'Baixa',
                'status' => 'Aberto',
                'solicitante_nome' => 'Coordenação de Infraestrutura',
                'solicitante_orgao' => 'Prefeitura Municipal de Torres',
                'solicitante_telefone' => '(51) 99344-5566',
                'solicitante_email' => 'obras@torres.rs.gov.br',
                'descricao' => 'Vistoria periódica trimestral dos painéis solares fotovoltaicos com controladores MPPT e verificação de salinidade em componentes costeiros.',
                'equipamento_afetado' => 'Placas Solares & Controladores Digitais MPPT',
                'tecnico_responsavel' => 'Aguardando Atribuição',
                'created_at' => now()->subDays(2)->format('d/m/Y H:i'),
                'updated_at' => now()->subDays(2)->format('d/m/Y H:i'),
                'sla_estimado' => 'Até 48 horas',
                'historico' => [
                    [
                        'data' => now()->subDays(2)->format('d/m/Y H:i'),
                        'evento' => 'Agendamento preventivo cadastrado no plano de manutenção',
                        'usuario' => 'Coordenação Operacional'
                    ]
                ]
            ]
        ];
    }
}


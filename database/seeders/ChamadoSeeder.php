<?php

namespace Database\Seeders;

use App\Models\Chamado;
use Illuminate\Database\Seeder;

class ChamadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $chamados = [
            [
                'protocolo' => 'FOC-2026-8941',
                'tipo' => '01 - AP – Amarelo Piscante',
                'nome_solicitante' => 'Inspetor Gabriel Ramos (DTT)',
                'telefone_contato' => '(51) 99294-1111',
                'local' => 'Av. Atlântica x Rua 1500 (Balneário Camboriú – SC)',
                'defeito' => 'Controlador semafórico entrou em modo Amarelo Piscante (AP) de emergência após oscilação da rede.',
                'observacao' => 'Cruzamento de fluxo intenso na orla. Nobreak LiFePO4 sustentando a controladora. Requer averiguação da placa de sincronismo.',
                'data_hora_abertura' => now()->subHours(2),
                'status' => 'Aberto',
                'tecnico_responsavel' => null,
                'conserto_executado' => null,
                'data_hora_execucao' => null,
                'observacao_finalizacao' => null,
                'historico' => [
                    [
                        'data' => now()->subHours(2)->format('d/m/Y H:i'),
                        'evento' => 'Chamado registrado pelo solicitante via portal.',
                        'usuario' => 'Inspetor Gabriel Ramos',
                    ],
                ],
            ],
            [
                'protocolo' => 'FOC-2026-8940',
                'tipo' => '05 - Semáforo - com duas cores/travado',
                'nome_solicitante' => 'Tenente Marcos Silveira (Guarda Municipal)',
                'telefone_contato' => '(51) 99881-2233',
                'local' => 'Av. Pedro Adams Filho x Rua Bento Gonçalves (Novo Hamburgo – RS)',
                'defeito' => 'Semáforo veicular travado com duas cores acesas no semáforo norte.',
                'observacao' => 'Risco crítico de abalroamento transversal no horário de pico escolar.',
                'data_hora_abertura' => now()->subHours(5),
                'status' => 'Em Atendimento',
                'tecnico_responsavel' => 'Eng. Lucas Menezes (Equipe Alpha)',
                'conserto_executado' => null,
                'data_hora_execucao' => null,
                'observacao_finalizacao' => null,
                'historico' => [
                    [
                        'data' => now()->subHours(5)->format('d/m/Y H:i'),
                        'evento' => 'Chamado registrado via portal do cliente.',
                        'usuario' => 'Tenente Marcos Silveira',
                    ],
                    [
                        'data' => now()->subHours(4)->format('d/m/Y H:i'),
                        'evento' => 'Triagem realizada pela Central 24h. Equipe Alpha despachada com iluminador LED reserva.',
                        'usuario' => 'Central de Operações FOCO',
                    ],
                ],
            ],
            [
                'protocolo' => 'FOC-2026-8939',
                'tipo' => '06 - Acidente – Poste abalroado/danificado/cabos na via',
                'nome_solicitante' => 'Sargento Oliveira (Polícia Rodoviária)',
                'telefone_contato' => '(47) 99123-4567',
                'local' => 'Rodovia BR-101 Km 142 (Morro do Boi – Balneário Camboriú – SC)',
                'defeito' => 'Colisão de veículo de carga contra coluna galvanizada do semáforo de obras, danificando leito de cabeamento.',
                'observacao' => 'Coluna semafórica abalroada com inclinação perigosa, fiação exposta e semáforo pendurado.',
                'data_hora_abertura' => now()->subDay(),
                'status' => 'Em Atendimento',
                'tecnico_responsavel' => 'Equipe de Infraestrutura Pesada FOCO',
                'conserto_executado' => null,
                'data_hora_execucao' => null,
                'observacao_finalizacao' => null,
                'historico' => [
                    [
                        'data' => now()->subDay()->format('d/m/Y H:i'),
                        'evento' => 'Acionamento de emergência via Plantão Rodoviário.',
                        'usuario' => 'Sargento Oliveira',
                    ],
                    [
                        'data' => now()->subDay()->addHours(1)->format('d/m/Y H:i'),
                        'evento' => 'Despacho de caminhão guindaste e isolamento elétrico.',
                        'usuario' => 'Central 24h',
                    ],
                ],
            ],
            [
                'protocolo' => 'FOC-2026-8938',
                'tipo' => '02 - FA – Fora de Ação (todos semáforos desligados)',
                'nome_solicitante' => 'Rodrigo Dutra (Secretaria de Mobilidade)',
                'telefone_contato' => '(51) 99777-8899',
                'local' => 'Av. Getúlio Vargas x Rua Domingos Martins (Canoas – RS)',
                'defeito' => 'Fora de Ação (FA) - Todos os semáforos desligados sem sinalização luminosa.',
                'observacao' => 'Queda de energia no bairro com descarga atmosférica que acionou fusível de proteção geral.',
                'data_hora_abertura' => now()->subDays(2),
                'status' => 'Finalizado',
                'tecnico_responsavel' => 'Eng. Ricardo Silveira (Equipe Beta)',
                'conserto_executado' => 'Substituição do módulo de proteção contra surtos (DPS), reset da placa de potência da controladora Digicon e recalibração dos grupos focais a LED. Sincronismo e onda verde restabelecidos com 100% de êxito.',
                'data_hora_execucao' => now()->subDays(2)->addHours(3),
                'observacao_finalizacao' => 'Cruzamento normalizado e validado na Central em Nuvem Digicon às '.now()->subDays(2)->addHours(3)->format('H:i').'. Ordem de serviço concluída.',
                'historico' => [
                    [
                        'data' => now()->subDays(2)->format('d/m/Y H:i'),
                        'evento' => 'Abertura de chamado por Foco Apagado.',
                        'usuario' => 'Rodrigo Dutra',
                    ],
                    [
                        'data' => now()->subDays(2)->addHours(1)->format('d/m/Y H:i'),
                        'evento' => 'Equipe Beta em deslocamento ao cruzamento.',
                        'usuario' => 'Central de Operações',
                    ],
                    [
                        'data' => now()->subDays(2)->addHours(3)->format('d/m/Y H:i'),
                        'evento' => 'Chamado Finalizado. Conserto executado e testado.',
                        'usuario' => 'Eng. Ricardo Silveira',
                    ],
                ],
            ],
        ];

        foreach ($chamados as $item) {
            Chamado::updateOrCreate(
                ['protocolo' => $item['protocolo']],
                $item
            );
        }
    }
}

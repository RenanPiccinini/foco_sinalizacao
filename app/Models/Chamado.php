<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chamado extends Model
{
    use HasFactory;

    protected $table = 'chamados';

    protected $fillable = [
        'protocolo',
        'tipo',
        'nome_solicitante',
        'telefone_contato',
        'local',
        'defeito',
        'observacao',
        'data_hora_abertura',
        'status',
        'conserto_executado',
        'data_hora_execucao',
        'observacao_finalizacao',
        'tecnico_responsavel',
        'historico',
    ];

    protected $casts = [
        'data_hora_abertura' => 'datetime',
        'data_hora_execucao' => 'datetime',
        'historico' => 'array',
    ];

    /**
     * Gera um número de protocolo único no formato FOC-AAAA-XXXX
     */
    public static function gerarProtocolo(): string
    {
        do {
            $num = str_pad((string) mt_rand(1000, 9999), 4, '0', STR_PAD_LEFT);
            $protocolo = 'FOC-' . date('Y') . '-' . $num;
        } while (static::where('protocolo', $protocolo)->exists());

        return $protocolo;
    }

    /**
     * Adiciona um evento na trilha de auditoria digital do chamado
     */
    public function adicionarHistorico(string $evento, ?string $usuario = null): void
    {
        $historico = $this->historico ?? [];
        $historico[] = [
            'data' => now()->format('d/m/Y H:i'),
            'evento' => $evento,
            'usuario' => $usuario ?? auth()->user()?->name ?? 'Sistema Foco',
        ];

        $this->historico = $historico;
    }

    /**
     * Retorna a classe de cor da badge para o tipo de chamado
     */
    public function getTipoBadgeClassAttribute(): string
    {
        return match ($this->tipo) {
            'AP' => 'bg-amber-500/20 text-amber-300 border border-amber-500/30',
            'FA' => 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30',
            'Acidente' => 'bg-rose-500/20 text-rose-300 border border-rose-500/30',
            'Vermelho Queimado' => 'bg-red-500/20 text-red-300 border border-red-500/30',
            default => 'bg-slate-500/20 text-slate-300',
        };
    }

    /**
     * Retorna a classe de cor da badge para o status
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'Aberto' => 'bg-amber-500/20 text-amber-300 border border-amber-500/30',
            'Em Atendimento' => 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30',
            'Finalizado' => 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30',
            default => 'bg-slate-500/20 text-slate-300',
        };
    }
}


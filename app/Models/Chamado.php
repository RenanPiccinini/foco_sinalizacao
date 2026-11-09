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

    public const DEFEITOS_RECLAMADOS = [
        '01' => 'AP – Amarelo Piscante',
        '02' => 'FA – Fora de Ação (todos semáforos desligados)',
        '03' => 'FA – Fora de Ação (Semáforo desligado parcialmente)',
        '04' => 'Semáforo - abalroado/pendurado/desalinhado/danificado',
        '05' => 'Semáforo - com duas cores/travado',
        '06' => 'Acidente – Poste abalroado/danificado/cabos na via',
        '07' => 'Cruzamento sem sincronismo/ajuste de tempos',
        '08' => 'Botoeira de pedestre com defeito/danificada/sem funcionamento',
    ];

    /**
     * Normaliza e valida se o valor informado corresponde a um dos defeitos oficiais da tabela.
     * Retorna sempre no formato padronizado "XX - Defeito Reclamado".
     */
    public static function formatarTipo(string $valor): string
    {
        $valorLimpo = trim($valor);

        // Mapeamento de códigos numéricos diretos (ex: '01', '1', etc.)
        $codigoPad = str_pad($valorLimpo, 2, '0', STR_PAD_LEFT);
        if (isset(self::DEFEITOS_RECLAMADOS[$codigoPad])) {
            return "{$codigoPad} - ".self::DEFEITOS_RECLAMADOS[$codigoPad];
        }

        // Mapeamento por texto exato ou já prefixado
        foreach (self::DEFEITOS_RECLAMADOS as $codigo => $descricao) {
            if ($valorLimpo === $descricao || $valorLimpo === "{$codigo} - {$descricao}") {
                return "{$codigo} - {$descricao}";
            }
        }

        // Compatibilidade reversa com termos legados do sistema
        if ($valorLimpo === 'AP') {
            return '01 - '.self::DEFEITOS_RECLAMADOS['01'];
        }
        if ($valorLimpo === 'FA') {
            return '02 - '.self::DEFEITOS_RECLAMADOS['02'];
        }
        if ($valorLimpo === 'Acidente') {
            return '06 - '.self::DEFEITOS_RECLAMADOS['06'];
        }
        if ($valorLimpo === 'Vermelho Queimado') {
            return '05 - '.self::DEFEITOS_RECLAMADOS['05'];
        }

        return $valorLimpo;
    }

    /**
     * Gera um número de protocolo único no formato FOC-AAAA-XXXX
     */
    public static function gerarProtocolo(): string
    {
        do {
            $num = str_pad((string) mt_rand(1000, 9999), 4, '0', STR_PAD_LEFT);
            $protocolo = 'FOC-'.date('Y').'-'.$num;
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
        return match (true) {
            str_contains($this->tipo, '01') || str_contains($this->tipo, 'Amarelo Piscante') || $this->tipo === 'AP' => 'bg-amber-500/20 text-amber-300 border border-amber-500/30',
            str_contains($this->tipo, '02') || str_contains($this->tipo, 'todos semáforos desligados') => 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30',
            str_contains($this->tipo, '03') || str_contains($this->tipo, 'desligado parcialmente') || $this->tipo === 'FA' => 'bg-sky-500/20 text-sky-300 border border-sky-500/30',
            str_contains($this->tipo, '04') || str_contains($this->tipo, 'abalroado/pendurado') || str_contains($this->tipo, 'Semáforo - abalroado') => 'bg-orange-500/20 text-orange-300 border border-orange-500/30',
            str_contains($this->tipo, '05') || str_contains($this->tipo, 'duas cores') || str_contains($this->tipo, 'travado') => 'bg-purple-500/20 text-purple-300 border border-purple-500/30',
            str_contains($this->tipo, '06') || str_contains($this->tipo, 'Acidente') || str_contains($this->tipo, 'cabos na via') => 'bg-rose-500/20 text-rose-300 border border-rose-500/30',
            str_contains($this->tipo, '07') || str_contains($this->tipo, 'sincronismo') || str_contains($this->tipo, 'ajuste de tempos') => 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30',
            str_contains($this->tipo, '08') || str_contains($this->tipo, 'Botoeira') => 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30',
            default => 'bg-slate-500/20 text-slate-300 border border-slate-500/30',
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

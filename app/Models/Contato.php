<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contato extends Model
{
    use HasFactory;

    protected $table = 'contatos';

    protected $fillable = [
        'protocolo',
        'user_id',
        'empresa',
        'responsavel',
        'fone',
        'email',
        'endereco',
        'cnpj',
        'arquivo_path',
        'arquivo_nome',
        'assunto',
        'descricao',
        'status',
        'ip',
    ];

    public const ASSUNTO_COMPRA_DIRETA = 'ORÇAMENTO COMPRA DIRETA';

    public const ASSUNTO_MONTAR_PROCESSO = 'ORÇAMENTO PARA MONTAR PROCESSO';

    public const ASSUNTO_QUESTIONAMENTO = 'QUESTIONAMENTO/SOLICITAÇÃO/OUTROS';

    public const ASSUNTO_ORCAMENTO_COMPRA_DIRETA = self::ASSUNTO_COMPRA_DIRETA;

    public const ASSUNTO_ORCAMENTO_MONTAR_PROCESSO = self::ASSUNTO_MONTAR_PROCESSO;

    public const ASSUNTOS = [
        self::ASSUNTO_COMPRA_DIRETA,
        self::ASSUNTO_MONTAR_PROCESSO,
        self::ASSUNTO_QUESTIONAMENTO,
    ];

    /**
     * Gera um número de protocolo único para a solicitação (formato SOL-AAAA-XXXX)
     */
    public static function gerarProtocolo(): string
    {
        do {
            $num = str_pad((string) mt_rand(1000, 9999), 4, '0', STR_PAD_LEFT);
            $protocolo = 'SOL-'.date('Y').'-'.$num;
        } while (static::where('protocolo', $protocolo)->exists());

        return $protocolo;
    }

    /**
     * Usuário que realizou a solicitação (se logado)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Badge de status
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'Novo' => 'bg-amber-500/20 text-amber-300 border border-amber-500/30',
            'Em Análise' => 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30',
            'Respondido' => 'bg-emerald-500/20 text-emerald-300 border border-emerald-500/30',
            default => 'bg-slate-500/20 text-slate-300',
        };
    }
}

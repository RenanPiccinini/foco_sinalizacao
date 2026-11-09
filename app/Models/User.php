<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    /**
     * Verifica se o usuário é administrador do sistema
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->email === 'admin@focosinalizacao.com.br';
    }

    /**
     * Verifica se é o Administrador Master da FOCO
     */
    public function isMasterAdmin(): bool
    {
        return $this->email === 'admin@focosinalizacao.com.br';
    }

    /**
     * Verifica se o usuário está ativo
     */
    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }

    /**
     * Verifica se o usuário está bloqueado
     */
    public function isBlocked(): bool
    {
        return ! $this->is_active;
    }

    /**
     * Solicitações e contatos abertos por este usuário
     */
    public function contatos(): HasMany
    {
        return $this->hasMany(Contato::class);
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@focosinalizacao.com.br'],
            [
                'name' => 'Diretoria Operacional (Admin Master)',
                'password' => bcrypt('admin1234'),
                'role' => 'admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'cliente@prefeitura.gov.br'],
            [
                'name' => 'Secretaria de Mobilidade Urbana',
                'password' => bcrypt('cliente1234'),
                'role' => 'cliente',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        $this->call(ChamadoSeeder::class);
    }
}

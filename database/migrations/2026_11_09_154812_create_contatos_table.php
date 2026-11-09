<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contatos', function (Blueprint $table) {
            $table->id();
            $table->string('protocolo', 50)->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('empresa', 180);
            $table->string('responsavel', 120);
            $table->string('fone', 40);
            $table->string('email', 120);
            $table->string('endereco', 255);
            $table->string('cnpj', 30);
            $table->string('arquivo_path', 255)->nullable();
            $table->string('arquivo_nome', 255)->nullable();
            $table->string('assunto', 80);
            $table->text('descricao');
            $table->string('status', 30)->default('Novo');
            $table->string('ip', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contatos');
    }
};

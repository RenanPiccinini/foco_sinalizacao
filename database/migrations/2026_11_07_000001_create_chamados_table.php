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
        Schema::create('chamados', function (Blueprint $table) {
            $table->id();
            $table->string('protocolo')->unique()->index();
            $table->string('tipo'); // AP, FA, Acidente, Vermelho Queimado
            $table->string('nome_solicitante');
            $table->string('telefone_contato');
            $table->string('local');
            $table->text('defeito');
            $table->text('observacao')->nullable();
            $table->timestamp('data_hora_abertura')->useCurrent();
            $table->string('status')->default('Aberto')->index(); // Aberto, Em Atendimento, Finalizado

            // Campos preenchidos pela FOCO ao finalizar no gerenciador
            $table->text('conserto_executado')->nullable();
            $table->timestamp('data_hora_execucao')->nullable();
            $table->text('observacao_finalizacao')->nullable();
            $table->string('tecnico_responsavel')->nullable();

            // Trilha de auditoria / eventos
            $table->json('historico')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chamados');
    }
};

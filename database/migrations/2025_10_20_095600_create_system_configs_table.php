<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela para configurações gerais do sistema
        Schema::create('system_configs', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Chave única da configuração
            $table->text('value')->nullable(); // Valor da configuração
            $table->string('type')->default('string'); // Tipo: string, boolean, integer, json
            $table->string('group')->nullable(); // Grupo: ai_agent, facebook, instagram, general
            $table->string('label')->nullable(); // Label para exibição
            $table->text('description')->nullable(); // Descrição da configuração
            $table->boolean('is_encrypted')->default(false); // Se valor é criptografado
            $table->boolean('is_public')->default(false); // Se pode ser acessado publicamente
            $table->timestamps();
            
            $table->index('key');
            $table->index('group');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_configs');
    }
};

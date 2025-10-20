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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Chave única da configuração
            $table->text('value')->nullable(); // Valor da configuração
            $table->string('type')->default('string'); // Tipo: string, boolean, number, json
            $table->string('group')->default('general'); // Grupo: general, sms, payment, etc.
            $table->string('label'); // Label amigável
            $table->text('description')->nullable(); // Descrição da configuração
            $table->boolean('is_encrypted')->default(false); // Se deve ser criptografado
            $table->timestamps();
            
            $table->index(['group']);
            $table->index(['key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

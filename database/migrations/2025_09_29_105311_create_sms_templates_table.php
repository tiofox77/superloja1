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
        Schema::create('sms_templates', function (Blueprint $table) {
            $table->id();
            $table->string('type')->unique(); // order_created, order_confirmed, order_shipped, etc.
            $table->string('name'); // Nome amigável do template
            $table->text('message'); // Template da mensagem SMS
            $table->boolean('is_active')->default(true); // Ativar/desativar
            $table->json('variables')->nullable(); // Variáveis disponíveis no template
            $table->timestamps();
            
            $table->index('type');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sms_templates');
    }
};

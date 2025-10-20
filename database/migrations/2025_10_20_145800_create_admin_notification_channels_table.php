<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Canais de notificação configuráveis por admin
        Schema::create('admin_notification_channels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            // Canais disponíveis
            $table->boolean('email_enabled')->default(true);
            $table->boolean('sms_enabled')->default(false);
            $table->boolean('facebook_messenger_enabled')->default(false);
            $table->boolean('instagram_enabled')->default(false);
            $table->boolean('browser_enabled')->default(true); // Notificação no painel
            
            // Configurações específicas
            $table->string('email')->nullable(); // Email alternativo
            $table->string('phone')->nullable(); // Telefone para SMS
            $table->string('facebook_messenger_id')->nullable(); // ID do Messenger
            $table->string('instagram_id')->nullable(); // ID do Instagram
            
            // Filtros de quando receber
            $table->json('notification_types')->nullable(); // Tipos específicos
            $table->boolean('urgent_only')->default(false); // Só urgências
            $table->json('quiet_hours')->nullable(); // Horários de silêncio
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_notification_channels');
    }
};

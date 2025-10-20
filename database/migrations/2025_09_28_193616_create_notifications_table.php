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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('type'); // order_status, auction_status, product_request, new_order, new_auction, new_request
            $table->string('title');
            $table->text('message');
            $table->json('data')->nullable(); // dados extras (order_id, auction_id, etc)
            $table->boolean('is_read')->default(false);
            $table->boolean('is_admin')->default(false); // true para notificações admin
            $table->string('icon')->nullable(); // ícone da notificação
            $table->string('color')->default('blue'); // cor da notificação
            $table->string('action_url')->nullable(); // URL para ação
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'is_read']);
            $table->index(['is_admin', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

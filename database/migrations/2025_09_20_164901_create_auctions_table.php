<?php

declare(strict_types=1);

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
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            
            // Preços
            $table->decimal('starting_price', 10, 2);
            $table->decimal('reserve_price', 10, 2)->nullable(); // Preço mínimo
            $table->decimal('current_bid', 10, 2)->default(0);
            $table->decimal('buy_now_price', 10, 2)->nullable(); // Comprar já
            
            // Datas e tempos
            $table->timestamp('start_time');
            $table->timestamp('end_time');
            $table->integer('duration_minutes')->default(1440); // 24h default
            
            // Status
            $table->enum('status', ['draft', 'active', 'ended', 'cancelled', 'sold'])->default('draft');
            $table->boolean('auto_extend')->default(true); // Extensão automática
            $table->integer('extend_minutes')->default(5);
            
            // Participação
            $table->integer('bid_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->integer('watcher_count')->default(0);
            
            // Vencedor
            $table->foreignId('winner_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('winning_bid', 10, 2)->nullable();
            $table->timestamp('won_at')->nullable();
            
            // Configurações
            $table->decimal('bid_increment', 10, 2)->default(1000); // Incremento mínimo
            $table->integer('max_bid_count')->nullable(); // Limite de lances
            $table->boolean('private_auction')->default(false);
            
            $table->timestamps();
            
            // Indexes
            $table->index(['status', 'end_time']);
            $table->index(['start_time', 'end_time']);
            $table->index('current_bid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('auctions');
    }
};

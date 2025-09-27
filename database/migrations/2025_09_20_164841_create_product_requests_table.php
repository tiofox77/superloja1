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
        Schema::create('product_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name'); // Nome do solicitante (se não logado)
            $table->string('email'); // Email do solicitante
            $table->string('phone')->nullable();
            $table->string('product_name');
            $table->text('description');
            $table->string('brand')->nullable();
            $table->string('model')->nullable();
            $table->decimal('budget_min', 10, 2)->nullable();
            $table->decimal('budget_max', 10, 2)->nullable();
            $table->enum('urgency', ['low', 'medium', 'high'])->default('medium');
            $table->enum('condition_preference', ['new', 'used', 'any'])->default('any');
            $table->json('images')->nullable(); // Imagens de referência
            $table->enum('status', ['pending', 'in_progress', 'matched', 'closed'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->foreignId('matched_product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
            
            $table->index(['status', 'created_at']);
            $table->index(['user_id', 'status']);
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_requests');
    }
};

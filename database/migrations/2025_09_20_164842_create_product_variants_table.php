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
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('name'); // ex: "Tamanho", "Cor", "Material"
            $table->string('value'); // ex: "M", "Azul", "Algodão"
            $table->decimal('price_adjustment', 10, 2)->default(0); // Ajuste no preço
            $table->integer('stock_quantity')->default(0);
            $table->string('sku_suffix')->nullable(); // Sufixo para o SKU
            $table->json('images')->nullable(); // Imagens específicas da variante
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
            
            $table->index(['product_id', 'is_active']);
            $table->unique(['product_id', 'name', 'value']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};

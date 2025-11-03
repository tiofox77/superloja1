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
        Schema::table('products', function (Blueprint $table) {
            // Remover a foreign key existente
            $table->dropForeign(['category_id']);
            
            // Alterar a coluna para nullable
            $table->foreignId('category_id')->nullable()->change();
            
            // Recriar a foreign key com onDelete('set null')
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Remover a foreign key
            $table->dropForeign(['category_id']);
            
            // Voltar para NOT NULL
            $table->foreignId('category_id')->nullable(false)->change();
            
            // Recriar a foreign key com onDelete('restrict')
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('restrict');
        });
    }
};

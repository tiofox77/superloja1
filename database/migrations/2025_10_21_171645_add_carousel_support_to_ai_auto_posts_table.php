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
        Schema::table('ai_auto_posts', function (Blueprint $table) {
            // Adicionar campo para armazenar múltiplos IDs de produtos (para carrossel)
            $table->json('product_ids')->nullable()->after('product_id');
            
            // Modificar product_id para ser nullable (quando for carrossel, usa product_ids)
            $table->unsignedBigInteger('product_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_auto_posts', function (Blueprint $table) {
            $table->dropColumn('product_ids');
        });
    }
};

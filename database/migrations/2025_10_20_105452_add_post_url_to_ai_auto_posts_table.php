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
            $table->string('post_url')->nullable()->after('external_post_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ai_auto_posts', function (Blueprint $table) {
            $table->dropColumn('post_url');
        });
    }
};

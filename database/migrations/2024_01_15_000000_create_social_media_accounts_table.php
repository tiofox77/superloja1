<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_media_accounts', function (Blueprint $table) {
            $table->id();
            $table->enum('platform', ['facebook', 'instagram']);
            $table->string('account_name');
            $table->string('page_id');
            $table->text('access_token');
            $table->text('refresh_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('auto_post')->default(false);
            $table->json('post_schedule')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->unique(['platform', 'page_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_media_accounts');
    }
};

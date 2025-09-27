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
        Schema::create('social_media_configs', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // facebook, instagram, twitter, etc
            $table->string('page_id')->nullable();
            $table->text('access_token')->nullable();
            $table->text('app_id')->nullable();
            $table->text('app_secret')->nullable();
            $table->boolean('is_active')->default(false);
            $table->boolean('auto_post')->default(false);
            $table->json('post_settings')->nullable(); // configurações específicas
            $table->timestamp('token_expires_at')->nullable();
            $table->timestamps();
            
            $table->unique('platform');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_media_configs');
    }
};

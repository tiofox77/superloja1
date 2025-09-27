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
        Schema::table('users', function (Blueprint $table) {
            // Campos pessoais
            $table->string('first_name')->after('name')->nullable();
            $table->string('last_name')->after('first_name')->nullable();
            $table->string('phone')->after('email')->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            
            // Endereço
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->default('Angola');
            
            // Perfil
            $table->string('avatar')->nullable();
            $table->enum('role', ['customer', 'admin', 'manager'])->default('customer');
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login_at')->nullable();
            
            // Preferências
            $table->json('preferences')->nullable();
            $table->boolean('newsletter_subscribed')->default(false);
            $table->boolean('sms_notifications')->default(false);
            
            // Verificação
            $table->boolean('phone_verified')->default(false);
            $table->timestamp('phone_verified_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'first_name', 'last_name', 'phone', 'birth_date', 'gender',
                'address', 'city', 'province', 'postal_code', 'country',
                'avatar', 'role', 'is_active', 'last_login_at',
                'preferences', 'newsletter_subscribed', 'sms_notifications',
                'phone_verified', 'phone_verified_at'
            ]);
        });
    }
};

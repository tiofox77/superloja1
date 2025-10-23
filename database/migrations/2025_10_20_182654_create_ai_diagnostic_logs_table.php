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
        Schema::create('ai_diagnostic_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_identifier');
            $table->string('issue_type'); // unsatisfied_with_suggestions, repetition_detected, transfer_to_human, etc
            $table->text('customer_message');
            $table->text('ai_response')->nullable();
            $table->json('context_data')->nullable();
            $table->enum('severity', ['low', 'medium', 'high'])->default('medium');
            $table->boolean('resolved')->default(false);
            $table->text('admin_notes')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
            
            $table->index('customer_id');
            $table->index('issue_type');
            $table->index('severity');
            $table->index('resolved');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ai_diagnostic_logs');
    }
};

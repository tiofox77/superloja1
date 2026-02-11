<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Drop all AI, Chatbot, Messenger, Auto Post and Social Media tables
     */
    public function up(): void
    {
        // Desativar foreign key checks para evitar erros de constraint
        Schema::disableForeignKeyConstraints();

        // Drop AI tables
        Schema::dropIfExists('ai_messages');
        Schema::dropIfExists('ai_agent_actions');
        Schema::dropIfExists('ai_sentiment_analysis');
        Schema::dropIfExists('ai_conversations');
        Schema::dropIfExists('ai_customer_contexts');
        Schema::dropIfExists('ai_auto_posts');
        Schema::dropIfExists('ai_agent_configs');
        Schema::dropIfExists('ai_integration_tokens');
        Schema::dropIfExists('ai_knowledge_bases');
        Schema::dropIfExists('ai_product_insights');
        Schema::dropIfExists('ai_performance_metrics');
        Schema::dropIfExists('ai_diagnostic_logs');

        // Drop Social Media tables
        Schema::dropIfExists('social_media_posts');
        Schema::dropIfExists('social_media_accounts');
        Schema::dropIfExists('social_media_configs');

        // Drop notification/config tables
        Schema::dropIfExists('admin_notification_channels');
        Schema::dropIfExists('system_configs');

        // Reativar foreign key checks
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // These tables are permanently removed - no rollback
    }
};

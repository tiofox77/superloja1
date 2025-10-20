<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabela principal do AI Agent
        Schema::create('ai_agent_config', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('SuperLoja AI Assistant');
            $table->boolean('is_active')->default(true);
            $table->boolean('instagram_enabled')->default(false);
            $table->boolean('messenger_enabled')->default(false);
            $table->boolean('auto_post_enabled')->default(false);
            $table->text('system_prompt')->nullable();
            $table->json('capabilities')->nullable(); // ['product_search', 'recommendations', 'analytics']
            $table->json('settings')->nullable();
            $table->timestamps();
        });

        // Conversas do Agent
        Schema::create('ai_conversations', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // 'instagram', 'messenger', 'whatsapp'
            $table->string('external_id'); // ID da conversa na plataforma externa
            $table->string('customer_name')->nullable();
            $table->string('customer_identifier'); // Username ou ID
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Se vincular a usuário
            $table->string('status')->default('active'); // active, closed, archived
            $table->timestamp('last_message_at')->nullable();
            $table->timestamps();
            
            $table->index(['platform', 'external_id']);
        });

        // Mensagens do Agent
        Schema::create('ai_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('ai_conversations')->cascadeOnDelete();
            $table->enum('direction', ['incoming', 'outgoing']);
            $table->enum('sender_type', ['customer', 'agent', 'human']); // quem enviou
            $table->text('message');
            $table->json('metadata')->nullable(); // attachments, reactions, etc
            $table->json('ai_context')->nullable(); // contexto da IA para essa mensagem
            $table->boolean('is_read')->default(false);
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            
            $table->index('conversation_id');
        });

        // Análises e Insights do Agent
        Schema::create('ai_product_insights', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->integer('total_views')->default(0);
            $table->integer('total_sales')->default(0);
            $table->decimal('total_revenue', 12, 2)->default(0);
            $table->decimal('conversion_rate', 5, 2)->default(0); // %
            $table->integer('times_recommended')->default(0);
            $table->integer('times_clicked')->default(0);
            $table->decimal('avg_rating', 3, 2)->default(0);
            $table->json('customer_questions')->nullable(); // perguntas frequentes
            $table->json('ai_recommendations')->nullable(); // recomendações da IA
            $table->string('performance_status'); // 'hot', 'cold', 'steady', 'declining'
            $table->date('analysis_date');
            $table->timestamps();
            
            $table->index(['product_id', 'analysis_date']);
        });

        // Posts automáticos do Agent
        Schema::create('ai_auto_posts', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // 'facebook', 'instagram'
            $table->string('post_type'); // 'product', 'promotion', 'news', 'tip'
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->text('content');
            $table->json('media_urls')->nullable(); // URLs das imagens/vídeos
            $table->json('hashtags')->nullable();
            $table->string('status'); // 'scheduled', 'posted', 'failed'
            $table->string('external_post_id')->nullable(); // ID do post na plataforma
            $table->timestamp('scheduled_for')->nullable();
            $table->timestamp('posted_at')->nullable();
            $table->json('engagement_metrics')->nullable(); // likes, comments, shares
            $table->text('error_message')->nullable();
            $table->timestamps();
            
            $table->index('status');
        });

        // Ações e decisões do Agent
        Schema::create('ai_agent_actions', function (Blueprint $table) {
            $table->id();
            $table->string('action_type'); // 'product_recommendation', 'price_suggestion', 'post_creation'
            $table->text('description');
            $table->json('context')->nullable(); // contexto da decisão
            $table->json('result')->nullable();
            $table->string('status'); // 'executed', 'pending', 'failed'
            $table->boolean('requires_approval')->default(false);
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();
        });

        // Integrações com APIs externas
        Schema::create('ai_integration_tokens', function (Blueprint $table) {
            $table->id();
            $table->string('platform'); // 'facebook', 'instagram'
            $table->text('access_token');
            $table->text('refresh_token')->nullable();
            $table->string('page_id')->nullable();
            $table->string('page_name')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('permissions')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_integration_tokens');
        Schema::dropIfExists('ai_agent_actions');
        Schema::dropIfExists('ai_auto_posts');
        Schema::dropIfExists('ai_product_insights');
        Schema::dropIfExists('ai_messages');
        Schema::dropIfExists('ai_conversations');
        Schema::dropIfExists('ai_agent_config');
    }
};

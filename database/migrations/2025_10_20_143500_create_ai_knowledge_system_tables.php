<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Base de Conhecimento (FAQ Automático)
        Schema::create('ai_knowledge_base', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // 'faq', 'product_info', 'policy', 'support'
            $table->text('question');
            $table->text('answer');
            $table->json('keywords')->nullable(); // palavras-chave para matching
            $table->integer('times_used')->default(0);
            $table->integer('times_successful')->default(0);
            $table->decimal('success_rate', 5, 2)->default(0); // %
            $table->json('related_products')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('category');
            $table->index('is_active');
        });

        // Análise de Sentimento das Mensagens
        Schema::create('ai_sentiment_analysis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('message_id')->constrained('ai_messages')->cascadeOnDelete();
            $table->foreignId('conversation_id')->constrained('ai_conversations')->cascadeOnDelete();
            $table->string('sentiment'); // positive, negative, neutral, urgent
            $table->decimal('confidence', 5, 2); // 0-100%
            $table->json('emotions')->nullable(); // ['joy', 'frustration', 'interest']
            $table->json('keywords')->nullable(); // palavras-chave detectadas
            $table->boolean('needs_human_attention')->default(false);
            $table->string('priority')->default('normal'); // low, normal, high, urgent
            $table->timestamps();
            
            $table->index('sentiment');
            $table->index('needs_human_attention');
        });

        // Contexto e Memória de Clientes
        Schema::create('ai_customer_context', function (Blueprint $table) {
            $table->id();
            $table->string('customer_identifier')->unique(); // Unifica entre plataformas
            $table->string('customer_name')->nullable();
            $table->string('preferred_platform')->nullable();
            $table->json('platforms')->nullable(); // ['facebook', 'instagram']
            $table->json('interests')->nullable(); // produtos/categorias de interesse
            $table->json('purchase_history')->nullable();
            $table->json('conversation_summary')->nullable(); // resumo de conversas
            $table->integer('total_conversations')->default(0);
            $table->integer('total_purchases')->default(0);
            $table->decimal('total_spent', 12, 2)->default(0);
            $table->string('customer_segment')->nullable(); // vip, regular, new, at_risk
            $table->timestamp('last_interaction_at')->nullable();
            $table->timestamps();
        });

        // Aprendizado e Feedback
        Schema::create('ai_learning_feedback', function (Blueprint $table) {
            $table->id();
            $table->foreignId('conversation_id')->constrained('ai_conversations')->cascadeOnDelete();
            $table->foreignId('message_id')->nullable()->constrained('ai_messages')->cascadeOnDelete();
            $table->string('feedback_type'); // 'conversion', 'satisfaction', 'issue_resolved'
            $table->string('result'); // success, failure, partial
            $table->json('context')->nullable(); // contexto da interação
            $table->json('products_mentioned')->nullable();
            $table->boolean('led_to_purchase')->default(false);
            $table->decimal('purchase_value', 12, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index('feedback_type');
            $table->index('led_to_purchase');
        });

        // Métricas de Performance da IA
        Schema::create('ai_performance_metrics', function (Blueprint $table) {
            $table->id();
            $table->date('metric_date');
            $table->integer('total_conversations')->default(0);
            $table->integer('successful_responses')->default(0);
            $table->integer('failed_responses')->default(0);
            $table->decimal('response_success_rate', 5, 2)->default(0);
            $table->integer('conversions')->default(0);
            $table->decimal('conversion_rate', 5, 2)->default(0);
            $table->decimal('avg_response_time_seconds', 8, 2)->default(0);
            $table->integer('human_interventions')->default(0);
            $table->json('top_questions')->nullable();
            $table->json('top_products')->nullable();
            $table->decimal('customer_satisfaction_score', 3, 2)->nullable(); // 0-5
            $table->timestamps();
            
            $table->unique('metric_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_performance_metrics');
        Schema::dropIfExists('ai_learning_feedback');
        Schema::dropIfExists('ai_customer_context');
        Schema::dropIfExists('ai_sentiment_analysis');
        Schema::dropIfExists('ai_knowledge_base');
    }
};

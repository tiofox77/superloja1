<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AiKnowledgeBase;
use App\Models\AiCustomerContext;
use App\Models\AiConversation;
use App\Models\AiMessage;
use Illuminate\Support\Facades\Log;

class AiKnowledgeService
{
    /**
     * Processar mensagem com contexto inteligente
     */
    public function processMessageWithContext(
        string $customerId,
        string $message,
        string $platform
    ): array {
        // 1. Buscar ou criar contexto do cliente
        $customerContext = $this->getOrCreateCustomerContext($customerId, $platform);

        // 2. Analisar sentimento
        $sentiment = $this->analyzeSentiment($message);

        // 3. Buscar conhecimento relevante
        $knowledge = $this->searchKnowledge($message);

        // 4. Gerar resposta com contexto
        $response = $this->generateContextualResponse(
            $message,
            $customerContext,
            $knowledge,
            $sentiment
        );

        // 5. Atualizar contexto em tempo real
        $customerContext->recordInteraction($platform, [
            'interests' => $this->extractInterests($message),
        ]);

        return [
            'response' => $response,
            'sentiment' => $sentiment,
            'knowledge_used' => $knowledge,
            'customer_segment' => $customerContext->customer_segment,
        ];
    }

    /**
     * Buscar ou criar contexto do cliente
     */
    private function getOrCreateCustomerContext(string $customerId, string $platform): AiCustomerContext
    {
        return AiCustomerContext::firstOrCreate(
            ['customer_identifier' => $customerId],
            [
                'preferred_platform' => $platform,
                'platforms' => [$platform],
                'customer_segment' => 'new',
                'last_interaction_at' => now(),
            ]
        );
    }

    /**
     * Análise de sentimento
     */
    private function analyzeSentiment(string $message): array
    {
        $message = strtolower($message);

        // Palavras-chave positivas
        $positive = ['obrigado', 'ótimo', 'excelente', 'adorei', 'perfeito', 'bom'];
        $positiveCount = 0;
        foreach ($positive as $word) {
            if (str_contains($message, $word)) $positiveCount++;
        }

        // Palavras-chave negativas
        $negative = ['problema', 'ruim', 'péssimo', 'errado', 'defeito', 'reclamar'];
        $negativeCount = 0;
        foreach ($negative as $word) {
            if (str_contains($message, $word)) $negativeCount++;
        }

        // Palavras-chave urgentes
        $urgent = ['urgente', 'rápido', 'agora', 'emergência', 'imediato'];
        $isUrgent = false;
        foreach ($urgent as $word) {
            if (str_contains($message, $word)) {
                $isUrgent = true;
                break;
            }
        }

        // Determinar sentimento
        if ($negativeCount > $positiveCount) {
            $sentiment = 'negative';
            $confidence = min(($negativeCount / max(1, strlen($message) / 100)) * 100, 100);
        } elseif ($positiveCount > $negativeCount) {
            $sentiment = 'positive';
            $confidence = min(($positiveCount / max(1, strlen($message) / 100)) * 100, 100);
        } else {
            $sentiment = 'neutral';
            $confidence = 50;
        }

        if ($isUrgent) {
            $sentiment = 'urgent';
        }

        return [
            'sentiment' => $sentiment,
            'confidence' => round($confidence, 2),
            'needs_human' => $negativeCount >= 2 || $isUrgent,
            'priority' => $isUrgent ? 'urgent' : ($negativeCount >= 2 ? 'high' : 'normal'),
        ];
    }

    /**
     * Buscar conhecimento relevante
     */
    private function searchKnowledge(string $message): ?AiKnowledgeBase
    {
        $message = strtolower($message);

        // Buscar conhecimento ativo
        $knowledge = AiKnowledgeBase::active()
            ->get()
            ->filter(function ($item) use ($message) {
                // Match por keywords
                if ($item->keywords) {
                    foreach ($item->keywords as $keyword) {
                        if (str_contains($message, strtolower($keyword))) {
                            return true;
                        }
                    }
                }
                
                // Match por pergunta
                similar_text(strtolower($item->question), $message, $percent);
                return $percent > 60; // 60% similaridade
            })
            ->sortByDesc(function ($item) use ($message) {
                similar_text(strtolower($item->question), $message, $percent);
                return $percent;
            })
            ->first();

        if ($knowledge) {
            // Registrar uso
            $knowledge->recordUsage(true);
        }

        return $knowledge;
    }

    /**
     * Gerar resposta contextual
     */
    private function generateContextualResponse(
        string $message,
        AiCustomerContext $context,
        ?AiKnowledgeBase $knowledge,
        array $sentiment
    ): string {
        // Se encontrou conhecimento na base
        if ($knowledge) {
            Log::info('Usando conhecimento da base', [
                'knowledge_id' => $knowledge->id,
                'question' => $knowledge->question,
            ]);
            
            return $this->personalizeResponse($knowledge->answer, $context);
        }

        // Resposta padrão baseada no contexto
        return $this->generateDefaultResponse($message, $context, $sentiment);
    }

    /**
     * Personalizar resposta
     */
    private function personalizeResponse(string $response, AiCustomerContext $context): string
    {
        // Adicionar nome se disponível
        if ($context->customer_name) {
            $response = $context->customer_name . ', ' . $response;
        }

        // Adicionar benefícios para VIPs
        if ($context->customer_segment === 'vip') {
            $response .= "\n\n✨ Como cliente VIP, você tem desconto especial!";
        }

        return $response;
    }

    /**
     * Gerar resposta padrão
     */
    private function generateDefaultResponse(
        string $message,
        AiCustomerContext $context,
        array $sentiment
    ): string {
        $message = strtolower($message);

        // Saudações
        if (preg_match('/^(olá|ola|oi|bom dia|boa tarde|boa noite|hey|hello)/i', $message)) {
            $greeting = $context->total_conversations > 0 
                ? "Olá novamente! 👋" 
                : "Olá! Bem-vindo à SuperLoja Angola! 👋";
            
            return $greeting . " Como posso ajudá-lo hoje?\n\n" . $this->getQuickOptions();
        }

        // Produtos
        if (str_contains($message, 'produto') || str_contains($message, 'vende')) {
            return "Temos uma grande variedade de produtos! 🛒\n\n" .
                   "Algumas categorias:\n" .
                   "📱 Tecnologia e Eletrônicos\n" .
                   "💊 Saúde e Bem-estar\n" .
                   "🧼 Produtos de Limpeza\n\n" .
                   "Visite: https://superloja.vip\n" .
                   "Ou me diga o que procura!";
        }

        // Preço
        if (str_contains($message, 'preço') || str_contains($message, 'custo')) {
            return "Para consultar preços:\n\n" .
                   "📱 WhatsApp: https://wa.me/244939729902\n" .
                   "🌐 Site: https://superloja.vip\n\n" .
                   "Ou me diga qual produto você procura! 😊";
        }

        // Entrega
        if (str_contains($message, 'entrega') || str_contains($message, 'envio')) {
            return "🚚 Fazemos entregas em Luanda e outras províncias!\n\n" .
                   "Entre em contato:\n" .
                   "📱 WhatsApp: https://wa.me/244939729902\n" .
                   "Para mais informações sobre prazos e valores.";
        }

        // Fallback
        return "Desculpe, não entendi bem. 😅\n\n" .
               "Posso ajudá-lo com:\n" .
               "• Informações sobre produtos\n" .
               "• Preços e promoções\n" .
               "• Entregas\n\n" .
               "Ou fale com nosso atendimento:\n" .
               "📱 https://wa.me/244939729902";
    }

    /**
     * Opções rápidas
     */
    private function getQuickOptions(): string
    {
        return "Pode me perguntar sobre:\n" .
               "📦 Produtos disponíveis\n" .
               "💰 Preços e promoções\n" .
               "🚚 Entregas\n" .
               "📱 Contato: https://wa.me/244939729902";
    }

    /**
     * Extrair interesses da mensagem
     */
    private function extractInterests(string $message): array
    {
        $interests = [];
        $message = strtolower($message);

        $categories = [
            'tecnologia' => ['laptop', 'computador', 'telefone', 'celular', 'macbook', 'iphone'],
            'saúde' => ['vitamina', 'suplemento', 'medicamento', 'remédio'],
            'limpeza' => ['detergente', 'sabão', 'desinfetante', 'limpeza'],
        ];

        foreach ($categories as $category => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($message, $keyword)) {
                    $interests[] = $category;
                    break;
                }
            }
        }

        return array_unique($interests);
    }

    /**
     * Aprender com feedback (chamar após venda ou interação)
     */
    public function recordFeedback(
        int $conversationId,
        bool $success,
        ?float $purchaseValue = null,
        array $products = []
    ): void {
        $conversation = AiConversation::find($conversationId);
        if (!$conversation) return;

        // Buscar contexto do cliente
        $context = AiCustomerContext::where(
            'customer_identifier',
            $conversation->customer_identifier
        )->first();

        if ($context && $success && $purchaseValue) {
            $context->recordPurchase($purchaseValue, $products);
        }

        Log::info('Feedback registrado', [
            'conversation_id' => $conversationId,
            'success' => $success,
            'value' => $purchaseValue,
        ]);
    }
}

<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AiKnowledgeBase;
use App\Models\AiCustomerContext;
use App\Models\AiConversation;
use App\Models\AiMessage;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class AiKnowledgeService
{
    private ?string $platform = null;
    private array $productList = []; // Lista de produtos para enviar via carousel
    
    /**
     * Processar mensagem com contexto inteligente
     */
    public function processMessageWithContext(
        string $customerId,
        string $message,
        string $platform,
        ?int $conversationId = null
    ): array {
        $this->platform = $platform; // Salvar plataforma para uso interno
        // 1. Buscar ou criar contexto do cliente
        $customerContext = $this->getOrCreateCustomerContext($customerId, $platform);

        // 2. Analisar sentimento
        $sentiment = $this->analyzeSentiment($message);

        // 3. Buscar conhecimento relevante
        $knowledge = $this->searchKnowledge($message);

        // 4. Verificar última mensagem para evitar repetições
        $lastResponse = $this->getLastResponse($conversationId);

        // 5. Gerar resposta com contexto
        $response = $this->generateContextualResponse(
            $message,
            $customerContext,
            $knowledge,
            $sentiment,
            $lastResponse
        );

        // 6. Atualizar contexto em tempo real
        $customerContext->recordInteraction($platform, [
            'interests' => $this->extractInterests($message),
        ]);

        return [
            'response' => $response,
            'sentiment' => $sentiment,
            'knowledge_used' => $knowledge,
            'products' => $this->productList, // Lista de produtos para carousel
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
     * Buscar última resposta da conversa
     */
    private function getLastResponse(?int $conversationId): ?string
    {
        if (!$conversationId) {
            return null;
        }

        $lastMessage = AiMessage::where('conversation_id', $conversationId)
            ->where('direction', 'outgoing')
            ->latest()
            ->first();

        return $lastMessage ? $lastMessage->message : null;
    }

    /**
     * Gerar resposta contextual
     */
    private function generateContextualResponse(
        string $message,
        AiCustomerContext $context,
        ?AiKnowledgeBase $knowledge,
        array $sentiment,
        ?string $lastResponse
    ): string {
        // Verificar histórico completo de repetições (50 mensagens)
        $recentHistory = $this->getRecentConversationHistory($context);
        $isRepeating = $this->detectRepetition($recentHistory, $lastResponse);
        
        // Verificar se cliente está insatisfeito com sugestões
        $isUnsatisfied = $this->detectUnsatisfaction($message, $lastResponse);
        
        // Log do contexto analisado
        Log::info('IA analisou contexto completo', [
            'customer' => $context->customer_name,
            'summary' => $recentHistory['context_summary'],
            'interests' => $recentHistory['customer_interests'],
            'products_mentioned' => $recentHistory['products_mentioned'],
            'sentiment' => $recentHistory['sentiment_trend'] ?? 'neutral',
        ]);
        
        // Se cliente está insatisfeito com sugestões
        if ($isUnsatisfied) {
            Log::warning('IA detectou insatisfação com sugestões', [
                'customer' => $context->customer_name,
                'message' => $message,
                'last_response' => substr($lastResponse ?? '', 0, 100)
            ]);
            
            // Criar log de diagnóstico
            $this->logAiDiagnostic($context, $message, 'unsatisfied_with_suggestions', [
                'last_response' => $lastResponse,
                'customer_feedback' => $message
            ]);
            
            // Perguntar mais detalhes
            return $this->askForMoreDetails($context, $message);
        }
        
        // Se detectou repetição, usar raciocínio alternativo
        if ($isRepeating) {
            Log::warning('IA detectou que está repetindo - Mudando estratégia', [
                'customer' => $context->customer_name,
                'repetitions' => $recentHistory['ai_repetition_count'],
                'context' => $recentHistory['context_summary']
            ]);
            
            // Log de diagnóstico
            $this->logAiDiagnostic($context, $message, 'repetition_detected', [
                'repetition_count' => $recentHistory['ai_repetition_count']
            ]);
            
            // Após 2 repetições, transferir para humano
            if ($recentHistory['ai_repetition_count'] >= 2) {
                return $this->transferToHuman($context, $message);
            }
            
            // Primeira repetição: tentar resposta alternativa
            return $this->generateAlternativeResponse($message, $context, $lastResponse);
        }
        
        // PRIORIDADE 1: IA responde primeiro (inteligente, busca produtos, conversa natural)
        // Passar contexto completo para resposta mais inteligente
        $aiResponse = $this->generateDefaultResponse($message, $context, $sentiment, $lastResponse, $recentHistory);
        
        // Se IA gerou resposta (não é fallback "não entendi")
        if (!str_contains($aiResponse, 'Não entendi bem sua pergunta')) {
            Log::info('IA respondeu com inteligência própria');
            return $aiResponse;
        }
        
        // PRIORIDADE 2: Base de conhecimento (apenas quando IA não souber)
        if ($knowledge) {
            Log::info('IA não soube responder - Usando base de conhecimento', [
                'knowledge_id' => $knowledge->id,
                'question' => $knowledge->question,
            ]);
            
            return $this->personalizeResponse($knowledge->answer, $context);
        }

        // PRIORIDADE 3: Fallback final (IA não sabe + sem conhecimento na base)
        Log::info('IA não soube + sem conhecimento na base = Transferindo para humano');
        return $this->transferToHuman($context, $message);
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
     * Gerar resposta padrão (com contexto de 50 mensagens)
     */
    private function generateDefaultResponse(
        string $message,
        AiCustomerContext $context,
        array $sentiment,
        ?string $lastResponse,
        array $fullHistory = []
    ): string {
        $messageLower = strtolower($message);
        
        // Extrair nome da mensagem se houver
        $customerName = $this->extractCustomerName($message, $context);
        
        // PRIORIDADE MÁXIMA: Cliente quer falar com humano
        if (preg_match('/(falar com|quero falar|chamar|chame|atendente|atendimento|pessoa|humano|gente|alguém|alguem|equipe|funcionário|funcionario)/i', $messageLower)) {
            Log::warning('Cliente solicitou atendimento humano explicitamente');
            return $this->transferToHuman($context, $message);
        }
        
        // Verificar se está em processo de checkout
        $checkoutService = app(\App\Services\CheckoutService::class);
        if ($checkoutService->isInCheckout($context)) {
            return $checkoutService->processCheckoutStep($context, $message, $customerName);
        }
        
        // Usar contexto histórico para resposta mais inteligente
        $interests = $fullHistory['customer_interests'] ?? [];
        $productsMentioned = $fullHistory['products_mentioned'] ?? [];
        $sentimentTrend = $fullHistory['sentiment_trend'] ?? 'neutral';

        // Saudações
        if (preg_match('/^(olá|ola|oi|bom dia|boa tarde|boa noite|hey|hello)/i', $message)) {
            $greetings = [
                "Olá{name}! 👋 Que bom ter você aqui!",
                "Oi{name}! 😊 Como posso te ajudar hoje?",
                "Olá{name}! Bem-vindo à SuperLoja! 🎉",
            ];
            
            $greeting = $greetings[array_rand($greetings)];
            $greeting = str_replace('{name}', $customerName ? " $customerName" : '', $greeting);
            
            // Se já conhece interesses do cliente, mencionar
            if (!empty($interests)) {
                $interestText = implode(', ', array_slice($interests, 0, 2));
                return $greeting . "\n\n" . 
                       "Vi que você tem interesse em {$interestText}! Posso te ajudar com isso? 😊";
            }
            
            return $greeting . "\n\n" . 
                   "Me diga: o que você procura? Posso te ajudar com produtos, preços ou qualquer dúvida! 😊";
        }

        // DETECÇÃO PRIORITÁRIA: Comandos simples diretos
        $simpleCommands = ['ver tudo', 'categorias', 'produtos', 'listar produtos', 'lista produtos'];
        foreach ($simpleCommands as $command) {
            if ($messageLower === $command || str_contains($messageLower, $command)) {
                Log::info('Comando simples detectado', ['command' => $command, 'message' => $messageLower]);
                return $this->listAvailableProducts($customerName, $messageLower);
            }
        }
        
        // Lista/Produtos - Buscar produtos reais do banco (EXPANDIDO)
        if (preg_match('/(lista|listar|quais|que produtos|produtos tem|produtos disponíveis|quero saber|saber os produtos|o que tem|dar uma lista|ver tudo|mostre tudo|mostrar tudo|quero ver|me mostre|me envia|envia|manda|enviar|mandar|lista completa|tudo que tem|todos.{0,15}produtos|ver.{0,10}produtos|produtos.{0,10}tem|lista.{0,10}produtos)/i', $messageLower)) {
            Log::info('Regex de produtos detectada', ['message' => $messageLower]);
            
            // Se cliente tem interesses específicos, priorizar produtos desses tipos
            if (!empty($interests) && !in_array('preço', $interests) && !in_array('entrega', $interests)) {
                $searchQuery = implode(' ', array_slice($interests, 0, 2));
                return $this->searchSpecificProducts($searchQuery, $customerName);
            }
            
            // Buscar produtos reais gerais
            return $this->listAvailableProducts($customerName, $messageLower);
        }
        
        // Busca específica por categoria ou tipo de produto (EXPANDIDO)
        // Padrões de busca de produtos
        $productPatterns = [
            // Eletrônicos
            'fone', 'fones', 'auricular', 'auriculares', 'escutador', 'escutadores', 
            'headphone', 'earphone', 'ouvido',
            // Tecnologia
            'laptop', 'smartphone', 'telefone', 'celular', 'tablet', 'computador',
            'mouse', 'teclado', 'cabo', 'carregador', 'adaptador', 'suporte',
            // Outros
            'vitamina', 'suplemento', 'detergente', 'limpeza', 'tecnologia', 
            'eletrônico', 'acessório'
        ];
        
        foreach ($productPatterns as $pattern) {
            if (str_contains($messageLower, $pattern)) {
                Log::info('IA detectou busca de produto', [
                    'pattern' => $pattern,
                    'message' => $messageLower
                ]);
                return $this->searchSpecificProducts($messageLower, $customerName);
            }
        }

        // Produtos gerais - resposta rápida
        if (str_contains($messageLower, 'produto') || str_contains($messageLower, 'vende')) {
            $responses = [
                "Vendemos várias coisas! Tecnologia, saúde, limpeza... O que você procura?",
                "Temos de tudo! Me diz o que precisa que eu te ajudo a encontrar 😊",
                "Nossa variedade é grande! Eletrônicos, vitaminas, produtos de casa... Qual seu interesse?"
            ];
            return $responses[array_rand($responses)];
        }

        // Preço
        if (str_contains($messageLower, 'preço') || str_contains($messageLower, 'custo') || str_contains($messageLower, 'quanto custa')) {
            return "Para consultar preços, entre em contato:\n\n" .
                   "📱 WhatsApp: https://wa.me/244939729902\n" .
                   "🌐 Site: https://superloja.vip\n\n" .
                   "Ou me diga qual produto você procura! 😊";
        }

        // Entrega
        if (str_contains($messageLower, 'entrega') || str_contains($messageLower, 'envio') || str_contains($messageLower, 'entregar')) {
            return "🚚 Fazemos entregas em Luanda e outras províncias!\n\n" .
                   "Para informações sobre prazos e valores:\n" .
                   "📱 WhatsApp: https://wa.me/244939729902";
        }

        // Contato/Falar com humano (envia notificação para admin)
        if (preg_match('/(deixa\s+eu\s+conectar|falar|atendente|humano|pessoa|ajuda|atendimento|conectar\s+com|falar\s+com)/i', $messageLower)) {
            // Enviar notificação para admin via Messenger
            $this->notifyAdminViaMessenger($context, $customerName, $message);
            
            return "Deixa eu te conectar com alguém que pode te ajudar melhor " . ($customerName ?: 'Carlos') . "! 🤝\n\n" .
                   "Nossa equipe está esperando:\n" .
                   "📱 WhatsApp: https://wa.me/244939729902\n\n" .
                   "Eles vão resolver pra você! 😊";
        }

        // Encomenda/Compra
        if (preg_match('/(quero encomendar|quero comprar|encomendar|comprar|fazer pedido|quero|gostei)/i', $messageLower)) {
            return $this->handleOrderRequest($messageLower, $customerName);
        }

        // Ver Carrinho
        if (preg_match('/(ver\s+carrinho|ver\s+meu\s+carrinho|meu\s+carrinho|^carrinho$|itens\s+carrinho|o\s+que\s+tenho|revisar|mostrar\s+carrinho)/i', $messageLower)) {
            return $this->showCart($context, $customerName);
        }

        // Finalizar Pedido/Checkout
        if (preg_match('/(finalizar|concluir|fechar\s+pedido|quero\s+comprar\s+carrinho|confirmar\s+pedido|fazer\s+pedido)/i', $messageLower)) {
            $checkoutService = app(\App\Services\CheckoutService::class);
            return $checkoutService->startCheckout($context, $customerName);
        }

        // Limpar Carrinho
        if (preg_match('/(limpar\s+carrinho|esvaziar\s+carrinho|remover\s+tudo|cancelar\s+carrinho)/i', $messageLower)) {
            return $this->clearCart($context, $customerName);
        }

        // Categorias
        if (preg_match('/(categoria|categorias|tipos|que tipo|seções|sessões)/i', $messageLower)) {
            return $this->listAvailableProducts($customerName, $messageLower);
        }

        // Agradecimento
        if (preg_match('/(obrigad|obg|thanks|valeu)/i', $messageLower)) {
            return "Por nada! 😊 Precisando de algo mais, é só chamar!\n\n" .
                   "📱 WhatsApp: https://wa.me/244939729902";
        }

        // Detectar frustração/confusão (quando fala 3+ vezes sem resultado)
        $conversationCount = $recentHistory['total_messages'] ?? 0;
        if ($conversationCount >= 6) {
            return "Acho que estou te confundindo mais do que ajudando... 😅\n\n" .
                   "Deixa eu chamar alguém da equipe pra te ajudar melhor!\n\n" .
                   "💬 Fale direto com nosso time:\n" .
                   "📱 https://wa.me/244939729902\n\n" .
                   "Ou me diga exatamente o que procura e tento ajudar! 🙏";
        }

        // Fallback - Não entendeu (MOSTRAR PRODUTOS DIRETO!)
        Log::info('Fallback - Mostrando produtos automaticamente');
        
        // Em vez de apenas dar opções, MOSTRAR produtos diretamente
        $productResponse = $this->listAvailableProducts($customerName, $messageLower);
        
        // Se conseguiu buscar produtos, retornar
        if (!str_contains($productResponse, 'catálogo está sendo atualizado')) {
            return "Não entendi exatamente o que você quer 😅\n\n" .
                   "Mas deixa eu te mostrar alguns produtos que temos! 👇\n\n" .
                   $productResponse;
        }
        
        // Se não tem produtos, dar opções e notificar admin
        try {
            \App\Services\NotificationService::aiConversationNeedsAttention(
                null,
                $customerName ?? 'Cliente',
                $context->preferred_platform ?? 'messenger',
                'Bot não entendeu mensagem do cliente',
                'normal',
                $message
            );
        } catch (\Exception $e) {
            Log::error('Erro ao notificar admin no fallback', ['error' => $e->getMessage()]);
        }
        
        return "Hmm, não entendi bem o que você precisa 🤔\n\n" .
               "Vou facilitar pra você! Escolha:\n\n" .
               "📋 Digite 'ver tudo' - Mostro todos produtos\n" .
               "🔍 Digite 'categorias' - Produtos por tipo\n" .
               "🛍️ Digite 'ver carrinho' - Seu carrinho\n" .
               "💬 Digite 'falar com alguém' - Equipe humana\n\n" .
               "Ou me diga o que procura e eu encontro! 😊";
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
     * Extrair nome do cliente da mensagem
     */
    private function extractCustomerName(string $message, AiCustomerContext $context): ?string
    {
        // Se já temos o nome no contexto, usar
        if ($context->customer_name) {
            return $context->customer_name;
        }
        
        // Tentar extrair nome de padrões comuns
        $patterns = [
            '/(?:me chamo|meu nome é|sou|eu sou)\s+([a-záàâãéèêíïóôõöúçñ]+)/iu',
            '/ola\s+(?:me chamo|sou)\s+([a-záàâãéèêíïóôõöúçñ]+)/iu',
        ];
        
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $message, $matches)) {
                $name = ucfirst(strtolower(trim($matches[1])));
                // Salvar nome no contexto
                $context->update(['customer_name' => $name]);
                return $name;
            }
        }
        
        return null;
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
     * Listar produtos disponíveis reais do banco
     */
    private function listAvailableProducts(?string $customerName, string $query): string
    {
        // Buscar produtos ativos com ordenação inteligente
        $products = Product::where('is_active', true)
            ->where('stock_quantity', '>', 0) // Apenas com estoque
            ->whereNotNull('featured_image')
            ->select('id', 'name', 'price', 'sale_price', 'featured_image', 'short_description', 'stock_quantity', 'category_id')
            ->orderByRaw('sale_price IS NOT NULL DESC') // Promoções primeiro
            ->orderBy('created_at', 'desc') // Mais recentes
            ->limit(10) // Limite máximo do Facebook
            ->get();

        Log::info('AI - Buscando produtos', [
            'total_found' => $products->count(),
            'customer' => $customerName
        ]);

        if ($products->isEmpty()) {
            // Tentar sem filtro de imagem
            $products = Product::where('is_active', true)
                ->inRandomOrder()
                ->limit(10)
                ->get(['id', 'name', 'price', 'short_description', 'stock_quantity']);
            
            if ($products->isEmpty()) {
                return "No momento nosso catálogo está sendo atualizado 😊\n\n" .
                       "Fale com a equipe para saber o que temos:\n" .
                       "📱 https://wa.me/244939729902";
            }
        }

        $name = $customerName ? " $customerName" : '';
        
        // Preparar lista de produtos para carousel (Facebook Messenger)
        $this->productList = [];
        foreach ($products as $product) {
            $imageUrl = $product->featured_image ? asset('storage/' . $product->featured_image) : null;
            
            $this->productList[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'sale_price' => $product->sale_price,
                'stock_quantity' => $product->stock_quantity,
                'image' => $imageUrl,
                'description' => $product->short_description ?? '',
            ];
        }
        
        Log::info('Produtos preparados para carousel', [
            'total' => count($this->productList),
            'products' => array_column($this->productList, 'name'),
            'has_images' => count(array_filter($this->productList, fn($p) => !empty($p['image'])))
        ]);
        
        // Contar produtos em promoção
        $promoCount = $products->filter(fn($p) => 
            !empty($p->sale_price) && $p->sale_price < $p->price
        )->count();
        
        // Resposta em texto (será substituída por carousel no Messenger)
        if ($promoCount > 0) {
            $intros = [
                "🔥 Olha só{$name}! Temos {$promoCount} produtos em PROMOÇÃO! Confere 👇",
                "🎉 Aproveite{$name}! {$promoCount} itens com DESCONTO especial pra você! 🔥",
                "💰 Ei{$name}! Selecionei {$promoCount} promoções IMPERDÍVEIS! Veja 👇"
            ];
        } else {
            $intros = [
                "Olha só{$name}! Vou te mostrar nossos melhores produtos! 📸",
                "Confere esses produtos{$name}! Selecionei os melhores pra você 😊",
                "Temos essas opções pra você{$name}! Todos com imagens 🎉"
            ];
        }
        
        $response = $intros[array_rand($intros)] . "\n\n";
        $response .= "Em cada produto você pode:\n";
        $response .= "📱 Ver detalhes completos\n";
        $response .= "🛍️ Adicionar ao carrinho\n\n";
        $response .= "Qual te interessou? Me fala! 😊";
        
        return $response;
    }

    /**
     * Expandir query com sinônimos inteligentes (OTIMIZADO)
     */
    private function expandQueryWithSynonyms(string $query): array
    {
        $synonyms = [
            'auricular' => ['auricular', 'fone', 'fones', 'escutador', 'escutadores', 'headphone', 'earphone', 'ear', 'auscultador'],
            'cabo' => ['cabo', 'fio'],
            'usb' => ['usb', 'tipo c', 'tipo-c', 'type-c', 'type c'],
            'mouse' => ['mouse', 'rato'],
            'adaptador' => ['adaptador', 'conversor', 'adapter'],
            'suporte' => ['suporte', 'holder', 'stand'],
            'carregador' => ['carregador', 'charger', 'charge'],
        ];
        
        // Remover palavras irrelevantes da query
        $stopWords = ['tem', 'quais', 'qual', 'que', 'tem?', 'tens', 'vocês', 'você', 'me', 'mostre', 'mostra', 'ver', 'o', 'a', 'os', 'as'];
        $queryWords = explode(' ', strtolower($query));
        $relevantWords = array_diff($queryWords, $stopWords);
        $queryClean = implode(' ', $relevantWords);
        
        Log::info('Query limpa', [
            'original' => $query,
            'clean' => $queryClean,
            'relevant_words' => $relevantWords
        ]);
        
        $expandedTerms = [];
        
        // Buscar sinônimos apenas para palavras relevantes
        foreach ($synonyms as $key => $group) {
            foreach ($relevantWords as $word) {
                $word = trim($word);
                if (empty($word)) continue;
                
                // Verificar se a palavra está no grupo de sinônimos
                if (in_array($word, $group) || $word === $key) {
                    $expandedTerms = array_merge($expandedTerms, $group);
                    Log::info('Sinônimos encontrados', [
                        'palavra' => $word,
                        'sinonimos' => $group
                    ]);
                    break 2;
                }
            }
        }
        
        // Se não encontrou sinônimos, usar palavras relevantes da query
        if (empty($expandedTerms)) {
            $expandedTerms = array_filter($relevantWords);
        }
        
        // Se ainda está vazio, usar query limpa
        if (empty($expandedTerms)) {
            $expandedTerms = [$queryClean];
        }
        
        return array_values(array_unique($expandedTerms));
    }

    /**
     * Buscar produtos específicos por categoria/termo (com IA)
     */
    private function searchSpecificProducts(string $query, ?string $customerName): string
    {
        // Expandir query com sinônimos inteligentes
        $searchTerms = $this->expandQueryWithSynonyms($query);
        
        Log::info('AI - Busca inteligente', [
            'query_original' => $query,
            'termos_expandidos' => $searchTerms
        ]);
        
        // Buscar produtos priorizando correspondência no NOME
        // Primeiro: busca produtos que TÊM o termo no nome
        $productsInName = Product::where('is_active', true)
            ->where(function($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $q->orWhere('name', 'like', "%{$term}%");
                }
            })
            ->whereNotNull('featured_image')
            ->where('stock_quantity', '>', 0)
            ->limit(10)
            ->get(['id', 'name', 'price', 'sale_price', 'featured_image', 'short_description', 'stock_quantity']);
        
        // Se não encontrou no nome, buscar na descrição
        if ($productsInName->count() < 3) {
            $foundIds = $productsInName->pluck('id')->toArray();
            
            $productsInDescription = Product::where('is_active', true)
                ->whereNotIn('id', $foundIds)
                ->where(function($q) use ($searchTerms) {
                    foreach ($searchTerms as $term) {
                        $q->orWhere('description', 'like', "%{$term}%")
                          ->orWhere('short_description', 'like', "%{$term}%");
                    }
                })
                ->whereNotNull('featured_image')
                ->where('stock_quantity', '>', 0)
                ->limit(10 - $productsInName->count())
                ->get(['id', 'name', 'price', 'sale_price', 'featured_image', 'short_description', 'stock_quantity']);
            
            $products = $productsInName->merge($productsInDescription);
        } else {
            $products = $productsInName;
        }

        Log::info('AI - Busca específica', [
            'query' => $query,
            'found' => $products->count()
        ]);

        if ($products->isEmpty()) {
            return "Hmm, não encontrei produtos específicos com esse termo 🤔\n\n" .
                   "Mas posso te ajudar de outras formas:\n\n" .
                   "📋 Digite 'ver tudo' - Ver todos os produtos\n" .
                   "🔍 Digite 'categorias' - Ver por categorias\n" .
                   "💬 Ou me diga o que procura e eu ajudo a encontrar!\n\n" .
                   "Quer falar com nossa equipe?\n" .
                   "📱 https://wa.me/244939729902";
        }

        $name = $customerName ? " $customerName" : '';
        
        // Preparar lista de produtos para carousel
        $this->productList = [];
        foreach ($products as $product) {
            $imageUrl = $product->featured_image ? url('storage/' . $product->featured_image) : null;
            
            $this->productList[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'sale_price' => $product->sale_price ?? null,
                'stock_quantity' => $product->stock_quantity ?? 0,
                'image' => $imageUrl,
                'description' => $product->short_description ?? '',
            ];
        }
        
        // Resposta em texto (será substituída por carousel)
        $intros = [
            "Achei isso pra você{$name}! Te mostro com fotos 📸",
            "Olha o que encontrei{$name}! Veja as imagens 🎯",
            "Confere esses{$name}! Te envio agora 👀"
        ];
        
        $response = $intros[array_rand($intros)] . "\n\n";
        $response .= "Escolha um produto para:\n";
        $response .= "🛒 Ver detalhes no site\n";
        $response .= "📦 Fazer encomenda\n\n";
        $response .= "Ou me fala qual te interessou! 😊";
        
        return $response;
    }

    /**
     * Processar solicitação de encomenda
     */
    private function handleOrderRequest(string $message, ?string $customerName): string
    {
        // Tentar extrair nome do produto da mensagem
        $productName = null;
        
        // Padrões: "quero encomendar iPhone", "comprar laptop", etc
        if (preg_match('/(encomendar|comprar|quero)\s+(.+)$/i', $message, $matches)) {
            $productName = trim($matches[2]);
        }
        
        if ($productName && strlen($productName) > 3) {
            // Buscar produto específico
            $product = Product::where('is_active', true)
                ->where('name', 'like', "%{$productName}%")
                ->whereNotNull('featured_image')
                ->first(['id', 'name', 'price', 'featured_image', 'stock_quantity']);
            
            if ($product) {
                $price = number_format((float)$product->price, 2, ',', '.');
                $imageUrl = asset('storage/' . $product->featured_image);
                $inStock = $product->stock_quantity > 0 ? '✅ Disponível' : '⚠️ Sob consulta';
                
                $name = $customerName ? " $customerName" : '';
                
                return "Ótima escolha{$name}! 🎉\n\n" .
                       "🔹 *{$product->name}*\n" .
                       "💰 {$price} Kz\n" .
                       "📦 {$inStock}\n" .
                       "🖼️ {$imageUrl}\n\n" .
                       "Para finalizar sua encomenda, fale com a equipe:\n" .
                       "📱 WhatsApp: https://wa.me/244939729902\n\n" .
                       "Diga que quer encomendar: *{$product->name}*";
            }
        }
        
        // Encomenda genérica - pedir mais detalhes
        $name = $customerName ? " $customerName" : '';
        return "Legal{$name}! 😊 Me diga qual produto você quer encomendar!\n\n" .
               "Ou fale direto com a equipe:\n" .
               "📱 WhatsApp: https://wa.me/244939729902";
    }

    /**
     * Mostrar carrinho do cliente
     */
    private function showCart(AiCustomerContext $context, ?string $customerName): string
    {
        $purchaseHistory = $context->purchase_history ?? [];
        $cart = $purchaseHistory['cart'] ?? [];
        
        if (empty($cart)) {
            $name = $customerName ? " $customerName" : '';
            return "Seu carrinho está vazio{$name}! 🛍️\n\n" .
                   "Que tal ver nossos produtos?\n" .
                   "Digite 'produtos' ou 'ver produtos'!\n\n" .
                   "📱 WhatsApp: https://wa.me/244939729902";
        }
        
        $name = $customerName ? " $customerName" : '';
        $response = "🛍️ *Seu Carrinho*{$name}:\n\n";
        
        $total = 0;
        $totalItems = 0;
        
        foreach ($cart as $item) {
            $quantity = $item['quantity'] ?? 1;
            $price = $item['price'] ?? 0;
            $itemTotal = $quantity * $price;
            $total += $itemTotal;
            $totalItems += $quantity;
            
            $priceFormatted = number_format((float)$price, 2, ',', '.');
            $itemTotalFormatted = number_format((float)$itemTotal, 2, ',', '.');
            
            $response .= "📦 *{$item['product_name']}*\n";
            $response .= "   Quantidade: {$quantity}x\n";
            $response .= "   Preço: {$priceFormatted} Kz cada\n";
            $response .= "   Subtotal: {$itemTotalFormatted} Kz\n\n";
        }
        
        $totalFormatted = number_format((float)$total, 2, ',', '.');
        
        $response .= "━━━━━━━━━━━━━━━━\n";
        $response .= "📊 *Total de itens:* {$totalItems}\n";
        $response .= "💰 *Total:* {$totalFormatted} Kz\n\n";
        $response .= "Opções:\n";
        $response .= "🛍️ Adicionar mais produtos\n";
        $response .= "✅ Digite 'finalizar' para concluir pedido\n";
        $response .= "📱 Ou fale com equipe: https://wa.me/244939729902\n\n";
        $response .= "💡 Dica: Diga o nome do produto que deseja ou 'ver produtos'";
        
        return $response;
    }

    /**
     * Limpar carrinho do cliente
     */
    private function clearCart(AiCustomerContext $context, ?string $customerName): string
    {
        $purchaseHistory = $context->purchase_history ?? [];
        $cart = $purchaseHistory['cart'] ?? [];
        
        if (empty($cart)) {
            $name = $customerName ? " $customerName" : '';
            return "Seu carrinho já está vazio{$name}! 🛍️\n\n" .
                   "Quer ver nossos produtos?\n" .
                   "📱 WhatsApp: https://wa.me/244939729902";
        }
        
        // Limpar carrinho
        $purchaseHistory['cart'] = [];
        $context->update(['purchase_history' => $purchaseHistory]);
        
        $name = $customerName ? " $customerName" : '';
        return "✅ Carrinho limpo com sucesso{$name}!\n\n" .
               "Quer ver nossos produtos novamente?\n" .
               "Digite 'produtos' ou 'ver produtos'!\n\n" .
               "📱 WhatsApp: https://wa.me/244939729902";
    }

    /**
     * Notificar admin via Messenger quando cliente pede ajuda
     */
    private function notifyAdminViaMessenger(AiCustomerContext $context, ?string $customerName, string $message): void
    {
        try {
            $adminMessengerId = \App\Models\AdminNotificationChannel::where('facebook_messenger_enabled', true)
                ->whereNotNull('facebook_messenger_id')
                ->value('facebook_messenger_id');
            
            if (!$adminMessengerId) {
                \Log::warning('Admin Messenger ID não configurado');
                return;
            }
            
            $socialMedia = app(\App\Services\SocialMediaAgentService::class);
            
            $notificationMessage = "🚨 *Cliente Precisa de Ajuda Humana!*\n\n" .
                                   "👤 Cliente: " . ($customerName ?: 'Não identificado') . "\n" .
                                   "💬 Mensagem: {$message}\n\n" .
                                   "📋 Contexto:\n" .
                                   "- Plataforma: {$context->preferred_platform}\n" .
                                   "- Conversas: {$context->total_conversations}\n\n" .
                                   "⏰ " . now()->format('d/m/Y H:i:s');
            
            $socialMedia->sendMessengerMessage($adminMessengerId, $notificationMessage);
            
        } catch (\Exception $e) {
            \Log::error('Erro ao enviar notificação Messenger: ' . $e->getMessage());
        }
    }

    /**
     * Buscar histórico recente da conversa (50 mensagens)
     */
    private function getRecentConversationHistory(AiCustomerContext $context): array
    {
        $conversations = AiConversation::where('customer_identifier', $context->customer_identifier)
            ->latest()
            ->first();
        
        if (!$conversations) {
            return [
                'messages' => [], 
                'ai_repetition_count' => 0,
                'context_summary' => '',
                'customer_interests' => [],
                'products_mentioned' => [],
            ];
        }
        
        // Pegar últimas 50 mensagens para contexto completo
        $messages = AiMessage::where('conversation_id', $conversations->id)
            ->latest()
            ->limit(50)
            ->get()
            ->reverse()
            ->values();
        
        // Contar repetições da IA (últimas 6 mensagens)
        $recentMessages = $messages->slice(-6);
        $aiMessages = $recentMessages->where('direction', 'outgoing')->pluck('message');
        $repetitionCount = 0;
        
        if ($aiMessages->count() >= 2) {
            $lastAi = $aiMessages->last();
            $previousAi = $aiMessages->slice(-2, 1)->first();
            
            // Similar em 70%? = Repetição
            similar_text(strtolower($lastAi ?? ''), strtolower($previousAi ?? ''), $percent);
            if ($percent > 70) {
                $repetitionCount++;
                
                // Verificar se repetiu 3x
                if ($aiMessages->count() >= 3) {
                    $thirdAi = $aiMessages->slice(-3, 1)->first();
                    similar_text(strtolower($lastAi ?? ''), strtolower($thirdAi ?? ''), $percent2);
                    if ($percent2 > 70) {
                        $repetitionCount++;
                    }
                }
            }
        }
        
        // Analisar todo histórico (50 mensagens) para contexto
        $contextAnalysis = $this->analyzeFullContext($messages);
        
        return [
            'messages' => $messages,
            'ai_repetition_count' => $repetitionCount,
            'context_summary' => $contextAnalysis['summary'],
            'customer_interests' => $contextAnalysis['interests'],
            'products_mentioned' => $contextAnalysis['products'],
            'sentiment_trend' => $contextAnalysis['sentiment'],
        ];
    }

    /**
     * Analisar contexto completo das 50 mensagens
     */
    private function analyzeFullContext($messages): array
    {
        $customerMessages = $messages->where('direction', 'incoming')->pluck('message');
        $fullText = $customerMessages->implode(' ');
        $fullTextLower = strtolower($fullText);
        
        // Detectar interesses do cliente
        $interests = [];
        $interestPatterns = [
            'laptop' => ['laptop', 'notebook', 'computador'],
            'smartphone' => ['smartphone', 'telefone', 'celular', 'iphone'],
            'acessórios' => ['acessório', 'fone', 'carregador', 'case', 'capa'],
            'vitaminas' => ['vitamina', 'suplemento', 'saúde'],
            'limpeza' => ['limpeza', 'detergente', 'sabão'],
            'preço' => ['preço', 'quanto custa', 'valor', 'barato'],
            'entrega' => ['entrega', 'envio', 'frete', 'receber'],
        ];
        
        foreach ($interestPatterns as $category => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($fullTextLower, $keyword)) {
                    $interests[] = $category;
                    break;
                }
            }
        }
        $interests = array_unique($interests);
        
        // Detectar produtos mencionados
        $products = [];
        preg_match_all('/(?:quero|preciso|comprar|encomendar)\s+([a-záàâãéèêíïóôõöúçñ\s]+)/iu', $fullText, $matches);
        if (!empty($matches[1])) {
            $products = array_slice(array_unique($matches[1]), 0, 5);
        }
        
        // Analisar sentimento geral
        $positiveWords = ['obrigado', 'ótimo', 'bom', 'legal', 'gostei', 'perfeito', 'excelente'];
        $negativeWords = ['não', 'ruim', 'problema', 'erro', 'demora', 'caro', 'insatisfeito'];
        
        $positiveCount = 0;
        $negativeCount = 0;
        
        foreach ($positiveWords as $word) {
            $positiveCount += substr_count($fullTextLower, $word);
        }
        foreach ($negativeWords as $word) {
            $negativeCount += substr_count($fullTextLower, $word);
        }
        
        $sentiment = 'neutral';
        if ($positiveCount > $negativeCount + 2) {
            $sentiment = 'positive';
        } elseif ($negativeCount > $positiveCount + 2) {
            $sentiment = 'negative';
        }
        
        // Criar resumo inteligente
        $summary = $this->generateContextSummary($interests, $products, $sentiment, $messages->count());
        
        return [
            'summary' => $summary,
            'interests' => $interests,
            'products' => $products,
            'sentiment' => $sentiment,
        ];
    }

    /**
     * Gerar resumo do contexto
     */
    private function generateContextSummary(array $interests, array $products, string $sentiment, int $messageCount): string
    {
        $parts = [];
        
        if (!empty($interests)) {
            $parts[] = "Interesses: " . implode(', ', $interests);
        }
        
        if (!empty($products)) {
            $parts[] = "Produtos mencionados: " . implode(', ', array_slice($products, 0, 3));
        }
        
        $parts[] = "Sentimento: {$sentiment}";
        $parts[] = "Total mensagens: {$messageCount}";
        
        return implode(' | ', $parts);
    }

    /**
     * Detectar se está repetindo
     */
    private function detectRepetition(array $history, ?string $lastResponse): bool
    {
        return $history['ai_repetition_count'] > 0;
    }

    /**
     * Detectar insatisfação do cliente com sugestões
     */
    private function detectUnsatisfaction(string $message, ?string $lastResponse): bool
    {
        if (!$lastResponse) {
            return false;
        }
        
        $messageLower = strtolower($message);
        
        // Padrões de insatisfação
        $unsatisfiedPatterns = [
            'não é isso',
            'nao é isso',
            'não é o que',
            'nao é o que',
            'não quero',
            'nao quero',
            'não tem',
            'nao tem',
            'não serve',
            'nao serve',
            'errado',
            'não é esse',
            'nao é esse',
            'outro',
            'diferente',
            'não encontrei',
            'nao encontrei',
        ];
        
        foreach ($unsatisfiedPatterns as $pattern) {
            if (str_contains($messageLower, $pattern)) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Perguntar mais detalhes ao cliente
     */
    private function askForMoreDetails(AiCustomerContext $context, string $message): string
    {
        $name = $context->customer_name ? " {$context->customer_name}" : '';
        
        $responses = [
            "Entendi{$name}! 🤔 Me ajuda a entender melhor:\n\n" .
            "Pode me descrever com mais detalhes o que você procura?\n" .
            "Por exemplo: cor, tamanho, marca, funcionalidade...\n\n" .
            "Ou fale direto com a equipe:\n📱 https://wa.me/244939729902",
            
            "Opa{$name}, vejo que não é bem isso! 😅\n\n" .
            "Me diz: tem alguma característica específica que você busca?\n" .
            "Ou como você chamaria esse produto?\n\n" .
            "Também pode falar direto:\n📱 https://wa.me/244939729902",
            
            "Desculpa{$name}, parece que não encontrei o que você quer 😕\n\n" .
            "Pode tentar me dizer de outra forma?\n" .
            "Ou me fala para que você precisa?\n\n" .
            "Nossa equipe também pode ajudar:\n📱 https://wa.me/244939729902"
        ];
        
        return $responses[array_rand($responses)];
    }

    /**
     * Criar log de diagnóstico da IA
     */
    private function logAiDiagnostic(AiCustomerContext $context, string $message, string $issueType, array $metadata = []): void
    {
        try {
            \App\Models\AiDiagnosticLog::create([
                'customer_id' => $context->id,
                'customer_name' => $context->customer_name,
                'customer_identifier' => $context->customer_identifier,
                'issue_type' => $issueType,
                'customer_message' => $message,
                'ai_response' => $metadata['last_response'] ?? null,
                'context_data' => json_encode([
                    'interests' => $context->interests,
                    'segment' => $context->customer_segment,
                    'total_conversations' => $context->total_conversations,
                    'metadata' => $metadata
                ]),
                'severity' => $this->getSeverityLevel($issueType),
                'resolved' => false,
            ]);
        } catch (\Exception $e) {
            Log::error('Erro ao criar log de diagnóstico: ' . $e->getMessage());
        }
    }

    /**
     * Determinar nível de severidade
     */
    private function getSeverityLevel(string $issueType): string
    {
        return match($issueType) {
            'unsatisfied_with_suggestions' => 'medium',
            'repetition_detected' => 'medium',
            'transfer_to_human' => 'high',
            'no_response_found' => 'high',
            default => 'low'
        };
    }

    /**
     * Gerar resposta alternativa quando detectou repetição
     */
    private function generateAlternativeResponse(string $message, AiCustomerContext $context, ?string $lastResponse): string
    {
        $name = $context->customer_name ? " {$context->customer_name}" : '';
        
        $alternatives = [
            "Vejo que não estou conseguindo te ajudar direito{$name} 😕\n\nDeixa eu te conectar com alguém da equipe que pode te ajudar melhor!\n\n📱 WhatsApp: https://wa.me/244939729902",
            
            "Percebo que você precisa de mais detalhes{$name}! 🤔\n\nNossa equipe pode te dar uma atenção mais personalizada:\n\n📱 https://wa.me/244939729902",
            
            "Acho que estou te confundindo mais do que ajudando{$name}... 😅\n\nMelhor falar direto com a equipe:\n\n📱 WhatsApp: https://wa.me/244939729902"
        ];
        
        return $alternatives[array_rand($alternatives)];
    }

    /**
     * Transferir para atendimento humano
     */
    private function transferToHuman(AiCustomerContext $context, string $message): string
    {
        $name = $context->customer_name ? " {$context->customer_name}" : '';
        
        // Marcar no contexto que precisa atenção humana
        $context->update([
            'conversation_summary' => ($context->conversation_summary ?? '') . "\n[PRECISA ATENÇÃO HUMANA] Mensagem: {$message}"
        ]);
        
        Log::warning('Cliente transferido para atendimento humano', [
            'customer' => $context->customer_name,
            'customer_id' => $context->customer_identifier,
            'message' => $message
        ]);
        
        // NOTIFICAR ADMIN: Cliente solicitou atendimento humano
        try {
            \App\Services\NotificationService::aiConversationNeedsAttention(
                null, // conversation_id (pode ser null se não tiver)
                $context->customer_name ?? 'Cliente',
                $context->preferred_platform ?? 'messenger',
                'Cliente solicitou atendimento humano',
                'high',
                $message
            );
            
            // ENVIAR MENSAGEM DIRETO VIA MESSENGER para admins configurados
            $socialMedia = app(\App\Services\SocialMediaAgentService::class);
            $adminChannels = \App\Models\AdminNotificationChannel::where('facebook_messenger_enabled', true)
                ->whereNotNull('facebook_messenger_id')
                ->get();
            
            foreach ($adminChannels as $adminChannel) {
                try {
                    $adminMessage = "🚨 *Cliente Solicitou Atendimento Humano*\n\n" .
                                   "👤 Cliente: {$context->customer_name}\n" .
                                   "📱 Plataforma: {$context->preferred_platform}\n" .
                                   "💬 Mensagem: " . substr($message, 0, 100) . "\n\n" .
                                   "⚠️ Entre em contato com o cliente AGORA!";
                    
                    $socialMedia->sendMessengerMessage($adminChannel->facebook_messenger_id, $adminMessage);
                    
                    Log::info('Notificação Messenger enviada para admin', [
                        'admin_messenger_id' => $adminChannel->facebook_messenger_id,
                        'customer' => $context->customer_name
                    ]);
                } catch (\Exception $e) {
                    Log::error('Erro ao enviar Messenger para admin', [
                        'admin_id' => $adminChannel->user_id,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Erro ao notificar admin sobre solicitação de atendimento humano', [
                'error' => $e->getMessage()
            ]);
        }
        
        $responses = [
            "Entendi{$name}! Você precisa de um atendimento mais especializado 🙋‍♂️\n\nNossa equipe está disponível para te ajudar:\n\n📱 WhatsApp: https://wa.me/244939729902\n\n💬 Diga que você conversou comigo e eles vão te atender rapidinho!",
            
            "Opa{$name}! Parece que sua dúvida precisa de alguém com mais conhecimento que eu 😊\n\nFala com a equipe aqui:\n\n📱 https://wa.me/244939729902\n\nEles vão resolver pra você!",
            
            "Deixa eu te conectar com alguém que pode te ajudar melhor{$name}! 🤝\n\nNossa equipe está esperando:\n\n📱 WhatsApp: https://wa.me/244939729902"
        ];
        
        return $responses[array_rand($responses)];
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

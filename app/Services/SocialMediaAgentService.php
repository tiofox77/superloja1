<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Models\AiAutoPost;
use App\Models\AiIntegrationToken;
use App\Models\AiConversation;
use App\Models\AiMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class SocialMediaAgentService
{
    private const FACEBOOK_GRAPH_API = 'https://graph.facebook.com/v18.0';

    /**
     * Enviar mensagem via Facebook Messenger
     */
    public function sendMessengerMessage(string $recipientId, string $message): bool
    {
        try {
            $token = AiIntegrationToken::getByPlatform('facebook');
            
            if (!$token || $token->isExpired()) {
                Log::error('Token do Facebook inválido ou expirado');
                return false;
            }

            $response = Http::post(self::FACEBOOK_GRAPH_API . '/me/messages', [
                'recipient' => ['id' => $recipientId],
                'messaging_type' => 'RESPONSE',
                'message' => ['text' => $message],
                'access_token' => $token->access_token,
            ]);

            if ($response->successful()) {
                Log::info('Mensagem Messenger enviada', [
                    'recipient' => $recipientId,
                    'message_id' => $response->json('message_id'),
                ]);
                return true;
            }

            Log::error('Erro ao enviar mensagem Messenger', [
                'status' => $response->status(),
                'response' => $response->json(),
            ]);
            return false;

        } catch (Exception $e) {
            Log::error('Exceção ao enviar mensagem Messenger: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Enviar mensagem via Instagram
     */
    public function sendInstagramMessage(string $recipientId, string $message): bool
    {
        try {
            $token = AiIntegrationToken::getByPlatform('instagram');
            
            if (!$token || $token->isExpired()) {
                Log::error('Token do Instagram inválido ou expirado');
                return false;
            }

            $response = Http::post(self::FACEBOOK_GRAPH_API . '/me/messages', [
                'recipient' => ['id' => $recipientId],
                'message' => ['text' => $message],
                'access_token' => $token->access_token,
            ]);

            if ($response->successful()) {
                Log::info('Mensagem Instagram enviada', [
                    'recipient' => $recipientId,
                ]);
                return true;
            }

            return false;

        } catch (Exception $e) {
            Log::error('Exceção ao enviar mensagem Instagram: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Criar post no Facebook
     */
    public function postToFacebook(
        string $message,
        ?array $mediaUrls = null,
        ?array $hashtags = null
    ): ?string {
        try {
            $token = AiIntegrationToken::getByPlatform('facebook');
            
            if (!$token || $token->isExpired()) {
                Log::error('Token do Facebook inválido');
                return null;
            }

            $pageId = $token->page_id;
            $content = $message;

            // Adicionar hashtags
            if ($hashtags) {
                $content .= "\n\n" . implode(' ', array_map(fn($tag) => "#{$tag}", $hashtags));
            }

            // Se tiver imagem, fazer upload direto do arquivo
            if ($mediaUrls && count($mediaUrls) > 0) {
                return $this->uploadPhotoToFacebook($pageId, $token->access_token, $mediaUrls[0], $content);
            }

            // Post sem imagem
            $params = [
                'message' => $content,
                'access_token' => $token->access_token,
            ];

            $endpoint = self::FACEBOOK_GRAPH_API . "/{$pageId}/feed";
            $response = Http::post($endpoint, $params);

            if ($response->successful()) {
                $postId = $response->json('id') ?? $response->json('post_id');
                
                Log::info('Post criado no Facebook (sem imagem)', [
                    'post_id' => $postId,
                ]);

                return $postId;
            }

            Log::error('Erro ao criar post no Facebook', [
                'response' => $response->json(),
            ]);
            return null;

        } catch (Exception $e) {
            Log::error('Exceção ao postar no Facebook: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Upload de foto diretamente para o Facebook
     */
    private function uploadPhotoToFacebook(string $pageId, string $accessToken, string $imageUrl, string $caption): ?string
    {
        try {
            // Extrair caminho local da imagem da URL
            $parsedUrl = parse_url($imageUrl);
            $path = $parsedUrl['path'] ?? '';
            
            // Converter de /storage/products/... para storage/app/public/products/...
            $localPath = str_replace('/storage/', '', $path);
            $fullPath = storage_path('app/public/' . $localPath);

            \Log::info('Tentando upload de imagem para Facebook', [
                'image_url' => $imageUrl,
                'local_path' => $fullPath,
                'exists' => file_exists($fullPath)
            ]);

            // Verificar se arquivo existe
            if (!file_exists($fullPath)) {
                \Log::error('Arquivo de imagem não encontrado', ['path' => $fullPath]);
                return null;
            }

            // Fazer upload usando attach() do Laravel HTTP
            $endpoint = self::FACEBOOK_GRAPH_API . "/{$pageId}/photos";
            
            $response = Http::attach(
                'source', 
                file_get_contents($fullPath), 
                basename($fullPath)
            )->post($endpoint, [
                'message' => $caption,
                'access_token' => $accessToken,
            ]);

            if ($response->successful()) {
                $postId = $response->json('id') ?? $response->json('post_id');
                
                \Log::info('Foto enviada com sucesso para Facebook', [
                    'post_id' => $postId,
                    'image_path' => $fullPath
                ]);

                return $postId;
            }

            \Log::error('Erro ao enviar foto para Facebook', [
                'response' => $response->json(),
                'status' => $response->status()
            ]);
            
            return null;

        } catch (\Exception $e) {
            \Log::error('Exceção ao fazer upload de foto', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Criar post no Instagram
     * NOTA: Instagram requer URL pública acessível (não funciona com localhost)
     */
    public function postToInstagram(
        string $caption,
        string $imageUrl,
        ?array $hashtags = null
    ): ?string {
        try {
            $token = AiIntegrationToken::getByPlatform('instagram');
            
            if (!$token || $token->isExpired()) {
                Log::error('Token do Instagram inválido');
                return null;
            }

            $igUserId = $token->page_id; // Instagram Business Account ID
            $content = $caption;

            // Adicionar hashtags
            if ($hashtags) {
                $content .= "\n\n" . implode(' ', array_map(fn($tag) => "#{$tag}", $hashtags));
            }

            \Log::info('Tentando criar post no Instagram', [
                'ig_user_id' => $igUserId,
                'image_url' => $imageUrl,
            ]);

            // Verificar se é localhost (Instagram não consegue acessar)
            if (str_contains($imageUrl, 'localhost') || str_contains($imageUrl, '.test')) {
                \Log::warning('Instagram não funciona com URLs localhost', [
                    'image_url' => $imageUrl,
                    'solucao' => 'Use domínio público ou ngrok para desenvolvimento'
                ]);
                // Vamos tentar mesmo assim, mas provavelmente vai falhar
            }

            // Passo 1: Criar container de mídia
            $containerResponse = Http::post(
                self::FACEBOOK_GRAPH_API . "/{$igUserId}/media",
                [
                    'image_url' => $imageUrl,
                    'caption' => $content,
                    'access_token' => $token->access_token,
                ]
            );

            if (!$containerResponse->successful()) {
                \Log::error('Erro ao criar container Instagram', [
                    'response' => $containerResponse->json(),
                    'status' => $containerResponse->status(),
                    'image_url' => $imageUrl
                ]);
                return null;
            }

            $containerId = $containerResponse->json('id');

            // Aguardar um pouco para o Instagram processar a imagem
            sleep(2);

            // Passo 2: Publicar o container
            $publishResponse = Http::post(
                self::FACEBOOK_GRAPH_API . "/{$igUserId}/media_publish",
                [
                    'creation_id' => $containerId,
                    'access_token' => $token->access_token,
                ]
            );

            if ($publishResponse->successful()) {
                $postId = $publishResponse->json('id');
                
                \Log::info('Post criado no Instagram', [
                    'post_id' => $postId,
                ]);

                return $postId;
            }

            \Log::error('Erro ao publicar no Instagram', [
                'response' => $publishResponse->json(),
                'status' => $publishResponse->status()
            ]);

            return null;

        } catch (Exception $e) {
            \Log::error('Exceção ao postar no Instagram', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Gerar conteúdo de post para produto
     */
    public function generateProductPostContent(Product $product, string $platform = 'facebook'): array
    {
        $emojis = ['🔥', '⚡', '✨', '💫', '🎯', '🌟'];
        $emoji = $emojis[array_rand($emojis)];

        // Mensagem base
        $messages = [
            "Chegou na SuperLoja! {$product->name} {$emoji}",
            "Novidade na SuperLoja: {$product->name} {$emoji}",
            "Não perca! {$product->name} disponível agora {$emoji}",
            "Oferta especial: {$product->name} {$emoji}",
        ];

        $message = $messages[array_rand($messages)];

        // Adicionar preço
        if ($product->is_on_sale) {
            $message .= "\n\n💰 De " . number_format((float)$product->price, 2, ',', '.') . " Kz";
            $message .= "\n🔥 Por apenas " . number_format((float)$product->sale_price, 2, ',', '.') . " Kz";
            $message .= "\n✨ Economize {$product->discount_percentage}%!";
        } else {
            $message .= "\n\n💰 Apenas " . number_format((float)$product->price, 2, ',', '.') . " Kz";
        }

        // Adicionar descrição curta (usar Str::limit para não cortar palavras)
        if ($product->short_description) {
            $message .= "\n\n" . \Illuminate\Support\Str::limit($product->short_description, 150, '...');
        }

        // Call to action (com https:// para criar link clicável)
        $message .= "\n\n📱 Peça já pelo WhatsApp: https://wa.me/244939729902";
        $message .= "\n🛒 Ou visite: https://superloja.vip";

        // Hashtags
        $hashtags = [
            'SuperLojaAngola',
            'Angola',
            'Luanda',
            'ComprasOnline',
        ];

        // Hashtags por categoria
        $categoryName = strtolower($product->category->name ?? '');
        
        if (str_contains($categoryName, 'tecnologia') || str_contains($categoryName, 'eletrônico')) {
            $hashtags = array_merge($hashtags, ['Tecnologia', 'Eletronicos', 'TecnologiaAngola']);
        } elseif (str_contains($categoryName, 'saúde') || str_contains($categoryName, 'bem-estar')) {
            $hashtags = array_merge($hashtags, ['Saude', 'BemEstar', 'SaudeAngola']);
        } elseif (str_contains($categoryName, 'limpeza')) {
            $hashtags = array_merge($hashtags, ['Limpeza', 'Higiene', 'Casa']);
        }

        // Imagens do produto (URL absoluta para Facebook/Instagram)
        $mediaUrls = [];
        if ($product->featured_image) {
            // Usar URL absoluta completa para redes sociais
            $imageUrl = url('storage/' . $product->featured_image);
            $mediaUrls[] = $imageUrl;
            
            \Log::info('Media URL gerada para post', [
                'product_id' => $product->id,
                'image_url' => $imageUrl,
                'featured_image' => $product->featured_image
            ]);
        }

        return [
            'message' => $message,
            'hashtags' => $hashtags,
            'media_urls' => $mediaUrls,
        ];
    }

    /**
     * Agendar post automático
     */
    public function scheduleAutoPost(
        Product $product,
        string $platform,
        ?\DateTime $scheduledFor = null
    ): AiAutoPost {
        $content = $this->generateProductPostContent($product, $platform);

        return AiAutoPost::create([
            'platform' => $platform,
            'post_type' => 'product',
            'product_id' => $product->id,
            'content' => $content['message'],
            'media_urls' => $content['media_urls'],
            'hashtags' => $content['hashtags'],
            'status' => 'scheduled',
            'scheduled_for' => $scheduledFor ?? now()->addHours(1),
        ]);
    }

    /**
     * Publicar posts pendentes
     */
    public function publishPendingPosts(): int
    {
        $pendingPosts = AiAutoPost::pending()->get();
        $published = 0;

        foreach ($pendingPosts as $post) {
            $success = $this->publishPost($post);
            if ($success) {
                $published++;
            }
        }

        return $published;
    }

    /**
     * Publicar post individual
     */
    private function publishPost(AiAutoPost $post): bool
    {
        try {
            \Log::info('Tentando publicar post', [
                'post_id' => $post->id,
                'platform' => $post->platform,
                'has_media' => !empty($post->media_urls),
                'media_urls' => $post->media_urls
            ]);

            // Verificar pré-requisitos específicos por plataforma
            if ($post->platform === 'facebook') {
                $token = \App\Models\AiIntegrationToken::getByPlatform('facebook');
                if (!$token || $token->isExpired()) {
                    $errorMsg = 'Token do Facebook não configurado ou expirado. Acesse Configurações → Integrações → Facebook e salve um novo Access Token + Page ID.';
                    \Log::error('Token Facebook não configurado ou expirado', ['post_id' => $post->id, 'has_token' => $token ? 'yes' : 'no']);
                    $post->update([
                        'status' => 'failed',
                        'error_message' => $errorMsg,
                    ]);
                    return false;
                }
            } elseif ($post->platform === 'instagram') {
                $token = \App\Models\AiIntegrationToken::getByPlatform('instagram');
                if (!$token || $token->isExpired()) {
                    $errorMsg = 'Token do Instagram não configurado ou expirado. Acesse Configurações → Integrações → Instagram e salve um novo Access Token + Page ID.';
                    \Log::error('Token Instagram não configurado ou expirado', ['post_id' => $post->id, 'has_token' => $token ? 'yes' : 'no']);
                    $post->update([
                        'status' => 'failed',
                        'error_message' => $errorMsg,
                    ]);
                    return false;
                }
            }

            // Verificar se tem imagem e se está acessível
            if (!empty($post->media_urls)) {
                $imageUrl = $post->media_urls[0];
                $headers = @get_headers($imageUrl);
                if (!$headers || strpos($headers[0], '200') === false) {
                    $errorMsg = "Imagem inacessível ({$imageUrl}). Verifique se o storage está linkado (execute: php artisan storage:link) e se a imagem existe.";
                    \Log::error('Imagem inacessível', ['post_id' => $post->id, 'url' => $imageUrl]);
                    $post->update([
                        'status' => 'failed',
                        'error_message' => $errorMsg,
                    ]);
                    return false;
                }
            }

            $postId = null;

            if ($post->platform === 'facebook') {
                $postId = $this->postToFacebook(
                    $post->content,
                    $post->media_urls,
                    $post->hashtags
                );
            } elseif ($post->platform === 'instagram' && !empty($post->media_urls)) {
                $postId = $this->postToInstagram(
                    $post->content,
                    $post->media_urls[0],
                    $post->hashtags
                );
            }

            if ($postId) {
                // Gerar URL do post
                $postUrl = null;
                if ($post->platform === 'facebook') {
                    // URL do post no Facebook
                    $pageId = \App\Models\SystemConfig::get('facebook_page_id', '');
                    if ($pageId) {
                        $postUrl = "https://www.facebook.com/{$pageId}/posts/{$postId}";
                    }
                } elseif ($post->platform === 'instagram') {
                    // URL do Instagram (se disponível)
                    $postUrl = "https://www.instagram.com/p/{$postId}/";
                }

                \Log::info('Post publicado com sucesso', [
                    'post_id' => $post->id,
                    'external_post_id' => $postId,
                    'post_url' => $postUrl
                ]);

                $post->update([
                    'status' => 'posted',
                    'external_post_id' => $postId,
                    'post_url' => $postUrl,
                    'posted_at' => now(),
                ]);
                return true;
            }

            $errorMsg = 'Falha ao publicar - Método de publicação não retornou ID';
            \Log::error('Falha ao publicar post', [
                'post_id' => $post->id,
                'platform' => $post->platform,
                'error' => $errorMsg
            ]);

            $post->update([
                'status' => 'failed',
                'error_message' => $errorMsg . '. Verifique tokens e permissões nas configurações.',
            ]);
            return false;

        } catch (\Exception $e) {
            \Log::error('Exceção ao publicar post', [
                'post_id' => $post->id,
                'platform' => $post->platform,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $post->update([
                'status' => 'failed',
                'error_message' => 'Erro: ' . $e->getMessage(),
            ]);
            return false;
        }
    }

    /**
     * Processar webhook do Facebook/Instagram
     */
    public function processWebhook(array $data, string $platform): void
    {
        try {
            // Verificar se é mensagem
            if (isset($data['entry'])) {
                foreach ($data['entry'] as $entry) {
                    if (isset($entry['messaging'])) {
                        foreach ($entry['messaging'] as $messaging) {
                            $this->processIncomingMessage($messaging, $platform);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            Log::error("Erro ao processar webhook {$platform}: " . $e->getMessage());
        }
    }

    /**
     * Processar mensagem recebida
     */
    private function processIncomingMessage(array $messaging, string $platform): void
    {
        $senderId = $messaging['sender']['id'] ?? null;
        $messageText = $messaging['message']['text'] ?? null;

        if (!$senderId || !$messageText) {
            return;
        }

        // Buscar ou criar conversa
        $conversation = AiConversation::firstOrCreate(
            [
                'platform' => $platform,
                'external_id' => $senderId,
            ],
            [
                'customer_identifier' => $senderId,
                'status' => 'active',
            ]
        );

        // Salvar mensagem recebida
        $conversation->addMessage($messageText, 'incoming', 'customer');

        // Usar serviço de conhecimento para resposta inteligente
        $knowledgeService = app(\App\Services\AiKnowledgeService::class);
        $result = $knowledgeService->processMessageWithContext(
            $senderId,
            $messageText,
            $platform
        );

        if ($result['response']) {
            // Enviar resposta
            $sent = $platform === 'facebook' 
                ? $this->sendMessengerMessage($senderId, $result['response'])
                : $this->sendInstagramMessage($senderId, $result['response']);

            if ($sent) {
                // Salvar mensagem enviada
                $conversation->addMessage($result['response'], 'outgoing', 'agent');
                
                // Salvar análise de sentimento
                if ($result['sentiment']) {
                    \App\Models\AiSentimentAnalysis::create([
                        'message_id' => $conversation->messages()->latest()->first()->id,
                        'conversation_id' => $conversation->id,
                        'sentiment' => $result['sentiment']['sentiment'],
                        'confidence' => $result['sentiment']['confidence'],
                        'needs_human_attention' => $result['sentiment']['needs_human'],
                        'priority' => $result['sentiment']['priority'],
                    ]);
                    
                    // Notificar admins se precisa atenção humana
                    if ($result['sentiment']['needs_human']) {
                        \App\Services\NotificationService::aiConversationNeedsAttention(
                            $conversation->id,
                            $conversation->customer_name ?? 'Cliente',
                            $platform,
                            $result['sentiment']['sentiment'],
                            $result['sentiment']['priority'],
                            $messageText
                        );
                    }
                }
            }
        }
    }

    /**
     * Gerar resposta automática
     */
    private function generateAutomaticResponse(string $message, AiConversation $conversation): ?string
    {
        $message = strtolower($message);

        // Saudações
        if (preg_match('/^(olá|ola|oi|bom dia|boa tarde|boa noite|hey|hello)/i', $message)) {
            return "Olá! 👋 Bem-vindo à SuperLoja Angola! Como posso ajudá-lo hoje?\n\n"
                 . "Pode me perguntar sobre:\n"
                 . "📦 Produtos disponíveis\n"
                 . "💰 Preços e promoções\n"
                 . "🚚 Entregas\n"
                 . "📱 Contato: +244 939 729 902";
        }

        // Produtos
        if (str_contains($message, 'produto') || str_contains($message, 'vende')) {
            return "Temos uma grande variedade de produtos! 🛒\n\n"
                 . "Algumas categorias:\n"
                 . "📱 Tecnologia e Eletrônicos\n"
                 . "💊 Saúde e Bem-estar\n"
                 . "🧼 Produtos de Limpeza\n\n"
                 . "Visite nosso site: superloja.vip\n"
                 . "Ou me diga o que procura!";
        }

        // Preço
        if (str_contains($message, 'preço') || str_contains($message, 'preco') || str_contains($message, 'custo')) {
            return "Para consultar preços específicos, por favor:\n\n"
                 . "📱 WhatsApp: https://wa.me/244939729902\n"
                 . "🌐 Site: superloja.vip\n"
                 . "📧 Email: contato@superloja.vip\n\n"
                 . "Ou me diga qual produto você procura! 😊";
        }

        // Entrega
        if (str_contains($message, 'entrega') || str_contains($message, 'envio') || str_contains($message, 'frete')) {
            return "🚚 Informações de Entrega:\n\n"
                 . "📍 Luanda: 24-48 horas\n"
                 . "📍 Interior: 3-5 dias úteis\n"
                 . "📍 Cobertura: 18 províncias\n\n"
                 . "Fale conosco: +244 939 729 902";
        }

        // Resposta padrão
        return "Obrigado pela sua mensagem! 😊\n\n"
             . "Para melhor atendê-lo, entre em contato:\n\n"
             . "📱 WhatsApp: https://wa.me/244939729902\n"
             . "📧 Email: contato@superloja.vip\n"
             . "🌐 Site: superloja.vip\n\n"
             . "Horário: Seg-Sex 8h-18h | Sáb 8h-14h";
    }
}

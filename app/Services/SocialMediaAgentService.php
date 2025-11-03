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
    
    private ImageProcessorService $imageProcessor;

    public function __construct()
    {
        $this->imageProcessor = new ImageProcessorService();
    }

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
     * Enviar produtos com imagens (Generic Template Carousel)
     */
    public function sendProductCarousel(string $recipientId, array $products, string $introText = '', string $platform = 'facebook'): bool
    {
        try {
            $token = AiIntegrationToken::getByPlatform($platform);
            
            if (!$token || $token->isExpired()) {
                Log::error("Token do {$platform} inválido ou expirado");
                return false;
            }

            // Enviar mensagem de introdução primeiro
            if ($introText) {
                if ($platform === 'facebook') {
                    $this->sendMessengerMessage($recipientId, $introText);
                } else {
                    $this->sendInstagramMessage($recipientId, $introText);
                }
                sleep(1); // Delay para não sobrecarregar
            }

            // Preparar elementos do carousel (máximo 10 - limite do Facebook)
            $elements = [];
            foreach (array_slice($products, 0, 10) as $product) {
                $imageUrl = $product['image'] ?? null;
                $productId = $product['id'] ?? '';
                
                // Calcular preços e promoção
                $price = (float)($product['price'] ?? 0);
                $salePrice = (float)($product['sale_price'] ?? 0);
                $hasPromo = $salePrice > 0 && $salePrice < $price;
                
                // Preparar título com badges
                $badges = [];
                if ($hasPromo) {
                    $discount = round((1 - $salePrice/$price) * 100);
                    $badges[] = "🔥 {$discount}% OFF";
                }
                
                $stockQty = (int)($product['stock_quantity'] ?? 0);
                if ($stockQty > 0 && $stockQty <= 5) {
                    $badges[] = "⚠️ Últimas {$stockQty}";
                }
                
                $title = substr($product['name'], 0, 80); // Máximo 80 caracteres
                
                // Preparar subtitle com preço e descrição
                $subtitle = '';
                
                if ($hasPromo) {
                    $oldPrice = number_format($price, 2, ',', '.');
                    $newPrice = number_format($salePrice, 2, ',', '.');
                    $subtitle = "🔥 De {$oldPrice} por {$newPrice} Kz";
                } else {
                    $priceFormatted = number_format($price, 2, ',', '.');
                    $subtitle = "💰 {$priceFormatted} Kz";
                }
                
                // Adicionar descrição curta se disponível
                $description = $product['description'] ?? '';
                if (!empty($description)) {
                    $subtitle .= "\n📝 " . substr($description, 0, 50);
                }
                
                // Adicionar badges ao subtitle
                if (!empty($badges)) {
                    $subtitle = implode(' ', $badges) . "\n" . $subtitle;
                }
                
                $element = [
                    'title' => $title,
                    'subtitle' => $subtitle,
                    'buttons' => [
                        [
                            'type' => 'web_url',
                            'url' => "https://superloja.vip/produto/{$productId}", // Link direto para produto
                            'title' => '📱 Ver Detalhes'
                        ],
                        [
                            'type' => 'postback',
                            'title' => '🛍️ Adicionar ao Carrinho',
                            'payload' => 'ADD_CART_' . $productId
                        ]
                    ]
                ];
                
                // Adicionar imagem se existir e for URL pública
                if ($imageUrl && str_starts_with($imageUrl, 'http')) {
                    $element['image_url'] = $imageUrl;
                }
                
                $elements[] = $element;
            }

            // Determinar endpoint correto
            if ($platform === 'instagram') {
                $instagramAccountId = $token->page_id; // Instagram Business Account ID
                $endpoint = self::FACEBOOK_GRAPH_API . "/{$instagramAccountId}/messages";
            } else {
                $endpoint = self::FACEBOOK_GRAPH_API . '/me/messages';
            }
            
            Log::info('Enviando carousel', [
                'platform' => $platform,
                'endpoint' => $endpoint,
                'total_products' => count($elements)
            ]);

            // Enviar carousel
            $response = Http::post($endpoint, [
                'recipient' => ['id' => $recipientId],
                'messaging_type' => 'RESPONSE',
                'message' => [
                    'attachment' => [
                        'type' => 'template',
                        'payload' => [
                            'template_type' => 'generic',
                            'elements' => $elements
                        ]
                    ]
                ],
                'access_token' => $token->access_token,
            ]);

            if ($response->successful()) {
                Log::info('Carousel de produtos enviado com sucesso', [
                    'platform' => $platform,
                    'recipient' => $recipientId,
                    'total_products' => count($elements),
                ]);
                return true;
            }
            
            Log::error('Falha ao enviar carousel', [
                'platform' => $platform,
                'status' => $response->status(),
                'response' => $response->json()
            ]);
            return false;

        } catch (Exception $e) {
            Log::error('Exceção ao enviar carousel: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Enviar lista de produtos com IMAGENS para Instagram
     * Envia sequência de mensagens: 1 mensagem = 1 produto com imagem
     */
    public function sendProductListInstagram(string $recipientId, array $products, string $introText = ''): bool
    {
        try {
            $token = AiIntegrationToken::getByPlatform('instagram');
            
            if (!$token || $token->isExpired()) {
                Log::error('Token do Instagram inválido');
                return false;
            }
            
            $instagramAccountId = $token->page_id;
            
            // Limitar a 3 produtos para não sobrecarregar
            $products = array_slice($products, 0, 3);
            
            Log::info('Enviando produtos com imagens no Instagram', [
                'total_produtos' => count($products),
                'recipient' => $recipientId
            ]);
            
            // 1. Enviar mensagem de introdução
            if ($introText) {
                $this->sendInstagramMessage($recipientId, $introText);
                sleep(1); // Delay para não sobrecarregar
            }
            
            // 2. Enviar cada produto como mensagem separada com imagem
            foreach ($products as $index => $product) {
                $num = $index + 1;
                $name = $product['name'] ?? 'Produto';
                $price = (float)($product['price'] ?? 0);
                $salePrice = (float)($product['sale_price'] ?? 0);
                $hasPromo = $salePrice > 0 && $salePrice < $price;
                $imageUrl = $product['image'] ?? null;
                $productId = $product['id'] ?? '';
                
                // Preparar texto do produto
                $caption = "*{$num}. {$name}*\n\n";
                
                if ($hasPromo) {
                    $discount = round((1 - $salePrice/$price) * 100);
                    $newPrice = number_format($salePrice, 2, ',', '.');
                    $caption .= "🔥 *OFERTA {$discount}% OFF*\n";
                    $caption .= "💰 *Apenas {$newPrice} Kz*\n";
                } else {
                    $priceFormatted = number_format($price, 2, ',', '.');
                    $caption .= "💰 *{$priceFormatted} Kz*\n";
                }
                
                $stock = (int)($product['stock_quantity'] ?? 0);
                if ($stock > 0 && $stock <= 5) {
                    $caption .= "⚠️ *Últimas {$stock} unidades!*\n";
                } else if ($stock > 0) {
                    $caption .= "✅ *Disponível*\n";
                }
                
                if ($productId) {
                    $caption .= "\n🔗 Ver detalhes: https://superloja.vip/produto/{$productId}";
                }
                
                // Enviar imagem com legenda
                if ($imageUrl && str_starts_with($imageUrl, 'http')) {
                    $this->sendInstagramImageMessage($recipientId, $imageUrl, $caption, $instagramAccountId, $token->access_token);
                } else {
                    // Se não tem imagem, enviar só texto
                    $this->sendInstagramMessage($recipientId, $caption);
                }
                
                sleep(2); // Delay entre produtos
            }
            
            // 3. Mensagem final
            $finalMessage = "━━━━━━━━━━━━━━━━━━\n\n";
            $finalMessage .= "💬 *Qual produto te interessou?*\n";
            $finalMessage .= "Me diga o número ou clique no link! 😊";
            
            $this->sendInstagramMessage($recipientId, $finalMessage);
            
            Log::info('Produtos com imagens enviados com sucesso no Instagram');
            return true;
            
        } catch (Exception $e) {
            Log::error('Erro ao enviar produtos com imagens Instagram', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
    
    /**
     * Enviar mensagem com imagem no Instagram
     */
    private function sendInstagramImageMessage(
        string $recipientId, 
        string $imageUrl, 
        string $caption, 
        string $instagramAccountId,
        string $accessToken
    ): bool {
        try {
            $endpoint = self::FACEBOOK_GRAPH_API . "/{$instagramAccountId}/messages";
            
            Log::info('Enviando imagem no Instagram', [
                'image_url' => $imageUrl,
                'caption_length' => strlen($caption)
            ]);
            
            // Tentar com Instagram Account ID
            $response = Http::post($endpoint, [
                'recipient' => ['id' => $recipientId],
                'message' => [
                    'attachment' => [
                        'type' => 'image',
                        'payload' => [
                            'url' => $imageUrl,
                            'is_reusable' => true
                        ]
                    ]
                ],
                'access_token' => $accessToken,
            ]);
            
            // Se falhar, tentar com /me
            if (!$response->successful() && $response->status() === 400) {
                Log::warning('Tentando enviar imagem com /me endpoint');
                
                $response = Http::post(self::FACEBOOK_GRAPH_API . '/me/messages', [
                    'recipient' => ['id' => $recipientId],
                    'message' => [
                        'attachment' => [
                            'type' => 'image',
                            'payload' => [
                                'url' => $imageUrl,
                                'is_reusable' => true
                            ]
                        ]
                    ],
                    'access_token' => $accessToken,
                ]);
            }
            
            if ($response->successful()) {
                // Enviar legenda como mensagem separada
                sleep(1);
                $this->sendInstagramMessage($recipientId, $caption);
                
                Log::info('Imagem enviada com sucesso no Instagram');
                return true;
            }
            
            Log::error('Falha ao enviar imagem no Instagram', [
                'status' => $response->status(),
                'response' => $response->json()
            ]);
            
            return false;
            
        } catch (Exception $e) {
            Log::error('Exceção ao enviar imagem Instagram', [
                'error' => $e->getMessage()
            ]);
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

            // Instagram requer o ID da conta business, não "me"
            $instagramAccountId = $token->page_id; // Este é o Instagram Business Account ID
            
            if (!$instagramAccountId) {
                Log::error('Instagram Business Account ID não configurado');
                return false;
            }

            Log::info('Tentando enviar mensagem Instagram', [
                'recipient' => $recipientId,
                'instagram_account_id' => $instagramAccountId,
                'message_length' => strlen($message)
            ]);

            // Tentar com Instagram Account ID
            $response = Http::post(self::FACEBOOK_GRAPH_API . "/{$instagramAccountId}/messages", [
                'recipient' => ['id' => $recipientId],
                'message' => ['text' => $message],
                'access_token' => $token->access_token,
            ]);
            
            // Se falhar, tentar com "me"
            if (!$response->successful() && $response->status() === 400) {
                Log::warning('Tentativa com Instagram ID falhou, tentando com "me"');
                
                $response = Http::post(self::FACEBOOK_GRAPH_API . "/me/messages", [
                    'recipient' => ['id' => $recipientId],
                    'message' => ['text' => $message],
                    'messaging_type' => 'RESPONSE',
                    'access_token' => $token->access_token,
                ]);
            }

            if ($response->successful()) {
                Log::info('Mensagem Instagram enviada com sucesso', [
                    'recipient' => $recipientId,
                    'message_id' => $response->json('message_id')
                ]);
                return true;
            }

            Log::error('Falha ao enviar mensagem Instagram', [
                'status' => $response->status(),
                'response' => $response->json(),
                'recipient' => $recipientId
            ]);

            return false;

        } catch (Exception $e) {
            Log::error('Exceção ao enviar mensagem Instagram', [
                'error' => $e->getMessage(),
                'recipient' => $recipientId
            ]);
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

            // Se tiver múltiplas imagens, criar carrossel
            if ($mediaUrls && count($mediaUrls) > 1) {
                return $this->uploadCarouselToFacebook($pageId, $token->access_token, $mediaUrls, $content);
            }
            
            // Se tiver apenas 1 imagem, fazer upload normal
            if ($mediaUrls && count($mediaUrls) == 1) {
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
     * Upload de carrossel (múltiplas fotos) para o Facebook
     */
    private function uploadCarouselToFacebook(string $pageId, string $accessToken, array $imageUrls, string $caption): ?string
    {
        try {
            \Log::info('Iniciando upload de carrossel para Facebook', [
                'total_images' => count($imageUrls),
                'page_id' => $pageId
            ]);

            // Passo 1: Fazer upload de todas as fotos (sem publicar)
            $photoIds = [];
            
            foreach ($imageUrls as $index => $imageUrl) {
                // Extrair caminho local da imagem
                $parsedUrl = parse_url($imageUrl);
                $path = $parsedUrl['path'] ?? '';
                $localPath = str_replace('/storage/', '', $path);
                $fullPath = storage_path('app/public/' . $localPath);

                // Verificar se arquivo existe
                if (!file_exists($fullPath)) {
                    \Log::error('Arquivo não encontrado para carrossel', [
                        'index' => $index,
                        'path' => $fullPath
                    ]);
                    continue;
                }

                // Upload da foto SEM publicar (published=false)
                $endpoint = self::FACEBOOK_GRAPH_API . "/{$pageId}/photos";
                
                $response = Http::timeout(60) // Aumentar timeout para 60 segundos
                    ->attach(
                        'source', 
                        file_get_contents($fullPath), 
                        basename($fullPath)
                    )->post($endpoint, [
                        'published' => 'false', // IMPORTANTE: não publicar ainda
                        'access_token' => $accessToken,
                    ]);

                if ($response->successful()) {
                    $photoId = $response->json('id');
                    $photoIds[] = $photoId;
                    
                    \Log::info('Foto do carrossel enviada', [
                        'index' => $index + 1,
                        'photo_id' => $photoId,
                        'file' => basename($fullPath)
                    ]);
                } else {
                    \Log::error('Erro ao enviar foto do carrossel', [
                        'index' => $index,
                        'response' => $response->json()
                    ]);
                }
            }

            if (empty($photoIds)) {
                \Log::error('Nenhuma foto foi enviada para o carrossel');
                return null;
            }

            \Log::info('Total de fotos enviadas para carrossel', [
                'count' => count($photoIds),
                'photo_ids' => $photoIds
            ]);

            // Passo 2: Criar post com todas as fotos
            $attachedMedia = array_map(function($photoId) {
                return ['media_fbid' => $photoId];
            }, $photoIds);

            $endpoint = self::FACEBOOK_GRAPH_API . "/{$pageId}/feed";
            
            $response = Http::timeout(60)->post($endpoint, [
                'message' => $caption,
                'attached_media' => json_encode($attachedMedia),
                'access_token' => $accessToken,
            ]);

            if ($response->successful()) {
                $postId = $response->json('id') ?? $response->json('post_id');
                
                \Log::info('Carrossel publicado com sucesso no Facebook', [
                    'post_id' => $postId,
                    'total_photos' => count($photoIds)
                ]);

                return $postId;
            }

            \Log::error('Erro ao publicar carrossel', [
                'response' => $response->json(),
                'status' => $response->status()
            ]);
            
            return null;

        } catch (\Exception $e) {
            \Log::error('Exceção ao fazer upload de carrossel', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Upload de carrossel (múltiplas fotos) para o Instagram
     */
    private function uploadCarouselToInstagram(string $caption, array $imageUrls, ?array $hashtags = null): ?string
    {
        try {
            $token = AiIntegrationToken::getByPlatform('instagram');
            
            if (!$token || $token->isExpired()) {
                \Log::error('Token do Instagram inválido');
                return null;
            }

            $igUserId = $token->page_id;
            $content = $caption;

            // Adicionar hashtags
            if ($hashtags) {
                $content .= "\n\n" . implode(' ', array_map(fn($tag) => "#{$tag}", $hashtags));
            }

            \Log::info('Iniciando upload de carrossel para Instagram', [
                'total_images' => count($imageUrls),
                'ig_user_id' => $igUserId
            ]);

            // Passo 1: Criar containers para cada imagem
            $childrenIds = [];

            foreach ($imageUrls as $index => $imageUrl) {
                // Verificar se é URL local e converter para caminho público se necessário
                if (str_contains($imageUrl, 'localhost') || str_contains($imageUrl, '.test')) {
                    \Log::warning('Instagram não funciona com URLs localhost. Imagem será ignorada.', [
                        'image_url' => $imageUrl
                    ]);
                    continue;
                }

                // Criar container de mídia para cada imagem
                $containerResponse = Http::timeout(60)->post(
                    self::FACEBOOK_GRAPH_API . "/{$igUserId}/media",
                    [
                        'image_url' => $imageUrl,
                        'is_carousel_item' => 'true',
                        'access_token' => $token->access_token,
                    ]
                );

                if (!$containerResponse->successful()) {
                    \Log::error('Erro ao criar container de imagem no Instagram', [
                        'index' => $index,
                        'response' => $containerResponse->json(),
                        'image_url' => $imageUrl
                    ]);
                    continue;
                }

                $containerId = $containerResponse->json('id');
                $childrenIds[] = $containerId;

                \Log::info('Container de imagem criado no Instagram', [
                    'index' => $index + 1,
                    'container_id' => $containerId
                ]);

                // Pequeno delay entre uploads
                usleep(500000); // 0.5 segundo
            }

            if (empty($childrenIds)) {
                \Log::error('Nenhum container de imagem foi criado no Instagram');
                return null;
            }

            \Log::info('Todos os containers criados, criando carrossel principal', [
                'total_containers' => count($childrenIds)
            ]);

            // Aguardar processamento das imagens
            sleep(3);

            // Passo 2: Criar container principal do carrossel
            $carouselResponse = Http::timeout(60)->post(
                self::FACEBOOK_GRAPH_API . "/{$igUserId}/media",
                [
                    'media_type' => 'CAROUSEL',
                    'caption' => $content,
                    'children' => implode(',', $childrenIds),
                    'access_token' => $token->access_token,
                ]
            );

            if (!$carouselResponse->successful()) {
                \Log::error('Erro ao criar carrossel principal no Instagram', [
                    'response' => $carouselResponse->json()
                ]);
                return null;
            }

            $carouselContainerId = $carouselResponse->json('id');

            \Log::info('Carrossel principal criado, publicando...', [
                'carousel_container_id' => $carouselContainerId
            ]);

            // Aguardar processamento
            sleep(2);

            // Passo 3: Publicar o carrossel
            $publishResponse = Http::timeout(60)->post(
                self::FACEBOOK_GRAPH_API . "/{$igUserId}/media_publish",
                [
                    'creation_id' => $carouselContainerId,
                    'access_token' => $token->access_token,
                ]
            );

            if ($publishResponse->successful()) {
                $postId = $publishResponse->json('id');
                
                \Log::info('Carrossel publicado no Instagram com sucesso', [
                    'post_id' => $postId,
                    'total_images' => count($childrenIds)
                ]);

                return $postId;
            }

            \Log::error('Erro ao publicar carrossel no Instagram', [
                'response' => $publishResponse->json()
            ]);

            return null;

        } catch (\Exception $e) {
            \Log::error('Exceção ao fazer upload de carrossel para Instagram', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Criar post no Instagram com múltiplas imagens (carrossel)
     * NOTA: Instagram requer URL pública acessível (não funciona com localhost)
     */
    public function postToInstagram(
        string $caption,
        string|array $imageUrl,
        ?array $hashtags = null
    ): ?string {
        // Se for array de imagens, criar carrossel
        if (is_array($imageUrl) && count($imageUrl) > 1) {
            return $this->uploadCarouselToInstagram($caption, $imageUrl, $hashtags);
        }
        
        // Se for array com 1 imagem, pegar a primeira
        if (is_array($imageUrl)) {
            $imageUrl = $imageUrl[0];
        }
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
            'superloja',
            'Angola',
            'Luanda',
            'ComprasOnline',
            'acessorios',
            'portateis',
            'tablets',
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
            // Processar imagem: adicionar logo, moldura e informações do produto
            $processedImage = $this->imageProcessor->processProductImage(
                'storage/' . $product->featured_image,
                [
                    'product_name' => $product->name,
                    'price' => $product->is_on_sale ? $product->sale_price : $product->price,
                    'add_logo' => true,
                    'add_border' => true,
                    'add_watermark' => true,
                ]
            );

            // Se processamento falhar, usar imagem original
            if ($processedImage) {
                $imageUrl = url('storage/' . $processedImage);
            } else {
                $imageUrl = url('storage/' . $product->featured_image);
            }
            
            $mediaUrls[] = $imageUrl;
            
            \Log::info('Media URL gerada para post', [
                'product_id' => $product->id,
                'image_url' => $imageUrl,
                'featured_image' => $product->featured_image,
                'processed' => $processedImage ? true : false
            ]);
        }

        return [
            'message' => $message,
            'hashtags' => $hashtags,
            'media_urls' => $mediaUrls,
        ];
    }

    /**
     * Gerar conteúdo de post para CARROSSEL de produtos
     */
    public function generateCarouselPostContent($products, string $platform = 'facebook'): array
    {
        $productsCount = $products->count();
        $emojis = ['🔥', '⚡', '✨', '💫', '🎯', '🌟'];
        $emoji = $emojis[array_rand($emojis)];

        // Mensagem de introdução
        $intros = [
            "🎉 SUPER SELEÇÃO! {$productsCount} produtos incríveis para você {$emoji}",
            "🔥 MEGA OFERTA! Confira nossos {$productsCount} produtos em destaque {$emoji}",
            "✨ PROMOÇÃO ESPECIAL! {$productsCount} produtos que você não pode perder {$emoji}",
            "🌟 OS MAIS VENDIDOS! {$productsCount} produtos top da SuperLoja {$emoji}",
        ];

        $message = $intros[array_rand($intros)];
        $message .= "\n━━━━━━━━━━━━━━━━━━━━━\n\n";

        // Adicionar cada produto na lista
        $totalValue = 0;
        $hasDiscount = false;
        
        foreach ($products as $index => $product) {
            $num = $index + 1;
            $message .= "📦 {$num}. {$product->name}\n";
            
            if ($product->is_on_sale) {
                $message .= "   💰 De " . number_format((float)$product->price, 2, ',', '.') . " Kz";
                $message .= " → 🔥 " . number_format((float)$product->sale_price, 2, ',', '.') . " Kz\n";
                $totalValue += (float)$product->sale_price;
                $hasDiscount = true;
            } else {
                $message .= "   💰 " . number_format((float)$product->price, 2, ',', '.') . " Kz\n";
                $totalValue += (float)$product->price;
            }
            
            $message .= "\n";
        }

        $message .= "━━━━━━━━━━━━━━━━━━━━━\n";
        
        if ($hasDiscount) {
            $message .= "🎁 ECONOMIA GARANTIDA!\n";
        }
        
        $message .= "💵 Valor total: " . number_format($totalValue, 2, ',', '.') . " Kz\n\n";

        // Call to action
        $message .= "📱 Peça agora pelo WhatsApp:\n";
        $message .= "https://wa.me/244939729902\n\n";
        $message .= "🛒 Ou compre online:\n";
        $message .= "https://superloja.vip";

        // Hashtags
        $hashtags = [
            'SuperLojaAngola',
            'superloja',
            'Angola',
            'Luanda',
            'ComprasOnline',
            'acessorios',
            'portateis',
            'tablets',
            'Promoção',
            'Ofertas',
            'MaisVendidos',
        ];

        // Coletar todas as imagens dos produtos
        $mediaUrls = [];
        foreach ($products as $product) {
            if ($product->featured_image) {
                // Processar cada imagem do carrossel
                $processedImage = $this->imageProcessor->processProductImage(
                    'storage/' . $product->featured_image,
                    [
                        'product_name' => $product->name,
                        'price' => $product->is_on_sale ? $product->sale_price : $product->price,
                        'add_logo' => true,
                        'add_border' => true,
                        'add_watermark' => true,
                    ]
                );

                if ($processedImage) {
                    $imageUrl = url('storage/' . $processedImage);
                } else {
                    $imageUrl = url(\Storage::url($product->featured_image));
                }
                
                $mediaUrls[] = $imageUrl;
            }
        }

        Log::info('Conteúdo de carrossel gerado', [
            'products_count' => $productsCount,
            'total_images' => count($mediaUrls),
            'platform' => $platform,
        ]);

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
            // Recarregar post do banco para garantir status atualizado (evitar duplicação)
            $post->refresh();
            
            // Se já foi publicado, não publicar novamente
            if ($post->status !== 'scheduled') {
                \Log::warning('Post não está mais agendado, pulando', [
                    'post_id' => $post->id,
                    'status' => $post->status
                ]);
                return false;
            }
            
            // Marcar como 'publishing' imediatamente para evitar duplicação
            $post->update(['status' => 'publishing']);
            
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
                
                // Se for path relativo (/storage/...), verificar arquivo local
                if (str_starts_with($imageUrl, '/storage/')) {
                    $localPath = str_replace('/storage/', '', $imageUrl);
                    $fullPath = storage_path('app/public/' . $localPath);
                    
                    if (!file_exists($fullPath)) {
                        $errorMsg = "Arquivo de imagem não encontrado ({$imageUrl}). Caminho: {$fullPath}";
                        \Log::error('Arquivo de imagem não encontrado', ['post_id' => $post->id, 'path' => $fullPath]);
                        $post->update([
                            'status' => 'failed',
                            'error_message' => $errorMsg,
                        ]);
                        return false;
                    }
                }
                // Se for URL completa (http://...), verificar com get_headers
                elseif (str_starts_with($imageUrl, 'http://') || str_starts_with($imageUrl, 'https://')) {
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
                    $post->media_urls, // Passar todas as imagens (suporta carrossel)
                    $post->hashtags
                );
            }

            if ($postId) {
                // Gerar URL do post
                $postUrl = null;
                if ($post->platform === 'facebook') {
                    // URL do post no Facebook usando o token configurado
                    $token = \App\Models\AiIntegrationToken::getByPlatform('facebook');
                    if ($token && $token->page_id) {
                        $postUrl = "https://www.facebook.com/{$token->page_id}/posts/{$postId}";
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

            // Se estava em 'publishing', reverter para 'failed' (não 'scheduled' para evitar loop)
            $post->update([
                'status' => 'failed',
                'error_message' => 'Erro ao publicar: ' . $e->getMessage(),
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
            // Verificar se é mensagem ou postback
            if (isset($data['entry'])) {
                foreach ($data['entry'] as $entry) {
                    if (isset($entry['messaging'])) {
                        foreach ($entry['messaging'] as $messaging) {
                            // IGNORAR mensagens de echo (próprias mensagens do bot)
                            if (isset($messaging['message']['is_echo']) && $messaging['message']['is_echo'] === true) {
                                Log::info('Mensagem de echo ignorada (própria mensagem do bot)');
                                continue;
                            }
                            
                            // IGNORAR delivery reports
                            if (isset($messaging['delivery'])) {
                                continue;
                            }
                            
                            // Se é mensagem de texto
                            if (isset($messaging['message']['text'])) {
                                $this->processIncomingMessage($messaging, $platform);
                            }
                            // Se é postback (clique em botão)
                            elseif (isset($messaging['postback'])) {
                                $this->processPostback($messaging, $platform);
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            Log::error("Erro ao processar webhook {$platform}: " . $e->getMessage());
        }
    }

    /**
     * Processar postback (quando cliente clica em "Adicionar ao Carrinho")
     */
    private function processPostback(array $messaging, string $platform): void
    {
        $senderId = $messaging['sender']['id'] ?? null;
        $payload = $messaging['postback']['payload'] ?? null;

        if (!$senderId || !$payload) {
            return;
        }

        // Se é adicionar ao carrinho (payload = ADD_CART_123)
        if (str_starts_with($payload, 'ADD_CART_')) {
            $productId = str_replace('ADD_CART_', '', $payload);
            $this->addToCart($senderId, $productId, $platform);
        }
        // Suporte legado ORDER_
        elseif (str_starts_with($payload, 'ORDER_')) {
            $productId = str_replace('ORDER_', '', $payload);
            $this->addToCart($senderId, $productId, $platform);
        }
    }

    /**
     * Adicionar produto ao carrinho (permite múltiplos)
     */
    private function addToCart(string $senderId, string $productId, string $platform): void
    {
        try {
            // Buscar produto
            $product = Product::find($productId);
            
            if (!$product) {
                $this->sendMessengerMessage($senderId, "Produto não encontrado 😕\n\nFale com a equipe:\n📱 https://wa.me/244939729902");
                return;
            }

            // Buscar conversa
            $conversation = AiConversation::where('platform', $platform)
                ->where('external_id', $senderId)
                ->first();

            if ($conversation) {
                // Salvar no carrinho do contexto
                $context = \App\Models\AiCustomerContext::where('customer_identifier', $senderId)->first();
                if ($context) {
                    // Adicionar ao carrinho (JSON)
                    $purchaseHistory = $context->purchase_history ?? [];
                    $cart = $purchaseHistory['cart'] ?? [];
                    
                    // Verificar se já está no carrinho
                    $found = false;
                    foreach ($cart as $key => $item) {
                        if ($item['product_id'] == $productId) {
                            $cart[$key]['quantity'] = ($item['quantity'] ?? 1) + 1;
                            $found = true;
                            break;
                        }
                    }
                    
                    if (!$found) {
                        $cart[] = [
                            'product_id' => $productId,
                            'product_name' => $product->name,
                            'price' => $product->price,
                            'quantity' => 1,
                            'added_at' => now()->toIso8601String()
                        ];
                    }
                    
                    $purchaseHistory['cart'] = $cart;
                    $context->update(['purchase_history' => $purchaseHistory]);
                }

                // Adicionar mensagem de carrinho
                $conversation->addMessage("🛍️ Adicionar ao carrinho: {$product->name}", 'incoming', 'customer');
            }

            $price = number_format((float)$product->price, 2, ',', '.');
            $inStock = $product->stock_quantity > 0 ? '✅ Disponível' : '⚠️ Sob consulta';

            // Contar itens no carrinho
            $context = \App\Models\AiCustomerContext::where('customer_identifier', $senderId)->first();
            $cartCount = 0;
            if ($context) {
                $purchaseHistory = $context->purchase_history ?? [];
                $cart = $purchaseHistory['cart'] ?? [];
                foreach ($cart as $item) {
                    $cartCount += $item['quantity'] ?? 1;
                }
            }
            
            // Enviar confirmação
            $response = "✅ Adicionado ao carrinho! 🛍️\n\n" .
                       "📦 *{$product->name}*\n" .
                       "💰 {$price} Kz\n" .
                       "{$inStock}\n\n" .
                       "🛍️ Seu carrinho: *{$cartCount} item(ns)*\n\n" .
                       "━━━━━━━━━━━━━━━━\n" .
                       "O que deseja fazer agora?\n\n" .
                       "🛍️ Digite 'ver carrinho' - Revisar itens\n" .
                       "✅ Digite 'finalizar' - Concluir pedido\n" .
                       "🔍 Digite 'produtos' - Continuar comprando\n" .
                       "💬 Fale com equipe: https://wa.me/244939729902";

            $this->sendMessengerMessage($senderId, $response);

            // Salvar resposta
            if ($conversation) {
                $conversation->addMessage($response, 'outgoing', 'agent');
            }

            Log::info('Produto adicionado ao carrinho', [
                'customer' => $senderId,
                'product' => $product->name,
                'cart_total' => $cartCount,
                'platform' => $platform
            ]);

        } catch (Exception $e) {
            Log::error('Erro ao processar encomenda: ' . $e->getMessage());
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
            $platform,
            $conversation->id  // Passar ID da conversa para evitar repetições
        );

        if ($result['response']) {
            // Se há produtos
            if (!empty($result['products'])) {
                Log::info('Tentando enviar produtos', [
                    'total_produtos' => count($result['products']),
                    'platform' => $platform,
                    'sender_id' => $senderId
                ]);
                
                // Facebook: Carousel visual
                if ($platform === 'facebook') {
                    $sent = $this->sendProductCarousel($senderId, $result['products'], $result['response'], $platform);
                    Log::info('Carousel enviado (Facebook)', ['sent' => $sent]);
                }
                // Instagram: Lista formatada (carousel não suportado sem aprovação)
                else if ($platform === 'instagram') {
                    $sent = $this->sendProductListInstagram($senderId, $result['products'], $result['response']);
                    Log::info('Lista de produtos enviada (Instagram)', ['sent' => $sent]);
                }
                
            } else {
                Log::info('Enviando resposta normal (sem carousel)', [
                    'has_products' => !empty($result['products']),
                    'platform' => $platform,
                    'products_count' => count($result['products'] ?? [])
                ]);
                
                // Enviar resposta normal
                $sent = $platform === 'facebook' 
                    ? $this->sendMessengerMessage($senderId, $result['response'])
                    : $this->sendInstagramMessage($senderId, $result['response']);
            }

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

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AiAutoPost;
use App\Services\SocialMediaAgentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;

class CronTriggerController extends Controller
{
    public function __construct(
        private SocialMediaAgentService $socialMedia
    ) {}

    /**
     * Disparar publicação de posts agendados
     * 
     * GET/POST /api/cron/trigger-posts
     */
    public function triggerPosts(Request $request)
    {
        // API pública - sem autenticação necessária

        try {
            // Buscar posts agendados que já passaram da hora
            $pendingPosts = AiAutoPost::where('status', 'scheduled')
                ->where('scheduled_for', '<=', now())
                ->orderBy('scheduled_for', 'asc')
                ->get();

            if ($pendingPosts->isEmpty()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Nenhum post agendado para publicar no momento',
                    'pending_count' => 0,
                    'published_count' => 0,
                    'next_scheduled' => $this->getNextScheduled()
                ]);
            }

            Log::channel('cron')->info('🌐 API Trigger - Iniciando publicação', [
                'pending_posts' => $pendingPosts->count(),
                'triggered_by' => 'n8n',
                'ip' => $request->ip()
            ]);

            // Publicar posts pendentes
            $published = [];
            $failed = [];

            foreach ($pendingPosts as $post) {
                try {
                    $result = $this->publishPost($post);
                    
                    if ($result['success']) {
                        $published[] = [
                            'id' => $post->id,
                            'platform' => $post->platform,
                            'type' => $post->post_type,
                            'scheduled_for' => $post->scheduled_for->format('Y-m-d H:i:s'),
                            'post_url' => $result['post_url'] ?? null
                        ];
                    } else {
                        $failed[] = [
                            'id' => $post->id,
                            'platform' => $post->platform,
                            'error' => $result['error']
                        ];
                    }
                } catch (\Exception $e) {
                    $failed[] = [
                        'id' => $post->id,
                        'platform' => $post->platform,
                        'error' => $e->getMessage()
                    ];
                }
            }

            Log::channel('cron')->info('✅ API Trigger - Publicação concluída', [
                'published' => count($published),
                'failed' => count($failed)
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Publicação concluída',
                'pending_count' => $pendingPosts->count(),
                'published_count' => count($published),
                'failed_count' => count($failed),
                'published' => $published,
                'failed' => $failed,
                'next_scheduled' => $this->getNextScheduled(),
                'timestamp' => now()->toIso8601String()
            ]);

        } catch (\Exception $e) {
            Log::channel('cron')->error('❌ API Trigger - Erro', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'message' => 'Erro ao processar publicação'
            ], 500);
        }
    }

    /**
     * Disparar análise de produtos
     * 
     * GET/POST /api/cron/trigger-analysis
     */
    public function triggerAnalysis(Request $request)
    {
        // API pública - sem autenticação necessária

        try {
            Log::channel('cron')->info('🌐 API Trigger - Iniciando análise de produtos');

            Artisan::call('ai:analyze-products');
            $output = Artisan::output();

            Log::channel('cron')->info('✅ API Trigger - Análise concluída');

            return response()->json([
                'success' => true,
                'message' => 'Análise de produtos executada com sucesso',
                'output' => trim($output),
                'timestamp' => now()->toIso8601String()
            ]);

        } catch (\Exception $e) {
            Log::channel('cron')->error('❌ API Trigger - Erro na análise', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Disparar criação automática de posts
     * 
     * GET/POST /api/cron/trigger-create-posts
     * 
     * Padrão: Cria automaticamente 10 posts para Instagram E 10 posts para Facebook
     * Com parâmetros: ?platform=facebook&limit=5 (para compatibilidade com workflows antigos)
     * 
     * Ideal para executar 1x por dia via n8n/cron
     */
    public function triggerCreatePosts(Request $request)
    {
        // API pública - sem autenticação necessária

        try {
            // Parâmetros opcionais (compatibilidade com workflows antigos)
            $platform = $request->input('platform'); // null = ambas plataformas
            $limit = $request->input('limit', 10); // padrão: 10 posts
            $results = [];

            // Se plataforma específica foi solicitada
            if ($platform && in_array($platform, ['facebook', 'instagram'])) {
                Log::channel('cron')->info('🌐 API Trigger - Criando posts', [
                    'platform' => $platform,
                    'limit' => $limit
                ]);

                Artisan::call('ai:auto-create-posts', [
                    '--platform' => $platform,
                    '--limit' => $limit
                ]);
                
                $results[$platform] = [
                    'output' => trim(Artisan::output()),
                    'limit' => $limit
                ];

                return response()->json([
                    'success' => true,
                    'message' => "Posts criados com sucesso para {$platform}",
                    'total_posts_created' => $limit,
                    'platform' => $platform,
                    'limit' => $limit,
                    'results' => $results,
                    'timestamp' => now()->toIso8601String()
                ]);
            }

            // Sem plataforma especificada = criar para AMBAS (comportamento novo)
            Log::channel('cron')->info('🌐 API Trigger - Criando posts diários', [
                'limit_per_platform' => $limit,
                'platforms' => ['facebook', 'instagram']
            ]);

            // 1️⃣ Criar posts para FACEBOOK
            Log::channel('cron')->info('📘 Criando posts para Facebook...');
            Artisan::call('ai:auto-create-posts', [
                '--platform' => 'facebook',
                '--limit' => $limit
            ]);
            $results['facebook'] = [
                'output' => trim(Artisan::output()),
                'limit' => $limit
            ];

            // 2️⃣ Criar posts para INSTAGRAM
            Log::channel('cron')->info('📸 Criando posts para Instagram...');
            Artisan::call('ai:auto-create-posts', [
                '--platform' => 'instagram',
                '--limit' => $limit
            ]);
            $results['instagram'] = [
                'output' => trim(Artisan::output()),
                'limit' => $limit
            ];

            Log::channel('cron')->info('✅ API Trigger - Posts criados para ambas plataformas');

            return response()->json([
                'success' => true,
                'message' => 'Posts criados com sucesso para Facebook e Instagram',
                'total_posts_created' => $limit * 2, // 10 Facebook + 10 Instagram = 20 posts
                'limit_per_platform' => $limit,
                'platforms' => ['facebook', 'instagram'],
                'results' => $results,
                'timestamp' => now()->toIso8601String()
            ]);

        } catch (\Exception $e) {
            Log::channel('cron')->error('❌ API Trigger - Erro ao criar posts', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Disparar criação de carrosséis
     * 
     * GET/POST /api/cron/trigger-create-carousels
     * 
     * Padrão: Cria 3 carrosséis para Facebook com horários automáticos
     * Com horários: ?count=3&times=10:00,14:00,18:00 (define horários específicos)
     * Com parâmetros: ?platform=facebook&count=3&products=8
     * 
     * Ideal para executar 1x por dia via n8n/cron
     */
    public function triggerCreateCarousels(Request $request)
    {
        // API pública - sem autenticação necessária

        try {
            // Parâmetros opcionais
            $platform = $request->input('platform', 'facebook');
            $count = $request->input('count', 3);
            $productsPerCarousel = $request->input('products', 8);
            $customTimes = $request->input('times'); // Ex: "10:00,14:00,18:00"

            Log::channel('cron')->info('🌐 API Trigger - Criando carrosséis', [
                'count' => $count,
                'products_per_carousel' => $productsPerCarousel,
                'platform' => $platform,
                'custom_times' => $customTimes
            ]);

            // Se horários personalizados foram fornecidos
            if ($customTimes) {
                return $this->createCarouselsWithCustomTimes($platform, $count, $productsPerCarousel, $customTimes);
            }

            // Comportamento padrão: usar comando artisan com horários automáticos
            Artisan::call('ai:auto-create-carousels', [
                '--platform' => $platform,
                '--count' => $count,
                '--products' => $productsPerCarousel
            ]);
            $output = Artisan::output();

            Log::channel('cron')->info('✅ API Trigger - Carrosséis criados');

            return response()->json([
                'success' => true,
                'message' => 'Carrosséis criados com sucesso',
                'total_carousels' => $count,
                'products_per_carousel' => $productsPerCarousel,
                'platform' => $platform,
                'output' => trim($output),
                'timestamp' => now()->toIso8601String()
            ]);

        } catch (\Exception $e) {
            Log::channel('cron')->error('❌ API Trigger - Erro ao criar carrosséis', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Criar carrosséis com horários personalizados
     */
    private function createCarouselsWithCustomTimes($platform, $count, $productsPerCarousel, $timesString)
    {
        $times = array_map('trim', explode(',', $timesString));
        $socialMedia = app(SocialMediaAgentService::class);
        $created = [];

        foreach (array_slice($times, 0, $count) as $time) {
            try {
                // Buscar produtos HOT
                $hotProducts = \App\Models\AiProductInsight::with('product')
                    ->hotProducts()
                    ->whereHas('product', function($query) {
                        $query->where('is_active', true)
                              ->whereNotNull('featured_image')
                              ->where('stock_quantity', '>', 0);
                    })
                    ->inRandomOrder()
                    ->limit($productsPerCarousel * 2)
                    ->get()
                    ->pluck('product')
                    ->filter()
                    ->unique('id')
                    ->take($productsPerCarousel);

                if ($hotProducts->count() < $productsPerCarousel) {
                    // Fallback: produtos aleatórios
                    $products = \App\Models\Product::where('is_active', true)
                        ->whereNotNull('featured_image')
                        ->where('stock_quantity', '>', 0)
                        ->inRandomOrder()
                        ->limit($productsPerCarousel)
                        ->get();
                } else {
                    $products = $hotProducts;
                }

                if ($products->count() < 3) {
                    continue; // Mínimo 3 produtos por carrossel
                }

                // Gerar conteúdo do carrossel
                $postData = $socialMedia->generateCarouselPostContent($products, $platform);

                // Parse do horário
                [$hour, $minute] = explode(':', $time);
                $scheduledTime = now()->setTime((int)$hour, (int)$minute);
                
                if ($scheduledTime->isPast()) {
                    $scheduledTime->addDay();
                }

                // Criar carrossel
                $post = \App\Models\AiAutoPost::create([
                    'platform' => $platform,
                    'post_type' => 'carousel',
                    'product_id' => null,
                    'product_ids' => $products->pluck('id')->toArray(),
                    'content' => $postData['message'],
                    'media_urls' => $postData['media_urls'],
                    'hashtags' => $postData['hashtags'],
                    'status' => 'scheduled',
                    'scheduled_for' => $scheduledTime,
                ]);

                $created[] = [
                    'id' => $post->id,
                    'products_count' => $products->count(),
                    'scheduled_for' => $scheduledTime->format('d/m/Y H:i'),
                ];

            } catch (\Exception $e) {
                Log::error('Erro ao criar carrossel', ['error' => $e->getMessage(), 'time' => $time]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Carrosséis criados com horários personalizados',
            'total_carousels' => count($created),
            'products_per_carousel' => $productsPerCarousel,
            'platform' => $platform,
            'carousels' => $created,
            'timestamp' => now()->toIso8601String()
        ]);
    }

    /**
     * Status geral - verificar posts agendados
     * 
     * GET /api/cron/status
     */
    public function status(Request $request)
    {
        // API pública - sem autenticação necessária

        $pending = AiAutoPost::where('status', 'scheduled')
            ->where('scheduled_for', '<=', now())
            ->count();

        $upcoming = AiAutoPost::where('status', 'scheduled')
            ->where('scheduled_for', '>', now())
            ->count();

        $nextScheduled = $this->getNextScheduled();

        return response()->json([
            'success' => true,
            'pending_posts' => $pending,
            'upcoming_posts' => $upcoming,
            'next_scheduled' => $nextScheduled,
            'should_trigger' => $pending > 0,
            'timestamp' => now()->toIso8601String()
        ]);
    }

    /**
     * Publicar um post
     */
    private function publishPost(AiAutoPost $post): array
    {
        try {
            if ($post->post_type === 'carousel') {
                $success = $this->socialMedia->publishCarousel($post);
            } else {
                $success = $this->socialMedia->publishPost($post);
            }

            if ($success) {
                return [
                    'success' => true,
                    'post_url' => $post->post_url
                ];
            }

            return [
                'success' => false,
                'error' => $post->error_message ?? 'Erro desconhecido'
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Obter próximo post agendado
     */
    private function getNextScheduled(): ?array
    {
        $next = AiAutoPost::where('status', 'scheduled')
            ->where('scheduled_for', '>', now())
            ->orderBy('scheduled_for', 'asc')
            ->first();

        if (!$next) {
            return null;
        }

        return [
            'id' => $next->id,
            'platform' => $next->platform,
            'type' => $next->post_type,
            'scheduled_for' => $next->scheduled_for->format('Y-m-d H:i:s'),
            'time_remaining' => $next->scheduled_for->diffForHumans()
        ];
    }
}

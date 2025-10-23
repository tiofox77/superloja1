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
     * GET/POST /api/cron/trigger-create-posts?platform=facebook&limit=3
     */
    public function triggerCreatePosts(Request $request)
    {
        // API pública - sem autenticação necessária

        try {
            $platform = $request->input('platform', 'facebook');
            $limit = $request->input('limit', 3);

            Log::channel('cron')->info('🌐 API Trigger - Criando posts', [
                'platform' => $platform,
                'limit' => $limit
            ]);

            Artisan::call('ai:auto-create-posts', [
                '--platform' => $platform,
                '--limit' => $limit
            ]);
            $output = Artisan::output();

            Log::channel('cron')->info('✅ API Trigger - Posts criados');

            return response()->json([
                'success' => true,
                'message' => 'Posts criados com sucesso',
                'platform' => $platform,
                'limit' => $limit,
                'output' => trim($output),
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
     * GET/POST /api/cron/trigger-create-carousels?platform=facebook&count=1&products=8
     */
    public function triggerCreateCarousels(Request $request)
    {
        // API pública - sem autenticação necessária

        try {
            $platform = $request->input('platform', 'facebook');
            $count = $request->input('count', 1);
            $products = $request->input('products', 8);

            Log::channel('cron')->info('🌐 API Trigger - Criando carrosséis', [
                'platform' => $platform,
                'count' => $count,
                'products' => $products
            ]);

            Artisan::call('ai:auto-create-carousels', [
                '--platform' => $platform,
                '--count' => $count,
                '--products' => $products
            ]);
            $output = Artisan::output();

            Log::channel('cron')->info('✅ API Trigger - Carrosséis criados');

            return response()->json([
                'success' => true,
                'message' => 'Carrosséis criados com sucesso',
                'platform' => $platform,
                'count' => $count,
                'products' => $products,
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

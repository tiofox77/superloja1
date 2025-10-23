<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SocialMediaAgentService;
use App\Models\AiProductInsight;
use App\Models\AiAutoPost;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class AutoCreateCarouselPosts extends Command
{
    protected $signature = 'ai:auto-create-carousel 
                            {--platform=facebook : Plataforma (facebook/instagram)}
                            {--products=10 : Número de produtos no carrossel}';

    protected $description = 'Criar posts de CARROSSEL com múltiplos produtos (até 10)';

    public function handle(SocialMediaAgentService $socialMedia): int
    {
        $platform = $this->option('platform');
        $productsCount = (int) $this->option('products');
        
        // Limitar entre 3 e 10 produtos
        $productsCount = max(3, min(10, $productsCount));

        $this->info('🎨 Iniciando criação de CARROSSEL de produtos...');
        $this->info("📦 {$productsCount} produtos por carrossel");
        $this->newLine();

        // 1. Buscar produtos HOT (alta performance)
        $hotProducts = AiProductInsight::with('product')
            ->hotProducts()
            ->whereHas('product', function($query) {
                $query->where('is_active', true)
                      ->whereNotNull('featured_image')
                      ->where('stock_quantity', '>', 0);
            })
            ->limit($productsCount * 2) // Buscar mais para ter opções
            ->get();

        if ($hotProducts->isEmpty()) {
            $this->warn('⚠️ Nenhum produto HOT encontrado. Usando produtos aleatórios...');
            
            // Fallback: usar produtos aleatórios
            $randomProducts = Product::where('is_active', true)
                ->whereNotNull('featured_image')
                ->where('stock_quantity', '>', 0)
                ->inRandomOrder()
                ->limit($productsCount)
                ->get();
            
            if ($randomProducts->isEmpty()) {
                $this->error('❌ Nenhum produto disponível para criar carrossel!');
                return self::FAILURE;
            }

            $products = $randomProducts;
        } else {
            $products = $hotProducts->pluck('product')->take($productsCount);
        }

        $this->info("✅ Selecionados {$products->count()} produtos");
        $this->newLine();

        try {
            // 2. Gerar conteúdo do carrossel com IA
            $postData = $socialMedia->generateCarouselPostContent($products, $platform);

            // 3. Verificar se já existe carrossel agendado para hoje
            $existingCarousel = AiAutoPost::where('platform', $platform)
                ->where('post_type', 'carousel')
                ->where('status', 'scheduled')
                ->whereDate('scheduled_for', today())
                ->first();

            if ($existingCarousel) {
                $this->warn('⚠️ Já existe um carrossel agendado para hoje nesta plataforma!');
                return self::SUCCESS;
            }

            // 4. Escolher horário estratégico (meio-dia = melhor engajamento para carrossel)
            $scheduledTime = now()->copy()->setTime(12, 0);
            if ($scheduledTime->isPast()) {
                $scheduledTime->addDay();
            }

            // 5. Criar post agendado
            $post = AiAutoPost::create([
                'platform' => $platform,
                'post_type' => 'carousel',
                'product_id' => null, // Não usa product_id individual
                'product_ids' => $products->pluck('id')->toArray(),
                'content' => $postData['message'],
                'media_urls' => $postData['media_urls'],
                'hashtags' => $postData['hashtags'],
                'status' => 'scheduled',
                'scheduled_for' => $scheduledTime,
            ]);

            $this->newLine();
            $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->info('✅ CARROSSEL CRIADO COM SUCESSO!');
            $this->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
            $this->newLine();

            $this->table(
                ['Informação', 'Valor'],
                [
                    ['Plataforma', ucfirst($platform)],
                    ['Total de Produtos', $products->count()],
                    ['Agendado Para', $scheduledTime->format('d/m/Y H:i')],
                    ['ID do Post', $post->id],
                ]
            );

            $this->newLine();
            $this->info('📦 Produtos no Carrossel:');
            foreach ($products as $index => $product) {
                $this->line("  " . ($index + 1) . ". {$product->name}");
            }

            Log::info('Carrossel de produtos criado automaticamente', [
                'post_id' => $post->id,
                'platform' => $platform,
                'products_count' => $products->count(),
                'product_ids' => $products->pluck('id')->toArray(),
            ]);

            return self::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Erro ao criar carrossel: {$e->getMessage()}");
            Log::error('Erro ao criar carrossel', [
                'error' => $e->getMessage(),
                'platform' => $platform,
            ]);
            return self::FAILURE;
        }
    }
}

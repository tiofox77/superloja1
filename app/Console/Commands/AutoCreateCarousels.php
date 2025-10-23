<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SocialMediaAgentService;
use App\Models\AiProductInsight;
use App\Models\AiAutoPost;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class AutoCreateCarousels extends Command
{
    protected $signature = 'ai:auto-create-carousels 
                            {--count=1 : Número de carrosséis a criar}
                            {--products=5 : Produtos por carrossel (3-10)}
                            {--platform=facebook : Plataforma (facebook/instagram)}';

    protected $description = 'Criar carrosséis automaticamente com produtos HOT';

    public function handle(SocialMediaAgentService $socialMedia): int
    {
        $count = (int) $this->option('count');
        $productsPerCarousel = (int) $this->option('products');
        $platform = $this->option('platform');

        // Validar quantidade de produtos
        if ($productsPerCarousel < 3 || $productsPerCarousel > 10) {
            $this->error('❌ Produtos por carrossel deve ser entre 3 e 10');
            return self::FAILURE;
        }

        $this->info('🎨 Iniciando criação automática de carrosséis...');
        $this->newLine();

        $created = 0;
        $table = [];

        for ($i = 0; $i < $count; $i++) {
            // Buscar produtos HOT diferentes para cada carrossel
            $hotProducts = AiProductInsight::with('product')
                ->hotProducts()
                ->whereHas('product', function($query) {
                    $query->where('is_active', true)
                          ->whereNotNull('featured_image')
                          ->where('stock_quantity', '>', 0);
                })
                ->inRandomOrder()
                ->limit($productsPerCarousel * 2) // Buscar mais para filtrar duplicados
                ->get()
                ->pluck('product')
                ->filter()
                ->unique('id')
                ->take($productsPerCarousel);

            // Fallback para produtos aleatórios se não tiver HOT suficientes
            if ($hotProducts->count() < $productsPerCarousel) {
                $this->warn("⚠️ Carrossel #" . ($i+1) . ": Poucos produtos HOT. Usando aleatórios...");
                
                $randomProducts = Product::where('is_active', true)
                    ->whereNotNull('featured_image')
                    ->where('stock_quantity', '>', 0)
                    ->inRandomOrder()
                    ->limit($productsPerCarousel)
                    ->get();
                
                if ($randomProducts->count() < $productsPerCarousel) {
                    $this->error("❌ Carrossel #" . ($i+1) . ": Produtos insuficientes");
                    continue;
                }
                
                $products = $randomProducts;
            } else {
                $products = $hotProducts;
            }

            // Verificar se já existe carrossel agendado com os mesmos produtos
            $productIds = $products->pluck('id')->sort()->toArray();
            $existingCarousel = AiAutoPost::where('post_type', 'carousel')
                ->where('platform', $platform)
                ->where('status', 'scheduled')
                ->where(function($query) use ($productIds) {
                    foreach ($productIds as $productId) {
                        $query->whereJsonContains('product_ids', $productId);
                    }
                })
                ->whereDate('scheduled_for', '>=', now())
                ->first();

            if ($existingCarousel) {
                $this->warn("⚠️ Carrossel #" . ($i+1) . ": Já existe carrossel agendado com produtos similares");
                continue;
            }

            // Gerar conteúdo do carrossel
            $postData = $socialMedia->generateCarouselPostContent($products, $platform);

            // Horários estratégicos para distribuir ao longo do dia
            $strategicHours = [9, 12, 15, 18, 21];
            $hour = $strategicHours[$created % count($strategicHours)];
            
            $scheduledTime = now()->setTime($hour, rand(0, 59));
            
            // Se horário já passou, agendar para próximo dia
            if ($scheduledTime->isPast()) {
                $scheduledTime->addDay();
            }

            // Criar carrossel
            $post = AiAutoPost::create([
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

            $table[] = [
                'ID' => $post->id,
                'Produtos' => $products->count(),
                'Plataforma' => ucfirst($platform),
                'Agendado' => $scheduledTime->format('d/m/Y H:i'),
            ];

            $created++;
        }

        if ($created > 0) {
            $this->newLine();
            $this->table(
                ['ID', 'Produtos', 'Plataforma', 'Agendado Para'],
                $table
            );

            $this->newLine();
            $this->info("✅ {$created} carrossel(is) criado(s) com sucesso!");
            
            Log::info('Carrosséis criados automaticamente', [
                'count' => $created,
                'platform' => $platform,
                'products_per_carousel' => $productsPerCarousel,
            ]);

            return self::SUCCESS;
        }

        $this->error('❌ Nenhum carrossel foi criado');
        return self::FAILURE;
    }
}

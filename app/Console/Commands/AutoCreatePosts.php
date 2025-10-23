<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SocialMediaAgentService;
use App\Models\AiProductInsight;
use App\Models\AiAutoPost;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class AutoCreatePosts extends Command
{
    protected $signature = 'ai:auto-create-posts 
                            {--limit=3 : Número de posts a criar}
                            {--platform=facebook : Plataforma (facebook/instagram)}';

    protected $description = 'Criar posts automaticamente baseado em produtos HOT';

    public function handle(SocialMediaAgentService $socialMedia): int
    {
        $limit = (int) $this->option('limit');
        $platform = $this->option('platform');

        $this->info('🤖 Iniciando criação automática de posts...');
        $this->newLine();

        // 1. Buscar produtos HOT (alta performance)
        $hotProducts = AiProductInsight::with('product')
            ->hotProducts()
            ->whereHas('product', function($query) {
                $query->where('is_active', true)
                      ->whereNotNull('featured_image');
            })
            ->limit($limit * 2) // Buscar mais para ter opções
            ->get();

        if ($hotProducts->isEmpty()) {
            $this->warn('⚠️ Nenhum produto HOT encontrado. Usando produtos aleatórios...');
            
            // Fallback: usar produtos aleatórios
            $randomProducts = Product::where('is_active', true)
                ->whereNotNull('featured_image')
                ->inRandomOrder()
                ->limit($limit)
                ->get();
            
            if ($randomProducts->isEmpty()) {
                $this->error('❌ Nenhum produto disponível para criar posts!');
                return self::FAILURE;
            }

            $products = $randomProducts;
        } else {
            $products = $hotProducts->pluck('product')->take($limit);
        }

        // 2. Horários estratégicos para publicação
        $strategicTimes = $this->getStrategicTimes();

        // 3. Criar posts para cada produto
        $created = 0;
        $createdPostIds = [];
        $skipped = 0;
        $errors = 0;
        $bar = $this->output->createProgressBar($products->count());

        foreach ($products as $index => $product) {
            try {
                // Gerar conteúdo com IA
                $postData = $socialMedia->generateProductPostContent($product, $platform);

                // Escolher horário (distribuir ao longo do dia)
                $scheduledTime = $strategicTimes[$index % count($strategicTimes)];

                // Ajustar para próximo dia se horário já passou
                if ($scheduledTime->isPast()) {
                    $scheduledTime->addDay();
                }

                // Verificar se já existe post agendado para este produto hoje/futuro
                $existingPost = AiAutoPost::where('product_id', $product->id)
                    ->where('platform', $platform)
                    ->where('status', 'scheduled')
                    ->where('scheduled_for', '>=', now())
                    ->first();

                if ($existingPost) {
                    $this->warn("  ⚠️ Post já agendado para: {$product->name}");
                    $skipped++;
                    $bar->advance();
                    continue;
                }

                // Criar post agendado
                $post = AiAutoPost::create([
                    'platform' => $platform,
                    'post_type' => 'product',
                    'product_id' => $product->id,
                    'content' => $postData['message'],
                    'media_urls' => $postData['media_urls'],
                    'hashtags' => $postData['hashtags'],
                    'status' => 'scheduled',
                    'scheduled_for' => $scheduledTime,
                ]);

                $createdPostIds[] = $post->id;
                $created++;
                $bar->advance();

            } catch (\Exception $e) {
                $this->error("  ❌ Erro ao criar post para {$product->name}: {$e->getMessage()}");
                $errors++;
                $bar->advance();
            }
        }

        $bar->finish();
        $this->newLine(2);

        // 4. Resumo detalhado
        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->info("📊 RESUMO DA EXECUÇÃO:");
        $this->info("━━━━━━━━━━━━━━━━━━━━━━━━━━━━");
        $this->info("✅ Posts criados: {$created}");
        
        if ($skipped > 0) {
            $this->warn("⏭️  Posts pulados (já agendados): {$skipped}");
        }
        
        if ($errors > 0) {
            $this->error("❌ Erros encontrados: {$errors}");
        }
        
        $this->newLine();

        // Mostrar APENAS os posts recém-criados
        if ($created > 0) {
            $this->table(
                ['Produto', 'Plataforma', 'Agendado Para'],
                AiAutoPost::with('product')
                    ->whereIn('id', $createdPostIds)
                    ->orderBy('scheduled_for')
                    ->get()
                    ->map(fn($post) => [
                        $post->product->name,
                        ucfirst($post->platform),
                        $post->scheduled_for->format('d/m/Y H:i'),
                    ])
            );
            
            \Log::info('Posts criados automaticamente', [
                'total' => $created,
                'platform' => $platform,
                'post_ids' => $createdPostIds,
            ]);
        } else {
            $this->warn('⚠️ Nenhum post foi criado nesta execução.');
            
            if ($skipped > 0) {
                $this->info('💡 Motivo: Todos os produtos selecionados já têm posts agendados.');
            } elseif ($errors > 0) {
                $this->error('💡 Motivo: Ocorreram erros ao tentar criar os posts.');
            } else {
                $this->warn('💡 Motivo: Nenhum produto disponível para criação de posts.');
            }
            
            \Log::warning('Nenhum post criado automaticamente', [
                'skipped' => $skipped,
                'errors' => $errors,
                'platform' => $platform,
            ]);
        }

        return self::SUCCESS;
    }

    /**
     * Horários estratégicos para publicação
     */
    private function getStrategicTimes(): array
    {
        $today = now();
        
        return [
            // Manhã (pico: 9h-11h)
            $today->copy()->setTime(9, 30),
            $today->copy()->setTime(10, 15),
            
            // Almoço (pico: 12h-13h)
            $today->copy()->setTime(12, 30),
            
            // Tarde (pico: 14h-16h)
            $today->copy()->setTime(14, 0),
            $today->copy()->setTime(15, 30),
            
            // Final de tarde (pico: 17h-19h)
            $today->copy()->setTime(17, 30),
            $today->copy()->setTime(18, 30),
            
            // Noite (pico: 20h-21h)
            $today->copy()->setTime(20, 0),
            $today->copy()->setTime(21, 0),
        ];
    }
}


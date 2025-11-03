<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Models\AiProductInsight;
use App\Models\AiAgentConfig;
use App\Models\AiAgentAction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class AiAgentService
{
    private ?AiAgentConfig $config;

    public function __construct()
    {
        $this->config = AiAgentConfig::getActive();
    }

    /**
     * Analisar todos os produtos e gerar insights
     */
    public function analyzeAllProducts(?Carbon $date = null): Collection
    {
        $date = $date ?? now();
        $insights = collect();

        Product::active()
            ->with(['category', 'brand'])
            ->chunk(50, function ($products) use ($date, &$insights) {
                foreach ($products as $product) {
                    $insight = $this->analyzeProduct($product, $date);
                    $insights->push($insight);
                }
            });

        return $insights;
    }

    /**
     * Analisar produto individual
     */
    public function analyzeProduct(Product $product, ?Carbon $date = null): AiProductInsight
    {
        $date = $date ?? now();

        // Buscar dados de vendas
        $salesData = $this->getProductSalesData($product->id);
        
        // Calcular métricas
        $totalSales = (int) $salesData['total_sales'];
        $totalRevenue = (float) $salesData['total_revenue'];
        $totalViews = (int) ($product->view_count ?? 0);
        
        $conversionRate = $totalViews > 0 
            ? round(($totalSales / $totalViews) * 100, 2) 
            : 0.0;

        // Determinar status de performance
        $performanceStatus = $this->calculatePerformanceStatus(
            $totalSales,
            $totalRevenue,
            (float) $conversionRate
        );

        // Gerar recomendações da IA
        $aiRecommendations = $this->generateProductRecommendations(
            $product,
            $performanceStatus,
            $salesData
        );

        // Criar ou atualizar insight
        return AiProductInsight::updateOrCreate(
            [
                'product_id' => $product->id,
                'analysis_date' => $date->toDateString(),
            ],
            [
                'total_views' => $totalViews,
                'total_sales' => $totalSales,
                'total_revenue' => $totalRevenue,
                'conversion_rate' => $conversionRate,
                'avg_rating' => $product->rating_average ?? 0,
                'performance_status' => $performanceStatus,
                'ai_recommendations' => $aiRecommendations,
            ]
        );
    }

    /**
     * Obter dados de vendas do produto
     */
    private function getProductSalesData(int $productId): array
    {
        $last30Days = now()->subDays(30);

        $data = OrderItem::join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('order_items.product_id', $productId)
            ->where('orders.created_at', '>=', $last30Days)
            ->whereIn('orders.status', ['confirmed', 'shipped', 'delivered'])
            ->selectRaw('
                COUNT(*) as total_sales,
                SUM(order_items.total_price) as total_revenue,
                AVG(order_items.unit_price) as avg_price
            ')
            ->first();

        return [
            'total_sales' => (int) ($data->total_sales ?? 0),
            'total_revenue' => (float) ($data->total_revenue ?? 0),
            'avg_price' => (float) ($data->avg_price ?? 0),
        ];
    }

    /**
     * Calcular status de performance
     */
    private function calculatePerformanceStatus(int $sales, float $revenue, float $conversionRate): string
    {
        // Critérios para "hot" (produto quente)
        if ($sales >= 10 && $conversionRate >= 5) {
            return 'hot';
        }

        // Critérios para "cold" (produto frio)
        if ($sales <= 2 && $conversionRate < 1) {
            return 'cold';
        }

        // Critérios para "declining" (em declínio)
        if ($sales > 2 && $sales < 10 && $conversionRate < 2) {
            return 'declining';
        }

        // Padrão: steady (estável)
        return 'steady';
    }

    /**
     * Gerar recomendações inteligentes para o produto
     */
    private function generateProductRecommendations(
        Product $product,
        string $performanceStatus,
        array $salesData
    ): array {
        $recommendations = [];

        // Recomendações baseadas em performance
        switch ($performanceStatus) {
            case 'hot':
                $recommendations[] = [
                    'type' => 'success',
                    'action' => 'highlight',
                    'message' => 'Produto em alta! Considere aumentar o estoque.',
                    'priority' => 'high',
                ];
                
                if ($product->stock_quantity < 10) {
                    $recommendations[] = [
                        'type' => 'warning',
                        'action' => 'restock',
                        'message' => 'Estoque baixo para produto popular. Reabastecer urgentemente.',
                        'priority' => 'high',
                    ];
                }

                $recommendations[] = [
                    'type' => 'success',
                    'action' => 'promote',
                    'message' => 'Promover nas redes sociais para maximizar vendas.',
                    'priority' => 'medium',
                ];
                break;

            case 'cold':
                $recommendations[] = [
                    'type' => 'warning',
                    'action' => 'price_reduction',
                    'message' => 'Produto com baixas vendas. Considere promoção ou desconto.',
                    'priority' => 'medium',
                ];

                $recommendations[] = [
                    'type' => 'info',
                    'action' => 'improve_description',
                    'message' => 'Melhorar descrição e imagens do produto.',
                    'priority' => 'medium',
                ];

                $recommendations[] = [
                    'type' => 'info',
                    'action' => 'bundle',
                    'message' => 'Criar combo/bundle com produtos relacionados.',
                    'priority' => 'low',
                ];
                break;

            case 'declining':
                $recommendations[] = [
                    'type' => 'warning',
                    'action' => 'investigate',
                    'message' => 'Produto em declínio. Investigar causas (preço, qualidade, concorrência).',
                    'priority' => 'high',
                ];

                $recommendations[] = [
                    'type' => 'info',
                    'action' => 'refresh',
                    'message' => 'Renovar apresentação do produto (fotos, descrição).',
                    'priority' => 'medium',
                ];
                break;

            case 'steady':
                $recommendations[] = [
                    'type' => 'success',
                    'action' => 'maintain',
                    'message' => 'Produto com performance estável. Manter estratégia atual.',
                    'priority' => 'low',
                ];
                break;
        }

        // Recomendações específicas por categoria
        $categoryRecommendations = $this->getCategorySpecificRecommendations($product);
        $recommendations = array_merge($recommendations, $categoryRecommendations);

        return $recommendations;
    }

    /**
     * Recomendações específicas por categoria
     */
    private function getCategorySpecificRecommendations(Product $product): array
    {
        $recommendations = [];
        $categoryName = strtolower($product->category->name ?? '');

        // Tecnologia
        if (str_contains($categoryName, 'tecnologia') || 
            str_contains($categoryName, 'eletrônico') ||
            str_contains($categoryName, 'celular') ||
            str_contains($categoryName, 'computador')) {
            
            $recommendations[] = [
                'type' => 'info',
                'action' => 'specs_highlight',
                'message' => 'Destacar especificações técnicas e comparações.',
                'priority' => 'medium',
                'category_specific' => true,
            ];

            $recommendations[] = [
                'type' => 'info',
                'action' => 'tech_content',
                'message' => 'Criar conteúdo educativo sobre o uso do produto.',
                'priority' => 'low',
                'category_specific' => true,
            ];
        }

        // Saúde e Bem-estar
        if (str_contains($categoryName, 'saúde') || 
            str_contains($categoryName, 'bem-estar') ||
            str_contains($categoryName, 'farmácia')) {
            
            $recommendations[] = [
                'type' => 'info',
                'action' => 'health_benefits',
                'message' => 'Destacar benefícios para saúde e certificações.',
                'priority' => 'high',
                'category_specific' => true,
            ];

            $recommendations[] = [
                'type' => 'info',
                'action' => 'trust_building',
                'message' => 'Adicionar depoimentos e garantias de qualidade.',
                'priority' => 'medium',
                'category_specific' => true,
            ];
        }

        // Limpeza
        if (str_contains($categoryName, 'limpeza') || 
            str_contains($categoryName, 'higiene')) {
            
            $recommendations[] = [
                'type' => 'info',
                'action' => 'usage_tips',
                'message' => 'Compartilhar dicas de uso e benefícios práticos.',
                'priority' => 'medium',
                'category_specific' => true,
            ];

            $recommendations[] = [
                'type' => 'info',
                'action' => 'eco_friendly',
                'message' => 'Se aplicável, destacar aspectos ecológicos.',
                'priority' => 'low',
                'category_specific' => true,
            ];
        }

        return $recommendations;
    }

    /**
     * Obter produtos mais vendidos
     */
    public function getTopSellingProducts(int $limit = 10, ?int $days = 30): Collection
    {
        $startDate = $days ? now()->subDays($days) : null;

        $query = AiProductInsight::with('product')
            ->orderByDesc('total_sales')
            ->orderByDesc('total_revenue');

        if ($startDate) {
            $query->where('analysis_date', '>=', $startDate);
        }

        return $query->limit($limit)->get();
    }

    /**
     * Obter produtos com baixo desempenho
     */
    public function getLowPerformingProducts(int $limit = 10): Collection
    {
        return AiProductInsight::with('product')
            ->coldProducts()
            ->limit($limit)
            ->get();
    }

    /**
     * Obter produtos em alta (trending)
     */
    public function getTrendingProducts(int $limit = 10): Collection
    {
        return AiProductInsight::with('product')
            ->hotProducts()
            ->limit($limit)
            ->get();
    }

    /**
     * Sugerir produtos alternativos
     */
    public function suggestAlternatives(Product $product, int $limit = 5): Collection
    {
        // Buscar produtos da mesma categoria com melhor performance
        return Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->whereHas('insights', function ($query) {
                $query->whereIn('performance_status', ['hot', 'steady']);
            })
            ->inStock()
            ->limit($limit)
            ->get();
    }

    /**
     * Gerar relatório de performance geral
     */
    public function generatePerformanceReport(?Carbon $date = null): array
    {
        $date = $date ?? now();

        $insights = AiProductInsight::where('analysis_date', $date->toDateString())->get();

        return [
            'date' => $date->toDateString(),
            'total_products_analyzed' => $insights->count(),
            'hot_products' => $insights->where('performance_status', 'hot')->count(),
            'cold_products' => $insights->where('performance_status', 'cold')->count(),
            'steady_products' => $insights->where('performance_status', 'steady')->count(),
            'declining_products' => $insights->where('performance_status', 'declining')->count(),
            'total_revenue' => $insights->sum('total_revenue'),
            'total_sales' => $insights->sum('total_sales'),
            'avg_conversion_rate' => $insights->avg('conversion_rate'),
            'top_performers' => $insights->where('performance_status', 'hot')
                ->sortByDesc('total_revenue')
                ->take(5)
                ->values(),
            'needs_attention' => $insights->whereIn('performance_status', ['cold', 'declining'])
                ->sortBy('total_sales')
                ->take(5)
                ->values(),
        ];
    }

    /**
     * Registrar ação do agente
     */
    public function logAction(
        string $actionType,
        string $description,
        ?array $context = null,
        bool $requiresApproval = false
    ): AiAgentAction {
        return AiAgentAction::create([
            'action_type' => $actionType,
            'description' => $description,
            'context' => $context,
            'status' => $requiresApproval ? 'pending' : 'executed',
            'requires_approval' => $requiresApproval,
        ]);
    }

    /**
     * Verificar se o agente está ativo
     */
    public function isActive(): bool
    {
        return $this->config && $this->config->is_active;
    }

    /**
     * Obter estatísticas do agente
     */
    public function getAgentStats(): array
    {
        return [
            'total_conversations' => DB::table('ai_conversations')->count(),
            'active_conversations' => DB::table('ai_conversations')->where('status', 'active')->count(),
            'total_messages' => DB::table('ai_messages')->count(),
            'insights_generated' => DB::table('ai_product_insights')->count(),
            'posts_published' => DB::table('ai_auto_posts')->where('status', 'posted')->count(),
            'actions_pending_approval' => DB::table('ai_agent_actions')
                ->where('requires_approval', true)
                ->whereNull('approved_at')
                ->count(),
        ];
    }
}

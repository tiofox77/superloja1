<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\AiAgentService;

class AnalyzeProducts extends Command
{
    protected $signature = 'ai:analyze-products 
                            {--date= : Data para análise (formato: Y-m-d)}
                            {--product= : ID de produto específico}';

    protected $description = 'Analisar produtos e gerar insights usando AI Agent';

    public function handle(AiAgentService $aiAgent): int
    {
        if (!$aiAgent->isActive()) {
            $this->error('❌ AI Agent não está ativo!');
            return self::FAILURE;
        }

        $this->info('🤖 Iniciando análise de produtos...');

        $date = $this->option('date') 
            ? \Carbon\Carbon::parse($this->option('date'))
            : now();

        $productId = $this->option('product');

        if ($productId) {
            // Analisar produto específico
            $product = \App\Models\Product::find($productId);
            
            if (!$product) {
                $this->error("Produto #{$productId} não encontrado!");
                return self::FAILURE;
            }

            $this->info("Analisando produto: {$product->name}");
            $insight = $aiAgent->analyzeProduct($product, $date);
            
            $this->displayInsight($insight);
        } else {
            // Analisar todos os produtos
            $bar = $this->output->createProgressBar();
            $bar->start();

            $insights = $aiAgent->analyzeAllProducts($date);
            
            $bar->finish();
            $this->newLine(2);

            $this->info("✅ Análise concluída!");
            $this->info("📊 Total de produtos analisados: " . $insights->count());
            
            // Resumo
            $this->displaySummary($insights);
        }

        return self::SUCCESS;
    }

    private function displayInsight($insight): void
    {
        $this->newLine();
        $this->info("📊 Insights do Produto");
        $this->table(
            ['Métrica', 'Valor'],
            [
                ['Vendas Totais', $insight->total_sales],
                ['Receita Total', number_format((float)$insight->total_revenue, 2) . ' Kz'],
                ['Taxa de Conversão', $insight->conversion_rate . '%'],
                ['Status', $insight->performance_status],
            ]
        );

        if ($insight->ai_recommendations) {
            $this->newLine();
            $this->info("💡 Recomendações:");
            foreach ($insight->ai_recommendations as $rec) {
                $icon = match($rec['type']) {
                    'success' => '✅',
                    'warning' => '⚠️',
                    'info' => 'ℹ️',
                    default => '📌',
                };
                $this->line("  {$icon} [{$rec['priority']}] {$rec['message']}");
            }
        }
    }

    private function displaySummary($insights): void
    {
        $hot = $insights->where('performance_status', 'hot')->count();
        $cold = $insights->where('performance_status', 'cold')->count();
        $steady = $insights->where('performance_status', 'steady')->count();
        $declining = $insights->where('performance_status', 'declining')->count();

        $this->newLine();
        $this->table(
            ['Status', 'Quantidade'],
            [
                ['🔥 Hot (Alta Performance)', $hot],
                ['❄️ Cold (Baixa Performance)', $cold],
                ['📊 Steady (Estável)', $steady],
                ['📉 Declining (Em Declínio)', $declining],
            ]
        );

        $totalRevenue = $insights->sum('total_revenue');
        $totalSales = $insights->sum('total_sales');
        
        $this->newLine();
        $this->info("💰 Receita Total: " . number_format((float)$totalRevenue, 2) . " Kz");
        $this->info("📦 Vendas Totais: {$totalSales}");
    }
}

<?php

declare(strict_types=1);

namespace App\Livewire\Admin\AiAgent;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AiProductInsight;
use App\Models\Product;
use App\Services\AiAgentService;

class ProductInsights extends Component
{
    use WithPagination;

    public $filterStatus = '';
    public $searchTerm = '';
    public $selectedInsight;
    public $showDetailModal = false;

    public function viewDetails($insightId)
    {
        $this->selectedInsight = AiProductInsight::with('product')->find($insightId);
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedInsight = null;
    }

    public function refreshAnalysis($productId)
    {
        try {
            $product = Product::find($productId);
            $aiAgent = app(AiAgentService::class);
            
            $aiAgent->analyzeProduct($product);
            
            session()->flash('message', "Análise atualizada para {$product->name}");
            $this->closeDetailModal();
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao atualizar análise: ' . $e->getMessage());
        }
    }

    public function render()
    {
        $insights = AiProductInsight::with('product')
            ->when($this->filterStatus, fn($q) => $q->where('performance_status', $this->filterStatus))
            ->when($this->searchTerm, function($q) {
                $q->whereHas('product', function($query) {
                    $query->where('name', 'like', '%' . $this->searchTerm . '%');
                });
            })
            ->orderByDesc('analysis_date')
            ->orderByDesc('total_revenue')
            ->paginate(20);

        // Estatísticas gerais
        $stats = [
            'total' => AiProductInsight::count(),
            'hot' => AiProductInsight::where('performance_status', 'hot')->count(),
            'cold' => AiProductInsight::where('performance_status', 'cold')->count(),
            'steady' => AiProductInsight::where('performance_status', 'steady')->count(),
            'declining' => AiProductInsight::where('performance_status', 'declining')->count(),
        ];

        return view('livewire.admin.ai-agent.product-insights', [
            'insights' => $insights,
            'stats' => $stats,
        ])->layout('components.layouts.admin', [
            'title' => 'Insights de Produtos',
            'pageTitle' => 'AI Agent - Insights'
        ]);
    }
}

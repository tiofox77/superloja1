<?php

declare(strict_types=1);

namespace App\Livewire\Admin\AiAgent;

use Livewire\Component;
use App\Services\AiAgentService;
use App\Models\AiAgentConfig;
use App\Models\AiConversation;
use App\Models\AiAutoPost;
use App\Models\AiProductInsight;

class AgentDashboard extends Component
{
    public $stats = [];
    public $config;
    public $topProducts = [];
    public $coldProducts = [];
    public $recentConversations = [];
    public $scheduledPosts = [];

    public function mount(AiAgentService $aiAgent)
    {
        $this->config = AiAgentConfig::getActive() ?? new AiAgentConfig();
        $this->stats = $aiAgent->getAgentStats();
        $this->loadData();
    }

    public function loadData()
    {
        // Top 5 produtos
        $this->topProducts = AiProductInsight::with('product')
            ->hotProducts()
            ->limit(5)
            ->get();

        // Produtos que precisam atenção
        $this->coldProducts = AiProductInsight::with('product')
            ->coldProducts()
            ->limit(5)
            ->get();

        // Conversas recentes
        $this->recentConversations = AiConversation::with('latestMessage')
            ->active()
            ->latest('last_message_at')
            ->limit(10)
            ->get();

        // Posts agendados
        $this->scheduledPosts = AiAutoPost::with('product')
            ->scheduled()
            ->orderBy('scheduled_for')
            ->limit(5)
            ->get();
    }

    public function toggleAgent()
    {
        if ($this->config->exists) {
            $this->config->update([
                'is_active' => !$this->config->is_active
            ]);
            
            $message = $this->config->is_active 
                ? 'AI Agent ativado com sucesso!' 
                : 'AI Agent desativado.';
                
            session()->flash('message', $message);
            $this->config = $this->config->fresh();
        }
    }

    public function runAnalysis()
    {
        try {
            $aiAgent = app(AiAgentService::class);
            $aiAgent->analyzeAllProducts();
            
            session()->flash('message', 'Análise de produtos executada com sucesso!');
            $this->loadData();
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao executar análise: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.ai-agent.agent-dashboard')
            ->layout('components.layouts.admin', [
                'title' => 'AI Agent Dashboard',
                'pageTitle' => 'AI Agent'
            ]);
    }
}

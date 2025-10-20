<?php

declare(strict_types=1);

namespace App\Livewire\Admin\AiAgent;

use Livewire\Component;
use App\Models\AiKnowledgeBase;
use App\Models\AiCustomerContext;
use App\Models\AiConversation;
use App\Models\AiMessage;
use Illuminate\Support\Facades\DB;

class KnowledgeCenter extends Component
{
    public $stats = [];
    public $knowledgeItems = [];
    public $topCustomers = [];
    public $recentLearnings = [];
    public $sentimentTrends = [];
    
    // Modal de novo conhecimento
    public $showKnowledgeModal = false;
    public $category = 'faq';
    public $question = '';
    public $answer = '';
    public $keywords = '';

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        // Estatísticas gerais
        $this->stats = [
            'total_knowledge' => AiKnowledgeBase::active()->count(),
            'total_customers' => AiCustomerContext::count(),
            'vip_customers' => AiCustomerContext::where('customer_segment', 'vip')->count(),
            'total_conversations' => AiConversation::count(),
            'avg_success_rate' => AiKnowledgeBase::active()->avg('success_rate') ?? 0,
        ];

        // Top conhecimento mais usado
        $this->knowledgeItems = AiKnowledgeBase::active()
            ->popular()
            ->limit(10)
            ->get();

        // Top clientes
        $this->topCustomers = AiCustomerContext::orderByDesc('total_spent')
            ->limit(10)
            ->get();

        // Análise de sentimento (últimos 7 dias)
        $this->sentimentTrends = $this->getSentimentTrends();
    }

    public function getSentimentTrends()
    {
        $conversations = AiConversation::with('messages')
            ->where('created_at', '>=', now()->subDays(7))
            ->get();

        $positive = 0;
        $negative = 0;
        $neutral = 0;

        foreach ($conversations as $conversation) {
            foreach ($conversation->messages as $message) {
                if ($message->direction === 'incoming') {
                    $sentiment = $this->quickSentiment($message->message);
                    if ($sentiment === 'positive') $positive++;
                    elseif ($sentiment === 'negative') $negative++;
                    else $neutral++;
                }
            }
        }

        $total = $positive + $negative + $neutral;
        
        return [
            'positive' => $total > 0 ? round(($positive / $total) * 100, 1) : 0,
            'negative' => $total > 0 ? round(($negative / $total) * 100, 1) : 0,
            'neutral' => $total > 0 ? round(($neutral / $total) * 100, 1) : 0,
        ];
    }

    private function quickSentiment(string $message): string
    {
        $message = strtolower($message);
        $positive = ['obrigado', 'ótimo', 'excelente', 'adorei', 'perfeito'];
        $negative = ['problema', 'ruim', 'péssimo', 'errado', 'defeito'];

        foreach ($positive as $word) {
            if (str_contains($message, $word)) return 'positive';
        }

        foreach ($negative as $word) {
            if (str_contains($message, $word)) return 'negative';
        }

        return 'neutral';
    }

    public function openKnowledgeModal()
    {
        $this->showKnowledgeModal = true;
    }

    public function closeKnowledgeModal()
    {
        $this->showKnowledgeModal = false;
        $this->reset(['category', 'question', 'answer', 'keywords']);
    }

    public function saveKnowledge()
    {
        $this->validate([
            'category' => 'required|string',
            'question' => 'required|string|min:10',
            'answer' => 'required|string|min:10',
            'keywords' => 'nullable|string',
        ]);

        AiKnowledgeBase::create([
            'category' => $this->category,
            'question' => $this->question,
            'answer' => $this->answer,
            'keywords' => $this->keywords ? explode(',', $this->keywords) : [],
            'is_active' => true,
        ]);

        session()->flash('message', 'Conhecimento adicionado com sucesso!');
        
        $this->closeKnowledgeModal();
        $this->loadData();
    }

    public function toggleKnowledge($id)
    {
        $knowledge = AiKnowledgeBase::find($id);
        if ($knowledge) {
            $knowledge->update(['is_active' => !$knowledge->is_active]);
            $this->loadData();
        }
    }

    public function deleteKnowledge($id)
    {
        AiKnowledgeBase::destroy($id);
        session()->flash('message', 'Conhecimento removido!');
        $this->loadData();
    }

    public function render()
    {
        return view('livewire.admin.ai-agent.knowledge-center')
            ->layout('components.layouts.admin', [
                'title' => 'Centro de Conhecimento AI',
                'pageTitle' => 'AI Agent - Conhecimento'
            ]);
    }
}

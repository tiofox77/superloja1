<?php

declare(strict_types=1);

namespace App\Livewire\Admin\AiAgent;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AiConversation;
use App\Models\AiMessage;
use App\Services\SocialMediaAgentService;

class ConversationManager extends Component
{
    use WithPagination;

    public $selectedConversation;
    public $messages = [];
    public $newMessage = '';
    public $filterPlatform = '';
    public $filterStatus = 'active';

    public function mount()
    {
        //
    }

    public function selectConversation($conversationId)
    {
        $this->selectedConversation = AiConversation::with('messages')->find($conversationId);
        $this->messages = $this->selectedConversation->messages()->orderBy('created_at')->get();
        
        // Marcar mensagens como lidas
        $this->selectedConversation->messages()
            ->where('direction', 'incoming')
            ->where('is_read', false)
            ->update(['is_read' => true]);
    }

    public function sendMessage()
    {
        $this->validate([
            'newMessage' => 'required|min:1',
        ]);

        if (!$this->selectedConversation) {
            return;
        }

        $socialMediaAgent = app(SocialMediaAgentService::class);
        
        // Enviar mensagem
        $sent = false;
        if ($this->selectedConversation->platform === 'facebook') {
            $sent = $socialMediaAgent->sendMessengerMessage(
                $this->selectedConversation->external_id,
                $this->newMessage
            );
        } elseif ($this->selectedConversation->platform === 'instagram') {
            $sent = $socialMediaAgent->sendInstagramMessage(
                $this->selectedConversation->external_id,
                $this->newMessage
            );
        }

        if ($sent) {
            // Salvar mensagem no banco
            $this->selectedConversation->addMessage(
                $this->newMessage,
                'outgoing',
                'human'
            );

            $this->messages = $this->selectedConversation->messages()->orderBy('created_at')->get();
            $this->newMessage = '';
            
            session()->flash('message', 'Mensagem enviada!');
        } else {
            session()->flash('error', 'Erro ao enviar mensagem.');
        }
    }

    public function closeConversation()
    {
        if ($this->selectedConversation) {
            $this->selectedConversation->update(['status' => 'closed']);
            $this->selectedConversation = null;
            $this->messages = [];
            
            session()->flash('message', 'Conversa fechada.');
        }
    }

    public function render()
    {
        $conversations = AiConversation::with('latestMessage')
            ->when($this->filterPlatform, fn($q) => $q->where('platform', $this->filterPlatform))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->orderByDesc('last_message_at')
            ->paginate(20);

        return view('livewire.admin.ai-agent.conversation-manager', [
            'conversations' => $conversations,
        ])->layout('components.layouts.admin', [
            'title' => 'Conversão AI Agent',
            'pageTitle' => 'AI Agent - Conversas'
        ]);
    }
}

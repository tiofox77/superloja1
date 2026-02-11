<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Sms;

use App\Models\SmsTemplate;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;

#[Layout('components.admin.layouts.app')]
#[Title('SMS')]
class SmsSpa extends Component
{
    use WithPagination;
    
    #[Url]
    public string $search = '';
    
    #[Url]
    public string $activeTab = 'templates'; // templates, logs
    
    public int $perPage = 15;
    
    // Template Modal
    public bool $showModal = false;
    public ?int $editingId = null;
    public string $name = '';
    public string $type = 'promotional';
    public string $messageText = '';
    public bool $is_active = true;
    
    public function updatingSearch(): void
    {
        $this->resetPage('templatesPage');
        $this->resetPage('logsPage');
    }
    
    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetPage('templatesPage');
        $this->resetPage('logsPage');
    }
    
    public function openCreateModal(): void
    {
        $this->reset(['editingId', 'name', 'type', 'messageText', 'is_active']);
        $this->is_active = true;
        $this->showModal = true;
    }
    
    public function editTemplate(int $id): void
    {
        $template = SmsTemplate::find($id);
        if ($template) {
            $this->editingId = $template->id;
            $this->name = $template->name;
            $this->type = $template->type;
            $this->messageText = $template->message;
            $this->is_active = $template->is_active;
            $this->showModal = true;
        }
    }
    
    public function saveTemplate(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
            'messageText' => 'required|string|max:500',
        ]);
        
        $data = [
            'name' => $this->name,
            'type' => $this->type,
            'message' => $this->messageText,
            'is_active' => $this->is_active,
        ];
        
        if ($this->editingId) {
            SmsTemplate::find($this->editingId)->update($data);
            $message = 'Template atualizado!';
        } else {
            SmsTemplate::create($data);
            $message = 'Template criado!';
        }
        
        $this->showModal = false;
        $this->dispatch('toast', ['type' => 'success', 'message' => $message]);
    }
    
    public function toggleStatus(int $id): void
    {
        $template = SmsTemplate::find($id);
        if ($template) {
            $template->update(['is_active' => !$template->is_active]);
            $this->dispatch('toast', ['type' => 'success', 'message' => 'Status atualizado!']);
        }
    }
    
    public function deleteTemplate(int $id): void
    {
        SmsTemplate::find($id)?->delete();
        $this->dispatch('toast', ['type' => 'success', 'message' => 'Template excluído!']);
    }
    
    // Test SMS Modal
    public bool $showTestModal = false;
    public string $testPhone = '';
    public string $testMessage = '';
    
    public function openTestModal(): void
    {
        $this->reset(['testPhone', 'testMessage']);
        $this->testMessage = 'Teste de SMS do sistema SuperLoja! 🚀';
        $this->showTestModal = true;
    }
    
    public function testSms(): void
    {
        $this->validate([
            'testPhone' => 'required|string|min:9',
            'testMessage' => 'required|string|max:160',
        ]);
        
        try {
            $smsService = app(\App\Services\SmsService::class);
            $result = $smsService->sendSms($this->testPhone, $this->testMessage);
            
            $this->showTestModal = false;
            $this->dispatch('toast', [
                'type' => 'success', 
                'message' => 'SMS enviado com sucesso!'
            ]);
        } catch (\Exception $e) {
            $this->dispatch('toast', [
                'type' => 'error', 
                'message' => 'Erro ao enviar SMS: ' . $e->getMessage()
            ]);
        }
    }
    
    public function render()
    {
        $templates = SmsTemplate::query()
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('message', 'like', "%{$this->search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage, ['*'], 'templatesPage');
        
        $logs = \App\Models\SmsLog::query()
            ->with(['user', 'template'])
            ->when($this->search, fn($q) => $q->where('phone', 'like', "%{$this->search}%")
                ->orWhere('message', 'like', "%{$this->search}%"))
            ->orderBy('created_at', 'desc')
            ->paginate($this->perPage, ['*'], 'logsPage');
        
        $stats = [
            'total' => SmsTemplate::count(),
            'active' => SmsTemplate::where('is_active', true)->count(),
            'promotional' => SmsTemplate::where('type', 'promotional')->count(),
            'transactional' => SmsTemplate::where('type', 'transactional')->count(),
        ];
        
        $logStats = [
            'total' => \App\Models\SmsLog::count(),
            'sent' => \App\Models\SmsLog::where('status', 'sent')->count(),
            'failed' => \App\Models\SmsLog::where('status', 'failed')->count(),
            'today' => \App\Models\SmsLog::whereDate('created_at', today())->count(),
        ];
        
        $totalCustomers = User::whereNotNull('phone')->count();
        
        return view('livewire.admin.sms.index-spa', [
            'templates' => $templates,
            'logs' => $logs,
            'stats' => $stats,
            'logStats' => $logStats,
            'totalCustomers' => $totalCustomers,
        ]);
    }
}

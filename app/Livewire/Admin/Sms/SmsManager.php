<?php

namespace App\Livewire\Admin\Sms;

use Livewire\Component;
use App\Models\SmsTemplate;
use App\Models\Setting;
use App\Services\SmsService;

class SmsManager extends Component
{
    public $templates = [];
    public $showModal = false;
    public $editingTemplate = null;
    
    // Form fields
    public $type = '';
    public $name = '';
    public $message = '';
    public $is_active = true;
    public $variables = [];
    
    // Test SMS
    public $testPhone = '';
    public $testMessage = '';
    public $testResult = '';
    
    // API Settings
    public $apiKey = '';
    public $signature = '';
    public $connectionStatus = '';

    protected $rules = [
        'type' => 'required|string|max:255',
        'name' => 'required|string|max:255',
        'message' => 'required|string',
        'is_active' => 'boolean',
        'testPhone' => 'required|string|min:9',
        'testMessage' => 'required|string|max:160'
    ];

    public function mount()
    {
        $this->loadTemplates();
        // Buscar configurações do banco primeiro, depois do config
        $this->apiKey = Setting::get('unimtx_api_key') ?? config('services.unimtx.api_key', '');
        $this->signature = Setting::get('unimtx_signature') ?? config('services.unimtx.signature', 'SuperLoja');
    }

    public function loadTemplates()
    {
        $this->templates = SmsTemplate::all();
    }

    public function openModal($templateId = null)
    {
        if ($templateId) {
            $this->editingTemplate = SmsTemplate::find($templateId);
            $this->type = $this->editingTemplate->type;
            $this->name = $this->editingTemplate->name;
            $this->message = $this->editingTemplate->message;
            $this->is_active = $this->editingTemplate->is_active;
            $this->variables = $this->editingTemplate->variables ?? [];
        } else {
            $this->resetForm();
        }
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->editingTemplate = null;
        $this->type = '';
        $this->name = '';
        $this->message = '';
        $this->is_active = true;
        $this->variables = [];
        $this->resetValidation();
    }

    public function save()
    {
        $this->validate([
            'type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            if ($this->editingTemplate) {
                $this->editingTemplate->update([
                    'type' => $this->type,
                    'name' => $this->name,
                    'message' => $this->message,
                    'is_active' => $this->is_active,
                    'variables' => $this->extractVariables($this->message)
                ]);
                $message = 'Template atualizado com sucesso!';
            } else {
                SmsTemplate::create([
                    'type' => $this->type,
                    'name' => $this->name,
                    'message' => $this->message,
                    'is_active' => $this->is_active,
                    'variables' => $this->extractVariables($this->message)
                ]);
                $message = 'Template criado com sucesso!';
            }

            $this->loadTemplates();
            $this->closeModal();
            $this->dispatch('showAlert', ['type' => 'success', 'message' => $message]);

        } catch (\Exception $e) {
            $this->dispatch('showAlert', ['type' => 'error', 'message' => 'Erro ao salvar: ' . $e->getMessage()]);
        }
    }

    public function toggleActive($templateId)
    {
        $template = SmsTemplate::find($templateId);
        if ($template) {
            $template->update(['is_active' => !$template->is_active]);
            $this->loadTemplates();
            
            $status = $template->is_active ? 'ativado' : 'desativado';
            $this->dispatch('showAlert', ['type' => 'success', 'message' => "Template {$status} com sucesso!"]);
        }
    }

    public function delete($templateId)
    {
        try {
            SmsTemplate::find($templateId)->delete();
            $this->loadTemplates();
            $this->dispatch('showAlert', ['type' => 'success', 'message' => 'Template excluído com sucesso!']);
        } catch (\Exception $e) {
            $this->dispatch('showAlert', ['type' => 'error', 'message' => 'Erro ao excluir: ' . $e->getMessage()]);
        }
    }
    public function testSms()
    {
        $this->validate([
            'testPhone' => 'required|string|min:9',
            'testMessage' => 'required|string|max:160'
        ]);
    }

    public function refreshConfig()
    {
        // Recarregar configurações do banco
        $this->apiKey = Setting::get('unimtx_api_key') ?? config('services.unimtx.api_key', '');
        $this->signature = Setting::get('unimtx_signature') ?? config('services.unimtx.signature', 'SuperLoja');
    }

    public function testConnection()
    {
        // Atualizar configurações antes do teste
        $this->refreshConfig();
        
        try {
            $smsService = new SmsService();
            $result = $smsService->testConnection();
            
            $this->connectionStatus = $result['message'];
            
            if ($result['success']) {
                $this->dispatch('showAlert', ['type' => 'success', 'message' => 'Conexão com API testada com sucesso!']);
            } else {
                $this->dispatch('showAlert', ['type' => 'error', 'message' => 'Falha na conexão: ' . $result['message']]);
            }

        } catch (\Exception $e) {
            $this->connectionStatus = 'Erro na conexão: ' . $e->getMessage();
            $this->dispatch('showAlert', ['type' => 'error', 'message' => 'Erro no teste de conexão']);
        }
    }

    public function createDefaultTemplates()
    {
        $defaultTemplates = [
            [
                'type' => 'order_created',
                'name' => 'Pedido Criado',
                'message' => 'Olá {{customer_name}}! Seu pedido #{{order_number}} foi criado com sucesso. Total: {{total}}. Acompanhe em nossa loja. SuperLoja: {{company_phone}}',
                'is_active' => true
            ],
            [
                'type' => 'order_confirmed',
                'name' => 'Pedido Confirmado',
                'message' => 'Olá {{customer_name}}! Seu pedido #{{order_number}} foi confirmado e está sendo preparado. Em breve será enviado. SuperLoja: {{company_phone}}',
                'is_active' => true
            ],
            [
                'type' => 'order_shipped',
                'name' => 'Pedido Enviado',
                'message' => 'Olá {{customer_name}}! Seu pedido #{{order_number}} foi enviado. Código de rastreamento: {{tracking_code}}. SuperLoja: {{company_phone}}',
                'is_active' => true
            ],
            [
                'type' => 'order_delivered',
                'name' => 'Pedido Entregue',
                'message' => 'Olá {{customer_name}}! Seu pedido #{{order_number}} foi entregue com sucesso. Obrigado por escolher a SuperLoja! {{company_phone}}',
                'is_active' => true
            ],
            [
                'type' => 'order_cancelled',
                'name' => 'Pedido Cancelado',
                'message' => 'Olá {{customer_name}}! Seu pedido #{{order_number}} foi cancelado. Motivo: {{reason}}. Dúvidas? SuperLoja: {{company_phone}}',
                'is_active' => false
            ]
        ];

        foreach ($defaultTemplates as $template) {
            SmsTemplate::updateOrCreate(
                ['type' => $template['type']],
                array_merge($template, ['variables' => $this->extractVariables($template['message'])])
            );
        }

        $this->loadTemplates();
        $this->dispatch('showAlert', ['type' => 'success', 'message' => 'Templates padrão criados com sucesso!']);
    }

    private function extractVariables($message)
    {
        preg_match_all('/\{\{(\w+)\}\}/', $message, $matches);
        return $matches[1] ?? [];
    }

    public function render()
    {
        // Sempre atualizar configurações ao renderizar
        $this->refreshConfig();
        
        return view('livewire.admin.sms.sms-manager')
            ->layout('components.layouts.admin', ['title' => 'Gerenciar SMS']);
    }
}

<?php

declare(strict_types=1);

namespace App\Livewire\Admin\AiAgent;

use Livewire\Component;
use App\Models\AdminNotificationChannel;
use Illuminate\Support\Facades\Auth;

class NotificationChannels extends Component
{
    public $config;
    
    // Canais
    public $email_enabled = true;
    public $sms_enabled = false;
    public $facebook_messenger_enabled = false;
    public $instagram_enabled = false;
    public $browser_enabled = true;
    
    // Configurações
    public $email = '';
    public $phone = '';
    public $facebook_messenger_id = '';
    public $instagram_id = '';
    
    // Filtros
    public $urgent_only = false;
    public $notification_types = [];
    public $quiet_hours_enabled = false;
    public $quiet_hours_start = 22;
    public $quiet_hours_end = 8;
    
    // Tipos disponíveis
    public $availableTypes = [
        'ai_urgent_conversation' => 'Conversas Urgentes da IA',
        'ai_new_message' => 'Novas Mensagens',
        'admin_new_order' => 'Novos Pedidos',
        'admin_new_product_request' => 'Solicitações de Produto',
        'admin_new_auction' => 'Novos Leilões',
    ];

    public function mount()
    {
        $this->loadConfig();
    }

    public function loadConfig()
    {
        $this->config = AdminNotificationChannel::getForUser(Auth::id());
        
        // Carregar valores
        $this->email_enabled = $this->config->email_enabled;
        $this->sms_enabled = $this->config->sms_enabled;
        $this->facebook_messenger_enabled = $this->config->facebook_messenger_enabled;
        $this->instagram_enabled = $this->config->instagram_enabled;
        $this->browser_enabled = $this->config->browser_enabled;
        
        $this->email = $this->config->email ?? Auth::user()->email;
        $this->phone = $this->config->phone ?? '';
        $this->facebook_messenger_id = $this->config->facebook_messenger_id ?? '';
        $this->instagram_id = $this->config->instagram_id ?? '';
        
        $this->urgent_only = $this->config->urgent_only;
        $this->notification_types = $this->config->notification_types ?? [];
        
        if ($this->config->quiet_hours) {
            $this->quiet_hours_enabled = true;
            $this->quiet_hours_start = $this->config->quiet_hours['start'] ?? 22;
            $this->quiet_hours_end = $this->config->quiet_hours['end'] ?? 8;
        }
    }

    public function save()
    {
        $this->validate([
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'facebook_messenger_id' => 'nullable|string',
            'instagram_id' => 'nullable|string',
        ]);

        $quietHours = $this->quiet_hours_enabled ? [
            'start' => (int) $this->quiet_hours_start,
            'end' => (int) $this->quiet_hours_end,
        ] : null;

        $this->config->update([
            'email_enabled' => $this->email_enabled,
            'sms_enabled' => $this->sms_enabled,
            'facebook_messenger_enabled' => $this->facebook_messenger_enabled,
            'instagram_enabled' => $this->instagram_enabled,
            'browser_enabled' => $this->browser_enabled,
            'email' => $this->email,
            'phone' => $this->phone,
            'facebook_messenger_id' => $this->facebook_messenger_id,
            'instagram_id' => $this->instagram_id,
            'urgent_only' => $this->urgent_only,
            'notification_types' => $this->notification_types,
            'quiet_hours' => $quietHours,
        ]);

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Configuracoes salvas com sucesso!'
        ]);
    }

    public function testEmail()
    {
        if (!$this->email_enabled || !$this->email) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Email nao esta habilitado ou nao configurado.'
            ]);
            return;
        }

        try {
            \Mail::raw(
                'Este e um teste de notificacao da IA Agent.\n\nSe voce recebeu este email, as notificacoes por email estao funcionando!',
                function ($message) {
                    $message->to($this->email)
                            ->subject('Teste de Notificacao - IA Agent');
                }
            );
            
            $this->dispatch('notify', [
                'type' => 'success',
                'message' => 'Email de teste enviado para ' . $this->email
            ]);
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erro ao enviar email: ' . $e->getMessage()
            ]);
        }
    }

    public function testSMS()
    {
        if (!$this->sms_enabled || !$this->phone) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'SMS nao esta habilitado ou telefone nao configurado.'
            ]);
            return;
        }

        try {
            $smsService = app(\App\Services\SmsService::class);
            
            $message = "Teste de Notificacao - SuperLoja\n\n" .
                       "Este e um SMS de teste do sistema de canais de notificacao da IA Agent.\n\n" .
                       "Se voce recebeu esta mensagem, o SMS esta configurado corretamente!\n\n" .
                       "Data/Hora: " . now()->format('d/m/Y H:i:s');
            
            $sent = $smsService->sendSms($this->phone, $message);
            
            if ($sent) {
                $this->dispatch('notify', [
                    'type' => 'success',
                    'message' => 'SMS de teste enviado com sucesso para ' . $this->phone
                ]);
            } else {
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Falha ao enviar SMS. Verifique configuracoes da Unimtx.'
                ]);
            }
        } catch (\Exception $e) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Erro ao enviar SMS: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        return view('livewire.admin.ai-agent.notification-channels')
            ->layout('components.layouts.admin', [
                'title' => 'Canais de Notificação',
                'pageTitle' => 'AI Agent - Notificações'
            ]);
    }
}

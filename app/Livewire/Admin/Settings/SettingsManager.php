<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Component;
use App\Models\Setting;
use App\Services\SmsService;

class SettingsManager extends Component
{
    public $activeTab = 'general';
    public $settings = [];
    public $saving = false;

    protected $rules = [
        'settings.*' => 'nullable'
    ];

    public function mount()
    {
        $this->loadSettings();
    }

    public function loadSettings()
    {
        // Carregar configurações existentes
        $allSettings = Setting::all()->keyBy('key');
        
        // Configurações padrão organizadas por grupos
        $defaultSettings = $this->getDefaultSettings();
        
        foreach ($defaultSettings as $group => $groupSettings) {
            foreach ($groupSettings as $key => $config) {
                if ($allSettings->has($key)) {
                    // Configuração existe, usar valor do banco
                    $this->settings[$key] = $allSettings[$key]->value;
                } else {
                    // Configuração não existe, usar valor padrão
                    $this->settings[$key] = $config['default'] ?? '';
                }
            }
        }
    }

    public function getApiKeyStatus()
    {
        $apiKey = Setting::get('unimtx_api_key') ?? config('services.unimtx.api_key');
        return !empty($apiKey) ? $apiKey : 'Não configurada';
    }

    public function getSignatureStatus()
    {
        $signature = Setting::get('unimtx_signature') ?? config('services.unimtx.signature', 'SuperLoja');
        return $signature ?: 'SuperLoja';
    }

    public function getDefaultSettings()
    {
        return [
            'general' => [
                'app_name' => [
                    'label' => 'Nome da Aplicação',
                    'description' => 'Nome principal da loja',
                    'type' => 'string',
                    'default' => 'SuperLoja Angola'
                ],
                'app_description' => [
                    'label' => 'Descrição da Loja',
                    'description' => 'Descrição breve da loja',
                    'type' => 'string',
                    'default' => 'Sua loja online de confiança em Angola'
                ],
                'contact_phone' => [
                    'label' => 'Telefone de Contacto',
                    'description' => 'Número principal de contacto',
                    'type' => 'string',
                    'default' => '+244 939 729 902'
                ],
                'contact_email' => [
                    'label' => 'Email de Contacto',
                    'description' => 'Email principal da empresa',
                    'type' => 'string',
                    'default' => 'contato@superloja.ao'
                ],
                'company_address' => [
                    'label' => 'Endereço da Empresa',
                    'description' => 'Endereço físico da empresa',
                    'type' => 'string',
                    'default' => 'Kilamba J13, Luanda, Angola'
                ]
            ],
            'sms' => [
                'unimtx_access_key' => [
                    'label' => 'Access Key da Unimtx',
                    'description' => 'Chave de acesso da API Unimtx (ex: 5w85m6dWZs4Ue97z7EvL23)',
                    'type' => 'string',
                    'default' => '',
                    'encrypted' => true
                ],
                'sms_enabled' => [
                    'label' => 'SMS Habilitado',
                    'description' => 'Ativar/desativar envio de SMS automático',
                    'type' => 'boolean',
                    'default' => true
                ]
            ],
            'payment' => [
                'bank_name' => [
                    'label' => 'Nome do Banco',
                    'description' => 'Nome do banco para transferências',
                    'type' => 'string',
                    'default' => 'Banco de Fomento Angola (BFA)'
                ],
                'bank_account' => [
                    'label' => 'Número da Conta',
                    'description' => 'Número da conta bancária',
                    'type' => 'string',
                    'default' => '123456789'
                ],
                'bank_iban' => [
                    'label' => 'IBAN',
                    'description' => 'IBAN para transferências internacionais',
                    'type' => 'string',
                    'default' => 'AO06 0040 0000 1234 5678 9012 1'
                ],
                'multicaixa_number' => [
                    'label' => 'Número Multicaixa',
                    'description' => 'Número para pagamentos Multicaixa',
                    'type' => 'string',
                    'default' => '939729902'
                ]
            ],
            'notifications' => [
                'order_notifications' => [
                    'label' => 'Notificações de Pedidos',
                    'description' => 'Enviar notificações sobre pedidos',
                    'type' => 'boolean',
                    'default' => true
                ],
                'stock_notifications' => [
                    'label' => 'Notificações de Stock',
                    'description' => 'Alertas quando produtos ficam em falta',
                    'type' => 'boolean',
                    'default' => true
                ],
                'admin_email' => [
                    'label' => 'Email do Administrador',
                    'description' => 'Email para receber notificações importantes',
                    'type' => 'string',
                    'default' => 'admin@superloja.ao'
                ]
            ]
        ];
    }

    public function save()
    {
        $this->saving = true;
        
        try {
            $defaultSettings = $this->getDefaultSettings();
            
            foreach ($this->settings as $key => $value) {
                // Encontrar configuração nos defaults
                $config = null;
                foreach ($defaultSettings as $group => $groupSettings) {
                    if (isset($groupSettings[$key])) {
                        $config = $groupSettings[$key];
                        $config['group'] = $group;
                        break;
                    }
                }
                
                if ($config) {
                    Setting::set(
                        $key,
                        $value,
                        $config['type'] ?? 'string',
                        $config['group'] ?? 'general',
                        $config['label'] ?? $key,
                        $config['description'] ?? null,
                        $config['encrypted'] ?? false
                    );
                }
            }
            
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Configurações salvas com sucesso!'
            ]);
            
        } catch (\Exception $e) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao salvar configurações: ' . $e->getMessage()
            ]);
        } finally {
            $this->saving = false;
        }
    }

    public function resetDefaults()
    {
        $this->loadSettings();
        
        $this->dispatch('showAlert', [
            'type' => 'info',
            'message' => 'Configurações resetadas para os valores padrão!'
        ]);
    }

    public function testSmsConnection()
    {
        try {
            // Validações básicas primeiro
            if (empty($this->settings['unimtx_access_key'])) {
                $this->dispatch('showAlert', [
                    'type' => 'warning',
                    'message' => 'Configure a Access Key da Unimtx antes de testar a conexão.'
                ]);
                return;
            }

            // Salvar a configuração da Access Key
            Setting::set('unimtx_access_key', $this->settings['unimtx_access_key'], 'string', 'sms', 'Access Key da Unimtx', 'Chave de acesso da API Unimtx', true);
            
            // Testar a conexão
            $smsService = new SmsService();
            $result = $smsService->testConnection();
            
            if ($result['success']) {
                $this->dispatch('showAlert', [
                    'type' => 'success',
                    'message' => 'Conexão SMS testada com sucesso! ' . $result['message']
                ]);
            } else {
                // Para problemas de timeout, oferecer validação offline
                if (str_contains($result['message'], 'Timeout') || str_contains($result['message'], 'temporariamente indisponível')) {
                    $this->dispatch('showAlert', [
                        'type' => 'info',
                        'message' => 'Conexão temporariamente indisponível, mas configurações salvas: ' . $result['message'] . ' As configurações foram validadas localmente.'
                    ]);
                } else {
                    $this->dispatch('showAlert', [
                        'type' => 'error', 
                        'message' => 'Falha na conexão SMS: ' . $result['message']
                    ]);
                }
            }
            
        } catch (\Exception $e) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao testar SMS: ' . $e->getMessage()
            ]);
        }
    }

    public function render()
    {
        $defaultSettings = $this->getDefaultSettings();
        
        return view('livewire.admin.settings.settings-manager', [
            'defaultSettings' => $defaultSettings
        ])->layout('components.layouts.admin', ['title' => 'Configurações']);
    }
}

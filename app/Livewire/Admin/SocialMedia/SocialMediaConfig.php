<?php

namespace App\Livewire\Admin\SocialMedia;

use App\Models\SocialMediaConfig as SocialMediaConfigModel;
use Livewire\Component;
use Illuminate\Support\Facades\Http;

class SocialMediaConfig extends Component
{
    public $configs = [];
    public $selectedPlatform = '';
    public $showModal = false;
    
    // Form fields
    public $platform = '';
    public $page_id = '';
    public $access_token = '';
    public $app_id = '';
    public $app_secret = '';
    public $is_active = false;
    public $auto_post = false;
    public $post_settings = [];

    // Available platforms
    public $platforms = [
        'facebook' => [
            'name' => 'Facebook',
            'icon' => 'fab fa-facebook',
            'color' => 'bg-blue-600',
            'fields' => ['page_id', 'access_token', 'app_id', 'app_secret']
        ],
        'instagram' => [
            'name' => 'Instagram',
            'icon' => 'fab fa-instagram',
            'color' => 'bg-pink-600',
            'fields' => ['page_id', 'access_token', 'app_id', 'app_secret']
        ],
        'twitter' => [
            'name' => 'Twitter',
            'icon' => 'fab fa-twitter',
            'color' => 'bg-blue-400',
            'fields' => ['access_token', 'app_id', 'app_secret']
        ],
        'linkedin' => [
            'name' => 'LinkedIn',
            'icon' => 'fab fa-linkedin',
            'color' => 'bg-blue-700',
            'fields' => ['page_id', 'access_token', 'app_id', 'app_secret']
        ]
    ];

    public function mount()
    {
        $this->loadConfigs();
    }

    public function render()
    {
        return view('livewire.admin.social-media.social-media-config')
            ->layout('components.layouts.admin', [
                'title' => 'Configurações de Redes Sociais',
                'pageTitle' => 'Redes Sociais - Configurações'
            ]);
    }

    public function loadConfigs()
    {
        $this->configs = [];
        
        foreach ($this->platforms as $platformKey => $platformData) {
            $config = SocialMediaConfigModel::where('platform', $platformKey)->first();
            
            $this->configs[$platformKey] = [
                'platform' => $platformKey,
                'name' => $platformData['name'],
                'icon' => $platformData['icon'],
                'color' => $platformData['color'],
                'is_configured' => $config && $config->access_token,
                'is_active' => $config ? $config->is_active : false,
                'auto_post' => $config ? $config->auto_post : false,
                'page_id' => $config ? $config->page_id : '',
                'token_expires_at' => $config ? $config->token_expires_at : null,
                'is_expired' => $config ? $config->isTokenExpired() : false,
            ];
        }
    }

    public function openConfigModal($platform)
    {
        $this->selectedPlatform = $platform;
        $this->platform = $platform;
        
        $config = SocialMediaConfigModel::where('platform', $platform)->first();
        
        if ($config) {
            $this->page_id = $config->page_id ?? '';
            $this->access_token = $config->access_token ?? '';
            $this->app_id = $config->app_id ?? '';
            $this->app_secret = $config->app_secret ?? '';
            $this->is_active = $config->is_active;
            $this->auto_post = $config->auto_post;
            $this->post_settings = $config->post_settings ?? [];
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
        $this->platform = '';
        $this->page_id = '';
        $this->access_token = '';
        $this->app_id = '';
        $this->app_secret = '';
        $this->is_active = false;
        $this->auto_post = false;
        $this->post_settings = [];
    }

    public function saveConfig()
    {
        $this->validate([
            'platform' => 'required|string',
            'access_token' => 'required|string',
            'app_id' => 'nullable|string',
            'app_secret' => 'nullable|string',
            'page_id' => 'nullable|string',
        ]);

        try {
            // Test token validity
            if ($this->platform === 'facebook' && $this->access_token) {
                $this->testFacebookToken();
            }

            SocialMediaConfigModel::updateOrCreate(
                ['platform' => $this->platform],
                [
                    'page_id' => $this->page_id,
                    'access_token' => $this->access_token,
                    'app_id' => $this->app_id,
                    'app_secret' => $this->app_secret,
                    'is_active' => $this->is_active,
                    'auto_post' => $this->auto_post,
                    'post_settings' => $this->post_settings,
                ]
            );

            $this->loadConfigs();
            $this->closeModal();

            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Configuração salva com sucesso!'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro ao salvar configuração: ' . $e->getMessage()
            ]);
        }
    }

    public function testConnection($platform)
    {
        $config = SocialMediaConfigModel::where('platform', $platform)->first();
        
        if (!$config || !$config->access_token) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Configuração não encontrada ou token não configurado.'
            ]);
            return;
        }

        try {
            switch ($platform) {
                case 'facebook':
                    $this->testFacebookConnection($config);
                    break;
                case 'instagram':
                    $this->testInstagramConnection($config);
                    break;
                default:
                    throw new \Exception('Plataforma não suportada para teste.');
            }

            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => 'Conexão testada com sucesso!'
            ]);

        } catch (\Exception $e) {
            $this->dispatch('showAlert', [
                'type' => 'error',
                'message' => 'Erro na conexão: ' . $e->getMessage()
            ]);
        }
    }

    private function testFacebookToken()
    {
        $response = Http::get('https://graph.facebook.com/me', [
            'access_token' => $this->access_token,
            'fields' => 'id,name'
        ]);

        if (!$response->successful()) {
            throw new \Exception('Token do Facebook inválido ou expirado.');
        }
    }

    private function testFacebookConnection($config)
    {
        $response = Http::get('https://graph.facebook.com/me', [
            'access_token' => $config->access_token,
            'fields' => 'id,name'
        ]);

        if (!$response->successful()) {
            throw new \Exception('Token do Facebook inválido ou expirado.');
        }

        $data = $response->json();
        
        if ($config->page_id) {
            $pageResponse = Http::get("https://graph.facebook.com/{$config->page_id}", [
                'access_token' => $config->access_token,
                'fields' => 'id,name'
            ]);

            if (!$pageResponse->successful()) {
                throw new \Exception('ID da página inválido ou sem permissões.');
            }
        }
    }

    private function testInstagramConnection($config)
    {
        if (!$config->page_id) {
            throw new \Exception('ID da página Instagram é obrigatório.');
        }

        $response = Http::get("https://graph.facebook.com/{$config->page_id}", [
            'access_token' => $config->access_token,
            'fields' => 'instagram_business_account'
        ]);

        if (!$response->successful()) {
            throw new \Exception('Erro ao acessar conta business do Instagram.');
        }

        $data = $response->json();
        if (!isset($data['instagram_business_account'])) {
            throw new \Exception('Conta business do Instagram não encontrada.');
        }
    }

    public function toggleActive($platform)
    {
        $config = SocialMediaConfigModel::where('platform', $platform)->first();
        
        if ($config) {
            $config->update(['is_active' => !$config->is_active]);
            $this->loadConfigs();
            
            $status = $config->is_active ? 'ativada' : 'desativada';
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => "Plataforma {$status} com sucesso!"
            ]);
        }
    }

    public function toggleAutoPost($platform)
    {
        $config = SocialMediaConfigModel::where('platform', $platform)->first();
        
        if ($config) {
            $config->update(['auto_post' => !$config->auto_post]);
            $this->loadConfigs();
            
            $status = $config->auto_post ? 'ativado' : 'desativado';
            $this->dispatch('showAlert', [
                'type' => 'success',
                'message' => "Auto-post {$status} com sucesso!"
            ]);
        }
    }

    public function deleteConfig($platform)
    {
        SocialMediaConfigModel::where('platform', $platform)->delete();
        $this->loadConfigs();
        
        $this->dispatch('showAlert', [
            'type' => 'success',
            'message' => 'Configuração removida com sucesso!'
        ]);
    }
}

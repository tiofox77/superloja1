<?php

declare(strict_types=1);

namespace App\Livewire\Admin\AiAgent;

use Livewire\Component;
use App\Models\AiAgentConfig;
use App\Models\AiIntegrationToken;

class AgentSettings extends Component
{
    public $config;
    
    // Configurações básicas
    public $name;
    public $is_active;
    public $system_prompt;
    
    // Integrações
    public $instagram_enabled;
    public $messenger_enabled;
    public $auto_post_enabled;
    
    // Tokens
    public $facebook_access_token;
    public $facebook_page_id;
    public $instagram_access_token;
    public $instagram_page_id;
    
    // Configurações avançadas
    public $auto_response_enabled;
    public $analysis_frequency;
    public $auto_post_frequency;
    public $response_delay_seconds;

    // Configurações do Sistema (do banco de dados)
    public $ai_agent_enabled;
    public $ai_analysis_frequency;
    public $ai_auto_post_enabled;
    public $facebook_app_id;
    public $facebook_app_secret;
    public $facebook_verify_token;
    public $instagram_business_account_id;
    public $instagram_verify_token;

    // Configurações de AI Provider
    public $ai_provider; // openai, claude
    public $openai_api_key;
    public $openai_model;
    public $claude_api_key;
    public $claude_model;

    public $testingFacebook = false;
    public $testingInstagram = false;
    public $testResult = '';

    public function mount()
    {
        $this->config = AiAgentConfig::getActive() ?? AiAgentConfig::create([
            'name' => 'SuperLoja AI Assistant',
            'is_active' => false,
        ]);

        $this->loadConfig();
        $this->loadTokens();
        $this->loadSystemConfigs();
    }

    private function loadSystemConfigs()
    {
        // Inicializar tokens padrão se não existirem
        $this->initializeDefaultTokens();
        
        // Carregar configurações do banco de dados
        $this->ai_agent_enabled = \App\Models\SystemConfig::get('ai_agent_enabled', true);
        $this->ai_analysis_frequency = \App\Models\SystemConfig::get('ai_analysis_frequency', 'daily');
        $this->ai_auto_post_enabled = \App\Models\SystemConfig::get('ai_auto_post_enabled', false);
        
        $this->facebook_app_id = \App\Models\SystemConfig::get('facebook_app_id', '');
        $this->facebook_app_secret = ''; // Não exibir por segurança
        $this->facebook_verify_token = ''; // Não exibir por segurança
        
        $this->instagram_business_account_id = \App\Models\SystemConfig::get('instagram_business_account_id', '');
        $this->instagram_verify_token = ''; // Não exibir por segurança
        
        // Carregar configurações de AI Provider
        $this->ai_provider = \App\Models\SystemConfig::get('ai_provider', 'openai');
        $this->openai_api_key = ''; // Não exibir por segurança
        $this->openai_model = \App\Models\SystemConfig::get('openai_model', 'gpt-4o-mini');
        $this->claude_api_key = ''; // Não exibir por segurança
        $this->claude_model = \App\Models\SystemConfig::get('claude_model', 'claude-3-5-sonnet-20241022');
    }

    private function initializeDefaultTokens()
    {
        // Configurar token padrão "Popadic17" se não existir
        if (!\App\Models\SystemConfig::has('facebook_verify_token')) {
            \App\Models\SystemConfig::set('facebook_verify_token', 'Popadic17', [
                'group' => 'facebook',
                'type' => 'string',
                'is_encrypted' => true,
                'label' => 'Facebook Verify Token',
                'description' => 'Token de verificação para webhooks do Facebook',
            ]);
        }

        if (!\App\Models\SystemConfig::has('instagram_verify_token')) {
            \App\Models\SystemConfig::set('instagram_verify_token', 'Popadic17', [
                'group' => 'instagram',
                'type' => 'string',
                'is_encrypted' => true,
                'label' => 'Instagram Verify Token',
                'description' => 'Token de verificação para webhooks do Instagram',
            ]);
        }
    }

    private function loadConfig()
    {
        $this->name = $this->config->name;
        $this->is_active = $this->config->is_active;
        $this->system_prompt = $this->config->system_prompt;
        $this->instagram_enabled = $this->config->instagram_enabled;
        $this->messenger_enabled = $this->config->messenger_enabled;
        $this->auto_post_enabled = $this->config->auto_post_enabled;
        
        $settings = $this->config->settings ?? [];
        $this->auto_response_enabled = $settings['auto_response_enabled'] ?? true;
        $this->analysis_frequency = $settings['analysis_frequency'] ?? 'daily';
        $this->auto_post_frequency = $settings['auto_post_frequency'] ?? 'twice_daily';
        $this->response_delay_seconds = $settings['response_delay_seconds'] ?? 2;
    }

    private function loadTokens()
    {
        $facebookToken = AiIntegrationToken::getByPlatform('facebook');
        if ($facebookToken) {
            $this->facebook_access_token = '';
            $this->facebook_page_id = $facebookToken->page_id;
        }

        $instagramToken = AiIntegrationToken::getByPlatform('instagram');
        if ($instagramToken) {
            $this->instagram_access_token = '';
            $this->instagram_page_id = $instagramToken->page_id;
        }
    }

    public function saveBasicSettings()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'system_prompt' => 'nullable|string',
        ]);

        $this->config->update([
            'name' => $this->name,
            'is_active' => $this->is_active,
            'system_prompt' => $this->system_prompt,
            'instagram_enabled' => $this->instagram_enabled,
            'messenger_enabled' => $this->messenger_enabled,
            'auto_post_enabled' => $this->auto_post_enabled,
        ]);

        session()->flash('message', 'Configurações básicas salvas com sucesso!');
    }

    public function saveAdvancedSettings()
    {
        $this->config->update([
            'settings' => [
                'auto_response_enabled' => $this->auto_response_enabled,
                'analysis_frequency' => $this->analysis_frequency,
                'auto_post_frequency' => $this->auto_post_frequency,
                'response_delay_seconds' => $this->response_delay_seconds,
            ],
        ]);

        session()->flash('message', 'Configurações avançadas salvas!');
    }

    public function saveFacebookToken()
    {
        $this->validate([
            'facebook_access_token' => 'required|string',
            'facebook_page_id' => 'required|string',
        ]);

        AiIntegrationToken::updateOrCreate(
            ['platform' => 'facebook'],
            [
                'access_token' => $this->facebook_access_token,
                'page_id' => $this->facebook_page_id,
                'is_active' => true,
            ]
        );

        session()->flash('message', 'Token do Facebook salvo!');
        $this->loadTokens();
    }

    public function saveInstagramToken()
    {
        $this->validate([
            'instagram_access_token' => 'required|string',
            'instagram_page_id' => 'required|string',
        ]);

        AiIntegrationToken::updateOrCreate(
            ['platform' => 'instagram'],
            [
                'access_token' => $this->instagram_access_token,
                'page_id' => $this->instagram_page_id,
                'is_active' => true,
            ]
        );

        session()->flash('message', 'Token do Instagram salvo!');
        $this->loadTokens();
        $this->instagram_access_token = '';
    }

    public function testFacebookConnection()
    {
        $this->testingFacebook = true;
        $this->testResult = '';

        try {
            $token = AiIntegrationToken::getByPlatform('facebook');
            
            if (!$token) {
                $this->testResult = 'error:Token do Facebook não configurado!';
                $this->testingFacebook = false;
                return;
            }

            // Testar conexão com Facebook Graph API
            $response = \Illuminate\Support\Facades\Http::get('https://graph.facebook.com/v18.0/me', [
                'access_token' => $token->access_token,
                'fields' => 'id,name'
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $this->testResult = 'success:Conexão OK! Conta: ' . ($data['name'] ?? 'N/A');
            } else {
                $error = $response->json();
                $this->testResult = 'error:Falha: ' . ($error['error']['message'] ?? 'Erro desconhecido');
            }
        } catch (\Exception $e) {
            $this->testResult = 'error:Erro: ' . $e->getMessage();
        }

        $this->testingFacebook = false;
    }

    public function testInstagramConnection()
    {
        $this->testingInstagram = true;
        $this->testResult = '';

        try {
            $token = AiIntegrationToken::getByPlatform('instagram');
            
            if (!$token) {
                $this->testResult = 'error:Token do Instagram não configurado!';
                $this->testingInstagram = false;
                return;
            }

            // Testar conexão com Instagram Graph API
            $response = \Illuminate\Support\Facades\Http::get(
                "https://graph.facebook.com/v18.0/{$token->page_id}",
                [
                    'fields' => 'id,username,name',
                    'access_token' => $token->access_token,
                ]
            );

            if ($response->successful()) {
                $data = $response->json();
                $this->testResult = 'success:Conexão OK! Conta: @' . ($data['username'] ?? 'N/A');
            } else {
                $error = $response->json();
                $this->testResult = 'error:Falha: ' . ($error['error']['message'] ?? 'Erro desconhecido');
            }
        } catch (\Exception $e) {
            $this->testResult = 'error:Erro: ' . $e->getMessage();
        }

        $this->testingInstagram = false;
    }

    public function testWebhook($platform)
    {
        $url = route('webhooks.' . $platform);
        $this->testResult = 'info:Webhook URL: ' . $url . ' - Configure no Facebook Developers';
    }

    public function testOpenAIConnection()
    {
        try {
            // Buscar API Key do banco (ou usar a que está sendo digitada)
            $apiKey = $this->openai_api_key ?: \App\Models\SystemConfig::get('openai_api_key');
            
            if (!$apiKey) {
                $this->testResult = 'error:Por favor, insira uma API Key primeiro';
                return;
            }

            // Fazer teste simples com a API
            $ch = curl_init('https://api.openai.com/v1/models');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $apiKey,
            ]);
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                $data = json_decode($response, true);
                $modelCount = count($data['data'] ?? []);
                $this->testResult = "success:✅ Conexão OK! {$modelCount} modelos disponíveis. API Key válida!";
            } else {
                $error = json_decode($response, true);
                $message = $error['error']['message'] ?? 'Erro desconhecido';
                $this->testResult = 'error:❌ Falha: ' . $message;
            }
        } catch (\Exception $e) {
            $this->testResult = 'error:❌ Erro: ' . $e->getMessage();
        }
    }

    public function testClaudeConnection()
    {
        try {
            // Buscar API Key do banco (ou usar a que está sendo digitada)
            $apiKey = $this->claude_api_key ?: \App\Models\SystemConfig::get('claude_api_key');
            $model = $this->claude_model ?: \App\Models\SystemConfig::get('claude_model', 'claude-3-5-sonnet-20241022');
            
            if (!$apiKey) {
                $this->testResult = 'error:Por favor, insira uma API Key primeiro';
                return;
            }

            // Fazer teste simples com a API
            $ch = curl_init('https://api.anthropic.com/v1/messages');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'x-api-key: ' . $apiKey,
                'anthropic-version: 2023-06-01',
                'content-type: application/json',
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
                'model' => $model,
                'max_tokens' => 10,
                'messages' => [
                    ['role' => 'user', 'content' => 'Hi']
                ]
            ]));
            
            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode === 200) {
                $data = json_decode($response, true);
                $this->testResult = "success:✅ Conexão OK! Modelo: {$model}. API Key válida!";
            } else {
                $error = json_decode($response, true);
                $message = $error['error']['message'] ?? 'Erro desconhecido';
                $this->testResult = 'error:❌ Falha: ' . $message;
            }
        } catch (\Exception $e) {
            $this->testResult = 'error:❌ Erro: ' . $e->getMessage();
        }
    }

    public function saveSystemConfigs()
    {
        try {
            // Salvar configurações do AI Agent
            \App\Models\SystemConfig::set('ai_agent_enabled', $this->ai_agent_enabled, [
                'group' => 'ai_agent',
                'type' => 'boolean',
            ]);

            \App\Models\SystemConfig::set('ai_analysis_frequency', $this->ai_analysis_frequency, [
                'group' => 'ai_agent',
                'type' => 'string',
            ]);

            \App\Models\SystemConfig::set('ai_auto_post_enabled', $this->ai_auto_post_enabled, [
                'group' => 'ai_agent',
                'type' => 'boolean',
            ]);

            // Salvar configurações do Facebook (apenas se preenchido)
            if ($this->facebook_app_id) {
                \App\Models\SystemConfig::set('facebook_app_id', $this->facebook_app_id, [
                    'group' => 'facebook',
                    'type' => 'string',
                ]);
            }

            if ($this->facebook_app_secret) {
                \App\Models\SystemConfig::set('facebook_app_secret', $this->facebook_app_secret, [
                    'group' => 'facebook',
                    'type' => 'string',
                    'is_encrypted' => true,
                ]);
            }

            if ($this->facebook_verify_token) {
                \App\Models\SystemConfig::set('facebook_verify_token', $this->facebook_verify_token, [
                    'group' => 'facebook',
                    'type' => 'string',
                    'is_encrypted' => true,
                ]);
            }

            // Salvar configurações do Instagram (apenas se preenchido)
            if ($this->instagram_business_account_id) {
                \App\Models\SystemConfig::set('instagram_business_account_id', $this->instagram_business_account_id, [
                    'group' => 'instagram',
                    'type' => 'string',
                ]);
            }

            if ($this->instagram_verify_token) {
                \App\Models\SystemConfig::set('instagram_verify_token', $this->instagram_verify_token, [
                    'group' => 'instagram',
                    'type' => 'string',
                    'is_encrypted' => true,
                ]);
            }

            // Salvar configurações de AI Provider
            \App\Models\SystemConfig::set('ai_provider', $this->ai_provider, [
                'group' => 'ai',
                'type' => 'string',
                'label' => 'AI Provider',
                'description' => 'Provider de IA (OpenAI ou Claude)',
            ]);

            if ($this->openai_api_key) {
                \App\Models\SystemConfig::set('openai_api_key', $this->openai_api_key, [
                    'group' => 'ai',
                    'type' => 'string',
                    'is_encrypted' => true,
                    'label' => 'OpenAI API Key',
                ]);
            }

            \App\Models\SystemConfig::set('openai_model', $this->openai_model, [
                'group' => 'ai',
                'type' => 'string',
                'label' => 'OpenAI Model',
            ]);

            if ($this->claude_api_key) {
                \App\Models\SystemConfig::set('claude_api_key', $this->claude_api_key, [
                    'group' => 'ai',
                    'type' => 'string',
                    'is_encrypted' => true,
                    'label' => 'Claude API Key',
                ]);
            }

            \App\Models\SystemConfig::set('claude_model', $this->claude_model, [
                'group' => 'ai',
                'type' => 'string',
                'label' => 'Claude Model',
            ]);

            session()->flash('message', 'Configurações do sistema salvas com sucesso!');
            
            // Recarregar configurações
            $this->loadSystemConfigs();
            
            // Limpar campos de senha por segurança
            $this->facebook_app_secret = '';
            $this->facebook_verify_token = '';
            $this->instagram_verify_token = '';
            $this->openai_api_key = '';
            $this->claude_api_key = '';
            
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao salvar configurações: ' . $e->getMessage());
        }
    }

    /**
     * Listar todos os Cron Jobs agendados
     */
    public function getCronJobs()
    {
        $basePath = base_path();
        $phpPath = '/usr/local/bin/php'; // Caminho padrão, ajustar se necessário
        
        return [
            [
                'name' => 'Publicar Posts Agendados',
                'command' => 'ai:publish-posts',
                'frequency' => 'A cada minuto',
                'cron' => '* * * * *',
                'description' => 'Publica automaticamente posts agendados no Facebook/Instagram',
                'next_run' => now()->addMinute()->format('H:i:s'),
                'status' => 'active',
                'full_command' => "* * * * * {$phpPath} {$basePath}/artisan ai:publish-posts >> /dev/null 2>&1",
            ],
            [
                'name' => 'Criar Posts no Facebook',
                'command' => 'ai:auto-create-posts --platform=facebook',
                'frequency' => '4x por dia (0h, 6h, 12h, 18h)',
                'cron' => '0 */6 * * *',
                'description' => 'Cria automaticamente 3 posts de produtos HOT para Facebook',
                'next_run' => $this->getNextCronRun('0 */6 * * *'),
                'status' => 'active',
                'full_command' => "0 */6 * * * {$phpPath} {$basePath}/artisan ai:auto-create-posts --platform=facebook >> /dev/null 2>&1",
            ],
            [
                'name' => 'Criar Posts no Instagram',
                'command' => 'ai:auto-create-posts --platform=instagram',
                'frequency' => '4x por dia (3h, 9h, 15h, 21h)',
                'cron' => '0 3-21/6 * * *',
                'description' => 'Cria automaticamente 3 posts de produtos HOT para Instagram',
                'next_run' => $this->getNextCronRunInstagram(),
                'status' => 'active',
                'full_command' => "0 3-21/6 * * * {$phpPath} {$basePath}/artisan ai:auto-create-posts --platform=instagram >> /dev/null 2>&1",
            ],
            [
                'name' => 'Criar Carrossel no Facebook',
                'command' => 'ai:auto-create-carousel --platform=facebook --products=10',
                'frequency' => 'Diariamente ao meio-dia',
                'cron' => '0 12 * * *',
                'description' => '🎨 Cria post de CARROSSEL com 10 produtos para Facebook',
                'next_run' => now()->setTime(12, 0) > now() ? now()->setTime(12, 0)->format('d/m/Y H:i') : now()->addDay()->setTime(12, 0)->format('d/m/Y H:i'),
                'status' => 'active',
                'full_command' => "0 12 * * * {$phpPath} {$basePath}/artisan ai:auto-create-carousel --platform=facebook --products=10 >> /dev/null 2>&1",
            ],
            [
                'name' => 'Criar Carrossel no Instagram',
                'command' => 'ai:auto-create-carousel --platform=instagram --products=10',
                'frequency' => 'Diariamente às 19h',
                'cron' => '0 19 * * *',
                'description' => '🎨 Cria post de CARROSSEL com 10 produtos para Instagram',
                'next_run' => now()->setTime(19, 0) > now() ? now()->setTime(19, 0)->format('d/m/Y H:i') : now()->addDay()->setTime(19, 0)->format('d/m/Y H:i'),
                'status' => 'active',
                'full_command' => "0 19 * * * {$phpPath} {$basePath}/artisan ai:auto-create-carousel --platform=instagram --products=10 >> /dev/null 2>&1",
            ],
            [
                'name' => 'Analisar Produtos',
                'command' => 'ai:analyze-products',
                'frequency' => 'Diariamente às 2h',
                'cron' => '0 2 * * *',
                'description' => 'Analisa performance dos produtos e gera insights com IA',
                'next_run' => now()->setTime(2, 0)->addDay()->format('d/m/Y H:i'),
                'status' => 'active',
                'full_command' => "0 2 * * * {$phpPath} {$basePath}/artisan ai:analyze-products >> /dev/null 2>&1",
            ],
            [
                'name' => 'Calcular Métricas da IA',
                'command' => 'ai:calculate-metrics',
                'frequency' => 'A cada 4 horas',
                'cron' => '0 */4 * * *',
                'description' => 'Calcula métricas de performance da IA (conversas, sentimento, sucesso)',
                'next_run' => $this->getNextCronRun('0 */4 * * *'),
                'status' => 'active',
                'full_command' => "0 */4 * * * {$phpPath} {$basePath}/artisan ai:calculate-metrics >> /dev/null 2>&1",
            ],
        ];
    }

    /**
     * Calcular próxima execução de um cron job
     */
    private function getNextCronRun(string $cronExpression): string
    {
        // Parse do cron expression (minuto hora dia mês dia_semana)
        $parts = explode(' ', $cronExpression);
        $minute = $parts[0];
        $hour = $parts[1];
        
        $now = now();
        $currentHour = $now->hour;
        $currentMinute = $now->minute;
        
        // Para */3 horas (a cada 3 horas: 0, 3, 6, 9, 12, 15, 18, 21)
        if ($hour === '*/3') {
            $nextHours = [0, 3, 6, 9, 12, 15, 18, 21];
            foreach ($nextHours as $h) {
                if ($h > $currentHour) {
                    return $now->copy()->setTime($h, 0)->format('d/m/Y H:i');
                }
            }
            // Se passou de todas as horas de hoje, próxima é 0h do próximo dia
            return $now->copy()->addDay()->setTime(0, 0)->format('d/m/Y H:i');
        }
        
        // Para */4 horas (a cada 4 horas: 0, 4, 8, 12, 16, 20)
        if ($hour === '*/4') {
            $nextHours = [0, 4, 8, 12, 16, 20];
            foreach ($nextHours as $h) {
                if ($h > $currentHour) {
                    return $now->copy()->setTime($h, 0)->format('d/m/Y H:i');
                }
            }
            // Se passou de todas as horas de hoje, próxima é 0h do próximo dia
            return $now->copy()->addDay()->setTime(0, 0)->format('d/m/Y H:i');
        }
        
        // Para */6 horas (a cada 6 horas: 0, 6, 12, 18) - Facebook
        if ($hour === '*/6') {
            $nextHours = [0, 6, 12, 18];
            foreach ($nextHours as $h) {
                if ($h > $currentHour) {
                    return $now->copy()->setTime($h, 0)->format('d/m/Y H:i');
                }
            }
            // Se passou de todas as horas de hoje, próxima é 0h do próximo dia
            return $now->copy()->addDay()->setTime(0, 0)->format('d/m/Y H:i');
        }
        
        return 'N/A';
    }

    /**
     * Calcular próxima execução do Instagram (3h, 9h, 15h, 21h)
     */
    private function getNextCronRunInstagram(): string
    {
        $now = now();
        $currentHour = $now->hour;
        
        // Horários específicos do Instagram
        $instagramHours = [3, 9, 15, 21];
        
        foreach ($instagramHours as $h) {
            if ($h > $currentHour) {
                return $now->copy()->setTime($h, 0)->format('d/m/Y H:i');
            }
        }
        
        // Se passou de todas as horas de hoje, próxima é 3h do próximo dia
        return $now->copy()->addDay()->setTime(3, 0)->format('d/m/Y H:i');
    }

    /**
     * Testar comando manualmente
     */
    public function testCronJob($command)
    {
        try {
            \Artisan::call($command);
            $output = \Artisan::output();
            
            session()->flash('cron_test_success', "✅ Comando '{$command}' executado com sucesso!");
            session()->flash('cron_output', $output);
        } catch (\Exception $e) {
            session()->flash('cron_test_error', "❌ Erro ao executar '{$command}': " . $e->getMessage());
        }
    }

    /**
     * Ver logs do cron
     */
    public function getCronLogs()
    {
        $logFile = storage_path('logs/laravel.log');
        
        if (!file_exists($logFile)) {
            return [];
        }

        // Pegar últimas 50 linhas
        $lines = file($logFile);
        $lastLines = array_slice($lines, -50);
        
        return array_reverse($lastLines);
    }

    public function render()
    {
        return view('livewire.admin.ai-agent.agent-settings', [
            'cronJobs' => $this->getCronJobs(),
        ])
            ->layout('components.layouts.admin', [
                'title' => 'Configurações AI Agent',
                'pageTitle' => 'AI Agent - Configurações'
            ]);
    }
}

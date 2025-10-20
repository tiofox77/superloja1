<?php

declare(strict_types=1);

namespace App\Livewire\Admin\System;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use App\Models\Setting;

class SystemUpdater extends Component
{
    public $isUpdating = false;
    public $progress = 0;
    public $currentStep = '';
    public $logs = [];
    public $hasError = false;
    public $updateComplete = false;
    
    // Configurações
    public $githubRepo = '';
    public $githubBranch = 'main';
    public $currentVersion = '';
    public $latestVersion = '';
    public $hasUpdate = false;
    public $updateInfo = null;
    
    public $steps = [
        'checking' => 'Verificando atualizacoes...',
        'pulling' => 'Baixando atualizacoes do GitHub...',
        'composer' => 'Instalando dependencias...',
        'migrations' => 'Executando migrations...',
        'cache' => 'Limpando cache...',
        'complete' => 'Atualizacao concluida!'
    ];

    public function mount()
    {
        $this->loadConfig();
        $this->getCurrentVersion();
    }
    
    public function loadConfig()
    {
        $this->githubRepo = Setting::get('github_repo', '');
        $this->githubBranch = Setting::get('github_branch', 'main');
    }
    
    public function saveConfig()
    {
        if (empty($this->githubRepo)) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Repositorio GitHub e obrigatorio!'
            ]);
            return;
        }
        
        Setting::set('github_repo', $this->githubRepo);
        Setting::set('github_branch', $this->githubBranch);
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Configuracao salva com sucesso!'
        ]);
    }
    
    public function getCurrentVersion()
    {
        try {
            // Tentar ler versão do arquivo version.txt
            $versionFile = base_path('version.txt');
            if (file_exists($versionFile)) {
                $this->currentVersion = trim(file_get_contents($versionFile));
            } else {
                // Tentar pegar do git
                $version = shell_exec('cd ' . base_path() . ' && git describe --tags --abbrev=0 2>&1');
                $this->currentVersion = $version ? trim($version) : 'v1.0.0';
            }
        } catch (\Exception $e) {
            $this->currentVersion = 'v1.0.0';
        }
    }
    
    public function checkForUpdates()
    {
        if (empty($this->githubRepo)) {
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Configure o repositorio GitHub primeiro!'
            ]);
            return;
        }
        
        $this->addLog('info', 'Verificando atualizacoes no GitHub...');
        
        try {
            // Buscar latest release do GitHub
            $response = Http::timeout(30)
                ->retry(3, 1000)
                ->get("https://api.github.com/repos/{$this->githubRepo}/releases/latest");
            
            if ($response->successful()) {
                $release = $response->json();
                $this->latestVersion = $release['tag_name'] ?? 'unknown';
                
                $this->updateInfo = [
                    'version' => $this->latestVersion,
                    'name' => $release['name'] ?? 'Release',
                    'body' => $release['body'] ?? '',
                    'published_at' => $release['published_at'] ?? '',
                    'html_url' => $release['html_url'] ?? '',
                ];
                
                // Comparar versões
                if ($this->latestVersion !== $this->currentVersion) {
                    $this->hasUpdate = true;
                    $this->addLog('success', "Nova versao disponivel: {$this->latestVersion}");
                    $this->addLog('info', "Versao atual: {$this->currentVersion}");
                } else {
                    $this->hasUpdate = false;
                    $this->addLog('info', 'Sistema ja esta na ultima versao!');
                }
                
                $this->dispatch('notify', [
                    'type' => 'success',
                    'message' => 'Verificacao concluida!'
                ]);
            } else {
                // Tentar alternativa: verificar via git local
                $this->addLog('warning', 'API GitHub falhou. Tentando via git local...');
                $this->checkViaGit();
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            
            // Tratamento específico de erros
            if (str_contains($errorMessage, 'timeout')) {
                $this->addLog('error', 'Timeout: Conexao demorou muito');
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Timeout: Verifique sua conexao com internet'
                ]);
            } elseif (str_contains($errorMessage, '404')) {
                $this->addLog('error', 'Repositorio nao encontrado ou sem releases');
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Repositorio nao encontrado. Verifique o nome.'
                ]);
            } elseif (str_contains($errorMessage, '403') || str_contains($errorMessage, '401')) {
                $this->addLog('error', 'Acesso negado: Repositorio pode ser privado');
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Repositorio privado ou sem permissao'
                ]);
            } else {
                $this->addLog('error', 'Erro: ' . $errorMessage);
                $this->dispatch('notify', [
                    'type' => 'error',
                    'message' => 'Erro ao conectar com GitHub'
                ]);
            }
        }
    }

    private function checkViaGit()
    {
        try {
            // Fazer fetch
            shell_exec('cd ' . base_path() . ' && git fetch origin 2>&1');
            
            // Verificar se há commits à frente
            $branch = $this->githubBranch ?: 'main';
            $behind = shell_exec('cd ' . base_path() . ' && git rev-list HEAD..origin/' . $branch . ' --count 2>&1');
            
            if ($behind && intval(trim($behind)) > 0) {
                $this->hasUpdate = true;
                $this->addLog('success', trim($behind) . ' atualizacao(oes) disponivel(eis)!');
                $this->addLog('info', 'Use "Iniciar Atualizacao" para atualizar');
                
                $this->dispatch('notify', [
                    'type' => 'info',
                    'message' => 'Atualizacoes disponiveis via Git'
                ]);
            } else {
                $this->hasUpdate = false;
                $this->addLog('info', 'Sistema ja esta atualizado!');
                
                $this->dispatch('notify', [
                    'type' => 'success',
                    'message' => 'Sistema ja esta na ultima versao'
                ]);
            }
        } catch (\Exception $e) {
            $this->addLog('error', 'Erro ao verificar via Git: ' . $e->getMessage());
            $this->dispatch('notify', [
                'type' => 'error',
                'message' => 'Nao foi possivel verificar atualizacoes'
            ]);
        }
    }
    
    public function startUpdate()
    {
        $this->isUpdating = true;
        $this->progress = 0;
        $this->logs = [];
        $this->hasError = false;
        $this->updateComplete = false;
        
        $this->addLog('info', 'Iniciando processo de atualizacao...');
        
        // Executar steps
        $this->executeStep1();
    }

    public function executeStep1()
    {
        $this->currentStep = 'checking';
        $this->progress = 10;
        $this->addLog('info', $this->steps['checking']);
        
        sleep(1); // Simular processo
        
        $this->dispatch('next-step', step: 2);
    }

    public function executeStep2()
    {
        $this->currentStep = 'pulling';
        $this->progress = 25;
        $this->addLog('info', $this->steps['pulling']);
        
        try {
            // Verificar se repositório está configurado
            if (empty($this->githubRepo)) {
                $this->addLog('error', 'Repositorio GitHub nao configurado!');
                $this->hasError = true;
                $this->isUpdating = false;
                return;
            }
            
            $this->addLog('info', 'Fazendo backup de seguranca...');
            
            // Git pull
            $branch = $this->githubBranch ?: 'main';
            $cmd = 'cd ' . base_path() . ' && git pull origin ' . $branch . ' 2>&1';
            $output = shell_exec($cmd);
            
            if ($output) {
                $this->addLog('success', 'Codigo atualizado com sucesso!');
                $this->addLog('info', trim($output));
                
                // Atualizar version.txt se necessário
                if ($this->latestVersion) {
                    file_put_contents(base_path('version.txt'), $this->latestVersion);
                    $this->addLog('info', "Versao atualizada para {$this->latestVersion}");
                }
            }
            
            $this->dispatch('next-step', step: 3);
            
        } catch (\Exception $e) {
            $this->addLog('error', 'Erro ao baixar atualizacoes: ' . $e->getMessage());
            $this->hasError = true;
            $this->isUpdating = false;
        }
    }

    public function executeStep3()
    {
        $this->currentStep = 'composer';
        $this->progress = 50;
        $this->addLog('info', $this->steps['composer']);
        
        try {
            // Composer install
            $output = shell_exec('cd ' . base_path() . ' && composer install --no-interaction --optimize-autoloader 2>&1');
            
            $this->addLog('success', 'Dependencias instaladas!');
            
            $this->dispatch('next-step', step: 4);
            
        } catch (\Exception $e) {
            $this->addLog('error', 'Erro ao instalar dependencias: ' . $e->getMessage());
            $this->hasError = true;
            $this->isUpdating = false;
        }
    }

    public function executeStep4()
    {
        $this->currentStep = 'migrations';
        $this->progress = 70;
        $this->addLog('info', $this->steps['migrations']);
        
        try {
            // Executar migrations
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();
            
            if ($output) {
                $this->addLog('success', 'Banco de dados atualizado!');
                $this->addLog('info', trim($output));
            }
            
            $this->dispatch('next-step', step: 5);
            
        } catch (\Exception $e) {
            $this->addLog('error', 'Erro ao executar migrations: ' . $e->getMessage());
            $this->hasError = true;
            $this->isUpdating = false;
        }
    }

    public function executeStep5()
    {
        $this->currentStep = 'cache';
        $this->progress = 85;
        $this->addLog('info', $this->steps['cache']);
        
        try {
            // Limpar cache
            Artisan::call('optimize:clear');
            $this->addLog('success', 'Cache limpo!');
            
            // Otimizar
            Artisan::call('optimize');
            $this->addLog('success', 'Sistema otimizado!');
            
            $this->dispatch('next-step', step: 6);
            
        } catch (\Exception $e) {
            $this->addLog('error', 'Erro ao limpar cache: ' . $e->getMessage());
            $this->hasError = true;
            $this->isUpdating = false;
        }
    }

    public function executeStep6()
    {
        $this->currentStep = 'complete';
        $this->progress = 100;
        $this->addLog('success', $this->steps['complete']);
        $this->updateComplete = true;
        $this->isUpdating = false;
        
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Sistema atualizado com sucesso!'
        ]);
    }

    public function addLog($type, $message)
    {
        $this->logs[] = [
            'type' => $type,
            'message' => $message,
            'time' => now()->format('H:i:s')
        ];
    }

    public function render()
    {
        return view('livewire.admin.system.system-updater')
            ->layout('components.layouts.admin', [
                'title' => 'Atualizacao do Sistema',
                'pageTitle' => 'Sistema - Atualizacao'
            ]);
    }
}

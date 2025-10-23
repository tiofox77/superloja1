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
    
    // Novos
    public $showChangelog = false;
    public $prerequisites = [];
    public $canUpdate = true;
    public $backupFile = null;
    public $updateHistory = [];
    public $autoScroll = true;
    public $startTime = null;
    
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
        $this->checkPrerequisites();
        $this->loadUpdateHistory();
    }
    
    public function loadConfig()
    {
        $this->githubRepo = Setting::get('github_repo', '');
        $this->githubBranch = Setting::get('github_branch', 'main');
    }
    
    public function saveConfig()
    {
        if (empty($this->githubRepo)) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Repositorio GitHub e obrigatorio!'
            ]);
            return;
        }
        
        Setting::set('github_repo', $this->githubRepo);
        Setting::set('github_branch', $this->githubBranch);
        
        $this->dispatch('showToast', [
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
    
    public function checkPrerequisites()
    {
        $this->prerequisites = [];
        
        // Git instalado?
        $gitVersion = shell_exec('git --version 2>&1');
        $this->prerequisites['git'] = [
            'name' => 'Git',
            'status' => str_contains($gitVersion, 'git version'),
            'message' => str_contains($gitVersion, 'git version') ? 'Instalado' : 'Não encontrado'
        ];
        
        // Composer instalado?
        $composerVersion = shell_exec('composer --version 2>&1');
        $this->prerequisites['composer'] = [
            'name' => 'Composer',
            'status' => str_contains($composerVersion, 'Composer'),
            'message' => str_contains($composerVersion, 'Composer') ? 'Instalado' : 'Não encontrado'
        ];
        
        // Permissões de escrita?
        $this->prerequisites['writable'] = [
            'name' => 'Permissões',
            'status' => is_writable(base_path()),
            'message' => is_writable(base_path()) ? 'OK' : 'Sem permissão de escrita'
        ];
        
        // Diretório .git existe?
        $this->prerequisites['git_repo'] = [
            'name' => 'Repositório Git',
            'status' => is_dir(base_path('.git')),
            'message' => is_dir(base_path('.git')) ? 'Inicializado' : 'Não encontrado'
        ];
        
        // Pode atualizar?
        $this->canUpdate = collect($this->prerequisites)->every(fn($p) => $p['status']);
    }
    
    public function loadUpdateHistory()
    {
        $historyFile = storage_path('app/update_history.json');
        if (file_exists($historyFile)) {
            $this->updateHistory = json_decode(file_get_contents($historyFile), true) ?? [];
            // Manter últimos 10
            $this->updateHistory = array_slice($this->updateHistory, -10);
        }
    }
    
    public function saveUpdateHistory($version, $status, $duration = null)
    {
        $this->updateHistory[] = [
            'version' => $version,
            'status' => $status,
            'duration' => $duration,
            'timestamp' => now()->toIso8601String(),
            'user' => auth()->user()->name ?? 'Sistema'
        ];
        
        $historyFile = storage_path('app/update_history.json');
        file_put_contents($historyFile, json_encode($this->updateHistory, JSON_PRETTY_PRINT));
    }
    
    public function toggleChangelog()
    {
        $this->showChangelog = !$this->showChangelog;
    }
    
    public function checkForUpdates()
    {
        if (empty($this->githubRepo)) {
            $this->dispatch('showToast', [
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
                
                $this->dispatch('showToast', [
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
                $this->dispatch('showToast', [
                    'type' => 'error',
                    'message' => 'Timeout: Verifique sua conexao com internet'
                ]);
            } elseif (str_contains($errorMessage, '404')) {
                $this->addLog('error', 'Repositorio nao encontrado ou sem releases');
                $this->dispatch('showToast', [
                    'type' => 'error',
                    'message' => 'Repositorio nao encontrado. Verifique o nome.'
                ]);
            } elseif (str_contains($errorMessage, '403') || str_contains($errorMessage, '401')) {
                $this->addLog('error', 'Acesso negado: Repositorio pode ser privado');
                $this->dispatch('showToast', [
                    'type' => 'error',
                    'message' => 'Repositorio privado ou sem permissao'
                ]);
            } else {
                $this->addLog('error', 'Erro: ' . $errorMessage);
                $this->dispatch('showToast', [
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
                
                $this->dispatch('showToast', [
                    'type' => 'info',
                    'message' => 'Atualizacoes disponiveis via Git'
                ]);
            } else {
                $this->hasUpdate = false;
                $this->addLog('info', 'Sistema ja esta atualizado!');
                
                $this->dispatch('showToast', [
                    'type' => 'success',
                    'message' => 'Sistema ja esta na ultima versao'
                ]);
            }
        } catch (\Exception $e) {
            $this->addLog('error', 'Erro ao verificar via Git: ' . $e->getMessage());
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Nao foi possivel verificar atualizacoes'
            ]);
        }
    }
    
    public function startUpdate()
    {
        // Validar pré-requisitos
        if (!$this->canUpdate) {
            $this->dispatch('showToast', [
                'type' => 'error',
                'message' => 'Sistema não atende os pré-requisitos para atualizar!'
            ]);
            return;
        }
        
        $this->isUpdating = true;
        $this->progress = 0;
        $this->logs = [];
        $this->hasError = false;
        $this->updateComplete = false;
        $this->startTime = now();
        
        $this->addLog('info', 'Iniciando processo de atualizacao...');
        $this->addLog('info', "Versão atual: {$this->currentVersion}");
        $this->addLog('info', "Versão alvo: {$this->latestVersion}");
        
        // Executar steps
        $this->executeStep1();
    }
    
    public function restoreBackup($backupFile)
    {
        try {
            $this->addLog('info', 'Restaurando backup...');
            
            $backupPath = storage_path('backups/' . $backupFile);
            if (!file_exists($backupPath)) {
                $this->addLog('error', 'Arquivo de backup não encontrado!');
                return;
            }
            
            // Restaurar banco
            $dbHost = env('DB_HOST', '127.0.0.1');
            $dbPort = env('DB_PORT', '3306');
            $dbName = env('DB_DATABASE');
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');
            
            $cmd = "mysql -h{$dbHost} -P{$dbPort} -u{$dbUser}";
            if ($dbPass) {
                $cmd .= " -p{$dbPass}";
            }
            $cmd .= " {$dbName} < {$backupPath} 2>&1";
            
            exec($cmd, $output, $returnVar);
            
            if ($returnVar === 0) {
                $this->addLog('success', 'Backup restaurado com sucesso!');
                $this->dispatch('showToast', [
                    'type' => 'success',
                    'message' => 'Backup restaurado!'
                ]);
            } else {
                $this->addLog('error', 'Erro ao restaurar backup');
            }
        } catch (\Exception $e) {
            $this->addLog('error', 'Erro: ' . $e->getMessage());
        }
    }

    public function executeStep1()
    {
        $this->currentStep = 'checking';
        $this->progress = 10;
        $this->addLog('info', $this->steps['checking']);
        
        // Verificar ambiente
        $this->addLog('info', 'Verificando ambiente...');
        
        // Próximo step direto
        $this->executeStep2();
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
            
            // BACKUP ANTES DE ATUALIZAR
            $this->addLog('info', '📦 Criando backup do banco de dados...');
            $this->createBackup();
            
            // Git pull
            $this->addLog('info', 'Baixando atualizacoes do GitHub...');
            $branch = $this->githubBranch ?: 'main';
            $cmd = 'cd ' . base_path() . ' && git pull origin ' . $branch . ' 2>&1';
            $output = shell_exec($cmd);
            
            if ($output) {
                $this->addLog('success', 'Codigo atualizado com sucesso!');
                
                // Atualizar version.txt se necessário
                if ($this->latestVersion) {
                    file_put_contents(base_path('version.txt'), $this->latestVersion);
                    $this->addLog('info', "Versao atualizada para {$this->latestVersion}");
                }
            }
            
            // Próximo step
            $this->executeStep3();
            
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
            // Composer install (pode demorar)
            $this->addLog('info', 'Isso pode levar alguns minutos...');
            $output = shell_exec('cd ' . base_path() . ' && composer install --no-interaction --optimize-autoloader 2>&1');
            
            $this->addLog('success', 'Dependencias instaladas!');
            
            // Próximo step
            $this->executeStep4();
            
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
            // Executar migrations PENDENTES
            $this->addLog('info', 'Verificando migrations pendentes...');
            
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();
            
            if (str_contains($output, 'Nothing to migrate')) {
                $this->addLog('info', 'Nenhuma migration pendente!');
            } else {
                $this->addLog('success', 'Banco de dados atualizado!');
                
                // Mostrar quais migrations rodaram
                $lines = explode("\n", trim($output));
                foreach ($lines as $line) {
                    if (!empty(trim($line))) {
                        $this->addLog('info', '→ ' . trim($line));
                    }
                }
            }
            
            // Próximo step
            $this->executeStep5();
            
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
            $this->addLog('info', 'Limpando cache...');
            Artisan::call('optimize:clear');
            $this->addLog('success', 'Cache limpo!');
            
            // Otimizar
            $this->addLog('info', 'Otimizando sistema...');
            Artisan::call('optimize');
            $this->addLog('success', 'Sistema otimizado!');
            
            // Finalizar
            $this->executeStep6();
            
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
        
        // Salvar histórico
        $duration = $this->startTime ? now()->diffInSeconds($this->startTime) : null;
        $this->saveUpdateHistory(
            $this->latestVersion ?? 'unknown',
            'success',
            $duration
        );
        
        $this->addLog('info', "Tempo total: {$duration}s");
        $this->addLog('info', 'Versão atual: ' . $this->latestVersion);
        
        $this->dispatch('showToast', [
            'type' => 'success',
            'message' => 'Sistema atualizado com sucesso!'
        ]);
        
        // Recarregar versão
        $this->getCurrentVersion();
    }

    private function createBackup()
    {
        try {
            // Criar pasta de backups se não existir
            $backupPath = storage_path('backups');
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }
            
            // Nome do arquivo com timestamp
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $fullPath = $backupPath . '/' . $filename;
            
            // Pegar configurações do banco
            $dbHost = env('DB_HOST', '127.0.0.1');
            $dbPort = env('DB_PORT', '3306');
            $dbName = env('DB_DATABASE');
            $dbUser = env('DB_USERNAME');
            $dbPass = env('DB_PASSWORD');
            
            // Comando mysqldump
            $cmd = "mysqldump -h{$dbHost} -P{$dbPort} -u{$dbUser}";
            if ($dbPass) {
                $cmd .= " -p{$dbPass}";
            }
            $cmd .= " {$dbName} > {$fullPath} 2>&1";
            
            exec($cmd, $output, $returnVar);
            
            if ($returnVar === 0 && file_exists($fullPath)) {
                $size = round(filesize($fullPath) / 1024, 2);
                $this->addLog('success', "Backup criado: {$filename} ({$size} KB)");
                
                // Limpar backups antigos (manter últimos 5)
                $this->cleanOldBackups($backupPath);
            } else {
                $this->addLog('warning', 'Backup falhou mas continuando...');
            }
        } catch (\Exception $e) {
            $this->addLog('warning', 'Erro ao criar backup: ' . $e->getMessage());
            $this->addLog('info', 'Continuando atualizacao sem backup...');
        }
    }
    
    private function cleanOldBackups($path)
    {
        $files = glob($path . '/backup_*.sql');
        if (count($files) > 5) {
            // Ordenar por data (mais antigo primeiro)
            usort($files, function($a, $b) {
                return filemtime($a) - filemtime($b);
            });
            
            // Remover arquivos antigos (manter últimos 5)
            $toDelete = array_slice($files, 0, count($files) - 5);
            foreach ($toDelete as $file) {
                unlink($file);
            }
            
            $this->addLog('info', 'Backups antigos removidos (' . count($toDelete) . ')');
        }
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

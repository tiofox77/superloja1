<?php

declare(strict_types=1);

namespace App\Livewire\Admin\System;

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Log;
use App\Models\Setting;

#[Layout('components.admin.layouts.app')]
#[Title('Atualização do Sistema')]
class UpdaterSpa extends Component
{
    // Version info
    public string $currentVersion = '1.0.0';
    public ?string $latestVersion = null;
    public bool $hasUpdate = false;
    public ?array $updateInfo = null;
    public bool $showChangelog = false;

    // Config
    public string $githubRepo = '';
    public string $githubBranch = 'main';

    // Update process
    public bool $isUpdating = false;
    public int $progress = 0;
    public string $currentStep = '';
    public bool $hasError = false;
    public bool $updateComplete = false;

    // Prerequisites
    public array $prerequisites = [];
    public bool $canUpdate = true;

    // Logs & History
    public array $logs = [];
    public array $updateHistory = [];

    // Backups
    public array $backups = [];

    // System info
    public string $phpVersion = '';
    public string $laravelVersion = '';

    // Step labels
    public array $steps = [
        'backup' => 'Criando backup do banco de dados...',
        'pulling' => 'Baixando atualizações do GitHub...',
        'composer' => 'Instalando dependências...',
        'migrations' => 'Executando migrations...',
        'cache' => 'Limpando e otimizando cache...',
        'complete' => 'Atualização concluída!',
    ];

    // Active tab
    public string $activeTab = 'update';

    public function mount(): void
    {
        $this->phpVersion = PHP_VERSION;
        $this->laravelVersion = app()->version();
        $this->loadConfig();
        $this->getCurrentVersion();
        $this->checkPrerequisites();
        $this->loadUpdateHistory();
        $this->loadBackups();
    }

    // ─── Config ──────────────────────────────────────────────────

    public function loadConfig(): void
    {
        $this->githubRepo = Setting::get('github_repo', '');
        $this->githubBranch = Setting::get('github_branch', 'main');
    }

    public function saveConfig(): void
    {
        if (empty($this->githubRepo)) {
            $this->dispatch('toast', type: 'error', message: 'Repositório GitHub é obrigatório!');
            return;
        }

        Setting::set('github_repo', $this->githubRepo);
        Setting::set('github_branch', $this->githubBranch);

        $this->dispatch('toast', type: 'success', message: 'Configuração salva com sucesso!');
    }

    // ─── Version ─────────────────────────────────────────────────

    public function getCurrentVersion(): void
    {
        try {
            $versionFile = base_path('version.txt');
            if (file_exists($versionFile)) {
                $this->currentVersion = trim(file_get_contents($versionFile));
                return;
            }

            $result = Process::path(base_path())->run('git describe --tags --abbrev=0 2>&1');
            if ($result->successful()) {
                $this->currentVersion = trim($result->output());
            } else {
                $this->currentVersion = config('app.version', 'v1.0.0');
            }
        } catch (\Exception $e) {
            $this->currentVersion = config('app.version', 'v1.0.0');
        }
    }

    // ─── Prerequisites ───────────────────────────────────────────

    public function checkPrerequisites(): void
    {
        $this->prerequisites = [];

        // Git
        try {
            $result = Process::run('git --version 2>&1');
            $gitOk = str_contains($result->output(), 'git version');
        } catch (\Exception $e) {
            $gitOk = false;
        }
        $this->prerequisites['git'] = [
            'name' => 'Git',
            'status' => $gitOk,
            'message' => $gitOk ? 'Instalado' : 'Não encontrado',
        ];

        // Composer
        try {
            $result = Process::run('composer --version 2>&1');
            $composerOk = str_contains($result->output(), 'Composer');
        } catch (\Exception $e) {
            $composerOk = false;
        }
        $this->prerequisites['composer'] = [
            'name' => 'Composer',
            'status' => $composerOk,
            'message' => $composerOk ? 'Instalado' : 'Não encontrado',
        ];

        // Write permissions
        $writable = is_writable(base_path());
        $this->prerequisites['writable'] = [
            'name' => 'Permissões de Escrita',
            'status' => $writable,
            'message' => $writable ? 'OK' : 'Sem permissão de escrita',
        ];

        // Git repo
        $gitRepo = is_dir(base_path('.git'));
        $this->prerequisites['git_repo'] = [
            'name' => 'Repositório Git',
            'status' => $gitRepo,
            'message' => $gitRepo ? 'Inicializado' : 'Não encontrado (.git)',
        ];

        $this->canUpdate = collect($this->prerequisites)->every(fn($p) => $p['status']);
    }

    // ─── Check for Updates ───────────────────────────────────────

    public function checkForUpdates(): void
    {
        if (empty($this->githubRepo)) {
            $this->dispatch('toast', type: 'error', message: 'Configure o repositório GitHub primeiro!');
            return;
        }

        $this->addLog('info', 'Verificando atualizações no GitHub...');

        try {
            $response = Http::timeout(30)
                ->retry(2, 1000)
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

                $cleanCurrent = ltrim($this->currentVersion, 'vV');
                $cleanLatest = ltrim($this->latestVersion, 'vV');

                if (version_compare($cleanLatest, $cleanCurrent, '>')) {
                    $this->hasUpdate = true;
                    $this->addLog('success', "Nova versão disponível: {$this->latestVersion}");
                } else {
                    $this->hasUpdate = false;
                    $this->addLog('info', 'Sistema já está na última versão!');
                }

                $this->dispatch('toast', type: 'success', message: 'Verificação concluída!');
            } else {
                $this->addLog('warning', 'API GitHub falhou (HTTP ' . $response->status() . '). Tentando via git local...');
                $this->checkViaGit();
            }
        } catch (\Exception $e) {
            $this->handleCheckError($e);
        }
    }

    private function checkViaGit(): void
    {
        try {
            $branch = $this->githubBranch ?: 'main';

            Process::path(base_path())->run('git fetch origin 2>&1');

            $result = Process::path(base_path())
                ->run("git rev-list HEAD..origin/{$branch} --count 2>&1");

            $behind = intval(trim($result->output()));

            if ($behind > 0) {
                $this->hasUpdate = true;
                $this->addLog('success', "{$behind} atualização(ões) disponível(eis)!");
            } else {
                $this->hasUpdate = false;
                $this->addLog('info', 'Sistema já está atualizado!');
            }

            $this->dispatch('toast', type: 'info', message: $this->hasUpdate ? 'Atualizações disponíveis' : 'Já está atualizado');
        } catch (\Exception $e) {
            $this->addLog('error', 'Erro ao verificar via Git: ' . $e->getMessage());
        }
    }

    private function handleCheckError(\Exception $e): void
    {
        $msg = $e->getMessage();

        if (str_contains($msg, 'timeout') || str_contains($msg, 'timed out')) {
            $this->addLog('error', 'Timeout: Conexão demorou muito');
        } elseif (str_contains($msg, '404')) {
            $this->addLog('error', 'Repositório não encontrado ou sem releases');
        } elseif (str_contains($msg, '403') || str_contains($msg, '401')) {
            $this->addLog('error', 'Acesso negado: Repositório pode ser privado');
        } else {
            $this->addLog('error', 'Erro: ' . $msg);
        }

        $this->addLog('warning', 'Tentando via git local...');
        $this->checkViaGit();
    }

    // ─── Update Process ──────────────────────────────────────────

    public function startUpdate(): void
    {
        if (!$this->canUpdate) {
            $this->dispatch('toast', type: 'error', message: 'Pré-requisitos não atendidos!');
            return;
        }

        if (empty($this->githubRepo)) {
            $this->dispatch('toast', type: 'error', message: 'Repositório GitHub não configurado!');
            return;
        }

        $this->isUpdating = true;
        $this->progress = 0;
        $this->logs = [];
        $this->hasError = false;
        $this->updateComplete = false;

        $this->addLog('info', '═══ Iniciando processo de atualização ═══');
        $this->addLog('info', "Versão atual: {$this->currentVersion}");
        if ($this->latestVersion) {
            $this->addLog('info', "Versão alvo: {$this->latestVersion}");
        }

        $this->stepBackup();
    }

    private function stepBackup(): void
    {
        $this->currentStep = 'backup';
        $this->progress = 10;
        $this->addLog('info', $this->steps['backup']);

        try {
            $result = $this->createDatabaseBackup();
            if ($result) {
                $this->addLog('success', "Backup criado: {$result}");
            } else {
                $this->addLog('warning', 'Backup falhou, mas continuando...');
            }
        } catch (\Exception $e) {
            $this->addLog('warning', 'Erro no backup: ' . $e->getMessage());
            $this->addLog('info', 'Continuando sem backup...');
        }

        $this->stepPull();
    }

    private function stepPull(): void
    {
        $this->currentStep = 'pulling';
        $this->progress = 25;
        $this->addLog('info', $this->steps['pulling']);

        try {
            $branch = $this->githubBranch ?: 'main';
            $basePath = base_path();

            // Stage ALL files (including untracked) and stash everything
            Process::path($basePath)->run('git add -A 2>&1');
            $stash = Process::path($basePath)->run('git stash --include-untracked 2>&1');
            if (str_contains($stash->output(), 'Saved working directory')) {
                $this->addLog('info', 'Alterações locais guardadas (git stash)');
            }

            // Try git pull first
            $result = Process::path($basePath)
                ->timeout(120)
                ->run("git pull origin {$branch} 2>&1");

            $output = trim($result->output());

            if (!$result->successful()) {
                // Pull failed — fallback to fetch + reset --hard
                $this->addLog('warning', 'git pull falhou, usando fetch + reset...');

                Process::path($basePath)->timeout(120)->run("git fetch origin {$branch} 2>&1");

                $reset = Process::path($basePath)->run("git reset --hard origin/{$branch} 2>&1");
                $output = trim($reset->output());

                if (!$reset->successful()) {
                    $this->addLog('error', 'Falha no git reset: ' . $output);
                    // Try to restore stash
                    Process::path($basePath)->run('git stash pop 2>&1');
                    $this->failUpdate();
                    return;
                }

                $this->addLog('success', 'Código sincronizado com o remoto (reset --hard)');
            } else {
                if (str_contains($output, 'Already up to date') || str_contains($output, 'Already up-to-date')) {
                    $this->addLog('info', 'Código já está atualizado');
                } else {
                    $this->addLog('success', 'Código atualizado com sucesso!');
                    $lines = array_filter(explode("\n", $output));
                    foreach (array_slice($lines, 0, 10) as $line) {
                        $this->addLog('info', '→ ' . trim($line));
                    }
                    if (count($lines) > 10) {
                        $this->addLog('info', '... e mais ' . (count($lines) - 10) . ' linhas');
                    }
                }
            }

            // Try to restore local-only changes (non-conflicting)
            $pop = Process::path($basePath)->run('git stash pop 2>&1');
            if ($pop->successful() && !str_contains($pop->output(), 'No stash entries')) {
                $this->addLog('info', 'Alterações locais restauradas');
            } elseif (str_contains($pop->output(), 'CONFLICT') || str_contains($pop->output(), 'error')) {
                // Conflicts — drop stash, remote wins
                Process::path($basePath)->run('git checkout -- . 2>&1');
                Process::path($basePath)->run('git stash drop 2>&1');
                $this->addLog('info', 'Conflitos de stash resolvidos (código remoto prevalece)');
            }

            // Update version.txt
            if ($this->latestVersion) {
                file_put_contents(base_path('version.txt'), $this->latestVersion);
                $this->addLog('info', "Versão atualizada para {$this->latestVersion}");
            }
        } catch (\Exception $e) {
            $this->addLog('error', 'Erro ao baixar atualizações: ' . $e->getMessage());
            $this->failUpdate();
            return;
        }

        $this->stepComposer();
    }

    private function stepComposer(): void
    {
        $this->currentStep = 'composer';
        $this->progress = 50;
        $this->addLog('info', $this->steps['composer']);
        $this->addLog('info', 'Isso pode levar alguns minutos...');

        try {
            $home = base_path();
            $result = Process::path(base_path())
                ->timeout(300)
                ->env([
                    'HOME' => $home,
                    'COMPOSER_HOME' => $home . '/.composer',
                ])
                ->run('composer install --no-interaction --optimize-autoloader --no-dev 2>&1');

            if ($result->successful()) {
                $this->addLog('success', 'Dependências instaladas!');
            } else {
                $output = trim($result->output());
                if (!empty($output)) {
                    $this->addLog('warning', 'Composer output: ' . substr($output, 0, 500));
                }
                // Don't fail on composer warnings
                $this->addLog('info', 'Continuando...');
            }
        } catch (\Exception $e) {
            $this->addLog('warning', 'Composer: ' . $e->getMessage());
            $this->addLog('info', 'Continuando sem atualizar dependências...');
        }

        $this->stepMigrations();
    }

    private function stepMigrations(): void
    {
        $this->currentStep = 'migrations';
        $this->progress = 70;
        $this->addLog('info', $this->steps['migrations']);

        try {
            Artisan::call('migrate', ['--force' => true]);
            $output = trim(Artisan::output());

            if (str_contains($output, 'Nothing to migrate')) {
                $this->addLog('info', 'Nenhuma migration pendente');
            } else {
                $this->addLog('success', 'Banco de dados atualizado!');
                $lines = array_filter(explode("\n", $output));
                foreach ($lines as $line) {
                    if (!empty(trim($line))) {
                        $this->addLog('info', '→ ' . trim($line));
                    }
                }
            }
        } catch (\Exception $e) {
            $this->addLog('error', 'Erro nas migrations: ' . $e->getMessage());
            $this->addLog('warning', 'Pode ser necessário executar manualmente');
        }

        $this->stepCache();
    }

    private function stepCache(): void
    {
        $this->currentStep = 'cache';
        $this->progress = 85;
        $this->addLog('info', $this->steps['cache']);

        try {
            Artisan::call('optimize:clear');
            $this->addLog('success', 'Cache limpo!');
        } catch (\Exception $e) {
            $this->addLog('warning', 'Erro ao limpar cache: ' . $e->getMessage());
        }

        $this->stepComplete();
    }

    private function stepComplete(): void
    {
        $this->currentStep = 'complete';
        $this->progress = 100;
        $this->updateComplete = true;
        $this->isUpdating = false;

        $this->addLog('success', '═══ ' . $this->steps['complete'] . ' ═══');

        // Save history
        $this->saveUpdateHistory($this->latestVersion ?? $this->currentVersion, 'success');

        // Reload
        $this->getCurrentVersion();
        $this->loadBackups();
        $this->hasUpdate = false;

        $this->dispatch('toast', type: 'success', message: 'Sistema atualizado com sucesso!');
    }

    private function failUpdate(): void
    {
        $this->hasError = true;
        $this->isUpdating = false;
        $this->addLog('error', '═══ Atualização falhou ═══');

        $this->saveUpdateHistory($this->latestVersion ?? 'unknown', 'failed');

        $this->dispatch('toast', type: 'error', message: 'Atualização falhou!');
    }

    // ─── Backup ──────────────────────────────────────────────────

    private function createDatabaseBackup(): ?string
    {
        $backupPath = storage_path('backups');
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $fullPath = $backupPath . DIRECTORY_SEPARATOR . $filename;

        $dbHost = config('database.connections.mysql.host', '127.0.0.1');
        $dbPort = config('database.connections.mysql.port', '3306');
        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');

        $cmd = "mysqldump -h{$dbHost} -P{$dbPort} -u{$dbUser}";
        if (!empty($dbPass)) {
            $cmd .= " -p" . escapeshellarg($dbPass);
        }
        $cmd .= " " . escapeshellarg($dbName) . " > " . escapeshellarg($fullPath) . " 2>&1";

        $result = Process::run($cmd);

        if (file_exists($fullPath) && filesize($fullPath) > 0) {
            return $fullPath;
        }

        return null;
    }

    private function createFullBackup(): ?string
    {
        $backupPath = storage_path('backups');
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        $timestamp = date('Y-m-d_H-i-s');
        $zipFilename = 'backup_' . $timestamp . '.zip';
        $zipPath = $backupPath . DIRECTORY_SEPARATOR . $zipFilename;

        $zip = new \ZipArchive();
        if ($zip->open($zipPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
            $this->addLog('error', 'Não foi possível criar o arquivo zip');
            return null;
        }

        // 1. Backup do banco de dados
        $this->addLog('info', 'Exportando banco de dados...');
        $sqlPath = $this->createDatabaseBackup();
        if ($sqlPath && file_exists($sqlPath)) {
            $zip->addFile($sqlPath, 'database/' . basename($sqlPath));
            $this->addLog('success', 'Banco de dados exportado (' . round(filesize($sqlPath) / 1024, 1) . ' KB)');
        } else {
            $this->addLog('warning', 'Falha ao exportar banco de dados');
        }

        // 2. Backup dos ficheiros importantes
        $this->addLog('info', 'Copiando ficheiros do projeto...');
        $directories = [
            'app' => base_path('app'),
            'config' => base_path('config'),
            'routes' => base_path('routes'),
            'database/migrations' => base_path('database/migrations'),
            'database/seeders' => base_path('database/seeders'),
            'resources/views' => base_path('resources/views'),
            'public/css' => base_path('public/css'),
            'public/js' => base_path('public/js'),
        ];

        $fileCount = 0;
        foreach ($directories as $zipDir => $realDir) {
            if (is_dir($realDir)) {
                $fileCount += $this->addDirectoryToZip($zip, $realDir, 'files/' . $zipDir);
            }
        }

        // 3. Ficheiros raiz importantes
        $rootFiles = ['.env', 'composer.json', 'composer.lock', 'package.json', 'vite.config.js', 'tailwind.config.js'];
        foreach ($rootFiles as $rootFile) {
            $filePath = base_path($rootFile);
            if (file_exists($filePath)) {
                $zip->addFile($filePath, 'files/' . $rootFile);
                $fileCount++;
            }
        }

        $zip->close();
        $this->addLog('success', "Ficheiros copiados: {$fileCount} ficheiros");

        // Limpar o .sql temporário
        if ($sqlPath && file_exists($sqlPath)) {
            @unlink($sqlPath);
        }

        if (file_exists($zipPath) && filesize($zipPath) > 0) {
            $this->cleanOldBackups($backupPath);
            return $zipFilename;
        }

        return null;
    }

    private function addDirectoryToZip(\ZipArchive $zip, string $dir, string $zipDir): int
    {
        $count = 0;
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $filePath = $file->getRealPath();
                $relativePath = $zipDir . '/' . substr($filePath, strlen($dir) + 1);
                $relativePath = str_replace('\\', '/', $relativePath);
                $zip->addFile($filePath, $relativePath);
                $count++;
            }
        }

        return $count;
    }

    public function createManualBackup(): void
    {
        $this->addLog('info', 'Criando backup completo (BD + Ficheiros)...');

        try {
            $result = $this->createFullBackup();
            if ($result) {
                $size = round(filesize(storage_path('backups/' . $result)) / 1024 / 1024, 2);
                $this->addLog('success', "Backup completo criado: {$result} ({$size} MB)");
                $this->dispatch('toast', type: 'success', message: 'Backup completo criado!');
                $this->loadBackups();
            } else {
                $this->addLog('error', 'Falha ao criar backup');
                $this->dispatch('toast', type: 'error', message: 'Falha ao criar backup');
            }
        } catch (\Exception $e) {
            $this->addLog('error', 'Erro: ' . $e->getMessage());
            $this->dispatch('toast', type: 'error', message: 'Erro ao criar backup');
        }
    }

    public function loadBackups(): void
    {
        $this->backups = [];
        $backupPath = storage_path('backups');

        if (!is_dir($backupPath)) {
            return;
        }

        // Encontrar ficheiros .zip e .sql
        $zipFiles = glob($backupPath . DIRECTORY_SEPARATOR . 'backup_*.zip') ?: [];
        $sqlFiles = glob($backupPath . DIRECTORY_SEPARATOR . 'backup_*.sql') ?: [];
        $files = array_merge($zipFiles, $sqlFiles);

        if (empty($files)) {
            return;
        }

        usort($files, fn($a, $b) => filemtime($b) - filemtime($a));

        foreach ($files as $file) {
            $ext = pathinfo($file, PATHINFO_EXTENSION);
            $sizeKB = filesize($file) / 1024;
            $this->backups[] = [
                'filename' => basename($file),
                'size' => $sizeKB >= 1024 ? round($sizeKB / 1024, 2) . ' MB' : round($sizeKB, 1) . ' KB',
                'date' => date('d/m/Y H:i:s', filemtime($file)),
                'timestamp' => filemtime($file),
                'type' => $ext === 'zip' ? 'completo' : 'bd',
            ];
        }
    }

    public function restoreBackup(string $filename): void
    {
        $backupFilePath = storage_path('backups/' . $filename);

        if (!file_exists($backupFilePath)) {
            $this->addLog('error', 'Arquivo de backup não encontrado!');
            $this->dispatch('toast', type: 'error', message: 'Backup não encontrado!');
            return;
        }

        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        $this->addLog('info', "Restaurando backup: {$filename}");

        try {
            $sqlFile = $backupFilePath;

            // Se for zip, extrair o SQL de dentro
            if ($ext === 'zip') {
                $zip = new \ZipArchive();
                if ($zip->open($backupFilePath) === true) {
                    // Procurar o .sql dentro do zip
                    $tmpDir = storage_path('backups/tmp_restore_' . time());
                    mkdir($tmpDir, 0755, true);

                    // Extrair apenas a pasta database/
                    for ($i = 0; $i < $zip->numFiles; $i++) {
                        $name = $zip->getNameIndex($i);
                        if (str_starts_with($name, 'database/') && str_ends_with($name, '.sql')) {
                            $zip->extractTo($tmpDir, $name);
                            $sqlFile = $tmpDir . '/' . $name;
                            break;
                        }
                    }
                    $zip->close();

                    if (!file_exists($sqlFile)) {
                        $this->addLog('error', 'Ficheiro SQL não encontrado dentro do zip');
                        $this->dispatch('toast', type: 'error', message: 'SQL não encontrado no backup');
                        @rmdir($tmpDir);
                        return;
                    }

                    $this->addLog('info', 'SQL extraído do backup zip');
                } else {
                    $this->addLog('error', 'Não foi possível abrir o arquivo zip');
                    $this->dispatch('toast', type: 'error', message: 'Erro ao abrir zip');
                    return;
                }
            }

            // Restaurar o banco de dados
            $dbHost = config('database.connections.mysql.host', '127.0.0.1');
            $dbPort = config('database.connections.mysql.port', '3306');
            $dbName = config('database.connections.mysql.database');
            $dbUser = config('database.connections.mysql.username');
            $dbPass = config('database.connections.mysql.password');

            $cmd = "mysql -h{$dbHost} -P{$dbPort} -u{$dbUser}";
            if (!empty($dbPass)) {
                $cmd .= " -p" . escapeshellarg($dbPass);
            }
            $cmd .= " " . escapeshellarg($dbName) . " < " . escapeshellarg($sqlFile) . " 2>&1";

            $result = Process::run($cmd);

            // Limpar ficheiros temporários
            if ($ext === 'zip') {
                $tmpDir = dirname($sqlFile);
                if (str_contains($tmpDir, 'tmp_restore_')) {
                    $this->removeDirectory($tmpDir);
                }
            }

            if ($result->successful()) {
                $this->addLog('success', 'Banco de dados restaurado com sucesso!');
                $this->dispatch('toast', type: 'success', message: 'Backup restaurado!');
            } else {
                $this->addLog('error', 'Erro ao restaurar: ' . $result->output());
                $this->dispatch('toast', type: 'error', message: 'Erro ao restaurar backup');
            }
        } catch (\Exception $e) {
            $this->addLog('error', 'Erro: ' . $e->getMessage());
            $this->dispatch('toast', type: 'error', message: 'Erro ao restaurar backup');
        }
    }

    private function removeDirectory(string $dir): void
    {
        if (!is_dir($dir)) return;
        $items = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($items as $item) {
            $item->isDir() ? @rmdir($item->getRealPath()) : @unlink($item->getRealPath());
        }
        @rmdir($dir);
    }

    public function deleteBackup(string $filename): void
    {
        $path = storage_path('backups/' . $filename);
        if (file_exists($path)) {
            unlink($path);
            $this->loadBackups();
            $this->dispatch('toast', type: 'info', message: 'Backup removido');
        }
    }

    private function cleanOldBackups(string $path): void
    {
        $zipFiles = glob($path . DIRECTORY_SEPARATOR . 'backup_*.zip') ?: [];
        $sqlFiles = glob($path . DIRECTORY_SEPARATOR . 'backup_*.sql') ?: [];
        $files = array_merge($zipFiles, $sqlFiles);

        if (count($files) <= 5) {
            return;
        }

        usort($files, fn($a, $b) => filemtime($a) - filemtime($b));

        $toDelete = array_slice($files, 0, count($files) - 5);
        foreach ($toDelete as $file) {
            @unlink($file);
        }
    }

    // ─── Git Rollback ────────────────────────────────────────────

    public function rollbackCode(): void
    {
        $this->addLog('info', 'Revertendo código para versão anterior...');

        try {
            // Reset to previous commit
            $result = Process::path(base_path())
                ->run('git reset --hard HEAD~1 2>&1');

            if ($result->successful()) {
                $this->addLog('success', 'Código revertido com sucesso!');

                // Pop stash if exists
                Process::path(base_path())->run('git stash pop 2>&1');

                // Clear cache
                Artisan::call('optimize:clear');
                $this->addLog('success', 'Cache limpo');

                $this->getCurrentVersion();
                $this->hasUpdate = true;
                $this->updateComplete = false;

                $this->dispatch('toast', type: 'success', message: 'Rollback concluído!');
            } else {
                $this->addLog('error', 'Falha no rollback: ' . $result->output());
                $this->dispatch('toast', type: 'error', message: 'Falha no rollback');
            }
        } catch (\Exception $e) {
            $this->addLog('error', 'Erro: ' . $e->getMessage());
            $this->dispatch('toast', type: 'error', message: 'Erro no rollback');
        }
    }

    // ─── Maintenance ─────────────────────────────────────────────

    public function clearAllCaches(): void
    {
        $this->logs = [];
        $errors = 0;

        $commands = [
            'cache:clear' => 'Cache da aplicação limpo',
            'config:clear' => 'Cache de configuração limpo',
            'view:clear' => 'Cache de views limpo',
            'route:clear' => 'Cache de rotas limpo',
        ];

        foreach ($commands as $cmd => $successMsg) {
            try {
                Artisan::call($cmd);
                $this->addLog('success', $successMsg);
            } catch (\Exception $e) {
                $errors++;
                $this->addLog('error', "{$cmd}: " . $e->getMessage());
            }
        }

        if ($errors === 0) {
            $this->dispatch('toast', type: 'success', message: 'Todos os caches limpos!');
        } else {
            $this->dispatch('toast', type: 'warning', message: "Caches limpos com {$errors} erro(s)");
        }
    }

    public function optimizeSystem(): void
    {
        $this->logs = [];
        $errors = 0;

        $commands = [
            'config:cache' => 'Configuração cacheada',
            'view:cache' => 'Views cacheadas',
        ];

        // route:cache falha com rotas baseadas em closures, tentar mas não falhar
        foreach ($commands as $cmd => $successMsg) {
            try {
                Artisan::call($cmd);
                $this->addLog('success', $successMsg);
            } catch (\Exception $e) {
                $errors++;
                $this->addLog('error', "{$cmd}: " . $e->getMessage());
            }
        }

        // route:cache separado (frequentemente falha com closures)
        try {
            Artisan::call('route:cache');
            $this->addLog('success', 'Rotas cacheadas');
        } catch (\Exception $e) {
            $this->addLog('warning', 'route:cache ignorado (rotas com closures detectadas)');
        }

        if ($errors === 0) {
            $this->dispatch('toast', type: 'success', message: 'Sistema otimizado!');
        } else {
            $this->dispatch('toast', type: 'warning', message: "Otimizado com {$errors} aviso(s)");
        }
    }

    public function runMigrations(): void
    {
        $this->logs = [];

        try {
            Artisan::call('migrate', ['--force' => true]);
            $output = trim(Artisan::output());

            if (str_contains($output, 'Nothing to migrate')) {
                $this->addLog('info', 'Nenhuma migration pendente');
            } else {
                $this->addLog('success', 'Migrations executadas!');
                $lines = array_filter(explode("\n", $output));
                foreach ($lines as $line) {
                    if (!empty(trim($line))) {
                        $this->addLog('info', '→ ' . trim($line));
                    }
                }
            }

            $this->dispatch('toast', type: 'success', message: 'Migrations executadas!');
        } catch (\Exception $e) {
            $this->addLog('error', $e->getMessage());
            $this->dispatch('toast', type: 'error', message: 'Erro nas migrations');
        }
    }

    // ─── Update History ──────────────────────────────────────────

    public function loadUpdateHistory(): void
    {
        $file = storage_path('app/update_history.json');
        if (file_exists($file)) {
            $this->updateHistory = json_decode(file_get_contents($file), true) ?? [];
            $this->updateHistory = array_slice($this->updateHistory, -10);
        }
    }

    private function saveUpdateHistory(string $version, string $status): void
    {
        $this->updateHistory[] = [
            'version' => $version,
            'status' => $status,
            'timestamp' => now()->toIso8601String(),
            'user' => auth()->user()->name ?? 'Sistema',
        ];

        $file = storage_path('app/update_history.json');
        file_put_contents($file, json_encode($this->updateHistory, JSON_PRETTY_PRINT));
    }

    // ─── Helpers ─────────────────────────────────────────────────

    public function toggleChangelog(): void
    {
        $this->showChangelog = !$this->showChangelog;
    }

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
    }

    public function addLog(string $type, string $message): void
    {
        $this->logs[] = [
            'type' => $type,
            'message' => $message,
            'time' => now()->format('H:i:s'),
        ];
    }

    // ─── Render ──────────────────────────────────────────────────

    public function render()
    {
        $systemInfo = [
            'PHP' => $this->phpVersion,
            'Laravel' => $this->laravelVersion,
            'Servidor' => $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown',
            'Memória' => ini_get('memory_limit'),
            'Max Exec Time' => ini_get('max_execution_time') . 's',
            'Upload Max' => ini_get('upload_max_filesize'),
            'Disco Livre' => round(disk_free_space(base_path()) / 1024 / 1024 / 1024, 2) . ' GB',
        ];

        return view('livewire.admin.system.updater-spa', [
            'systemInfo' => $systemInfo,
        ]);
    }
}

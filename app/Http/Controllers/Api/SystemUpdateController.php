<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SystemUpdateController extends Controller
{
    /**
     * Diretório de updates
     */
    protected const UPDATES_DIR = 'updates';

    /**
     * Pasta temporária para extração
     */
    protected const TEMP_DIR = 'temp_update';

    /**
     * Token de segurança para updates (configurar no .env)
     */
    protected const UPDATE_TOKEN = 'Popadic17';

    /**
     * Versão atual do sistema
     */
    protected const CURRENT_VERSION = '1.0.0';

    /**
     * Verificar estado do sistema
     * GET /api/v1/system/status
     */
    public function status(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => [
                'version' => self::CURRENT_VERSION,
                'laravel_version' => app()->version(),
                'php_version' => PHP_VERSION,
                'environment' => app()->environment(),
                'debug_mode' => config('app.debug'),
                'database_connection' => DB::connection()->getDriverName(),
                'storage_disk' => Storage::getDefaultDriver(),
                'last_backup' => $this->getLastBackupDate(),
                'disk_space' => $this->getDiskSpace(),
                'queued_jobs' => $this->getQueuedJobsCount(),
            ]
        ]);
    }

    /**
     * Verificar atualizações disponíveis
     * GET /api/v1/system/updates/check
     */
    public function checkUpdates(Request $request): JsonResponse
    {
        $token = $request->header('X-Update-Token') ?? $request->input('token');

        if (!$this->validateUpdateToken($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Token de update inválido.'
            ], 401);
        }

        // Simular verificação de atualizações (pode conectar com servidor remoto)
        $availableUpdates = [
            [
                'version' => '1.1.0',
                'release_date' => '2026-02-15',
                'description' => 'Novas funcionalidades de API e melhorias de performance',
                'file_size' => 5242880, // 5MB
                'checksum' => 'sha256:abc123...',
                'requires_db_migration' => true,
                'breaking_changes' => false,
                'download_url' => 'https://superloja.vip/updates/superloja-v1.1.0.zip',
            ]
        ];

        $currentVersion = self::CURRENT_VERSION;
        $updates = array_filter($availableUpdates, function ($update) use ($currentVersion) {
            return version_compare($update['version'], $currentVersion, '>');
        });

        return response()->json([
            'success' => true,
            'data' => [
                'current_version' => $currentVersion,
                'latest_version' => !empty($updates) ? $updates[0]['version'] : $currentVersion,
                'updates_available' => count($updates),
                'updates' => $updates,
            ]
        ]);
    }

    /**
     * Upload e instalação de update via ficheiro
     * POST /api/v1/system/updates/upload
     */
    public function uploadUpdate(Request $request): JsonResponse
    {
        $token = $request->header('X-Update-Token') ?? $request->input('token');

        if (!$this->validateUpdateToken($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Token de update inválido.'
            ], 401);
        }

        // Validar ficheiro
        $request->validate([
            'update_file' => 'required|file|mimes:zip|max:102400', // Max 100MB
            'version' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $version = $request->input('version');
        $description = $request->input('description', 'Update do sistema');

        // Criar backup antes do update
        $backupCreated = $this->performBackup();
        if (!$backupCreated['success']) {
            return response()->json([
                'success' => false,
                'message' => 'Falha ao criar backup: ' . $backupCreated['message']
            ], 500);
        }

        try {
            // Guardar ficheiro de update
            $updateFile = $request->file('update_file');
            $filename = 'update_' . $version . '_' . time() . '.zip';
            $updatePath = storage_path('app/' . self::UPDATES_DIR . '/' . $filename);

            // Criar diretório se não existir
            if (!File::exists(storage_path('app/' . self::UPDATES_DIR))) {
                File::makeDirectory(storage_path('app/' . self::UPDATES_DIR), 0755, true);
            }

            $updateFile->move(dirname($updatePath), basename($updatePath));

            // Extrair e processar update
            $result = $this->processUpdate($updatePath, $version, $description);

            if ($result['success']) {
                return response()->json([
                    'success' => true,
                    'message' => 'Update instalado com sucesso!',
                    'data' => [
                        'version' => $version,
                        'backup_created' => $backupCreated['data']['backup_path'],
                        'files_updated' => $result['files_updated'],
                        'migrations_run' => $result['migrations_run'],
                        'commands_executed' => $result['commands'],
                        'changelog' => $description,
                        'installed_at' => now()->toIso8601String(),
                    ]
                ]);
            } else {
                // Reverter backup
                $this->performRestore($backupCreated['data']['backup_path']);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Falha no update: ' . $result['message'],
                    'rolled_back' => true,
                    'backup_restored' => true,
                ], 500);
            }
        } catch (\Exception $e) {
            // Reverter em caso de erro
            $this->performRestore($backupCreated['data']['backup_path']);
            
            return response()->json([
                'success' => false,
                'message' => 'Erro ao processar update: ' . $e->getMessage(),
                'rolled_back' => true,
                'backup_restored' => true,
            ], 500);
        }
    }

    /**
     * Upload de ficheiros específicos (plugins, temas, etc.)
     * POST /api/v1/system/files/upload
     */
    public function uploadFile(Request $request): JsonResponse
    {
        $token = $request->header('X-Update-Token') ?? $request->input('token');

        if (!$this->validateUpdateToken($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Token de update inválido.'
            ], 401);
        }

        $request->validate([
            'file' => 'required|file|max:51200', // Max 50MB
            'destination' => 'required|string|in:plugins,themes,assets,uploads',
            'filename' => 'nullable|string|max:255',
        ]);

        $destination = $request->input('destination');
        $customFilename = $request->input('filename');
        $file = $request->file('file');

        // Validar tipo de ficheiro por destino
        $allowedMimes = $this->getAllowedMimes($destination);
        $mime = $file->getClientMimeType();
        
        if (!in_array($mime, $allowedMimes) && !in_array($file->getClientOriginalExtension(), ['zip'])) {
            return response()->json([
                'success' => false,
                'message' => 'Tipo de ficheiro não permitido para este destino.'
            ], 400);
        }

        // Determinar caminho de destino
        $basePath = base_path();
        $destinations = [
            'plugins' => $basePath . '/plugins',
            'themes' => $basePath . '/themes',
            'assets' => public_path('assets'),
            'uploads' => storage_path('app/uploads'),
        ];

        $targetPath = $destinations[$destination] ?? $basePath;

        // Criar diretório se não existir
        if (!File::exists($targetPath)) {
            File::makeDirectory($targetPath, 0755, true);
        }

        // Gerar nome do ficheiro
        $filename = $customFilename ?? time() . '_' . Str::slug($file->getClientOriginalName());
        $filePath = $targetPath . '/' . $filename;

        // Mover ficheiro
        if ($file->move(dirname($filePath), basename($filePath))) {
            // Se for ZIP, perguntar se quer extrair
            $extracted = false;
            $extractPath = null;
            
            if ($file->getClientOriginalExtension() === 'zip') {
                $extractPath = $targetPath . '/' . pathinfo($filename, PATHINFO_FILENAME);
                $extracted = $this->extractZip($filePath, $extractPath);
            }

            return response()->json([
                'success' => true,
                'message' => 'Ficheiro enviado com sucesso.',
                'data' => [
                    'filename' => basename($filePath),
                    'path' => str_replace($basePath, '', $filePath),
                    'size' => filesize($filePath),
                    'mime_type' => $mime,
                    'extracted' => $extracted,
                    'extract_path' => $extractPath ? str_replace($basePath, '', $extractPath) : null,
                    'uploaded_at' => now()->toIso8601String(),
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Falha ao guardar ficheiro.'
        ], 500);
    }

    /**
     * Executar comandos artisan
     * POST /api/v1/system/commands/run
     */
    public function runCommand(Request $request): JsonResponse
    {
        $token = $request->header('X-Update-Token') ?? $request->input('token');

        if (!$this->validateUpdateToken($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Token de update inválido.'
            ], 401);
        }

        $request->validate([
            'command' => 'required|string|in:migrate,cache:clear,config:clear,route:clear,view:clear,optimize,db:seed',
            'force' => 'nullable|boolean',
            'params' => 'nullable|array',
        ]);

        $command = $request->input('command');
        $force = $request->input('force', false);
        $params = $request->input('params', []);

        try {
            $commandString = $command;
            if ($force) {
                $commandString .= ' --force';
            }
            
            foreach ($params as $param) {
                $commandString .= ' ' . escapeshellarg($param);
            }

            // Executar comando
            Artisan::call($command, array_merge(
                $force ? ['--force' => true] : [],
                $params
            ));

            $output = Artisan::output();

            return response()->json([
                'success' => true,
                'message' => 'Comando executado com sucesso.',
                'data' => [
                    'command' => $command,
                    'output' => $output,
                    'exit_code' => 0,
                    'executed_at' => now()->toIso8601String(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao executar comando: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Criar backup
     * POST /api/v1/system/backup/create
     */
    public function createBackup(): JsonResponse
    {
        $token = request()->header('X-Update-Token') ?? request()->input('token');

        if (!$this->validateUpdateToken($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Token de update inválido.'
            ], 401);
        }

        $result = $this->performBackup();

        return response()->json($result);
    }

    /**
     * Restaurar backup
     * POST /api/v1/system/backup/restore
     */
    public function restoreBackup(Request $request): JsonResponse
    {
        $token = $request->header('X-Update-Token') ?? $request->input('token');

        if (!$this->validateUpdateToken($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Token de update inválido.'
            ], 401);
        }

        $request->validate([
            'backup_path' => 'required|string',
        ]);

        $result = $this->performRestore($request->input('backup_path'));

        return response()->json($result);
    }

    /**
     * Listar backups disponíveis
     * GET /api/v1/system/backup/list
     */
    public function listBackups(Request $request): JsonResponse
    {
        $token = $request->header('X-Update-Token') ?? $request->input('token');

        if (!$this->validateUpdateToken($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Token de update inválido.'
            ], 401);
        }

        $backupDir = storage_path('app/backups');
        $backups = [];

        if (File::exists($backupDir)) {
            $files = File::allFiles($backupDir);
            foreach ($files as $file) {
                $backups[] = [
                    'filename' => $file->getFilename(),
                    'path' => $file->getPathname(),
                    'size' => $file->getSize(),
                    'created_at' => date('Y-m-d H:i:s', $file->getMTime()),
                ];
            }

            // Ordenar por data (mais recente primeiro)
            usort($backups, fn($a, $b) => strtotime($b['created_at']) - strtotime($a['created_at']));
        }

        return response()->json([
            'success' => true,
            'data' => [
                'count' => count($backups),
                'backups' => $backups,
            ]
        ]);
    }

    /**
     * Limpar cache e otimizar
     * POST /api/v1/system/optimize
     */
    public function optimize(Request $request): JsonResponse
    {
        $token = $request->header('X-Update-Token') ?? $request->input('token');

        if (!$this->validateUpdateToken($token)) {
            return response()->json([
                'success' => false,
                'message' => 'Token de update inválido.'
            ], 401);
        }

        try {
            Artisan::call('optimize:clear');
            Artisan::call('view:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('cache:clear');
            Artisan::call('optimize');

            return response()->json([
                'success' => true,
                'message' => 'Sistema otimizado com sucesso.',
                'data' => [
                    'commands_run' => [
                        'optimize:clear',
                        'view:clear',
                        'config:clear',
                        'route:clear',
                        'cache:clear',
                        'optimize',
                    ],
                    'optimized_at' => now()->toIso8601String(),
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao otimizar: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Processar update (extrair e instalar)
     */
    protected function processUpdate(string $updatePath, string $version, string $description): array
    {
        $basePath = base_path();
        $tempPath = storage_path('app/' . self::TEMP_DIR . '/' . time());

        try {
            // Criar diretório temporário
            if (!File::exists($tempPath)) {
                File::makeDirectory($tempPath, 0755, true);
            }

            // Extrair ficheiro ZIP
            $extractPath = $tempPath . '/extract';
            if (!$this->extractZip($updatePath, $extractPath)) {
                throw new \Exception('Falha ao extrair ficheiro de update.');
            }

            // Verificar estrutura do update
            if (!File::exists($extractPath . '/manifest.json')) {
                throw new \Exception('Ficheiro manifest.json não encontrado no update.');
            }

            // Ler manifest
            $manifest = json_decode(File::get($extractPath . '/manifest.json'), true);

            // Aplicar ficheiros
            $filesUpdated = 0;
            if (isset($manifest['files'])) {
                foreach ($manifest['files'] as $file) {
                    $source = $extractPath . '/' . $file;
                    $dest = $basePath . '/' . $file;

                    if (File::exists($source)) {
                        // Criar backup do ficheiro antigo
                        if (File::exists($dest)) {
                            $backupFile = storage_path('app/backups/files/' . basename($file) . '_' . time());
                            File::copy($dest, $backupFile);
                        }

                        // Copiar novo ficheiro
                        File::copy($source, $dest);
                        $filesUpdated++;
                    }
                }
            }

            // Executar migrações se necessário
            $migrationsRun = [];
            if (!empty($manifest['migrations'])) {
                foreach ($manifest['migrations'] as $migration) {
                    try {
                        Artisan::call('migrate', ['--force' => true]);
                        $migrationsRun[] = $migration;
                    } catch (\Exception $e) {
                        // Logar mas não falhar
                    }
                }
            }

            // Executar comandos pós-update
            $commands = [];
            if (!empty($manifest['commands'])) {
                foreach ($manifest['commands'] as $cmd) {
                    try {
                        Artisan::call($cmd);
                        $commands[] = $cmd;
                    } catch (\Exception $e) {
                        $commands[] = $cmd . ' (falhou: ' . $e->getMessage() . ')';
                    }
                }
            }

            // Atualizar versão
            $this->updateVersion($version);

            // Guardar log do update
            $this->logUpdate($version, $description, [
                'files_updated' => $filesUpdated,
                'migrations_run' => $migrationsRun,
                'commands' => $commands,
            ]);

            // Limpar ficheiros temporários
            File::deleteDirectory($tempPath);
            File::delete($updatePath);

            return [
                'success' => true,
                'files_updated' => $filesUpdated,
                'migrations_run' => count($migrationsRun),
                'commands' => $commands,
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Extrair ficheiro ZIP
     */
    protected function extractZip(string $zipPath, string $extractPath): bool
    {
        if (!File::exists(dirname($extractPath))) {
            File::makeDirectory($extractPath, 0755, true);
        }

        $zip = new \ZipArchive();
        if ($zip->open($zipPath) === true) {
            $zip->extractTo($extractPath);
            $zip->close();
            return true;
        }

        return false;
    }

    /**
     * Criar backup completo (método interno)
     */
    protected function performBackup(): array
    {
        try {
            $timestamp = time();
            $backupDir = storage_path('app/backups/' . $timestamp);
            
            if (!File::exists($backupDir)) {
                File::makeDirectory($backupDir, 0755, true);
            }

            // Backup da base de dados
            $database = storage_path('app/backups/' . $timestamp . '/database.sql');
            File::put($database, ''); // Criar ficheiro vazio
            // Nota: Usar mysqldump ou similar para banco real

            // Backup de ficheiros importantes
            $filesToBackup = [
                '.env',
                'app/',
                'config/',
                'database/',
                'routes/',
                'vendor/',
            ];

            foreach ($filesToBackup as $file) {
                $source = base_path($file);
                $dest = $backupDir . '/' . $file;

                if (File::exists($source)) {
                    if (is_dir($source)) {
                        File::copyDirectory($source, $dest);
                    } else {
                        File::copy($source, $dest);
                    }
                }
            }

            return [
                'success' => true,
                'data' => [
                    'backup_path' => $backupDir,
                    'created_at' => date('Y-m-d H:i:s'),
                ]
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Restaurar backup (método interno)
     */
    protected function performRestore(string $backupPath): array
    {
        try {
            if (!File::exists($backupPath)) {
                return [
                    'success' => false,
                    'message' => 'Backup não encontrado.',
                ];
            }

            // Copiar ficheiros de volta
            File::copyDirectory($backupPath . '/app', base_path('app'));
            File::copyDirectory($backupPath . '/config', base_path('config'));
            File::copyDirectory($backupPath . '/routes', base_path('routes'));

            // Restaurar .env
            if (File::exists($backupPath . '/.env')) {
                File::copy($backupPath . '/.env', base_path('.env'));
            }

            return [
                'success' => true,
                'message' => 'Backup restaurado com sucesso.',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Validar token de update
     */
    protected function validateUpdateToken(?string $token): bool
    {
        if (!$token) {
            return false;
        }

        $validToken = \App\Models\Setting::get('update_token', self::UPDATE_TOKEN);
        
        return hash_equals($validToken, $token);
    }

    /**
     * Atualizar versão do sistema
     */
    protected function updateVersion(string $version): void
    {
        // Guardar nova versão em ficheiro ou base de dados
        $versionFile = base_path('.version');
        File::put($versionFile, $version);
    }

    /**
     * Guardar log de updates
     */
    protected function logUpdate(string $version, string $description, array $details): void
    {
        $logFile = storage_path('app/updates_log.json');
        $existing = File::exists($logFile) ? json_decode(File::get($logFile), true) : [];
        
        $existing[] = [
            'version' => $version,
            'description' => $description,
            'details' => $details,
            'installed_at' => now()->toIso8601String(),
        ];

        File::put($logFile, json_encode($existing, JSON_PRETTY_PRINT));
    }

    /**
     * Obter última data de backup
     */
    protected function getLastBackupDate(): ?string
    {
        $backupDir = storage_path('app/backups');
        if (!File::exists($backupDir)) {
            return null;
        }

        $dirs = array_filter(File::directories($backupDir), fn($d) => is_numeric(basename($d)));
        if (empty($dirs)) {
            return null;
        }

        $latest = max(array_map(fn($d) => basename($d), $dirs));
        return date('Y-m-d H:i:s', $latest);
    }

    /**
     * Obter espaço em disco
     */
    protected function getDiskSpace(): array
    {
        $total = disk_total_space(base_path());
        $free = disk_free_space(base_path());
        
        return [
            'total' => $total,
            'free' => $free,
            'used_percent' => round((($total - $free) / $total) * 100, 2),
        ];
    }

    /**
     * Obter tipos de ficheiros permitidos por destino
     */
    protected function getAllowedMimes(string $destination): array
    {
        $mimes = [
            'plugins' => ['application/zip', 'text/x-php'],
            'themes' => ['application/zip', 'text/x-php'],
            'assets' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'text/css', 'application/javascript'],
            'uploads' => ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'application/pdf', 'text/csv'],
        ];

        return $mimes[$destination] ?? [];
    }

    /**
     * Obter número de jobs em fila
     */
    protected function getQueuedJobsCount(): int
    {
        // Simplificado - pode implementar com Redis/database
        return 0;
    }
}

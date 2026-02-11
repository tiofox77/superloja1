<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateApiTokenCommand extends Command
{
    protected $signature = 'api:generate-token {--show : Only show current token without generating a new one}';
    protected $description = 'Gerar ou exibir o token de autenticação da API';

    public function handle(): int
    {
        if ($this->option('show')) {
            $token = Setting::get('api_token');
            if ($token) {
                $this->info("Token atual: {$token}");
            } else {
                $this->warn('Nenhum token configurado. Execute sem --show para gerar.');
            }
            return self::SUCCESS;
        }

        $token = Str::random(64);

        Setting::set(
            key: 'api_token',
            value: $token,
            type: 'string',
            group: 'api',
            label: 'API Token',
            description: 'Token de autenticação para acesso à API REST'
        );

        $this->info('Token API gerado com sucesso!');
        $this->newLine();
        $this->line("Token: <comment>{$token}</comment>");
        $this->newLine();
        $this->info('Use no header: Authorization: Bearer ' . $token);

        return self::SUCCESS;
    }
}

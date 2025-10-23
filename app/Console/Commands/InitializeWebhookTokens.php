<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SystemConfig;

class InitializeWebhookTokens extends Command
{
    protected $signature = 'webhook:init-tokens';
    protected $description = 'Inicializar tokens padrão para webhooks';

    public function handle()
    {
        $this->info('Inicializando tokens de webhook...');

        // Sempre forçar atualização se estiver vazio
        $fbToken = SystemConfig::get('facebook_verify_token');
        if (empty($fbToken)) {
            SystemConfig::set('facebook_verify_token', 'Popadic17', [
                'group' => 'facebook',
                'type' => 'string',
                'is_encrypted' => true,
                'label' => 'Facebook Verify Token',
                'description' => 'Token de verificação para webhooks do Facebook',
            ]);
            $this->info('✓ Token do Facebook atualizado para: Popadic17');
        } else {
            $this->info('✓ Token do Facebook já configurado: ' . $fbToken);
        }

        // Instagram
        $igToken = SystemConfig::get('instagram_verify_token');
        if (empty($igToken)) {
            SystemConfig::set('instagram_verify_token', 'Popadic17', [
                'group' => 'instagram',
                'type' => 'string',
                'is_encrypted' => true,
                'label' => 'Instagram Verify Token',
                'description' => 'Token de verificação para webhooks do Instagram',
            ]);
            $this->info('✓ Token do Instagram atualizado para: Popadic17');
        } else {
            $this->info('✓ Token do Instagram já configurado: ' . $igToken);
        }

        $this->info('');
        $this->info('Tokens inicializados com sucesso!');
        
        return 0;
    }
}

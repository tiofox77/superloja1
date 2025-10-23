<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AiIntegrationToken;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ConfigureInstagramToken extends Command
{
    protected $signature = 'instagram:configure';
    protected $description = 'Configurar e testar token do Instagram';

    public function handle()
    {
        $this->info('🔧 Configurando Token do Instagram...');
        
        // Dados fornecidos
        $accessToken = 'EAAX22PMnYEABPgusgYzMwjk8SsCaiuOcWZAfAK5GiDj8SN6znBYPZCE64hNPdWdHt8t2DUZB6pcIgrukeqYGjTpvZBkjzXP41iTCf4QuyXGXu6B72TttPG7BS2Gaizg3VzW2UZAUQienwD2LJqvE3mkbyeySbdUm54awq7ZASJ1EfG18u0gZBu7rp8pMMLK7V9pwJ3HpnaVLQmnZCUDqlSeavzvIIZA3gK6PtOeif5wZDZD';
        $instagramAccountId = '17841464824215251';
        $pageId = '230190170178019';
        $pageName = 'Superloja';
        
        // Salvar no banco
        $this->info('💾 Salvando token no banco de dados...');
        
        AiIntegrationToken::updateOrCreate(
            ['platform' => 'instagram'],
            [
                'access_token' => $accessToken,
                'page_id' => $instagramAccountId,
                'page_name' => $pageName,
                'is_active' => true,
                'expires_at' => null, // Page tokens não expiram
            ]
        );
        
        $this->info('✅ Token salvo com sucesso!');
        $this->newLine();
        
        // Verificar token
        $this->info('🔍 Verificando token...');
        
        $debugResponse = Http::get('https://graph.facebook.com/v18.0/debug_token', [
            'input_token' => $accessToken,
            'access_token' => $accessToken,
        ]);
        
        if ($debugResponse->successful()) {
            $data = $debugResponse->json('data');
            
            $this->table(
                ['Campo', 'Valor'],
                [
                    ['Tipo', $data['type'] ?? 'N/A'],
                    ['App ID', $data['app_id'] ?? 'N/A'],
                    ['Válido', $data['is_valid'] ? 'SIM' : 'NÃO'],
                    ['Expira', isset($data['expires_at']) ? date('d/m/Y H:i', $data['expires_at']) : 'Nunca'],
                ]
            );
        }
        
        $this->newLine();
        
        // Testar conexão com Instagram
        $this->info('📱 Testando conexão com Instagram...');
        
        $instagramResponse = Http::get("https://graph.facebook.com/v18.0/{$instagramAccountId}", [
            'fields' => 'id,username,name,profile_picture_url',
            'access_token' => $accessToken,
        ]);
        
        if ($instagramResponse->successful()) {
            $instagram = $instagramResponse->json();
            
            $this->info('✅ Conectado ao Instagram:');
            $this->table(
                ['Campo', 'Valor'],
                [
                    ['ID', $instagram['id'] ?? 'N/A'],
                    ['Username', $instagram['username'] ?? 'N/A'],
                    ['Nome', $instagram['name'] ?? 'N/A'],
                ]
            );
        } else {
            $this->error('❌ Erro ao conectar com Instagram:');
            $this->error(json_encode($instagramResponse->json(), JSON_PRETTY_PRINT));
        }
        
        $this->newLine();
        
        // Testar envio de mensagem (teste simulado)
        $this->info('🧪 Teste de envio de mensagem...');
        $this->warn('⚠️  Para testar realmente, envie uma mensagem via Instagram primeiro!');
        
        $this->newLine();
        $this->info('📊 Configuração completa!');
        
        // Mostrar comandos úteis
        $this->newLine();
        $this->info('📝 Comandos úteis:');
        $this->line('  - Ver logs: tail -f storage/logs/laravel.log');
        $this->line('  - Testar webhook: Envie mensagem pelo Instagram');
        $this->line('  - Ver token no DB: php artisan tinker → AiIntegrationToken::where("platform", "instagram")->first()');
        
        $this->newLine();
        $this->info('✅ PRONTO! Envie uma mensagem pelo Instagram para testar!');
        
        return 0;
    }
}

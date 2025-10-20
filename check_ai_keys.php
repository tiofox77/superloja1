<?php

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\SystemConfig;

echo "=== Verificação de API Keys no BD ===\n\n";

// Verificar se as configurações existem
$configs = [
    'ai_provider' => 'AI Provider',
    'openai_api_key' => 'OpenAI API Key',
    'openai_model' => 'OpenAI Model',
    'claude_api_key' => 'Claude API Key',
    'claude_model' => 'Claude Model',
];

foreach ($configs as $key => $label) {
    $exists = SystemConfig::has($key);
    $value = SystemConfig::get($key, 'não definido');
    
    echo "[$label]\n";
    echo "  - Existe: " . ($exists ? "✅ SIM" : "❌ NÃO") . "\n";
    
    if ($exists) {
        // Não exibir API Keys por segurança
        if (strpos($key, 'api_key') !== false) {
            echo "  - Valor: [OCULTO - API KEY]\n";
        } else {
            echo "  - Valor: $value\n";
        }
    }
    echo "\n";
}

// Verificar todas as configs do grupo 'ai'
echo "=== Todas configurações do grupo 'ai' ===\n\n";
$aiConfigs = \DB::table('system_configs')->where('group', 'ai')->get();

if ($aiConfigs->count() > 0) {
    foreach ($aiConfigs as $config) {
        echo "- {$config->key}: ";
        if (strpos($config->key, 'api_key') !== false) {
            echo "[OCULTO]\n";
        } else {
            echo "{$config->value}\n";
        }
    }
} else {
    echo "❌ Nenhuma configuração encontrada no grupo 'ai'\n";
}

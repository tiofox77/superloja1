<?php

require_once __DIR__ . '/vendor/autoload.php';

use Uni\UniClient;
use Uni\UniException;

echo "🚀 Teste Rápido SDK Unimtx\n";
echo "========================\n\n";

// Configurar variáveis de ambiente
$accessKey = '5w85m6dWZs4Ue97z7EvL23';
$phoneNumber = '+244939729902';
$message = 'Teste SMS SuperLoja via SDK - ' . date('H:i:s');

putenv('UNIMTX_ACCESS_KEY_ID=' . $accessKey);

echo "📱 Número: {$phoneNumber}\n";
echo "💬 Mensagem: {$message}\n";
echo "🔑 Access Key: " . substr($accessKey, 0, 4) . '...' . substr($accessKey, -4) . "\n\n";

try {
    echo "🔧 Inicializando cliente...\n";
    
    // Tentar com simple auth (sem secret)
    $client = new UniClient([
        'accessKeyId' => $accessKey
        // Omitindo accessKeySecret para simple auth
    ]);
    
    echo "✅ Cliente inicializado com sucesso\n\n";
    
    echo "📤 Enviando SMS...\n";
    
    // Tentar primeiro sem signature
    echo "📤 Tentando enviar SMS sem signature...\n";
    
    $response = $client->messages->send([
        'to' => $phoneNumber,
        'text' => $message
    ]);
    
    echo "🎉 SMS ENVIADO COM SUCESSO!\n";
    echo "📋 Resposta da API:\n";
    var_dump($response);
    
    if (isset($response->data)) {
        echo "\n📊 Detalhes:\n";
        echo "ID: " . ($response->data->id ?? 'N/A') . "\n";
        echo "Status: " . ($response->data->status ?? 'N/A') . "\n";
        echo "Para: " . ($response->data->to ?? 'N/A') . "\n";
    }
    
} catch (UniException $e) {
    echo "❌ Erro Unimtx:\n";
    echo "Código: " . $e->getCode() . "\n";
    echo "Mensagem: " . $e->getMessage() . "\n";
    
    // Tentar com variável de ambiente apenas
    echo "\n🔄 Tentando com configuração de ambiente...\n";
    
    try {
        $client2 = new UniClient(); // Usar configuração de ambiente
        
        $response2 = $client2->messages->send([
            'to' => $phoneNumber,
            'text' => $message . ' (env)'
        ]);
        
        echo "🎉 SMS ENVIADO COM SUCESSO (ambiente)!\n";
        var_dump($response2);
        
    } catch (UniException $e2) {
        echo "❌ Erro com ambiente:\n";
        echo "Código: " . $e2->getCode() . "\n";
        echo "Mensagem: " . $e2->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "💥 Erro geral: " . $e->getMessage() . "\n";
}

echo "\n========================\n";
echo "✅ Teste finalizado\n";

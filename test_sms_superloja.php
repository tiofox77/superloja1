<?php

require_once __DIR__ . '/vendor/autoload.php';

use Uni\UniClient;
use Uni\UniException;

echo "🚀 Teste SMS com Sender SUPERLOJA Aprovado\n";
echo "==========================================\n\n";

// Configurações
$accessKey = '5w85m6dWZs4Ue97z7EvL23';
$phoneNumber = '+244939729902';
$senderName = 'SUPERLOJA'; // Sender aprovado
$message = 'Ola! Teste de SMS da SUPERLOJA Angola. Pedido #12345 confirmado. Obrigado pela preferencia!';

echo "📱 Número Destino: {$phoneNumber}\n";
echo "📤 Sender: {$senderName}\n";
echo "💬 Mensagem: {$message}\n";
echo "🔑 Access Key: " . substr($accessKey, 0, 4) . '...' . substr($accessKey, -4) . "\n\n";

// Configurar variável de ambiente
putenv('UNIMTX_ACCESS_KEY_ID=' . $accessKey);

try {
    echo "🔧 Inicializando cliente Unimtx...\n";
    
    // Inicializar cliente (simple auth mode - sem secret)
    $client = new UniClient([
        'accessKeyId' => $accessKey
    ]);
    
    echo "✅ Cliente inicializado com sucesso!\n\n";
    
    echo "📤 Enviando SMS com sender SUPERLOJA...\n";
    
    // Enviar SMS com signature (sender name)
    $response = $client->messages->send([
        'to' => $phoneNumber,
        'signature' => $senderName,
        'text' => $message
    ]);
    
    echo "\n🎉 SMS ENVIADO COM SUCESSO!\n";
    echo "================================\n\n";
    
    // Exibir resposta completa
    echo "📋 Resposta da API Unimtx:\n";
    var_dump($response);
    
    if (isset($response->data)) {
        echo "\n📊 DETALHES DO ENVIO:\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "🆔 Message ID: " . ($response->data->id ?? 'N/A') . "\n";
        echo "📱 Para: " . ($response->data->to ?? 'N/A') . "\n";
        echo "📤 De: " . ($response->data->from ?? $senderName) . "\n";
        echo "📊 Status: " . ($response->data->status ?? 'N/A') . "\n";
        echo "💰 Preço: " . ($response->data->price ?? 'N/A') . "\n";
        echo "🌍 ISO: " . ($response->data->iso ?? 'N/A') . "\n";
        echo "⏰ Criado: " . ($response->data->dateCreated ?? date('Y-m-d H:i:s')) . "\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    }
    
    echo "\n✅ Verifique se o SMS chegou no dispositivo com o sender 'SUPERLOJA'\n";
    
} catch (UniException $e) {
    echo "\n❌ ERRO UNIMTX:\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "Código: " . $e->getCode() . "\n";
    echo "Mensagem: " . $e->getMessage() . "\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";
    
    // Análise de erros comuns
    $code = $e->getCode();
    $message = $e->getMessage();
    
    echo "💡 DIAGNÓSTICO:\n";
    
    if ($code === 107121 || strpos($message, 'SmsSignatureNotExists') !== false) {
        echo "⚠️  O sender 'SUPERLOJA' pode não estar aprovado ainda.\n";
        echo "📝 Verifique no painel Unimtx se o sender está ativo.\n";
        echo "🔗 https://console.unimtx.com/sms/senders\n";
    } elseif ($code === 107141 || strpos($message, 'SmsTemplateNotExists') !== false) {
        echo "⚠️  Erro de template. Tentando enviar sem template...\n";
    } elseif ($code === 40100 || strpos($message, 'invalid access key') !== false) {
        echo "⚠️  Access Key inválida ou expirada.\n";
    } elseif ($code === 40300 || strpos($message, 'forbidden') !== false) {
        echo "⚠️  Acesso negado. Verifique permissões da Access Key.\n";
    } else {
        echo "⚠️  Erro desconhecido. Verifique logs da Unimtx.\n";
    }
    
    // Tentar envio com HTTP direto (fallback)
    echo "\n🔄 Tentando envio via HTTP direto (fallback)...\n";
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://api.unimtx.com/v1/messages',
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode([
            'to' => $phoneNumber,
            'signature' => $senderName,
            'text' => $message
        ]),
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $accessKey,
            'Content-Type: application/json'
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30
    ]);
    
    $httpResponse = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    echo "HTTP Status: {$httpCode}\n";
    echo "Resposta: {$httpResponse}\n";
    
    $data = json_decode($httpResponse, true);
    if ($httpCode === 200 && isset($data['code']) && $data['code'] === 0) {
        echo "\n✅ SMS ENVIADO VIA HTTP com sender SUPERLOJA!\n";
        print_r($data);
    } else {
        echo "\n⚠️  Resposta HTTP:\n";
        print_r($data);
    }
    
} catch (Exception $e) {
    echo "\n💥 ERRO GERAL:\n";
    echo "Mensagem: " . $e->getMessage() . "\n";
    echo "Arquivo: " . $e->getFile() . "\n";
    echo "Linha: " . $e->getLine() . "\n";
}

echo "\n==========================================\n";
echo "✅ Teste finalizado - " . date('d/m/Y H:i:s') . "\n";

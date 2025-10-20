<?php

echo "🚀 Teste SMS SIMPLES com Sender SUPERLOJA\n";
echo "=========================================\n\n";

// Configurações hardcoded
$accessKey = '5w85m6dWZs4Ue97z7EvL23';
$senderName = 'SUPERLOJA';
$phoneNumber = '+244939729902';
$message = 'Teste da SUPERLOJA Angola. Seu pedido foi confirmado! Obrigado pela preferencia.';

echo "📱 Para: {$phoneNumber}\n";
echo "📤 De: {$senderName}\n";
echo "💬 Mensagem: {$message}\n\n";

echo "📤 Enviando SMS via API Unimtx...\n";

$data = json_encode([
    'to' => $phoneNumber,
    'signature' => $senderName,
    'text' => $message
]);

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.unimtx.com/v1/messages',
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $data,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $accessKey,
        'Content-Type: application/json'
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => true,
]);

$startTime = microtime(true);
$response = curl_exec($ch);
$endTime = microtime(true);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

$duration = round(($endTime - $startTime) * 1000, 2);

if ($error) {
    echo "❌ Erro cURL: {$error}\n";
    exit(1);
}

echo "⏱️  Tempo de resposta: {$duration}ms\n";
echo "📊 HTTP Status: {$httpCode}\n\n";

$responseData = json_decode($response, true);

if ($httpCode === 200) {
    echo "✅ Resposta da API:\n";
    print_r($responseData);
    
    if (isset($responseData['code']) && $responseData['code'] == 0) {
        echo "\n🎉 SMS ENVIADO COM SUCESSO!\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
        echo "✅ O SMS foi enviado para {$phoneNumber}\n";
        echo "✅ Sender exibido será: {$senderName}\n";
        echo "✅ Verifique o dispositivo!\n";
        echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    } else {
        echo "\n⚠️  API retornou código diferente de sucesso:\n";
        echo "Código: " . ($responseData['code'] ?? 'N/A') . "\n";
        echo "Mensagem: " . ($responseData['message'] ?? 'N/A') . "\n";
    }
} else {
    echo "❌ ERRO NO ENVIO\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    echo "HTTP Status: {$httpCode}\n";
    echo "Resposta: {$response}\n";
    echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
    
    if (isset($responseData['message'])) {
        echo "\n💡 Mensagem de erro: " . $responseData['message'] . "\n";
    }
}

echo "\n=========================================\n";
echo "✅ Teste finalizado - " . date('d/m/Y H:i:s') . "\n";

<?php

echo "🚀 Teste HTTP Direto Unimtx\n";
echo "==========================\n\n";

$accessKey = '5w85m6dWZs4Ue97z7EvL23';
$apiUrl = 'https://api.unimtx.com/v1/messages';
$phoneNumber = '+244939729902';
$message = 'Teste SMS SuperLoja HTTP - ' . date('H:i:s');

echo "📱 Número: {$phoneNumber}\n";
echo "💬 Mensagem: {$message}\n";
echo "🔗 API URL: {$apiUrl}\n";
echo "🔑 Access Key: " . substr($accessKey, 0, 4) . '...' . substr($accessKey, -4) . "\n\n";

$data = [
    'to' => $phoneNumber,
    'text' => $message
];

$headers = [
    'Authorization: Bearer ' . $accessKey,
    'Content-Type: application/json'
];

echo "📤 Enviando SMS via cURL...\n";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_SSL_VERIFYPEER => true,
    CURLOPT_VERBOSE => false
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$error = curl_error($ch);
curl_close($ch);

if ($error) {
    echo "❌ Erro cURL: {$error}\n";
} else {
    echo "📊 Código HTTP: {$httpCode}\n";
    echo "📋 Resposta:\n";
    
    $decodedResponse = json_decode($response, true);
    if ($decodedResponse) {
        print_r($decodedResponse);
        
        if ($httpCode >= 200 && $httpCode < 300) {
            echo "\n🎉 SMS ENVIADO COM SUCESSO!\n";
            
            if (isset($decodedResponse['data']['id'])) {
                echo "📨 ID da Mensagem: " . $decodedResponse['data']['id'] . "\n";
            }
            if (isset($decodedResponse['data']['status'])) {
                echo "📊 Status: " . $decodedResponse['data']['status'] . "\n";
            }
        } else {
            echo "\n❌ ERRO NO ENVIO\n";
            
            if (isset($decodedResponse['message'])) {
                echo "💬 Mensagem de erro: " . $decodedResponse['message'] . "\n";
            }
            if (isset($decodedResponse['code'])) {
                echo "🔢 Código de erro: " . $decodedResponse['code'] . "\n";
            }
        }
    } else {
        echo "Resposta bruta: {$response}\n";
    }
}

echo "\n==========================\n";
echo "✅ Teste finalizado\n";

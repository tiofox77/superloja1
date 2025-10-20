<?php

echo "🚀 Teste SMS - 3 Métodos Unimtx\n";
echo "=================================\n\n";

$accessKey = '5w85m6dWZs4Ue97z7EvL23';
$senderName = 'SUPERLOJA';
$phoneNumber = '+244939729902';
$apiUrl = 'https://api.unimtx.com/v1/messages';

echo "📱 Número: {$phoneNumber}\n";
echo "📤 Sender: {$senderName}\n";
echo "🔑 Access Key: " . substr($accessKey, 0, 4) . '...' . substr($accessKey, -4) . "\n\n";

// ===================================================
// MÉTODO 1: CONTENT (Recomendado - Unimtx junta automaticamente)
// ===================================================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📝 MÉTODO 1: CONTENT\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "💡 Unimtx junta automaticamente: [{$senderName}] + mensagem\n\n";

$message1 = "Seu pedido #12345 foi confirmado! Total: 25.000 Kz. Entrega em 3 dias uteis.";

$payload1 = json_encode([
    'to' => $phoneNumber,
    'signature' => $senderName,
    'content' => $message1
]);

echo "📤 Enviando com CONTENT...\n";
echo "Mensagem: {$message1}\n";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $payload1,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $accessKey,
        'Content-Type: application/json'
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30
]);

$response1 = curl_exec($ch);
$httpCode1 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$data1 = json_decode($response1, true);

if ($httpCode1 === 200 && isset($data1['code']) && $data1['code'] == 0) {
    echo "✅ SUCESSO! HTTP {$httpCode1}\n";
    echo "📨 Aparecerá como: [{$senderName}] {$message1}\n";
} else {
    echo "❌ ERRO! HTTP {$httpCode1}\n";
    print_r($data1);
}

echo "\n";
sleep(2);

// ===================================================
// MÉTODO 2: TEXT (Texto completo - você controla tudo)
// ===================================================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📝 MÉTODO 2: TEXT\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "💡 Você controla 100% do texto enviado\n\n";

$message2 = "[SUPERLOJA] Promocao especial! 30% de desconto em todos os produtos. Valido ate amanha!";

$payload2 = json_encode([
    'to' => $phoneNumber,
    'text' => $message2
]);

echo "📤 Enviando com TEXT...\n";
echo "Mensagem: {$message2}\n";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $payload2,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $accessKey,
        'Content-Type: application/json'
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30
]);

$response2 = curl_exec($ch);
$httpCode2 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$data2 = json_decode($response2, true);

if ($httpCode2 === 200 && isset($data2['code']) && $data2['code'] == 0) {
    echo "✅ SUCESSO! HTTP {$httpCode2}\n";
    echo "📨 Aparecerá exatamente como: {$message2}\n";
} else {
    echo "❌ ERRO! HTTP {$httpCode2}\n";
    print_r($data2);
}

echo "\n";
sleep(2);

// ===================================================
// MÉTODO 3: TEMPLATE (Para OTP e mensagens padronizadas)
// ===================================================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📝 MÉTODO 3: TEMPLATE\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "💡 Usa template público (pub_*) ou aprovado\n\n";

// Usando template público de verificação
$templateId = 'pub_verif_en_basic2'; // Template público sem auditoria
$verificationCode = rand(1000, 9999);

$payload3 = json_encode([
    'to' => $phoneNumber,
    'signature' => $senderName,
    'templateId' => $templateId,
    'templateData' => [
        'code' => (string)$verificationCode
    ]
]);

echo "📤 Enviando com TEMPLATE...\n";
echo "Template: {$templateId}\n";
echo "Código: {$verificationCode}\n";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $apiUrl,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $payload3,
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $accessKey,
        'Content-Type: application/json'
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30
]);

$response3 = curl_exec($ch);
$httpCode3 = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$data3 = json_decode($response3, true);

if ($httpCode3 === 200 && isset($data3['code']) && $data3['code'] == 0) {
    echo "✅ SUCESSO! HTTP {$httpCode3}\n";
    echo "📨 Template enviado com código: {$verificationCode}\n";
} else {
    echo "❌ ERRO! HTTP {$httpCode3}\n";
    print_r($data3);
}

// ===================================================
// RESUMO
// ===================================================
echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "📊 RESUMO DOS TESTES\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "1️⃣  CONTENT: " . ($httpCode1 === 200 ? "✅ OK" : "❌ ERRO") . " (Recomendado para uso geral)\n";
echo "2️⃣  TEXT: " . ($httpCode2 === 200 ? "✅ OK" : "❌ ERRO") . " (Controle total do texto)\n";
echo "3️⃣  TEMPLATE: " . ($httpCode3 === 200 ? "✅ OK" : "❌ ERRO") . " (OTP e mensagens padronizadas)\n\n";

echo "💡 RECOMENDAÇÕES:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "✅ Use CONTENT para pedidos e notificações gerais\n";
echo "✅ Use TEXT quando precisar de controle total da mensagem\n";
echo "✅ Use TEMPLATE para OTP e mensagens que se repetem\n\n";

echo "=================================\n";
echo "✅ Teste finalizado - " . date('d/m/Y H:i:s') . "\n";

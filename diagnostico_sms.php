<?php

echo "🔍 DIAGNÓSTICO SMS - SuperLoja Angola\n";
echo "=====================================\n\n";

$accessKey = '5w85m6dWZs4Ue97z7EvL23';
$senderName = 'SUPERLOJA';
$apiUrl = 'https://api.unimtx.com/v1/messages';

// Números para testar
$phones = [
    '+244939729902',
    '+244954949595'
];

echo "📱 Números a testar:\n";
foreach ($phones as $phone) {
    echo "   - {$phone}\n";
}
echo "\n";

// ===================================================
// 1. VERIFICAR STATUS DA CONTA
// ===================================================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "1️⃣  VERIFICANDO STATUS DA CONTA\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Tentar buscar informações da conta
$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.unimtx.com/v1/account',
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $accessKey,
        'Content-Type: application/json'
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30
]);

$accountResponse = curl_exec($ch);
$accountHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($accountHttpCode === 200) {
    $accountData = json_decode($accountResponse, true);
    echo "✅ Conta acessível\n";
    print_r($accountData);
} else {
    echo "⚠️  Não foi possível verificar a conta (HTTP {$accountHttpCode})\n";
    echo "Resposta: {$accountResponse}\n";
}

echo "\n";

// ===================================================
// 2. TESTAR ENVIO COM DETALHES COMPLETOS
// ===================================================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "2️⃣  TESTANDO ENVIO PARA AMBOS NÚMEROS\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

foreach ($phones as $index => $phone) {
    $num = $index + 1;
    echo "📱 TESTE {$num}/2: {$phone}\n";
    echo "─────────────────────────────────\n";
    
    $message = "Teste SUPERLOJA #{$num} - " . date('H:i:s');
    
    // Tentar com CONTENT primeiro
    $payload = json_encode([
        'to' => $phone,
        'signature' => $senderName,
        'content' => $message
    ], JSON_PRETTY_PRINT);
    
    echo "📤 Payload enviado:\n";
    echo $payload . "\n\n";
    
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => $apiUrl,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bearer ' . $accessKey,
            'Content-Type: application/json'
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_VERBOSE => false
    ]);
    
    $startTime = microtime(true);
    $response = curl_exec($ch);
    $endTime = microtime(true);
    
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);
    
    $duration = round(($endTime - $startTime) * 1000, 2);
    
    echo "⏱️  Tempo: {$duration}ms\n";
    echo "📊 HTTP: {$httpCode}\n";
    
    if ($curlError) {
        echo "❌ Erro cURL: {$curlError}\n";
    }
    
    $responseData = json_decode($response, true);
    
    echo "📋 Resposta completa:\n";
    print_r($responseData);
    echo "\n";
    
    if ($httpCode === 200 && isset($responseData['code'])) {
        if ($responseData['code'] == 0) {
            echo "✅ API retornou SUCESSO\n";
            
            // Verificar se tem dados adicionais
            if (isset($responseData['data'])) {
                echo "\n📊 Dados da mensagem:\n";
                foreach ($responseData['data'] as $key => $value) {
                    echo "   {$key}: {$value}\n";
                }
            }
        } else {
            echo "⚠️  API retornou código: {$responseData['code']}\n";
            echo "   Mensagem: " . ($responseData['message'] ?? 'N/A') . "\n";
        }
    } else {
        echo "❌ ERRO no envio\n";
    }
    
    echo "\n";
    
    if ($index < count($phones) - 1) {
        sleep(3); // Aguardar entre envios
    }
}

// ===================================================
// 3. VERIFICAR MENSAGENS ENVIADAS RECENTEMENTE
// ===================================================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "3️⃣  VERIFICANDO HISTÓRICO DE MENSAGENS\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => 'https://api.unimtx.com/v1/messages?limit=10',
    CURLOPT_HTTPHEADER => [
        'Authorization: Bearer ' . $accessKey,
        'Content-Type: application/json'
    ],
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 30
]);

$historyResponse = curl_exec($ch);
$historyHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($historyHttpCode === 200) {
    $historyData = json_decode($historyResponse, true);
    echo "✅ Histórico obtido (HTTP {$historyHttpCode})\n\n";
    
    if (isset($historyData['data']) && is_array($historyData['data'])) {
        echo "📨 Últimas mensagens:\n";
        foreach ($historyData['data'] as $msg) {
            echo "─────────────────────────────────\n";
            echo "ID: " . ($msg['id'] ?? 'N/A') . "\n";
            echo "Para: " . ($msg['to'] ?? 'N/A') . "\n";
            echo "Status: " . ($msg['status'] ?? 'N/A') . "\n";
            echo "Data: " . ($msg['dateCreated'] ?? 'N/A') . "\n";
            echo "Erro: " . ($msg['errorCode'] ?? 'Nenhum') . "\n";
        }
    } else {
        echo "📭 Nenhuma mensagem no histórico\n";
    }
} else {
    echo "⚠️  Não foi possível verificar histórico (HTTP {$historyHttpCode})\n";
    echo "Resposta: {$historyResponse}\n";
}

echo "\n";

// ===================================================
// POSSÍVEIS PROBLEMAS
// ===================================================
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "💡 POSSÍVEIS CAUSAS\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "1. 🏦 CONTA EM MODO TESTE/SANDBOX\n";
echo "   - Verificar no painel se a conta está em produção\n";
echo "   - https://console.unimtx.com\n\n";

echo "2. 💰 CRÉDITOS INSUFICIENTES\n";
echo "   - Verificar saldo da conta\n";
echo "   - SMS para Angola pode ter custo específico\n\n";

echo "3. 📱 NÚMEROS NÃO VERIFICADOS\n";
echo "   - Alguns provedores exigem verificação de números\n";
echo "   - Verificar lista de números permitidos\n\n";

echo "4. 🌍 RESTRIÇÕES REGIONAIS\n";
echo "   - SMS para Angola (+244) pode ter restrições\n";
echo "   - Verificar cobertura no painel Unimtx\n\n";

echo "5. 📤 SENDER NÃO APROVADO COMPLETAMENTE\n";
echo "   - Verificar status do sender 'SUPERLOJA'\n";
echo "   - https://console.unimtx.com/sms/senders\n\n";

echo "6. ⏰ DELAY NA ENTREGA\n";
echo "   - SMS pode demorar alguns minutos\n";
echo "   - Verificar novamente em 5-10 minutos\n\n";

echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "🔗 PRÓXIMOS PASSOS:\n";
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

echo "1. Acesse: https://console.unimtx.com\n";
echo "2. Verifique:\n";
echo "   ✓ Saldo da conta\n";
echo "   ✓ Status do sender 'SUPERLOJA'\n";
echo "   ✓ Logs de envio (Messages → History)\n";
echo "   ✓ Modo da conta (Sandbox vs Produção)\n";
echo "   ✓ Cobertura para Angola\n\n";

echo "3. Se tudo estiver OK, contate suporte Unimtx:\n";
echo "   📧 support@unimtx.com\n";
echo "   💬 Chat no console\n\n";

echo "=====================================\n";
echo "✅ Diagnóstico concluído - " . date('d/m/Y H:i:s') . "\n";

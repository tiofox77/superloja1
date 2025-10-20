<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Services\SmsService;
use App\Models\Setting;
use Illuminate\Support\Facades\Log;

// Simular ambiente Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "🚀 SuperLoja Angola - Teste SMS Direto\n";
echo "=====================================\n\n";

// Configurações
$phoneNumber = '+244939729902'; // Número da SuperLoja
$testMessage = 'Teste SMS SuperLoja Angola - ' . date('d/m/Y H:i:s');

echo "📱 Número: {$phoneNumber}\n";
echo "💬 Mensagem: {$testMessage}\n\n";

try {
    // Verificar configurações do banco
    echo "🔍 Verificando configurações...\n";
    
    $accessKey = Setting::get('unimtx_access_key');
    $smsEnabled = Setting::get('sms_enabled', true);
    
    echo "SMS Habilitado: " . ($smsEnabled ? '✅ Sim' : '❌ Não') . "\n";
    echo "Access Key: " . ($accessKey ? '✅ Configurada (' . substr($accessKey, -4) . ')' : '❌ Não configurada') . "\n\n";
    
    if (!$smsEnabled) {
        throw new Exception('SMS está desabilitado nas configurações');
    }
    
    if (!$accessKey) {
        throw new Exception('Access Key não configurada');
    }
    
    // Criar instância do serviço
    $smsService = new SmsService();
    
    // Teste de conectividade
    echo "🌐 Testando conectividade...\n";
    $testResult = $smsService->testConnection();
    
    if ($testResult['success']) {
        echo "✅ Conectividade OK: " . $testResult['message'] . "\n\n";
    } else {
        echo "⚠️ Problema conectividade: " . $testResult['message'] . "\n";
        
        // Perguntar se deve continuar
        echo "Continuar mesmo assim? (y/N): ";
        $handle = fopen("php://stdin", "r");
        $line = fgets($handle);
        fclose($handle);
        
        if (trim(strtolower($line)) !== 'y') {
            echo "❌ Teste cancelado\n";
            exit(1);
        }
        echo "\n";
    }
    
    // Tentar enviar SMS
    echo "📤 Enviando SMS...\n";
    
    $startTime = microtime(true);
    $result = $smsService->sendSms($phoneNumber, $testMessage);
    $endTime = microtime(true);
    
    $duration = round(($endTime - $startTime) * 1000, 2);
    
    if ($result) {
        echo "🎉 SMS ENVIADO COM SUCESSO!\n";
        echo "⏱️ Tempo de envio: {$duration}ms\n";
        echo "📱 Número: {$phoneNumber}\n";
        echo "💬 Mensagem: {$testMessage}\n";
        echo "⏰ Enviado em: " . date('d/m/Y H:i:s') . "\n\n";
        echo "🔍 Verifique se o SMS foi recebido no dispositivo.\n";
    } else {
        echo "❌ FALHA NO ENVIO DO SMS\n";
        echo "⏱️ Tempo tentativa: {$duration}ms\n";
        echo "💡 Verifique os logs: storage/logs/laravel.log\n";
    }
    
} catch (Exception $e) {
    echo "💥 ERRO: " . $e->getMessage() . "\n\n";
    
    $errorMsg = $e->getMessage();
    
    // Identificar tipo de erro
    if (str_contains($errorMsg, 'cURL error 28') || str_contains($errorMsg, 'timeout')) {
        echo "📊 DIAGNÓSTICO: Timeout\n";
        echo "💡 SOLUÇÃO: A API da Unimtx está lenta. Tente novamente em alguns minutos.\n";
    } elseif (str_contains($errorMsg, 'Could not resolve host')) {
        echo "📊 DIAGNÓSTICO: Problema DNS/Internet\n";
        echo "💡 SOLUÇÃO: Verifique sua conexão com a internet.\n";
    } elseif (str_contains($errorMsg, '401') || str_contains($errorMsg, 'Unauthorized')) {
        echo "📊 DIAGNÓSTICO: API Key inválida\n";
        echo "💡 SOLUÇÃO: Verifique se sua API Key da Unimtx está correta.\n";
    } elseif (str_contains($errorMsg, '403') || str_contains($errorMsg, 'Forbidden')) {
        echo "📊 DIAGNÓSTICO: Acesso negado\n";
        echo "💡 SOLUÇÃO: Sua API Key não tem permissão para enviar SMS.\n";
    } elseif (str_contains($errorMsg, 'API Key não configurada')) {
        echo "📊 DIAGNÓSTICO: Configuração faltante\n";
        echo "💡 SOLUÇÃO: Configure a API Key usando:\n";
        echo "    php artisan tinker\n";
        echo "    >>> App\\Models\\Setting::set('unimtx_api_key', 'sua_api_key', 'string', 'sms', 'API Key da Unimtx', null, true)\n";
    } else {
        echo "📊 DIAGNÓSTICO: Erro desconhecido\n";
        echo "💡 SOLUÇÃO: Verifique os logs para mais detalhes.\n";
    }
}

echo "\n=====================================\n";
echo "✅ Teste finalizado\n";

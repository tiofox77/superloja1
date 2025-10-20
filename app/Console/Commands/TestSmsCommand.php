<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SmsService;
use App\Models\Setting;

class TestSmsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:test {phone?} {--message=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Testar envio de SMS para um número específico';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Iniciando teste de SMS SuperLoja Angola');
        $this->info('=====================================');

        // Obter número do argumento ou usar padrão
        $phone = $this->argument('phone') ?: '939729902';
        $message = $this->option('message') ?: 'Teste SMS da SuperLoja Angola - ' . now()->format('d/m/Y H:i:s');

        // Formatear número se necessário
        if (!str_starts_with($phone, '+244')) {
            $phone = '+244' . ltrim($phone, '+244');
        }

        $this->info("📱 Número de teste: {$phone}");
        $this->info("💬 Mensagem: {$message}");
        $this->newLine();

        // Verificar configurações do banco
        $this->info('🔍 Verificando configurações no banco de dados...');
        
        $apiKey = Setting::get('unimtx_api_key');
        $signature = Setting::get('unimtx_signature');
        $smsEnabled = Setting::get('sms_enabled', true);

        $this->table(['Configuração', 'Valor', 'Status'], [
            ['SMS Habilitado', $smsEnabled ? 'Sim' : 'Não', $smsEnabled ? '✅' : '❌'],
            ['API Key', $apiKey ? '••••••••••••' . substr($apiKey, -4) : 'Não configurada', $apiKey ? '✅' : '❌'],
            ['Assinatura', $signature ?: 'Padrão (SuperLoja)', '✅'],
        ]);

        if (!$smsEnabled) {
            $this->error('❌ SMS está desabilitado nas configurações!');
            return Command::FAILURE;
        }

        if (!$apiKey) {
            $this->error('❌ API Key não configurada!');
            $this->info('💡 Configure usando: php artisan tinker');
            $this->info('    >>> App\\Models\\Setting::set("unimtx_api_key", "sua_api_key_aqui", "string", "sms", "API Key da Unimtx", null, true)');
            return Command::FAILURE;
        }

        $this->newLine();

        // Testar conectividade primeiro
        $this->info('🌐 Testando conectividade com API Unimtx...');
        
        try {
            $smsService = new SmsService();
            
            $this->withProgressBar([1], function () use ($smsService) {
                $testResult = $smsService->testConnection();
                $this->testResult = $testResult;
            });

            $this->newLine(2);

            if ($this->testResult['success']) {
                $this->info('✅ Conectividade OK: ' . $this->testResult['message']);
            } else {
                $this->warn('⚠️ Problema de conectividade: ' . $this->testResult['message']);
                
                if ($this->confirm('Continuar mesmo com problema de conectividade?', false)) {
                    $this->info('📤 Tentando envio direto...');
                } else {
                    return Command::FAILURE;
                }
            }

        } catch (\Exception $e) {
            $this->error('❌ Erro na verificação de conectividade: ' . $e->getMessage());
            
            if (!$this->confirm('Continuar mesmo assim?', false)) {
                return Command::FAILURE;
            }
        }

        $this->newLine();

        // Tentar enviar SMS
        $this->info('📤 Enviando SMS de teste...');
        
        try {
            $this->withProgressBar([1, 2, 3], function ($step) use ($smsService, $phone, $message) {
                if ($step === 1) {
                    sleep(1);
                } elseif ($step === 2) {
                    $this->sendResult = $smsService->sendSms($phone, $message);
                    sleep(1);
                } else {
                    sleep(1);
                }
            });

            $this->newLine(2);

            if ($this->sendResult) {
                $this->info('🎉 SMS enviado com sucesso!');
                $this->info("📱 Número: {$phone}");
                $this->info("💬 Mensagem: {$message}");
                $this->info('⏰ Enviado em: ' . now()->format('d/m/Y H:i:s'));
                
                $this->newLine();
                $this->info('🔍 Verifique se o SMS foi recebido no dispositivo.');
                
                return Command::SUCCESS;
                
            } else {
                $this->error('❌ Falha no envio do SMS!');
                $this->warn('💡 Verifique os logs para mais detalhes:');
                $this->info('    tail -f storage/logs/laravel.log');
                
                return Command::FAILURE;
            }

        } catch (\Exception $e) {
            $this->error('💥 Erro durante envio: ' . $e->getMessage());
            
            // Analisar tipo de erro
            $errorMsg = $e->getMessage();
            
            if (str_contains($errorMsg, 'cURL error 28') || str_contains($errorMsg, 'timeout')) {
                $this->warn('⏰ Erro de timeout - A API pode estar lenta');
                $this->info('💡 Tente novamente em alguns minutos');
            } elseif (str_contains($errorMsg, 'Could not resolve host')) {
                $this->warn('🌐 Problema de DNS/Internet');
                $this->info('💡 Verifique sua conexão com a internet');
            } elseif (str_contains($errorMsg, '401') || str_contains($errorMsg, 'Unauthorized')) {
                $this->warn('🔑 API Key inválida ou expirada');
                $this->info('💡 Verifique sua API Key da Unimtx');
            } elseif (str_contains($errorMsg, '403') || str_contains($errorMsg, 'Forbidden')) {
                $this->warn('🚫 Acesso negado');
                $this->info('💡 Verifique as permissões da sua API Key');
            } else {
                $this->warn('❓ Erro desconhecido');
            }

            return Command::FAILURE;
        }
    }

    private $testResult;
    private $sendResult;
}

<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\SmsTemplate;
use App\Models\Setting;
use Exception;

class SmsService
{
    private $accessKey;
    private $apiUrl;
    private $senderName;

    public function __construct()
    {
        // Buscar Access Key do banco primeiro, senão usar config
        $this->accessKey = Setting::get('unimtx_access_key') ?? config('services.unimtx.access_key');
        $this->apiUrl = 'https://api.unimtx.com/v1/messages';
        $this->senderName = 'SUPERLOJA'; // Sender aprovado na Unimtx
    }

    /**
     * Enviar SMS usando template
     */
    public function sendTemplateMessage(string $templateType, string $phoneNumber, array $variables = [])
    {
        try {
            // Buscar template
            $template = SmsTemplate::getByType($templateType);
            
            if (!$template) {
                Log::warning("Template SMS não encontrado: {$templateType}");
                return false;
            }

            // Processar mensagem com variáveis
            $message = $template->processMessage($variables);
            
            // Enviar SMS
            return $this->sendSms($phoneNumber, $message);

        } catch (Exception $e) {
            Log::error("Erro ao enviar SMS template", [
                'template_type' => $templateType,
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Enviar SMS diretamente usando 'content' (Unimtx junta com signature automaticamente)
     * Mais simples e recomendado pela Unimtx
     */
    public function sendSms(string $phoneNumber, string $message)
    {
        $logData = [
            'phone' => $phoneNumber,
            'message' => $message,
            'provider' => 'unimtx',
            'type' => 'manual',
            'user_id' => auth()->id(),
        ];
        
        try {
            // Verificar se SMS está habilitado
            $smsEnabled = Setting::get('sms_enabled', true);
            if (!$smsEnabled) {
                Log::info("SMS desabilitado nas configurações");
                \App\Models\SmsLog::create(array_merge($logData, [
                    'status' => 'failed',
                    'error' => 'SMS desabilitado nas configurações'
                ]));
                return false;
            }
            
            if (!$this->accessKey) {
                Log::warning("Access Key da Unimtx não configurada");
                \App\Models\SmsLog::create(array_merge($logData, [
                    'status' => 'failed',
                    'error' => 'Access Key não configurada'
                ]));
                return false;
            }

            // Formatar número de telefone (E.164 format)
            $phoneNumber = $this->formatPhoneNumber($phoneNumber);
            $logData['phone'] = $phoneNumber;
            
            // MÉTODO 1: Usar 'content' - Unimtx junta automaticamente com signature
            // Mais simples e recomendado
            $response = Http::timeout(30)
                ->retry(3, 1000)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->accessKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->apiUrl, [
                    'to' => $phoneNumber,
                    'signature' => $this->senderName,
                    'content' => $message // Unimtx junta: [SUPERLOJA] + mensagem
                ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info("SMS enviado com sucesso (content)", [
                    'phone' => $phoneNumber,
                    'message_id' => $data['data']['id'] ?? null,
                    'status' => $data['data']['status'] ?? null,
                    'sender' => $this->senderName
                ]);
                
                // Registrar log de sucesso
                \App\Models\SmsLog::create(array_merge($logData, [
                    'status' => 'sent',
                    'message_id' => $data['data']['id'] ?? null,
                    'response' => json_encode($data),
                ]));
                
                return true;
            } else {
                $errorData = $response->json();
                Log::error("Erro ao enviar SMS", [
                    'phone' => $phoneNumber,
                    'status' => $response->status(),
                    'response' => $errorData
                ]);
                
                // Registrar log de falha
                \App\Models\SmsLog::create(array_merge($logData, [
                    'status' => 'failed',
                    'error' => $errorData['message'] ?? 'Erro desconhecido',
                    'response' => json_encode($errorData),
                ]));
                
                return false;
            }
        } catch (Exception $e) {
            Log::error("Exceção ao enviar SMS", [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);
            
            // Registrar log de exceção
            \App\Models\SmsLog::create(array_merge($logData, [
                'status' => 'failed',
                'error' => $e->getMessage(),
            ]));
            
            return false;
        }
    }

    /**
     * Enviar SMS usando 'text' completo (sem signature automática)
     * Use quando quiser controle total do texto
     */
    public function sendSmsWithFullText(string $phoneNumber, string $fullMessage)
    {
        try {
            if (!$this->accessKey) {
                Log::warning("Access Key da Unimtx não configurada");
                return false;
            }

            $phoneNumber = $this->formatPhoneNumber($phoneNumber);
            
            // MÉTODO 2: Usar 'text' - texto completo sem modificações
            $response = Http::timeout(30)
                ->retry(3, 1000)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->accessKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->apiUrl, [
                    'to' => $phoneNumber,
                    'text' => $fullMessage // Texto enviado exatamente como está
                ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info("SMS enviado com sucesso (text)", [
                    'phone' => $phoneNumber,
                    'message_id' => $data['data']['id'] ?? null
                ]);
                return true;
            }
            
            return false;
        } catch (Exception $e) {
            Log::error("Erro ao enviar SMS com text", [
                'phone' => $phoneNumber,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Enviar SMS usando templateId público ou aprovado
     * MÉTODO 3: Para OTP e mensagens padronizadas
     */
    public function sendSmsWithTemplate(string $phoneNumber, string $templateId, array $templateData = [])
    {
        try {
            if (!$this->accessKey) {
                Log::warning("Access Key da Unimtx não configurada");
                return false;
            }

            $phoneNumber = $this->formatPhoneNumber($phoneNumber);
            
            $payload = [
                'to' => $phoneNumber,
                'signature' => $this->senderName,
                'templateId' => $templateId, // ex: 'pub_verif_en_basic2' ou seu template
                'templateData' => $templateData // ex: ['code' => '123456']
            ];
            
            $response = Http::timeout(30)
                ->retry(3, 1000)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->accessKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->apiUrl, $payload);

            if ($response->successful()) {
                $data = $response->json();
                Log::info("SMS enviado com sucesso (template)", [
                    'phone' => $phoneNumber,
                    'template' => $templateId,
                    'message_id' => $data['data']['id'] ?? null
                ]);
                return true;
            }
            
            return false;
        } catch (Exception $e) {
            Log::error("Erro ao enviar SMS com template", [
                'phone' => $phoneNumber,
                'template' => $templateId,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Formatar número de telefone para padrão E.164
     */
    private function formatPhoneNumber(string $phoneNumber)
    {
        // Remove todos os caracteres não numéricos
        $cleaned = preg_replace('/[^0-9]/', '', $phoneNumber);
        
        // Se começa com 244 (código Angola), mantém
        if (str_starts_with($cleaned, '244')) {
            return '+' . $cleaned;
        }
        
        // Se começa com 9 (número local Angola), adiciona código do país
        if (str_starts_with($cleaned, '9') && strlen($cleaned) === 9) {
            return '+244' . $cleaned;
        }
        
        // Se não tem código do país, assume Angola
        if (strlen($cleaned) === 9) {
            return '+244' . $cleaned;
        }
        
        // Retorna como está com sinal +
        return '+' . $cleaned;
    }

    /**
     * Notificações específicas para pedidos
     */
    public function sendOrderCreatedNotification($order)
    {
        if (!$order->phone) {
            return false;
        }

        return $this->sendTemplateMessage('order_created', $order->phone, [
            'customer_name' => $order->customer_name,
            'order_number' => $order->order_number,
            'total' => number_format((float)$order->total, 2, ',', '.') . ' Kz',
            'company_phone' => '+244 939 729 902'
        ]);
    }

    public function sendOrderConfirmedNotification($order)
    {
        if (!$order->phone) {
            return false;
        }

        return $this->sendTemplateMessage('order_confirmed', $order->phone, [
            'customer_name' => $order->customer_name,
            'order_number' => $order->order_number,
            'company_phone' => '+244 939 729 902'
        ]);
    }

    public function sendOrderShippedNotification($order)
    {
        if (!$order->phone) {
            return false;
        }

        return $this->sendTemplateMessage('order_shipped', $order->phone, [
            'customer_name' => $order->customer_name,
            'order_number' => $order->order_number,
            'tracking_code' => $order->tracking_code ?? 'N/A',
            'company_phone' => '+244 939 729 902'
        ]);
    }

    public function sendOrderDeliveredNotification($order)
    {
        if (!$order->phone) {
            return false;
        }

        return $this->sendTemplateMessage('order_delivered', $order->phone, [
            'customer_name' => $order->customer_name,
            'order_number' => $order->order_number,
            'company_phone' => '+244 939 729 902'
        ]);
    }

    public function sendOrderCancelledNotification($order)
    {
        if (!$order->phone) {
            return false;
        }

        return $this->sendTemplateMessage('order_cancelled', $order->phone, [
            'customer_name' => $order->customer_name,
            'order_number' => $order->order_number,
            'reason' => $order->cancellation_reason ?? 'Solicitação do cliente',
            'company_phone' => '+244 939 729 902'
        ]);
    }

    /**
     * Testar conexão com API
     */
    public function testConnection()
    {
        try {
            // Validações básicas
            if (!$this->accessKey) {
                return [
                    'success' => false,
                    'message' => 'Access Key não configurada'
                ];
            }

            // Teste com número fictício usando CONTENT (método recomendado)
            $response = Http::timeout(30)
                ->retry(2, 1000)
                ->withHeaders([
                    'Authorization' => 'Bearer ' . $this->accessKey,
                    'Content-Type' => 'application/json',
                ])
                ->post($this->apiUrl, [
                    'to' => '+244999999999', // Número fictício para teste
                    'signature' => $this->senderName,
                    'content' => 'Teste de conexao SuperLoja - ' . now()->format('H:i:s')
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'message' => 'Conexão estabelecida com sucesso! Access Key válida.',
                    'data' => [
                        'message_id' => $data['data']['id'] ?? null,
                        'status' => $data['data']['status'] ?? null,
                        'response' => $data
                    ]
                ];
            } else {
                $statusCode = $response->status();
                $responseData = $response->json();
                
                if ($statusCode === 401) {
                    return [
                        'success' => false,
                        'message' => 'Access Key inválida ou expirada'
                    ];
                }
                
                if ($statusCode === 403) {
                    return [
                        'success' => false,
                        'message' => 'Acesso negado - verifique as permissões da Access Key'
                    ];
                }
                
                return [
                    'success' => false,
                    'message' => "Erro HTTP {$statusCode}: " . ($responseData['message'] ?? 'Erro desconhecido')
                ];
            }
            
        } catch (Exception $e) {
            $message = $e->getMessage();
            
            // Tratar erros específicos de conexão
            if (str_contains($message, 'cURL error 28') || str_contains($message, 'timeout')) {
                return [
                    'success' => false,
                    'message' => 'Timeout na conexão: A API da Unimtx não respondeu dentro do tempo esperado. Tente novamente em alguns minutos.'
                ];
            }

            if (str_contains($message, 'Could not resolve host')) {
                return [
                    'success' => false,
                    'message' => 'Erro de DNS: Não foi possível resolver o endereço da API Unimtx. Verifique sua conexão com a internet.'
                ];
            }

            return [
                'success' => false,
                'message' => 'Erro inesperado: ' . $message
            ];
        }
    }
}

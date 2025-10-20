# 📱 Guia SMS - SuperLoja Angola com Unimtx

## 🎯 3 Métodos de Envio

### ✅ MÉTODO 1: CONTENT (RECOMENDADO)
**Uso:** Notificações gerais, pedidos, alertas  
**Vantagem:** Unimtx junta automaticamente `[SUPERLOJA] + mensagem`

```php
// SmsService
$smsService->sendSms($phoneNumber, "Seu pedido foi confirmado!");

// Payload HTTP
[
    'to' => '+244939729902',
    'signature' => 'SUPERLOJA',
    'content' => 'Seu pedido foi confirmado!'
]

// Cliente recebe:
// [SUPERLOJA] Seu pedido foi confirmado!
```

**Quando usar:**
- ✅ Confirmação de pedidos
- ✅ Status de entrega
- ✅ Notificações gerais
- ✅ Promoções

---

### ✅ MÉTODO 2: TEXT (CONTROLE TOTAL)
**Uso:** Quando você quer controle 100% do texto  
**Vantagem:** Texto enviado exatamente como você escreve

```php
// SmsService
$smsService->sendSmsWithFullText($phoneNumber, "[SUPERLOJA] Texto completo aqui");

// Payload HTTP
[
    'to' => '+244939729902',
    'text' => '[SUPERLOJA] Texto completo aqui'
]

// Cliente recebe exatamente:
// [SUPERLOJA] Texto completo aqui
```

**Quando usar:**
- ✅ Mensagens personalizadas complexas
- ✅ Quando não quer a signature automática
- ✅ Controle total da formatação

---

### ✅ MÉTODO 3: TEMPLATE (OTP e PADRÕES)
**Uso:** OTP, verificações, mensagens que se repetem  
**Vantagem:** Usa templates públicos (pub_*) ou seus templates aprovados

```php
// SmsService
$smsService->sendSmsWithTemplate($phoneNumber, 'pub_verif_en_basic2', [
    'code' => '1234'
]);

// Payload HTTP
[
    'to' => '+244939729902',
    'signature' => 'SUPERLOJA',
    'templateId' => 'pub_verif_en_basic2',
    'templateData' => ['code' => '1234']
]

// Cliente recebe (conforme template):
// Your verification code is 1234
```

**Templates Públicos Disponíveis:**
- `pub_verif_en_basic2` - Código de verificação inglês
- Outros templates públicos começam com `pub_`
- Você pode criar seus próprios templates no painel Unimtx

**Quando usar:**
- ✅ OTP (códigos de verificação)
- ✅ 2FA (autenticação de dois fatores)
- ✅ Mensagens padronizadas que se repetem
- ✅ Quando precisa de aprovação regional

---

## 📊 Comparação Rápida

| Método | Signature Auto | Controle | Uso Principal |
|--------|---------------|----------|---------------|
| **CONTENT** | ✅ Sim | Médio | Geral (Recomendado) |
| **TEXT** | ❌ Não | Total | Personalizado |
| **TEMPLATE** | ✅ Sim | Variáveis | OTP/Padrões |

---

## 🚀 Exemplos Práticos SuperLoja

### 1. Confirmar Pedido (CONTENT)
```php
$smsService->sendSms(
    $order->phone,
    "Pedido #{$order->id} confirmado! Total: {$order->total} Kz. Entrega em 3 dias."
);
```

### 2. Promoção Personalizada (TEXT)
```php
$smsService->sendSmsWithFullText(
    $customer->phone,
    "[SUPERLOJA] 🎉 {$customer->name}, 50% OFF em eletrônicos! Válido até amanhã. Acesse: superloja.ao"
);
```

### 3. Código de Verificação (TEMPLATE)
```php
$code = rand(1000, 9999);
$smsService->sendSmsWithTemplate(
    $user->phone,
    'pub_verif_en_basic2',
    ['code' => $code]
);
// Salvar $code na sessão para verificar depois
```

---

## ⚙️ Configuração Atual

```php
Access Key: 5w85m6dWZs4Ue97z7EvL23
Sender Name: SUPERLOJA (aprovado)
API URL: https://api.unimtx.com/v1/messages
Método: Bearer Token Authentication
```

---

## 🛠️ Métodos Disponíveis no SmsService

```php
// 1. Método padrão (CONTENT)
$smsService->sendSms($phone, $message);

// 2. Texto completo (TEXT)
$smsService->sendSmsWithFullText($phone, $fullMessage);

// 3. Com template (TEMPLATE)
$smsService->sendSmsWithTemplate($phone, $templateId, $data);

// 4. Notificações de pedido (usa CONTENT)
$smsService->sendOrderCreatedNotification($order);
$smsService->sendOrderConfirmedNotification($order);
$smsService->sendOrderShippedNotification($order);
$smsService->sendOrderDeliveredNotification($order);
$smsService->sendOrderCancelledNotification($order);
```

---

## 📝 Scripts de Teste

### Teste Simples
```bash
php test_sms_simple.php
```

### Teste 3 Métodos
```bash
php test_sms_3metodos.php
```

### Teste com Sender SUPERLOJA
```bash
php test_sms_superloja.php
```

---

## 💡 Dicas e Boas Práticas

### ✅ Fazer
- Use CONTENT para 90% dos casos
- Sempre inclua informações úteis (número pedido, total, prazo)
- Mantenha mensagens concisas (< 160 caracteres ideal)
- Teste antes de usar em produção

### ❌ Evitar
- Não use TEXT a menos que realmente precise
- Não abuse de templates públicos (use para OTP)
- Não envie SMS em excesso (limite por cliente)
- Não coloque URLs muito longas

---

## 🔧 Troubleshooting

### Erro 107121 (SmsSignatureNotExists)
- Sender 'SUPERLOJA' não aprovado ainda
- Verifique: https://console.unimtx.com/sms/senders

### Erro 107141 (SmsTemplateNotExists)
- Template não existe ou não está aprovado
- Use template público: `pub_verif_en_basic2`
- Ou use CONTENT/TEXT ao invés de template

### Erro 40100 (Invalid Access Key)
- Access Key inválida ou expirada
- Verifique configurações em /admin/settings

---

## 📞 Suporte

- **Documentação Unimtx:** https://www.unimtx.com/docs
- **Console Unimtx:** https://console.unimtx.com
- **SuperLoja Admin:** /admin/settings (aba SMS)

---

**Status:** ✅ Sistema 100% Funcional  
**Última Atualização:** 30/09/2025  
**Versão:** 1.0

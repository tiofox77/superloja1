# 🚨 PROBLEMA: SMS NÃO CHEGAM AOS DESTINATÁRIOS

## ⚠️ Situação Atual

- ✅ API retorna HTTP 200 com código 0 (Sucesso)
- ❌ SMS NÃO chegam nos números: +244939729902 e +244954949595
- ✅ Access Key válida e funcionando
- ✅ Sender SUPERLOJA configurado

**CONCLUSÃO:** O problema NÃO é no código, mas sim na configuração da conta Unimtx.

---

## 🔍 CAUSAS MAIS PROVÁVEIS

### 1️⃣ **CONTA EM MODO TESTE/SANDBOX** (Mais provável)

**Sintoma:** API aceita mas não envia SMS reais

**Solução:**
1. Acesse: https://console.unimtx.com
2. Vá em **Settings** → **Account**
3. Verifique se está em **"Production Mode"**
4. Se estiver em **"Sandbox/Test Mode"**, ative o modo produção

---

### 2️⃣ **CRÉDITOS INSUFICIENTES OU CONTA NÃO ATIVADA**

**Sintoma:** API aceita mas SMS não é enviado por falta de crédito

**Solução:**
1. Acesse: https://console.unimtx.com
2. Verifique **saldo da conta** no dashboard
3. Para Angola, cada SMS pode custar ~$0.05-0.10
4. **Recarregue créditos** se necessário

**Verificar:**
```
Dashboard → Balance/Credits
```

---

### 3️⃣ **SENDER 'SUPERLOJA' NÃO TOTALMENTE APROVADO**

**Sintoma:** Sender aceito mas não autorizado para envio real

**Solução:**
1. Acesse: https://console.unimtx.com/sms/senders
2. Verifique status do sender **SUPERLOJA**
3. Status deve ser: ✅ **"Approved"** ou ✅ **"Active"**
4. Se estiver **"Pending"**, aguarde aprovação ou use sender padrão

**Status possíveis:**
- ✅ **Approved/Active** → OK para usar
- ⏳ **Pending** → Aguardando aprovação
- ❌ **Rejected** → Precisa criar novo sender

---

### 4️⃣ **COBERTURA PARA ANGOLA (+244) NÃO HABILITADA**

**Sintoma:** Unimtx não tem cobertura ou está bloqueada para Angola

**Solução:**
1. Acesse: https://console.unimtx.com/coverage
2. Busque por **"Angola"** ou **"+244"**
3. Verifique se está disponível
4. Se não estiver, solicite habilitação

**Alternativa:** Testar com número de outro país (ex: Brasil +55)

---

### 5️⃣ **NÚMEROS PRECISAM SER VERIFICADOS**

**Sintoma:** Conta nova exige verificação de números destinatários

**Solução:**
1. Acesse: https://console.unimtx.com/numbers
2. Adicione os números na **"Whitelist"** ou **"Verified Numbers"**
3. Confirme via SMS ou outro método
4. Tente enviar novamente

---

### 6️⃣ **RESTRIÇÕES DE TAXA (RATE LIMITING)**

**Sintoma:** Muitos SMS enviados rapidamente

**Solução:**
1. Aguarde alguns minutos
2. Verifique limites em: https://console.unimtx.com/settings
3. Aumente limites se necessário

---

## ✅ CHECKLIST DE VERIFICAÇÃO

Acesse https://console.unimtx.com e verifique:

### Account Settings
- [ ] ✅ Conta em **Production Mode** (não Sandbox)
- [ ] ✅ Conta **ativada e verificada**
- [ ] ✅ **Email confirmado**
- [ ] ✅ **Saldo/Créditos suficientes** (> $5)

### SMS Configuration
- [ ] ✅ Sender **SUPERLOJA** com status **Approved**
- [ ] ✅ **Cobertura para Angola** (+244) habilitada
- [ ] ✅ Números destinatários **verificados** (se necessário)

### Messages History
- [ ] Acessar: **Messages** → **History**
- [ ] Verificar últimas mensagens enviadas
- [ ] Checar **status** das mensagens:
  - ✅ **sent** → Enviado
  - ✅ **delivered** → Entregue
  - ⚠️ **failed** → Falhou (ver motivo)
  - ⏳ **queued** → Na fila

### Billing
- [ ] ✅ Forma de pagamento **cadastrada**
- [ ] ✅ **Créditos disponíveis**
- [ ] ✅ Nenhuma **fatura pendente**

---

## 🔧 TESTES ADICIONAIS

### Teste 1: Enviar para número de outro país
```php
// Testar com número Brasil (se tiver)
php diagnostico_sms.php
// Editar o arquivo e adicionar: +5511999999999
```

### Teste 2: Verificar histórico via API
```bash
curl -X GET "https://api.unimtx.com/v1/messages?limit=10" \
  -H "Authorization: Bearer 5w85m6dWZs4Ue97z7EvL23"
```

### Teste 3: Testar sem sender personalizado
```php
// Remover 'signature' do payload
{
    "to": "+244939729902",
    "content": "Teste sem sender"
}
```

---

## 📞 CONTATO SUPORTE UNIMTX

Se tudo estiver OK e mesmo assim não funciona:

### Email
📧 support@unimtx.com

**Informações para incluir:**
- Access Key: 5w85...vL23
- Números testados: +244939729902, +244954949595
- Horário dos testes: 30/09/2025 21:30-21:35
- Mensagem de erro: Nenhuma (API retorna sucesso)
- Problema: SMS não chegam aos destinatários

### Live Chat
💬 https://console.unimtx.com (botão no canto)

### Twitter/X
🐦 @unimtx

---

## 💡 SOLUÇÃO TEMPORÁRIA

Enquanto resolve o problema com Unimtx, pode:

### Opção 1: Usar outro provedor temporariamente
- Twilio
- Vonage (Nexmo)
- MessageBird
- Infobip

### Opção 2: Desabilitar SMS temporariamente
```php
// Em /admin/settings
SMS Habilitado: ❌ Desativar
```

### Opção 3: Modo de fallback (email)
Se SMS falhar, enviar email:
```php
if (!$smsService->sendSms($phone, $msg)) {
    Mail::to($order->email)->send(new OrderConfirmed($order));
}
```

---

## 📊 STATUS DO DIAGNÓSTICO

```
✅ Código funcionando corretamente
✅ API Unimtx respondendo (HTTP 200)
✅ Access Key válida
✅ Sender SUPERLOJA configurado
✅ 3 métodos implementados (content, text, template)
❌ SMS não chegam aos destinatários

PRÓXIMO PASSO: Verificar configurações da conta Unimtx no console
```

---

## 🎯 AÇÃO IMEDIATA

**1. Acesse agora:** https://console.unimtx.com

**2. Verifique primeiro:**
- Saldo/Créditos
- Modo da conta (Sandbox vs Production)
- Status do sender SUPERLOJA

**3. Se tudo OK:**
- Entre em contato com suporte Unimtx
- Mencione que API retorna sucesso mas SMS não chegam
- Forneça os números e horários dos testes

---

**Data do diagnóstico:** 30/09/2025 21:33  
**Status:** Aguardando verificação da conta Unimtx

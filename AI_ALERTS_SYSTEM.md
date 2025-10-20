# 🚨 Sistema de Alertas da IA - Documentação Completa

## 📋 Índice
1. [Como a IA Alerta o Usuário](#como-a-ia-alerta-o-usuário)
2. [Caminhos de Notificação](#caminhos-de-notificação)
3. [Tipos de Alertas](#tipos-de-alertas)
4. [Configuração Atual](#configuração-atual)
5. [Visualização dos Alertas](#visualização-dos-alertas)

---

## 🤖 Como a IA Alerta o Usuário

### Fluxo Automático (Tempo Real)

```
Cliente envia mensagem
    ↓
Webhook recebe (Facebook/Instagram)
    ↓
AiKnowledgeService analisa sentimento
    ↓
Detecta se precisa atenção humana
    ↓
SocialMediaAgentService dispara notificação
    ↓
NotificationService cria notificação para TODOS os admins
    ↓
Admin recebe alerta no painel
```

---

## 🛤️ Caminhos de Notificação

### 1️⃣ Análise de Sentimento (Automática)
**Arquivo:** `app/Services/AiKnowledgeService.php`
**Método:** `analyzeSentiment()`

Detecta automaticamente:
- ✅ **Positivo** - Cliente feliz, palavras: obrigado, ótimo, excelente
- ⚠️ **Negativo** - Cliente insatisfeito, palavras: problema, ruim, péssimo
- 🚨 **Urgente** - Situação urgente, palavras: urgente, rápido, emergência

**Código:**
```php
private function analyzeSentiment(string $message): array
{
    // Palavras-chave negativas
    $negative = ['problema', 'ruim', 'péssimo', 'errado', 'defeito', 'reclamar'];
    
    // Palavras-chave urgentes
    $urgent = ['urgente', 'rápido', 'agora', 'emergência', 'imediato'];
    
    return [
        'sentiment' => 'negative', // ou 'positive', 'neutral', 'urgent'
        'confidence' => 75.5, // 0-100%
        'needs_human' => true, // Se precisa atenção
        'priority' => 'urgent', // low, normal, high, urgent
    ];
}
```

---

### 2️⃣ Salvamento no Banco de Dados
**Arquivo:** `app/Services/SocialMediaAgentService.php`
**Tabela:** `ai_sentiment_analysis`

Quando mensagem chega:
```php
AiSentimentAnalysis::create([
    'message_id' => $messageId,
    'conversation_id' => $conversationId,
    'sentiment' => 'negative',
    'confidence' => 85.5,
    'needs_human_attention' => true, // ← GATILHO
    'priority' => 'urgent',
]);
```

---

### 3️⃣ Disparo de Notificação
**Arquivo:** `app/Services/SocialMediaAgentService.php` (linha 637-646)

```php
// Notificar admins se precisa atenção humana
if ($result['sentiment']['needs_human']) {
    \App\Services\NotificationService::aiConversationNeedsAttention(
        $conversation->id,
        $conversation->customer_name ?? 'Cliente',
        $platform, // facebook ou instagram
        $result['sentiment']['sentiment'], // negative, urgent
        $result['sentiment']['priority'], // urgent, high
        $messageText
    );
}
```

---

### 4️⃣ Criação da Notificação
**Arquivo:** `app/Services/NotificationService.php`
**Método:** `aiConversationNeedsAttention()`

```php
public static function aiConversationNeedsAttention(
    int $conversationId,
    string $customerName,
    string $platform,
    string $sentiment,
    string $priority,
    string $lastMessage
): void {
    $priorityEmojis = [
        'urgent' => '🚨',
        'high' => '⚠️',
        'normal' => 'ℹ️',
        'low' => '💬',
    ];

    $emoji = $priorityEmojis[$priority];
    $title = "{$emoji} Conversa Urgente - {$customerName}";
    
    $message = "Cliente em {$platform} precisa atenção humana.\n" .
               "Sentimento: Cliente insatisfeito\n" .
               "Prioridade: urgent\n" .
               "Última mensagem: ...";

    // Cria notificação para TODOS os admins
    self::createForAdmins(
        'ai_urgent_conversation',
        $title,
        $message,
        [...]
    );
}
```

---

## 📊 Tipos de Alertas

### 1. Conversa Urgente (needs_human_attention = true)

**Quando acontece:**
- Cliente usa palavras negativas (≥2 palavras)
- Cliente usa palavras urgentes
- Sentimento negativo detectado

**Visual no menu:**
```
💬 Conversas  [🚨 3]  ← Badge vermelho pulsante
```

**Exemplo de notificação:**
```
🚨 Conversa Urgente - João Silva
Cliente em facebook precisa atenção humana.
Sentimento: Cliente insatisfeito
Prioridade: urgent
Última mensagem: Este produto está com defeito e preciso trocar urgente!
```

---

### 2. Nova Mensagem Não Lida

**Quando acontece:**
- Cliente envia qualquer mensagem
- Mensagem ainda não foi marcada como lida

**Visual no menu:**
```
💬 Conversas  [5]  ← Badge azul simples
```

**Código:**
```php
$unreadMessages = AiMessage::where('is_read', false)
    ->where('direction', 'incoming')
    ->count();
```

---

## ⚙️ Configuração Atual

### Gatilhos de Alerta (needs_human_attention)

| Condição | Gatilho | Prioridade |
|----------|---------|-----------|
| 2+ palavras negativas | ✅ SIM | high |
| Palavra "urgente" | ✅ SIM | urgent |
| Sentimento negativo | ✅ SIM | high |
| Sentimento neutro | ❌ NÃO | normal |
| Sentimento positivo | ❌ NÃO | low |

**Arquivo:** `app/Services/AiKnowledgeService.php` (linha 89-107)

---

## 👀 Visualização dos Alertas

### 1️⃣ Menu Lateral (Sidebar)
**Arquivo:** `resources/views/components/layouts/partials/admin-sidebar.blade.php`

```blade
<!-- Conversas urgentes (vermelho pulsante) -->
@if($urgentConversations > 0)
    <span class="bg-red-500 text-white animate-pulse">
        🚨 {{ $urgentConversations }}
    </span>
@endif

<!-- Mensagens não lidas (azul) -->
@if($unreadMessages > 0)
    <span class="bg-blue-500 text-white">
        {{ $unreadMessages }}
    </span>
@endif
```

**Localização:** Menu AI AGENT → 💬 Conversas

---

### 2️⃣ Painel de Notificações
**Arquivo:** `app/Livewire/NotificationDropdown.php`

Admin vê notificação no sino (🔔):
```
🚨 Conversa Urgente - João Silva
Cliente em facebook precisa atenção humana...
```

Clicando na notificação → Redireciona para:
`/admin/ai-agent/conversations?conversation_id=123`

---

### 3️⃣ Lista de Conversas
**Arquivo:** `app/Livewire/Admin/AiAgent/ConversationManager.php`

Na página de conversas, filtros disponíveis:
- **Todas** (status: active)
- **Plataforma:** Facebook, Instagram
- **Urgentes:** needs_human_attention = true

---

## 🔔 Tipos de Notificações Criadas

### Para Admins (createForAdmins)

| Tipo | Quando | Título | Ícone |
|------|--------|--------|-------|
| `ai_urgent_conversation` | Cliente insatisfeito/urgente | Conversa Urgente - Nome | 🚨 |
| `ai_new_message` | Nova mensagem | Nova mensagem - Nome | 💬 |

**Quem recebe:**
- ✅ TODOS os usuários com `is_admin = true`
- ✅ Notificação individual para cada admin
- ✅ Aparece no sino 🔔 de cada um

---

## 📈 Exemplo Prático Completo

### Cenário: Cliente Insatisfeito

```
1. Cliente João envia no Facebook:
   "Este produto está com defeito! Preciso resolver urgente!"

2. Webhook recebe mensagem
   └─ SocialMediaAgentService::processIncomingMessage()

3. AiKnowledgeService analisa:
   └─ Detecta palavras: "defeito", "urgente"
   └─ Resultado:
       - sentiment: 'urgent'
       - confidence: 95%
       - needs_human: TRUE
       - priority: 'urgent'

4. Sistema salva no banco:
   └─ ai_sentiment_analysis
       - needs_human_attention = true
       - priority = urgent

5. Dispara notificação:
   └─ NotificationService::aiConversationNeedsAttention()
       - Cria notificação para todos admins

6. Admins recebem:
   ├─ Sino 🔔 com notificação
   ├─ Badge no menu: 💬 Conversas [🚨 1]
   └─ Título: "🚨 Conversa Urgente - João Silva"

7. Admin clica e vê:
   ├─ Conversa completa
   ├─ Última mensagem
   └─ Pode responder manualmente
```

---

## 🛠️ Customização

### Adicionar Novas Palavras-Chave

**Arquivo:** `app/Services/AiKnowledgeService.php`

```php
// Palavras negativas
$negative = ['problema', 'ruim', 'péssimo', 'errado', 'defeito', 'reclamar'];

// Adicionar mais
$negative[] = 'insatisfeito';
$negative[] = 'enganado';
```

### Ajustar Sensibilidade

```php
// Mais sensível (1+ palavra negativa já alerta)
if ($negativeCount >= 1) {
    $sentiment = 'negative';
}

// Menos sensível (3+ palavras)
if ($negativeCount >= 3) {
    $sentiment = 'negative';
}
```

---

## 📊 Métricas

**Arquivo:** `app/Console/Commands/CalculateAiMetrics.php`

Métricas calculadas a cada 4 horas:
```php
'human_interventions' => $sentiments
    ->where('needs_human_attention', true)
    ->count()
```

**Visível em:**
- `/admin/ai-agent/knowledge` (Centro de Conhecimento)
- Dashboard AI Agent

---

## ✅ Checklist de Funcionamento

- [x] Análise de sentimento em tempo real
- [x] Detecção de palavras negativas/urgentes
- [x] Salvamento no banco (ai_sentiment_analysis)
- [x] Disparo automático de notificação
- [x] Notificação para todos os admins
- [x] Badge pulsante no menu (conversas urgentes)
- [x] Badge simples (mensagens não lidas)
- [x] Sino de notificações
- [x] Link direto para conversa
- [x] Métricas de intervenções humanas

---

## 🚀 Testando o Sistema

### 1. Simular Cliente Insatisfeito
Enviar via webhook teste:
```json
{
  "sender": {"id": "123"},
  "message": {"text": "Este produto está péssimo e com defeito urgente!"}
}
```

### 2. Verificar Alertas
- [ ] Badge vermelho pulsante aparece no menu
- [ ] Notificação no sino 🔔
- [ ] Conversa marcada como urgente
- [ ] Admin pode ver detalhes

---

## 📝 Resumo

**Sistema 100% automático que:**
- ✅ Detecta cliente insatisfeito EM TEMPO REAL
- ✅ Analisa sentimento automaticamente
- ✅ Notifica TODOS os admins instantaneamente
- ✅ Badge pulsante vermelho para urgências
- ✅ Badge azul para mensagens não lidas
- ✅ Link direto para responder
- ✅ Rastreia intervenções humanas

**Zero configuração necessária - Funciona automaticamente!** 🎉

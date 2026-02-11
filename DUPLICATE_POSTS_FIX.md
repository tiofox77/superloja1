# 🔧 Correção de Posts Duplicados

## ❌ Problema Identificado

Posts duplicados estavam sendo criados quando os comandos de IA rodavam múltiplas vezes no mesmo dia.

### **Causa Raiz:**

**Posts Individuais:**
```php
// VERIFICAÇÃO ANTIGA (FALHA):
$existingPost = AiAutoPost::where('product_id', $product->id)
    ->where('platform', $platform)
    ->where('status', 'scheduled')        // ❌ Só verificava 'scheduled'
    ->where('scheduled_for', '>=', now()) // ❌ Só verificava futuro
    ->first();
```

**Problemas:**
1. ❌ Não verificava posts já publicados hoje
2. ❌ Não verificava posts com status 'publishing'
3. ❌ Não verificava posts do mesmo dia (apenas futuro)
4. ❌ Se o comando rodasse 2x no mesmo dia → criava duplicatas

**Carrosséis:**
```php
// VERIFICAÇÃO ANTIGA (FALHA):
$existingCarousel = AiAutoPost::where('post_type', 'carousel')
    ->where('platform', $platform)
    ->where('status', 'scheduled')         // ❌ Só verificava 'scheduled'
    ->whereDate('scheduled_for', '>=', now()) // ❌ Permitia múltiplos no mesmo dia
    ->first();
```

**Problemas:**
1. ❌ Permitia múltiplos carrosséis no mesmo dia
2. ❌ Não verificava carrosséis já publicados
3. ❌ Verificação de produtos era muito complexa e falha

---

## ✅ Solução Implementada

### **1. Posts Individuais - Verificação Melhorada**

**Arquivo:** `app/Console/Commands/AutoCreatePosts.php` (linha 83-102)

```php
// NOVA VERIFICAÇÃO (CORRETA):
$todayStart = now()->startOfDay();
$todayEnd = now()->endOfDay();

$existingPost = AiAutoPost::where('product_id', $product->id)
    ->where('platform', $platform)
    ->whereIn('status', ['scheduled', 'published', 'publishing']) // ✅ Múltiplos status
    ->where(function($query) use ($todayStart, $todayEnd) {
        $query->whereBetween('scheduled_for', [$todayStart, $todayEnd])  // ✅ Agendados hoje
              ->orWhereBetween('published_at', [$todayStart, $todayEnd]); // ✅ Publicados hoje
    })
    ->first();

if ($existingPost) {
    $statusMsg = $existingPost->status === 'published' ? 'já publicado' : 'já agendado';
    $this->warn("  ⚠️ Produto {$statusMsg} hoje: {$product->name}");
    $skipped++;
    continue;
}
```

**O que mudou:**
- ✅ Verifica posts **agendados E publicados** hoje
- ✅ Verifica múltiplos status: `scheduled`, `published`, `publishing`
- ✅ Usa `whereBetween` para verificar TODO O DIA (00:00 até 23:59)
- ✅ Mensagem clara sobre o motivo do skip

---

### **2. Carrosséis - Verificação Simplificada**

**Arquivo:** `app/Console/Commands/AutoCreateCarousels.php` (linha 79-97)

```php
// NOVA VERIFICAÇÃO (CORRETA):
$todayStart = now()->startOfDay();
$todayEnd = now()->endOfDay();

$existingCarousel = AiAutoPost::where('post_type', 'carousel')
    ->where('platform', $platform)
    ->whereIn('status', ['scheduled', 'published', 'publishing'])
    ->where(function($query) use ($todayStart, $todayEnd) {
        $query->whereBetween('scheduled_for', [$todayStart, $todayEnd])
              ->orWhereBetween('published_at', [$todayStart, $todayEnd]);
    })
    ->first();

if ($existingCarousel) {
    $statusMsg = $existingCarousel->status === 'published' ? 'já foi publicado' : 'já está agendado';
    $this->warn("⚠️ Carrossel #" . ($i+1) . ": Já {$statusMsg} para hoje nesta plataforma");
    continue;
}
```

**O que mudou:**
- ✅ **Regra simples:** Apenas 1 carrossel por dia por plataforma
- ✅ Não importa quais produtos (evita over-complicação)
- ✅ Verifica agendados E publicados
- ✅ Muito mais eficiente

---

## 🧹 Limpeza de Posts Duplicados Existentes

### **Novo Comando:**

```bash
# Ver quais posts seriam deletados (sem deletar)
php artisan ai:clean-duplicate-posts --dry-run

# Deletar posts duplicados de verdade
php artisan ai:clean-duplicate-posts

# Limpar apenas uma plataforma
php artisan ai:clean-duplicate-posts --platform=facebook
```

**O que o comando faz:**

**Posts Individuais:**
1. Agrupa posts por: `product_id + platform + data`
2. Se encontrar > 1 post no mesmo grupo → DUPLICATA
3. Mantém o **primeiro criado** (mais antigo)
4. Deleta os demais

**Carrosséis:**
1. Agrupa por: `platform + data`
2. Se encontrar > 1 carrossel no mesmo dia → DUPLICATA
3. Mantém o **primeiro criado**
4. Deleta os demais

**Exemplo de saída:**
```
🧹 Iniciando limpeza de posts duplicados...

📊 Analisando posts individuais...
⚠️ Encontrados 5 grupos de posts duplicados

📦 Caixa de Som Bluetooth JBL
   Plataforma: facebook
   Data: 2025-11-04
   Total de posts: 3
   ✅ Manter post ID: 123
   ❌ Deletar posts IDs: 124, 125
   ✓ Deletados!

━━━━━━━━━━━━━━━━━━━━━━━━━━━━
✅ LIMPEZA CONCLUÍDA!
🗑️ Posts deletados: 10
✅ Grupos mantidos: 5
━━━━━━━━━━━━━━━━━━━━━━━━━━━━
```

---

## 🎯 Benefícios

### **Antes:**
❌ Múltiplos posts do mesmo produto no mesmo dia
❌ Múltiplos carrosséis no mesmo dia
❌ Spam na timeline
❌ Desperdício de processamento de imagens
❌ Confusão para o público

### **Depois:**
✅ **1 post por produto por dia** por plataforma
✅ **1 carrossel por dia** por plataforma
✅ Timeline limpa e profissional
✅ Processamento eficiente
✅ Melhor experiência do usuário

---

## 🚀 Como Usar

### **1. Limpar posts duplicados existentes:**
```bash
# Primeiro, ver o que seria deletado
php artisan ai:clean-duplicate-posts --dry-run

# Se estiver OK, executar a limpeza
php artisan ai:clean-duplicate-posts
```

### **2. Criar novos posts (agora sem duplicatas):**
```bash
# Posts individuais
php artisan ai:auto-create-posts --limit=5 --platform=facebook

# Carrosséis
php artisan ai:auto-create-carousels --count=1 --products=5 --platform=instagram
```

### **3. Verificar no admin:**
```
http://superloja.test/admin/ai-agent/posts
```

**Você deve ver:**
- ✅ Sem posts duplicados do mesmo produto
- ✅ Apenas 1 carrossel por dia por plataforma
- ✅ Timeline organizada

---

## 📊 Lógica de Agendamento

### **Posts Individuais:**
```
Produto X + Facebook + 04/11/2025
  ├─ 1º post: ✅ CRIADO (09:30)
  ├─ 2º tentativa: ⚠️ SKIP (já existe)
  └─ 3º tentativa: ⚠️ SKIP (já existe)
```

### **Carrosséis:**
```
Facebook + 04/11/2025
  ├─ 1º carrossel: ✅ CRIADO (12:00)
  ├─ 2º tentativa: ⚠️ SKIP (já existe um carrossel hoje)
  └─ 3º tentativa: ⚠️ SKIP (já existe um carrossel hoje)
```

---

## 🔍 Detalhes Técnicos

### **Verificação de Data:**
```php
$todayStart = now()->startOfDay();    // 2025-11-04 00:00:00
$todayEnd = now()->endOfDay();        // 2025-11-04 23:59:59

// Verifica QUALQUER post entre 00:00 e 23:59 de hoje
->whereBetween('scheduled_for', [$todayStart, $todayEnd])
```

### **Status Verificados:**
```php
->whereIn('status', [
    'scheduled',   // Agendado para publicar
    'published',   // Já foi publicado
    'publishing',  // Em processo de publicação
])
```

**Não verifica:**
- `failed` - Posts que falharam podem ser reagendados
- `draft` - Rascunhos não contam

---

## ✅ Checklist de Validação

Após implementar, verifique:

- [ ] Comando `ai:clean-duplicate-posts` executa sem erros
- [ ] Posts duplicados são identificados corretamente
- [ ] Apenas posts extras são deletados (primeiro é mantido)
- [ ] `ai:auto-create-posts` não cria duplicatas
- [ ] `ai:auto-create-carousels` cria apenas 1 por dia
- [ ] Logs mostram "já agendado" ou "já publicado"
- [ ] Admin mostra timeline limpa

---

## 📝 Próximos Passos

### **Prevenção:**
- ✅ Verificação já implementada nos comandos
- ✅ Comando de limpeza disponível
- 💡 Considerar adicionar validação no Model

### **Monitoramento:**
```bash
# Verificar duplicatas periodicamente
php artisan ai:clean-duplicate-posts --dry-run

# Se encontrar duplicatas, executar limpeza
php artisan ai:clean-duplicate-posts
```

### **Automação (opcional):**
Adicionar ao cron para verificar diariamente:
```cron
0 23 * * * php /path/to/artisan ai:clean-duplicate-posts
```

---

## 🎉 Resultado Final

**Antes:**
```
Timeline:
├─ 09:00 - Produto A (duplicado)
├─ 09:30 - Produto A (duplicado)
├─ 10:00 - Produto A (duplicado)
├─ 12:00 - Carrossel 1
├─ 12:30 - Carrossel 2 (duplicado)
└─ 15:00 - Carrossel 3 (duplicado)
```

**Depois:**
```
Timeline:
├─ 09:00 - Produto A ✅
├─ 12:00 - Carrossel ✅
├─ 14:00 - Produto B ✅
└─ 18:00 - Produto C ✅
```

**Timeline limpa, profissional e eficiente!** 🚀

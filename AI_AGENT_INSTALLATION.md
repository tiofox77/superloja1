# 🚀 Instalação do AI Agent - SuperLoja Angola

## ✅ Checklist de Instalação Completa

### 1️⃣ Executar Migration

```bash
php artisan migrate
```

Isso criará as seguintes tabelas:
- ✅ `ai_agent_config` - Configuração do agent
- ✅ `ai_conversations` - Conversas com clientes
- ✅ `ai_messages` - Mensagens individuais
- ✅ `ai_product_insights` - Análises de produtos
- ✅ `ai_auto_posts` - Posts automáticos
- ✅ `ai_agent_actions` - Ações do agent
- ✅ `ai_integration_tokens` - Tokens de API

### 2️⃣ Popular Configuração Inicial

```bash
php artisan db:seed --class=AiAgentSeeder
```

Isso criará a configuração padrão do AI Agent.

### 3️⃣ Configurar Variáveis de Ambiente

Adicione ao arquivo `.env`:

```env
# AI Agent
AI_AGENT_ENABLED=true
AI_ANALYSIS_FREQUENCY=daily
AI_AUTO_POST_ENABLED=false

# Facebook
FACEBOOK_APP_ID=your_app_id_here
FACEBOOK_APP_SECRET=your_app_secret_here
FACEBOOK_VERIFY_TOKEN=sua_senha_secreta_aqui

# Instagram
INSTAGRAM_BUSINESS_ACCOUNT_ID=your_instagram_id_here
INSTAGRAM_VERIFY_TOKEN=outra_senha_secreta_aqui
```

**Importante:** Os `VERIFY_TOKEN` podem ser qualquer string aleatória que você criar. Eles serão usados para validar os webhooks.

### 4️⃣ Configurar Facebook App

1. **Acesse:** https://developers.facebook.com
2. **Crie um App** ou use um existente
3. **Adicione Produtos:**
   - Messenger
   - Instagram (se quiser Instagram Direct)
4. **Configure Webhooks:**
   - URL de Callback: `https://seudominio.com/webhooks/facebook`
   - Verify Token: (o mesmo que você definiu no `.env`)
   - Subscribe to fields: `messages`, `messaging_postbacks`
5. **Gere Access Token:**
   - Vá em Settings → Basic
   - Adicione uma página
   - Gere o Page Access Token
   - Salve no painel admin: `/admin/ai-agent/settings`

### 5️⃣ Configurar Instagram Business

**Pré-requisitos:**
- Conta Instagram convertida para Business Account
- Facebook Page vinculada à conta Instagram

**Passos:**
1. No Facebook Developers, adicione produto "Instagram"
2. Configure webhook similar ao Facebook
3. Obtenha Instagram Business Account ID
4. Salve no painel: `/admin/ai-agent/settings`

### 6️⃣ Executar Primeira Análise

```bash
php artisan ai:analyze-products
```

Isso analisará todos os produtos e gerará insights.

### 7️⃣ Acessar o Painel

Acesse: `https://seudominio.com/admin/ai-agent`

Você verá:
- ✅ Dashboard com estatísticas
- ✅ Produtos analisados
- ✅ Conversas (quando começarem a chegar)
- ✅ Posts agendados

### 8️⃣ Configurar Tarefas Automáticas (Opcional)

Adicione ao crontab ou `app/Console/Kernel.php`:

```php
// Em app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    // Análise diária de produtos às 2h da manhã
    $schedule->command('ai:analyze-products')->dailyAt('02:00');
    
    // Publicar posts 2x ao dia (9h e 18h)
    $schedule->command('ai:publish-posts')->twiceDaily(9, 18);
}
```

**Ou no crontab Linux:**
```bash
# Editar crontab
crontab -e

# Adicionar:
0 2 * * * cd /path/to/superloja && php artisan ai:analyze-products
0 9,18 * * * cd /path/to/superloja && php artisan ai:publish-posts
```

---

## 🧪 Testar o Sistema

### Teste 1: Análise de Produtos

```bash
# Analisar todos os produtos
php artisan ai:analyze-products

# Analisar produto específico
php artisan ai:analyze-products --product=1
```

**Resultado esperado:** Insights gerados na tabela `ai_product_insights`

### Teste 2: Webhook do Facebook

Simule uma mensagem:

```bash
curl -X POST http://localhost:8000/webhooks/facebook \
  -H "Content-Type: application/json" \
  -d '{
    "entry": [{
      "messaging": [{
        "sender": {"id": "123456789"},
        "message": {"text": "olá"}
      }]
    }]
  }'
```

**Resultado esperado:** 
- Conversa criada em `ai_conversations`
- Mensagem salva em `ai_messages`
- Resposta automática enviada

### Teste 3: Agendar Post

Via Painel: `/admin/ai-agent/posts` → Novo Post

Ou via código:
```php
use App\Services\SocialMediaAgentService;
use App\Models\Product;

$service = app(SocialMediaAgentService::class);
$product = Product::first();

$service->scheduleAutoPost($product, 'facebook', now()->addHours(1));
```

**Resultado esperado:** Post agendado em `ai_auto_posts`

### Teste 4: Publicar Posts

```bash
php artisan ai:publish-posts
```

**Resultado esperado:** Posts pendentes são publicados no Facebook/Instagram

---

## 🎯 Primeiros Passos Após Instalação

### Dia 1: Configuração Inicial
1. ✅ Executar migration e seeder
2. ✅ Configurar variáveis de ambiente
3. ✅ Ativar o Agent no dashboard
4. ✅ Executar primeira análise de produtos

### Dia 2: Configurar Integrações
1. ✅ Criar Facebook App
2. ✅ Configurar webhooks
3. ✅ Salvar tokens no painel
4. ✅ Testar envio de mensagem

### Dia 3: Monitorar e Ajustar
1. ✅ Ver insights de produtos
2. ✅ Testar respostas automáticas
3. ✅ Agendar primeiro post
4. ✅ Ajustar configurações conforme necessário

---

## 📊 Estrutura de Arquivos Criados

```
app/
├── Console/Commands/
│   ├── AnalyzeProducts.php          ✅
│   └── PublishScheduledPosts.php    ✅
├── Http/Controllers/Admin/
│   └── AiAgentWebhookController.php ✅
├── Livewire/Admin/AiAgent/
│   ├── AgentDashboard.php           ✅
│   ├── AgentSettings.php            ✅
│   ├── ConversationManager.php      ✅
│   ├── PostScheduler.php            ✅
│   └── ProductInsights.php          ✅
├── Models/
│   ├── AiAgentAction.php            ✅
│   ├── AiAgentConfig.php            ✅
│   ├── AiAutoPost.php               ✅
│   ├── AiConversation.php           ✅
│   ├── AiIntegrationToken.php       ✅
│   ├── AiMessage.php                ✅
│   └── AiProductInsight.php         ✅
└── Services/
    ├── AiAgentService.php           ✅
    └── SocialMediaAgentService.php  ✅

config/
└── aiagent.php                      ✅

database/
├── migrations/
│   └── 2025_10_20_094100_create_ai_agent_tables.php ✅
└── seeders/
    └── AiAgentSeeder.php            ✅

resources/views/livewire/admin/ai-agent/
├── agent-dashboard.blade.php        ✅
├── agent-settings.blade.php         ✅
├── conversation-manager.blade.php   ✅
├── post-scheduler.blade.php         ✅
└── product-insights.blade.php       ✅

routes/
└── web.php (rotas adicionadas)      ✅

Documentação:
├── AI_AGENT_README.md               ✅
└── AI_AGENT_INSTALLATION.md         ✅ (este arquivo)
```

---

## 🔧 Troubleshooting Comum

### Problema: "Class 'AiAgentConfig' not found"
**Solução:**
```bash
composer dump-autoload
php artisan optimize:clear
```

### Problema: Agent não está analisando produtos
**Diagnóstico:**
1. Verificar se está ativo: `/admin/ai-agent`
2. Ver logs: `tail -f storage/logs/laravel.log`
3. Executar manualmente: `php artisan ai:analyze-products`

### Problema: Webhooks não funcionam
**Diagnóstico:**
1. Verificar se URL está acessível publicamente (não localhost)
2. Confirmar verify_token no .env
3. Ver logs: `storage/logs/laravel.log`
4. Testar com curl (veja seção de testes)

### Problema: Posts não são publicados
**Diagnóstico:**
1. Verificar tokens em `/admin/ai-agent/settings`
2. Confirmar permissões do token no Facebook
3. Executar: `php artisan ai:publish-posts`
4. Ver status em `/admin/ai-agent/posts`

### Problema: Erro 500 ao acessar painel
**Solução:**
```bash
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

---

## 📞 Suporte

Para questões sobre:
- **Facebook API:** https://developers.facebook.com/support
- **Instagram API:** https://developers.facebook.com/docs/instagram-api
- **Laravel:** https://laravel.com/docs

---

## 🎉 Conclusão

Após seguir todos os passos, você terá:

✅ **AI Agent totalmente funcional**
✅ **Análise automática de produtos**
✅ **Chat integrado com Instagram e Facebook**
✅ **Postagem automática nas redes sociais**
✅ **Recomendações inteligentes**
✅ **Dashboard completo de métricas**

**Próximos passos sugeridos:**
1. Monitorar conversas diariamente
2. Ajustar respostas automáticas conforme feedback
3. Criar mais templates de posts
4. Analisar performance dos produtos
5. Implementar melhorias baseadas nos insights

---

**Desenvolvido para SuperLoja Angola** 🇦🇴  
**Versão:** 1.0  
**Data:** 20/10/2025

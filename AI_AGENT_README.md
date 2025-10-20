# 🤖 AI Agent - SuperLoja Angola

## 📋 Visão Geral

O **AI Agent** é um sistema inteligente de automação e gestão para a SuperLoja Angola que:

- 📊 **Analisa produtos** e identifica tendências de vendas
- 🔥 **Detecta produtos quentes** (alta performance) e frios (baixa performance)
- 💡 **Gera recomendações inteligentes** baseadas em dados
- 💬 **Responde automaticamente** mensagens no Instagram e Facebook
- 📱 **Publica automaticamente** no Facebook e Instagram
- 📈 **Fornece insights** para tomada de decisão

---

## 🏗️ Estrutura do Sistema

### Models
- **AiAgentConfig** - Configuração geral do agent
- **AiConversation** - Conversas com clientes
- **AiMessage** - Mensagens individuais
- **AiProductInsight** - Análises e insights de produtos
- **AiAutoPost** - Posts automáticos agendados
- **AiAgentAction** - Ações e decisões do agent
- **AiIntegrationToken** - Tokens de integração (Facebook/Instagram)

### Services
- **AiAgentService** - Lógica principal de análise e insights
- **SocialMediaAgentService** - Integração com redes sociais

### Livewire Components
- **AgentDashboard** - Dashboard principal
- **ProductInsights** - Visualização de insights
- **ConversationManager** - Gestão de conversas
- **PostScheduler** - Agendamento de posts
- **AgentSettings** - Configurações

---

## 🚀 Instalação

### 1. Executar Migration

```bash
php artisan migrate
```

### 2. Popular Configuração Inicial

```bash
php artisan db:seed --class=AiAgentSeeder
```

### 3. Configurar Variáveis de Ambiente

Adicione ao arquivo `.env`:

```env
# AI Agent
AI_AGENT_ENABLED=true
AI_ANALYSIS_FREQUENCY=daily
AI_AUTO_POST_ENABLED=false

# Facebook
FACEBOOK_APP_ID=your_app_id
FACEBOOK_APP_SECRET=your_app_secret
FACEBOOK_VERIFY_TOKEN=your_custom_verify_token

# Instagram
INSTAGRAM_BUSINESS_ACCOUNT_ID=your_instagram_business_id
INSTAGRAM_VERIFY_TOKEN=your_custom_verify_token
```

---

## 📊 Funcionalidades Principais

### 1. Análise de Produtos

O AI Agent analisa produtos com base em:
- **Vendas totais** (últimos 30 dias)
- **Receita gerada**
- **Taxa de conversão** (vendas / visualizações)
- **Estoque disponível**

**Status de Performance:**
- 🔥 **HOT** - Alta performance (≥10 vendas, ≥5% conversão)
- ❄️ **COLD** - Baixa performance (≤2 vendas, <1% conversão)
- 📉 **DECLINING** - Em declínio (2-10 vendas, <2% conversão)
- 📊 **STEADY** - Estável (performance regular)

**Executar análise manual:**
```bash
php artisan ai:analyze-products
```

**Analisar produto específico:**
```bash
php artisan ai:analyze-products --product=1
```

### 2. Recomendações Inteligentes

Para cada produto, o agent gera recomendações específicas:

**Produtos HOT:**
- Aumentar estoque
- Promover nas redes sociais
- Destacar na homepage

**Produtos COLD:**
- Criar promoções
- Melhorar descrição/imagens
- Criar bundles

**Recomendações por Categoria:**
- **Tecnologia:** Destacar especificações, criar conteúdo educativo
- **Saúde:** Enfatizar benefícios, adicionar certificações
- **Limpeza:** Compartilhar dicas de uso, destacar eco-friendly

### 3. Integração com Facebook Messenger

**Configuração:**

1. Criar App no [Facebook Developers](https://developers.facebook.com)
2. Adicionar produto "Messenger"
3. Configurar Webhook:
   - URL: `https://seudominio.com/webhooks/facebook`
   - Verify Token: (mesmo do .env)
   - Subscribe to: `messages`, `messaging_postbacks`
4. Gerar Page Access Token
5. Salvar token em `/admin/ai-agent/settings`

**Respostas Automáticas:**
- Saudações → Mensagem de boas-vindas
- "produtos" → Lista de categorias
- "preço" → Informações de contato
- "entrega" → Informações de envio

### 4. Integração com Instagram

**Configuração:**

1. Converter conta para Business Account
2. Vincular ao Facebook Page
3. Configurar Webhook:
   - URL: `https://seudominio.com/webhooks/instagram`
   - Verify Token: (mesmo do .env)
4. Obter Instagram Business Account ID
5. Salvar token em `/admin/ai-agent/settings`

### 5. Postagem Automática

**Agendar post:**
```php
$socialMediaAgent->scheduleAutoPost($product, 'facebook', now()->addHours(2));
```

**Publicar posts pendentes:**
```bash
php artisan ai:publish-posts
```

**Configurar no Cron (opcional):**
```bash
# Publicar posts 2x ao dia (9h e 18h)
0 9,18 * * * cd /path/to/superloja && php artisan ai:publish-posts
```

**Conteúdo gerado automaticamente:**
- Mensagem atrativa com emojis
- Preço (com destaque para promoções)
- Descrição curta
- Call-to-action
- Hashtags relevantes por categoria
- Imagem do produto

---

## 🎯 Como Usar

### 1. Acessar Dashboard

Navegue para: `/admin/ai-agent`

### 2. Ativar o Agent

Clique no botão "▶️ Ativar Agent" no dashboard

### 3. Executar Primeira Análise

Clique em "🔄 Executar Análise" ou via command:
```bash
php artisan ai:analyze-products
```

### 4. Configurar Integrações

1. Acesse `/admin/ai-agent/settings`
2. Adicione tokens do Facebook e Instagram
3. Ative as integrações desejadas
4. Salve as configurações

### 5. Visualizar Insights

Acesse `/admin/ai-agent/insights` para ver:
- Performance de cada produto
- Recomendações específicas
- Métricas detalhadas

### 6. Gerenciar Conversas

Acesse `/admin/ai-agent/conversations` para:
- Ver conversas ativas
- Responder manualmente
- Visualizar histórico

### 7. Agendar Posts

Acesse `/admin/ai-agent/posts` para:
- Agendar posts automáticos
- Ver posts pendentes
- Publicar imediatamente

---

## 📈 Análise Automática (Cron)

Configure no crontab para executar análises diárias:

```bash
# Análise diária às 2h da manhã
0 2 * * * cd /path/to/superloja && php artisan ai:analyze-products

# Publicar posts 2x ao dia
0 9,18 * * * cd /path/to/superloja && php artisan ai:publish-posts
```

Ou adicione no `app/Console/Kernel.php`:

```php
protected function schedule(Schedule $schedule)
{
    // Análise diária de produtos
    $schedule->command('ai:analyze-products')->dailyAt('02:00');
    
    // Publicar posts automáticos
    $schedule->command('ai:publish-posts')->twiceDaily(9, 18);
}
```

---

## 🔒 Segurança

### Webhooks
- Valide sempre o verify_token
- Use HTTPS em produção
- Implemente rate limiting

### Tokens
- Nunca exponha tokens no código
- Use variáveis de ambiente
- Renove tokens periodicamente
- Verifique expiração

### Dados
- Não armazene informações sensíveis nas conversas
- Implemente política de retenção de dados
- Criptografe tokens no banco

---

## 🧪 Testes

### Testar Webhook do Facebook

```bash
curl -X POST http://localhost:8000/webhooks/facebook \
  -H "Content-Type: application/json" \
  -d '{"entry": [{"messaging": [{"sender": {"id": "123"}, "message": {"text": "olá"}}]}]}'
```

### Testar Análise de Produto

```bash
php artisan ai:analyze-products --product=1
```

---

## 📊 Métricas e KPIs

O AI Agent rastreia:
- **Conversas:** Total, ativas, fechadas
- **Mensagens:** Enviadas, recebidas, taxa de resposta
- **Posts:** Agendados, publicados, engajamento
- **Insights:** Produtos analisados, recomendações geradas
- **Performance:** Hot products, cold products, receita

---

## 🎨 Personalização

### Modificar Recomendações

Edite `app/Services/AiAgentService.php`:
- `calculatePerformanceStatus()` - Critérios de performance
- `generateProductRecommendations()` - Lógica de recomendações
- `getCategorySpecificRecommendations()` - Recomendações por categoria

### Modificar Respostas Automáticas

Edite `app/Services/SocialMediaAgentService.php`:
- `generateAutomaticResponse()` - Lógica de respostas

### Modificar Conteúdo de Posts

Edite `app/Services/SocialMediaAgentService.php`:
- `generateProductPostContent()` - Geração de conteúdo

---

## 🐛 Troubleshooting

### Agent não está analisando produtos
- Verifique se está ativo: `/admin/ai-agent`
- Execute manualmente: `php artisan ai:analyze-products`
- Verifique logs: `storage/logs/laravel.log`

### Mensagens não chegam/não são enviadas
- Verifique tokens em `/admin/ai-agent/settings`
- Confirme que webhooks estão configurados
- Verifique logs de webhook: `storage/logs/laravel.log`

### Posts não são publicados
- Execute: `php artisan ai:publish-posts`
- Verifique status em `/admin/ai-agent/posts`
- Confirme tokens e permissões

---

## 📚 Recursos Adicionais

### APIs Utilizadas
- [Facebook Graph API](https://developers.facebook.com/docs/graph-api)
- [Instagram Graph API](https://developers.facebook.com/docs/instagram-api)
- [Facebook Messenger Platform](https://developers.facebook.com/docs/messenger-platform)

### Documentação
- [Facebook Webhooks](https://developers.facebook.com/docs/graph-api/webhooks)
- [Instagram Messaging](https://developers.facebook.com/docs/messenger-platform/instagram)

---

## 🎯 Roadmap Futuro

- [ ] Integração com OpenAI/ChatGPT para respostas mais inteligentes
- [ ] Análise de sentimento nas conversas
- [ ] Predição de vendas com ML
- [ ] Integração com WhatsApp Business API
- [ ] A/B testing de posts automáticos
- [ ] Recomendações de preços dinâmicos
- [ ] Detecção automática de fraudes

---

## ✅ Checklist de Implementação

### Backend (Concluído)
- [x] Migrations para todas as tabelas
- [x] Models com relacionamentos
- [x] AiAgentService (análise e insights)
- [x] SocialMediaAgentService (integração redes sociais)
- [x] Commands (analyze-products, publish-posts)
- [x] Webhook Controller
- [x] Rotas admin e webhooks

### Frontend (Livewire)
- [x] AgentDashboard
- [x] ProductInsights
- [x] ConversationManager
- [x] PostScheduler
- [x] AgentSettings
- [ ] Views Blade (necessário criar)

### Integrações
- [x] Facebook Messenger (código pronto)
- [x] Instagram Direct (código pronto)
- [x] Postagem Facebook (código pronto)
- [x] Postagem Instagram (código pronto)
- [ ] Configurar apps no Facebook Developers
- [ ] Obter e configurar tokens

### Testes
- [ ] Testar análise de produtos
- [ ] Testar webhooks
- [ ] Testar postagem automática
- [ ] Testar respostas automáticas

### Documentação
- [x] README completo
- [x] Comentários no código
- [x] Guia de configuração

---

**Desenvolvido para SuperLoja Angola** 🇦🇴  
**Versão:** 1.0  
**Data:** 20/10/2025

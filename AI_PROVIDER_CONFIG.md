# 🤖 Configuração de AI Provider - OpenAI e Claude

## ✅ Funcionalidade Implementada

O AI Agent agora permite configurar e escolher entre **OpenAI** e **Claude AI** como provider de inteligência artificial, com seleção de modelos específicos.

---

## 🎯 Recursos Disponíveis

### 1. **Seleção de Provider**
- ✅ **OpenAI** (GPT-4, GPT-3.5)
- ✅ **Anthropic Claude** (Claude 3.5 Sonnet, Opus, etc)

### 2. **Configuração de API Keys**
- ✅ Armazenamento criptografado no banco de dados
- ✅ Indicadores visuais de configuração
- ✅ Proteção de dados sensíveis

### 3. **Seleção de Modelos**

#### OpenAI:
- **GPT-4o** - Mais avançado, multimodal
- **GPT-4o Mini** - Rápido e eficiente
- **GPT-4 Turbo** - Contexto grande
- **GPT-4** - Clássico, mais preciso
- **GPT-3.5 Turbo** - Rápido e econômico

#### Claude:
- **Claude 3.5 Sonnet** - Mais recente, balanceado
- **Claude 3 Opus** - Mais inteligente
- **Claude 3 Sonnet** - Balanceado
- **Claude 3 Haiku** - Mais rápido

---

## 📍 Como Acessar

### URL Direta:
```
http://superloja.test/admin/ai-agent/settings#ai-config
```

### Navegação:
1. Acesse o painel admin
2. Menu lateral: **AI Agent** → **⚙️ Configurações AI**
3. Clique na aba **🤖 Configuração de IA**

---

## 🚀 Como Configurar

### OpenAI

#### 1. Obter API Key
1. Acesse https://platform.openai.com/api-keys
2. Faça login ou crie uma conta
3. Vá em "API Keys"
4. Clique em "Create new secret key"
5. Copie a chave (começa com `sk-...`)

#### 2. Configurar no Sistema
1. Acesse `/admin/ai-agent/settings#ai-config`
2. Selecione "🤖 OpenAI" como provider
3. Cole a API Key
4. Escolha o modelo desejado
5. Clique em "💾 Salvar Configurações de IA"

**Resultado:**
```
✅ Configurações do sistema salvas com sucesso!
✓ API Key configurada (criptografada)
Modelo atual: gpt-4o-mini
```

---

### Claude AI

#### 1. Obter API Key
1. Acesse https://console.anthropic.com/
2. Faça login ou crie uma conta
3. Vá em "API Keys"
4. Gere uma nova chave
5. Copie a chave (começa com `sk-ant-...`)

#### 2. Configurar no Sistema
1. Acesse `/admin/ai-agent/settings#ai-config`
2. Selecione "🧠 Anthropic Claude" como provider
3. Cole a API Key
4. Escolha o modelo desejado
5. Clique em "💾 Salvar Configurações de IA"

**Resultado:**
```
✅ Configurações do sistema salvas com sucesso!
✓ API Key configurada (criptografada)
Modelo atual: claude-3-5-sonnet-20241022
```

---

## 💾 Armazenamento

### Banco de Dados (system_configs)

| Chave | Tipo | Criptografado | Padrão |
|-------|------|---------------|--------|
| `ai_provider` | string | ❌ | `openai` |
| `openai_api_key` | string | ✅ | `(vazio)` |
| `openai_model` | string | ❌ | `gpt-4o-mini` |
| `claude_api_key` | string | ✅ | `(vazio)` |
| `claude_model` | string | ❌ | `claude-3-5-sonnet-20241022` |

### Criptografia
```php
// API Keys são automaticamente criptografadas
SystemConfig::set('openai_api_key', 'sk-...', [
    'is_encrypted' => true
]);

// Ao ler, são automaticamente descriptografadas
$apiKey = SystemConfig::get('openai_api_key');
```

---

## 🎨 Interface

### Estados Visuais

#### Provider Ativo (OpenAI)
```
┌─────────────────────────────────────┐
│ 🤖 OpenAI Configuration             │
│ ✅ ATIVO                            │
│                                      │
│ 🔑 API Key: [**************]        │
│ ✓ API Key configurada (criptografada)
│                                      │
│ 🎯 Modelo: [GPT-4o Mini ▼]         │
│ Modelo atual: gpt-4o-mini           │
└─────────────────────────────────────┘
```

#### Provider Inativo (Claude)
```
┌─────────────────────────────────────┐
│ 🧠 Claude AI Configuration          │
│ (desabilitado - opaco)               │
│                                      │
│ Campos desabilitados                │
└─────────────────────────────────────┘
```

### Indicadores

✅ **Token Configurado**
```
✓ API Key configurada (criptografada)
```

⚠️ **Token Não Configurado**
```
(nenhum indicador)
Deixe vazio para manter a chave atual
```

🔮 **Provider Selecionado**
```
Selecionado: OpenAI GPT
```

---

## 🔧 Como Usar no Código

### Obter Provider Atual
```php
use App\Models\SystemConfig;

$provider = SystemConfig::get('ai_provider', 'openai');
// Retorna: 'openai' ou 'claude'
```

### Obter API Key
```php
if ($provider === 'openai') {
    $apiKey = SystemConfig::get('openai_api_key');
    $model = SystemConfig::get('openai_model', 'gpt-4o-mini');
} else {
    $apiKey = SystemConfig::get('claude_api_key');
    $model = SystemConfig::get('claude_model', 'claude-3-5-sonnet-20241022');
}
```

### Fazer Requisição (OpenAI)
```php
use OpenAI;

$apiKey = SystemConfig::get('openai_api_key');
$model = SystemConfig::get('openai_model');

$client = OpenAI::client($apiKey);

$response = $client->chat()->create([
    'model' => $model,
    'messages' => [
        ['role' => 'user', 'content' => 'Olá!'],
    ],
]);

$content = $response->choices[0]->message->content;
```

### Fazer Requisição (Claude)
```php
use Anthropic\Anthropic;

$apiKey = SystemConfig::get('claude_api_key');
$model = SystemConfig::get('claude_model');

$client = Anthropic::client($apiKey);

$response = $client->messages()->create([
    'model' => $model,
    'max_tokens' => 1024,
    'messages' => [
        ['role' => 'user', 'content' => 'Olá!'],
    ],
]);

$content = $response->content[0]->text;
```

---

## 📋 Checklist de Implementação

### Backend
- [x] ✅ Propriedades no Livewire Component
- [x] ✅ Método loadSystemConfigs
- [x] ✅ Método saveSystemConfigs
- [x] ✅ Salvamento no banco com criptografia
- [x] ✅ Seeder com valores padrão

### Frontend
- [x] ✅ Seção de configuração de IA
- [x] ✅ Seleção de provider
- [x] ✅ Campos para API Keys
- [x] ✅ Seleção de modelos
- [x] ✅ Estados visuais (ativo/inativo)
- [x] ✅ Indicadores de configuração
- [x] ✅ Instruções de uso
- [x] ✅ Links para documentação

### Segurança
- [x] ✅ API Keys criptografadas
- [x] ✅ Campos de senha (não exibem valor)
- [x] ✅ Validações
- [x] ✅ Armazenamento seguro

---

## 🎯 Modelos Disponíveis

### OpenAI Models

| Modelo | Descrição | Contexto | Custo |
|--------|-----------|----------|-------|
| **gpt-4o** | Mais avançado, multimodal | 128K tokens | $$$ |
| **gpt-4o-mini** | Rápido e eficiente | 128K tokens | $ |
| **gpt-4-turbo** | Contexto grande | 128K tokens | $$$ |
| **gpt-4** | Clássico, mais preciso | 8K tokens | $$$ |
| **gpt-3.5-turbo** | Rápido e econômico | 16K tokens | $ |

### Claude Models

| Modelo | Descrição | Contexto | Custo |
|--------|-----------|----------|-------|
| **claude-3-5-sonnet** | Mais recente, balanceado | 200K tokens | $$ |
| **claude-3-opus** | Mais inteligente | 200K tokens | $$$ |
| **claude-3-sonnet** | Balanceado | 200K tokens | $$ |
| **claude-3-haiku** | Mais rápido | 200K tokens | $ |

**Legenda de Custo:**
- $ = Econômico
- $$ = Moderado
- $$$ = Premium

---

## 🌟 Vantagens

### ✅ Flexibilidade
- Escolha entre 2 providers líderes de mercado
- Múltiplos modelos para diferentes necessidades
- Troca fácil entre providers

### ✅ Segurança
- API Keys criptografadas
- Armazenamento seguro no banco
- Não expostas na interface

### ✅ Facilidade
- Interface visual intuitiva
- Instruções passo a passo
- Indicadores de status

### ✅ Performance
- Cache inteligente (1h)
- Modelos otimizados disponíveis
- Escolha baseada em necessidade vs custo

---

## 💡 Casos de Uso

### OpenAI (GPT)
✅ **Recomendado para:**
- Análise de texto e sentimento
- Geração de conteúdo criativo
- Suporte multimodal (imagem + texto)
- Respostas rápidas

### Claude
✅ **Recomendado para:**
- Conversas longas e detalhadas
- Análise profunda de documentos
- Raciocínio complexo
- Seguir instruções precisas

---

## 🐛 Troubleshooting

### Erro: "API Key inválida"
**Solução:**
1. Verifique se a chave está correta
2. Confirme que a chave está ativa na plataforma
3. Verifique se há créditos disponíveis
4. Re-salve a configuração

### Erro: "Modelo não encontrado"
**Solução:**
1. Verifique se o modelo está disponível
2. Confirme acesso ao modelo na sua conta
3. Use um modelo alternativo

### Provider não muda
**Solução:**
1. Salve as configurações após mudar
2. Limpe o cache: `php artisan cache:clear`
3. Recarregue a página

---

## 📞 Documentação Oficial

### OpenAI
- **Platform:** https://platform.openai.com
- **Docs:** https://platform.openai.com/docs
- **Modelos:** https://platform.openai.com/docs/models
- **Pricing:** https://openai.com/pricing

### Anthropic Claude
- **Console:** https://console.anthropic.com
- **Docs:** https://docs.anthropic.com
- **Modelos:** https://docs.anthropic.com/claude/docs/models-overview
- **Pricing:** https://www.anthropic.com/pricing

---

## ✅ Status

**Implementação:** 100% Completa ✅  
**Testado:** Sim ✅  
**Documentado:** Sim ✅  
**Pronto para Produção:** Sim ✅

---

**Desenvolvido para SuperLoja Angola** 🇦🇴  
**Data:** 20/10/2025  
**Versão:** 1.0

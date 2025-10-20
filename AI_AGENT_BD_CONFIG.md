# ✅ Configurações do AI Agent no Banco de Dados - COMPLETO

## 📋 O Que Foi Implementado

### 🎯 Objetivo Alcançado

Todas as configurações do AI Agent agora são armazenadas no **banco de dados** em vez do arquivo `.env`, incluindo:

- ✅ AI Agent habilitado/desabilitado
- ✅ Frequência de análise (diária/semanal)
- ✅ Posts automáticos habilitados
- ✅ Facebook App ID, App Secret, Verify Token
- ✅ Instagram Business Account ID, Verify Token

---

## 🗄️ Estrutura do Banco de Dados

### Tabela: `system_configs`

```sql
CREATE TABLE system_configs (
    id BIGINT PRIMARY KEY AUTO_INCREMENT,
    key VARCHAR(255) UNIQUE NOT NULL,          -- Chave única
    value TEXT NULL,                            -- Valor
    type VARCHAR(255) DEFAULT 'string',         -- Tipo de dado
    `group` VARCHAR(255) NULL,                  -- Grupo (ai_agent, facebook, etc)
    label VARCHAR(255) NULL,                    -- Label para UI
    description TEXT NULL,                      -- Descrição
    is_encrypted BOOLEAN DEFAULT false,         -- Se é criptografado
    is_public BOOLEAN DEFAULT false,            -- Se é público
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    INDEX (key),
    INDEX (`group`)
);
```

### Tipos de Dados Suportados

- `string` - Texto simples
- `boolean` - Verdadeiro/Falso
- `integer` - Números inteiros
- `float` - Números decimais
- `json` - Objetos JSON

### Criptografia Automática

Valores sensíveis são **automaticamente criptografados** quando `is_encrypted = true`:
- Facebook App Secret ✅ **Criptografado**
- Facebook Verify Token ✅ **Criptografado**
- Instagram Verify Token ✅ **Criptografado**

---

## 💾 Model SystemConfig

### Métodos Disponíveis

#### 1. **Obter Configuração**
```php
$value = SystemConfig::get('ai_agent_enabled', true);
// Retorna valor do banco ou default se não existir
```

#### 2. **Definir Configuração**
```php
SystemConfig::set('ai_agent_enabled', true, [
    'group' => 'ai_agent',
    'type' => 'boolean',
    'label' => 'AI Agent Habilitado',
    'description' => 'Ativar ou desativar o agent',
    'is_encrypted' => false,
]);
```

#### 3. **Obter Grupo de Configurações**
```php
$configs = SystemConfig::getGroup('facebook');
// Retorna array com todas configs do grupo
```

#### 4. **Verificar Se Existe**
```php
if (SystemConfig::has('facebook_app_id')) {
    // Configuração existe
}
```

#### 5. **Deletar Configuração**
```php
SystemConfig::forget('old_config');
```

#### 6. **Limpar Cache**
```php
SystemConfig::clearCache();
```

---

## ⚙️ Configurações Disponíveis

### Grupo: `ai_agent`

| Chave | Tipo | Padrão | Descrição |
|-------|------|--------|-----------|
| `ai_agent_enabled` | boolean | true | AI Agent habilitado |
| `ai_analysis_frequency` | string | 'daily' | Frequência de análise |
| `ai_auto_post_enabled` | boolean | false | Posts automáticos |

### Grupo: `facebook`

| Chave | Tipo | Criptografado | Descrição |
|-------|------|---------------|-----------|
| `facebook_app_id` | string | ❌ | App ID do Facebook |
| `facebook_app_secret` | string | ✅ | App Secret (criptografado) |
| `facebook_verify_token` | string | ✅ | Token para webhook |

### Grupo: `instagram`

| Chave | Tipo | Criptografado | Descrição |
|-------|------|---------------|-----------|
| `instagram_business_account_id` | string | ❌ | Business Account ID |
| `instagram_verify_token` | string | ✅ | Token para webhook |

---

## 🎨 Interface de Usuário

### Página: `/admin/ai-agent/settings`

Nova aba criada: **💾 Configurações Sistema**

#### Seções:

**1. 🤖 AI Agent**
```
☑ AI Agent Habilitado
Frequência de Análise: [Diária ▼]
☑ Posts Automáticos Habilitados
```

**2. 📘 Facebook**
```
Facebook App ID: [____________]
✓ Configurado no banco de dados

Facebook App Secret: [************]
✓ Configurado no banco de dados (criptografado)
Deixe vazio para manter o valor atual

Facebook Verify Token: [************]
✓ Configurado no banco de dados (criptografado)
Use esta mesma string ao configurar o webhook
```

**3. 📸 Instagram**
```
Instagram Business Account ID: [____________]
✓ Configurado no banco de dados

Instagram Verify Token: [************]
✓ Configurado no banco de dados (criptografado)
Use esta mesma string ao configurar o webhook
```

**Botão:**
```
[💾 Salvar Todas Configurações do Sistema]
```

---

## 🔐 Segurança

### 1. **Criptografia Automática**

Valores sensíveis são criptografados usando Laravel Crypt:

```php
// Ao salvar
$encrypted = Crypt::encryptString($value);

// Ao ler
$decrypted = Crypt::decryptString($encrypted);
```

### 2. **Não Exibir Valores Sensíveis**

Na interface, valores criptografados **nunca são exibidos**:
```php
$this->facebook_app_secret = ''; // Sempre vazio na interface
```

Para atualizar, usuário deve digitar novo valor. Campo vazio = manter atual.

### 3. **Cache de 1 Hora**

Configurações são cacheadas por 1 hora para performance:
```php
Cache::remember('system_config_' . $key, 3600, function() {
    // Buscar do banco
});
```

Cache é limpo automaticamente ao salvar.

---

## 🔄 Como Funciona

### Fluxo de Salvamento

```
Usuário preenche formulário
    ↓
Livewire: saveSystemConfigs()
    ↓
SystemConfig::set() para cada campo
    ↓
Valor criptografado se is_encrypted=true
    ↓
Salvo na tabela system_configs
    ↓
Cache limpo
    ↓
Mensagem de sucesso
```

### Fluxo de Leitura

```
Sistema precisa de configuração
    ↓
SystemConfig::get('chave')
    ↓
Verifica cache (1h)
    ↓
Se não no cache, busca do banco
    ↓
Descriptografa se necessário
    ↓
Converte para tipo apropriado
    ↓
Retorna valor
```

### Uso em Webhooks

```
Facebook envia verificação
    ↓
WebhookController recebe
    ↓
SystemConfig::get('facebook_verify_token')
    ↓
Compara com token recebido
    ↓
Retorna challenge ou erro 403
```

---

## 📁 Arquivos Criados/Modificados

### Novos Arquivos

```
✅ database/migrations/2025_10_20_095600_create_system_configs_table.php
   Migration para tabela system_configs

✅ app/Models/SystemConfig.php
   Model com métodos get(), set(), getGroup(), etc

✅ database/seeders/SystemConfigSeeder.php
   Seeder com configurações padrão

✅ AI_AGENT_BD_CONFIG.md
   Este arquivo de documentação
```

### Arquivos Modificados

```
✏️ app/Livewire/Admin/AiAgent/AgentSettings.php
   - Propriedades para configs do sistema
   - Método loadSystemConfigs()
   - Método saveSystemConfigs()

✏️ resources/views/livewire/admin/ai-agent/agent-settings.blade.php
   - Nova aba "Configurações Sistema"
   - Formulário completo
   - Indicadores de configurado

✏️ app/Http/Controllers/Admin/AiAgentWebhookController.php
   - Webhooks usam banco em vez de .env

✏️ .env.example
   - Removido configs do AI Agent
   - Adicionado nota sobre banco de dados
```

---

## 🚀 Como Usar

### 1. **Executar Migration**

```bash
php artisan migrate
```

Isso cria a tabela `system_configs`.

### 2. **Popular Configurações Iniciais**

```bash
php artisan db:seed --class=SystemConfigSeeder
```

Isso popula com valores padrão.

### 3. **Acessar Interface**

```
/admin/ai-agent/settings
```

Clique na aba **💾 Configurações Sistema**

### 4. **Configurar**

Preencha os campos desejados:

**AI Agent:**
- ☑ Marque "AI Agent Habilitado"
- Selecione "Diária" ou "Semanal"
- ☑ Marque "Posts Automáticos" se desejar

**Facebook:**
- Cole App ID
- Cole App Secret (será criptografado)
- Defina Verify Token para webhook

**Instagram:**
- Cole Business Account ID
- Defina Verify Token para webhook

### 5. **Salvar**

Clique em **💾 Salvar Todas Configurações do Sistema**

### 6. **Resultado**

```
✅ Configurações do sistema salvas com sucesso!
```

Indicadores ✓ aparecem nos campos configurados.

---

## 💡 Exemplos de Uso no Código

### Verificar Se Agent Está Habilitado

```php
use App\Models\SystemConfig;

if (SystemConfig::get('ai_agent_enabled', false)) {
    // Agent está ativo, executar análise
    $aiAgent->analyzeProducts();
}
```

### Obter Frequência de Análise

```php
$frequency = SystemConfig::get('ai_analysis_frequency', 'daily');

if ($frequency === 'daily') {
    // Executar diariamente
} else {
    // Executar semanalmente
}
```

### Verificar Token no Webhook

```php
// No WebhookController
$storedToken = SystemConfig::get('facebook_verify_token');

if ($receivedToken === $storedToken) {
    // Token válido
    return response($challenge, 200);
}
```

### Salvar Nova Configuração

```php
SystemConfig::set('nova_config', 'valor', [
    'group' => 'ai_agent',
    'type' => 'string',
    'label' => 'Nova Configuração',
    'description' => 'Descrição da config',
]);
```

---

## 🎯 Vantagens

### ✅ Sem Necessidade do .env

Antes:
```env
AI_AGENT_ENABLED=true
FACEBOOK_APP_ID=123456
```

Agora:
```
✅ Tudo no banco de dados
✅ Interface web para configurar
✅ Não precisa editar arquivos
```

### ✅ Criptografia Automática

```php
// Facebook App Secret é automaticamente criptografado
SystemConfig::set('facebook_app_secret', 'secret123', [
    'is_encrypted' => true,
]);

// Ao ler, é automaticamente descriptografado
$secret = SystemConfig::get('facebook_app_secret');
// Retorna: "secret123" (descriptografado)
```

### ✅ Cache Inteligente

```php
// Primeira chamada: busca do banco
$value = SystemConfig::get('ai_agent_enabled');

// Próximas chamadas (1h): retorna do cache
$value = SystemConfig::get('ai_agent_enabled'); // Instantâneo!
```

### ✅ Interface Amigável

- Não precisa SSH
- Não precisa editar arquivos
- Indicadores visuais
- Validações em tempo real
- Botões de teste integrados

---

## 🐛 Troubleshooting

### Erro: "Class SystemConfig not found"

**Solução:**
```bash
composer dump-autoload
php artisan optimize:clear
```

### Configuração não salva

**Verificar:**
1. Migration executada? `php artisan migrate`
2. Tabela existe? Verificar no banco de dados
3. Permissões do banco de dados

### Webhook retorna "Token inválido"

**Verificar:**
1. Token foi salvo? Verificar em `/admin/ai-agent/settings`
2. Token está no banco? Query: `SELECT * FROM system_configs WHERE key = 'facebook_verify_token'`
3. Token do Facebook é o mesmo?

### Cache desatualizado

**Solução:**
```bash
php artisan cache:clear
```

Ou no código:
```php
SystemConfig::clearCache();
```

---

## 📊 Comparação: Antes vs Depois

### Antes (.env)

```env
AI_AGENT_ENABLED=true
AI_ANALYSIS_FREQUENCY=daily
FACEBOOK_APP_ID=123
FACEBOOK_APP_SECRET=secret
FACEBOOK_VERIFY_TOKEN=token123
```

**Problemas:**
- ❌ Precisa SSH/FTP
- ❌ Editar arquivo manualmente
- ❌ Sem criptografia
- ❌ Sem interface
- ❌ Difícil de gerenciar

### Depois (Banco de Dados)

```
✅ Interface web em /admin/ai-agent/settings
✅ Criptografia automática
✅ Cache inteligente
✅ Validações
✅ Indicadores visuais
✅ Fácil de usar
```

---

## ✅ Checklist de Implementação

### Backend
- [x] ✅ Tabela system_configs criada
- [x] ✅ Model SystemConfig implementado
- [x] ✅ Métodos get(), set(), getGroup()
- [x] ✅ Criptografia automática
- [x] ✅ Cache de 1 hora
- [x] ✅ Seeder com valores padrão

### Frontend
- [x] ✅ Nova aba "Configurações Sistema"
- [x] ✅ Formulário completo
- [x] ✅ Indicadores de configurado
- [x] ✅ Mensagens de sucesso/erro
- [x] ✅ Campos de senha ocultos

### Integração
- [x] ✅ AgentSettings carrega do banco
- [x] ✅ AgentSettings salva no banco
- [x] ✅ Webhooks usam banco
- [x] ✅ .env.example atualizado

### Segurança
- [x] ✅ Valores sensíveis criptografados
- [x] ✅ Não exibir senhas na UI
- [x] ✅ Validações implementadas
- [x] ✅ Cache seguro

---

## 🎉 Resultado Final

✅ **Sistema 100% no Banco de Dados**  
✅ **Criptografia Automática**  
✅ **Interface Web Completa**  
✅ **Cache Inteligente**  
✅ **Webhooks Funcionais**  
✅ **Fácil de Usar**  

**Não é mais necessário usar .env para configurações do AI Agent!**

---

**Desenvolvido para SuperLoja Angola** 🇦🇴  
**Data:** 20/10/2025  
**Versão:** 2.0

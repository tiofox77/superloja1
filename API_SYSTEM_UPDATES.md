# API de Updates e Sistema - Superloja

API completa para gestão de updates do sistema, uploads de ficheiros e operações de manutenção.

## ⚠️ Importante - Token de Segurança

Todas as rotas de sistema requerem o **Token de Update**:
- **Header:** `X-Update-Token`
- **Ou parâmetro:** `?token=SEU_TOKEN`

**Token padrão:** `SuperlojaUpdate2024!`

> ⚠️ **Recomendação:** Alterar o token no código ou configurar via `.env` para produção.

---

## 📋 Endpoints Disponíveis

### Sistema
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| `GET` | `/api/v1/system/status` | Ver estado do sistema |
| `POST` | `/api/v1/system/optimize` | Limpar cache e otimizar |

### Updates
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| `GET` | `/api/v1/system/updates/check` | Verificar atualizações |
| `POST` | `/api/v1/system/updates/upload` | Upload e instalar update |

### Ficheiros
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| `POST` | `/api/v1/system/files/upload` | Upload de ficheiros |

### Comandos
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| `POST` | `/api/v1/system/commands/run` | Executar comandos Artisan |

### Backup
| Método | Endpoint | Descrição |
|--------|----------|-----------|
| `GET` | `/api/v1/system/backup/list` | Listar backups |
| `POST` | `/api/v1/system/backup/create` | Criar backup |
| `POST` | `/api/v1/system/backup/restore` | Restaurar backup |

---

## 1️⃣ ESTADO DO SISTEMA

### Endpoint
```
GET https://superloja.vip/api/v1/system/status
```

### Exemplo de Resposta

```json
{
  "success": true,
  "data": {
    "version": "1.0.0",
    "laravel_version": "11.0.0",
    "php_version": "8.2.0",
    "environment": "local",
    "debug_mode": true,
    "database_connection": "mysql",
    "storage_disk": "local",
    "last_backup": "2026-02-10 20:00:00",
    "disk_space": {
      "total": 53687091200,
      "free": 21474836480,
      "used_percent": 60.0
    },
    "queued_jobs": 0
  }
}
```

---

## 2️⃣ VERIFICAR UPDATES

### Endpoint
```
GET https://superloja.vip/api/v1/system/updates/check
```

### Headers
```
X-Update-Token: SuperlojaUpdate2024!
```

### Exemplo de Resposta

```json
{
  "success": true,
  "data": {
    "current_version": "1.0.0",
    "latest_version": "1.1.0",
    "updates_available": 1,
    "updates": [
      {
        "version": "1.1.0",
        "release_date": "2026-02-15",
        "description": "Novas funcionalidades de API e melhorias de performance",
        "file_size": 5242880,
        "checksum": "sha256:abc123...",
        "requires_db_migration": true,
        "breaking_changes": false,
        "download_url": "https://superloja.vip/updates/superloja-v1.1.0.zip"
      }
    ]
  }
}
```

---

## 3️⃣ UPLOAD E INSTALAÇÃO DE UPDATE

### Endpoint
```
POST https://superloja.vip/api/v1/system/updates/upload
```

### Content-Type: `multipart/form-data`

### Headers
```
X-Update-Token: SuperlojaUpdate2024!
```

### Campos do Formulário

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `update_file` | file | ✅ | Ficheiro ZIP do update |
| `version` | string | ✅ | Versão do update (ex: 1.1.0) |
| `description` | string | ❌ | Descrição do update |

### Estrutura Esperada do ZIP

O ficheiro ZIP deve conter:

```
update-v1.1.0.zip
├── manifest.json
├── app/
│   └── Http/
│       └── Controllers/
│           └── NovoController.php
├── config/
│   └── novo-config.php
└── database/
    └── migrations/
        └── 2024_01_01_000000_create_nova_tabela.php
```

### Exemplo manifest.json

```json
{
  "version": "1.1.0",
  "description": "Nova funcionalidade de API",
  "files": [
    "app/Http/Controllers/NovoController.php",
    "config/novo-config.php"
  ],
  "migrations": [
    "2024_01_01_000000_create_nova_tabela.php"
  ],
  "commands": [
    "migrate --force",
    "cache:clear",
    "route:clear"
  ]
}
```

### Exemplo cURL

```bash
curl -X POST https://superloja.vip/api/v1/system/updates/upload \
  -H "X-Update-Token: SuperlojaUpdate2024!" \
  -F "update_file=@/caminho/update-v1.1.0.zip" \
  -F "version=1.1.0" \
  -F "description=Nova funcionalidade de API"
```

### Exemplo JavaScript

```javascript
const formData = new FormData();
formData.append('update_file', document.querySelector('#update_file').files[0]);
formData.append('version', '1.1.0');
formData.append('description', 'Nova funcionalidade de API');

const response = await fetch('https://superloja.vip/api/v1/system/updates/upload', {
  method: 'POST',
  headers: {
    'X-Update-Token': 'SuperlojaUpdate2024!'
  },
  body: formData
});

const data = await response.json();
console.log(data);
```

### Exemplo Python

```python
import requests

url = 'https://superloja.vip/api/v1/system/updates/upload'

files = {
    'update_file': ('update-v1.1.0.zip', open('update-v1.1.0.zip', 'rb'), 'application/zip')
}

data = {
    'version': '1.1.0',
    'description': 'Nova funcionalidade de API'
}

response = requests.post(
    url,
    headers={'X-Update-Token': 'SuperlojaUpdate2024!'},
    data=data,
    files=files
)

print(response.json())
```

### Resposta de Sucesso

```json
{
  "success": true,
  "message": "Update instalado com sucesso!",
  "data": {
    "version": "1.1.0",
    "backup_created": "storage/app/backups/1707590400",
    "files_updated": 5,
    "migrations_run": 2,
    "commands_executed": ["migrate --force", "cache:clear"],
    "changelog": "Nova funcionalidade de API",
    "installed_at": "2026-02-10T21:00:00.000000Z"
  }
}
```

### Resposta de Erro (com rollback)

```json
{
  "success": false,
  "message": "Falha no update: Ficheiro manifest.json não encontrado",
  "rolled_back": true,
  "backup_restored": true
}
```

---

## 4️⃣ UPLOAD DE FICHEIROS

### Endpoint
```
POST https://superloja.vip/api/v1/system/files/upload
```

### Content-Type: `multipart/form-data`

### Headers
```
X-Update-Token: SuperlojaUpdate2024!
```

### Campos do Formulário

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `file` | file | ✅ | Ficheiro a enviar |
| `destination` | string | ✅ | Destino: `plugins`, `themes`, `assets`, `uploads` |
| `filename` | string | ❌ | Nome personalizado |

### Destinos Disponíveis

| Destino | Descrição | Tipos Aceites |
|---------|-----------|---------------|
| `plugins` | Plugins do sistema | ZIP, PHP |
| `themes` | Temas do sistema | ZIP, PHP |
| `assets` | Assets públicos | Imagens, CSS, JS |
| `uploads` | Uploads de utilizadores | Imagens, PDF, CSV |

### Exemplo cURL (Enviar plugin)

```bash
curl -X POST https://superloja.vip/api/v1/system/files/upload \
  -H "X-Update-Token: SuperlojaUpdate2024!" \
  -F "file=@/meu-plugin.zip" \
  -F "destination=plugins" \
  -F "filename=meu-plugin-v1.0.zip"
```

### Exemplo cURL (Enviar imagem)

```bash
curl -X POST https://superloja.vip/api/v1/system/files/upload \
  -H "X-Update-Token: SuperlojaUpdate2024!" \
  -F "file=@/produto.jpg" \
  -F "destination=uploads"
```

### Resposta de Sucesso

```json
{
  "success": true,
  "message": "Ficheiro enviado com sucesso.",
  "data": {
    "filename": "1707590400_produto.jpg",
    "path": "/storage/app/uploads/1707590400_produto.jpg",
    "size": 524288,
    "mime_type": "image/jpeg",
    "extracted": false,
    "extract_path": null,
    "uploaded_at": "2026-02-10T21:00:00.000000Z"
  }
}
```

### Resposta (ZIP extraído automaticamente)

```json
{
  "success": true,
  "message": "Ficheiro enviado com sucesso.",
  "data": {
    "filename": "meu-plugin-v1.0.zip",
    "path": "/plugins/meu-plugin-v1.0.zip",
    "size": 1048576,
    "mime_type": "application/zip",
    "extracted": true,
    "extract_path": "/plugins/meu-plugin-v1.0",
    "uploaded_at": "2026-02-10T21:00:00.000000Z"
  }
}
```

---

## 5️⃣ EXECUTAR COMANDOS

### Endpoint
```
POST https://superloja.vip/api/v1/system/commands/run
```

### Headers
```
X-Update-Token: SuperlojaUpdate2024!
Content-Type: application/json
```

### Body JSON

```json
{
  "command": "migrate",
  "force": true,
  "params": ["--path=database/migrations/custom"]
}
```

### Comandos Disponíveis

| Comando | Descrição |
|---------|-----------|
| `migrate` | Executar migrações |
| `cache:clear` | Limpar cache |
| `config:clear` | Limpar configuração |
| `route:clear` | Limpar rotas |
| `view:clear` | Limpar views |
| `optimize` | Otimizar aplicação |
| `db:seed` | Executar seeders |

### Exemplo cURL

```bash
curl -X POST https://superloja.vip/api/v1/system/commands/run \
  -H "X-Update-Token: SuperlojaUpdate2024!" \
  -H "Content-Type: application/json" \
  -d '{"command": "migrate", "force": true}'
```

### Resposta de Sucesso

```json
{
  "success": true,
  "message": "Comando executado com sucesso.",
  "data": {
    "command": "migrate",
    "output": "Migrating: 2024_01_01_000000_create_table\nMigrated: 2024_01_01_000000_create_table",
    "exit_code": 0,
    "executed_at": "2026-02-10T21:00:00.000000Z"
  }
}
```

---

## 6️⃣ BACKUPS

### Listar Backups

```
GET https://superloja.vip/api/v1/system/backup/list
```

### Resposta

```json
{
  "success": true,
  "data": {
    "count": 3,
    "backups": [
      {
        "filename": "1707590400",
        "path": "C:/laragon/www/superloja/storage/app/backups/1707590400",
        "size": 52428800,
        "created_at": "2026-02-10 21:00:00"
      },
      {
        "filename": "1707504000",
        "path": "C:/laragon/www/superloja/storage/app/backups/1707504000",
        "size": 48345000,
        "created_at": "2026-02-09 21:00:00"
      }
    ]
  }
}
```

### Criar Backup

```
POST https://superloja.vip/api/v1/system/backup/create
```

### Resposta

```json
{
  "success": true,
  "message": "Backup criado com sucesso.",
  "data": {
    "backup_path": "storage/app/backups/1707590400",
    "created_at": "2026-02-10 21:00:00",
    "files_included": [".env", "app/", "config/", "database/", "routes/"]
  }
}
```

### Restaurar Backup

```
POST https://superloja.vip/api/v1/system/backup/restore
```

### Body JSON

```json
{
  "backup_path": "storage/app/backups/1707590400"
}
```

### Resposta

```json
{
  "success": true,
  "message": "Backup restaurado com sucesso."
}
```

---

## 7️⃣ OTIMIZAR SISTEMA

### Endpoint
```
POST https://superloja.vip/api/v1/system/optimize
```

### Headers
```
X-Update-Token: SuperlojaUpdate2024!
```

### Exemplo cURL

```bash
curl -X POST https://superloja.vip/api/v1/system/optimize \
  -H "X-Update-Token: SuperlojaUpdate2024!"
```

### Resposta de Sucesso

```json
{
  "success": true,
  "message": "Sistema otimizado com sucesso.",
  "data": {
    "commands_run": [
      "optimize:clear",
      "view:clear",
      "config:clear",
      "route:clear",
      "cache:clear",
      "optimize"
    ],
    "optimized_at": "2026-02-10T21:00:00.000000Z"
  }
}
```

---

## ⚠️ Códigos de Erro

| Código | Descrição |
|--------|-----------|
| `200` | Sucesso |
| `201` | Criado com sucesso |
| `400` | Erro na requisição |
| `401` | Token inválido ou ausente |
| `500` | Erro interno (rollback automático) |

### Exemplo de Erro

```json
{
  "success": false,
  "message": "Token de update inválido.",
  "error_code": "UNAUTHORIZED"
}
```

---

## 📁 Estrutura de Ficheiros

```
superloja/
├── app/
│   └── Http/
│       └── Controllers/
│           └── Api/
│               └── SystemUpdateController.php  ← NOVO
├── storage/
│   └── app/
│       ├── updates/           ← Updates guardados
│       ├── backups/           ← Backups automáticos
│       └── temp_update/       ← Extração temporária
└── routes/
    └── api.php               ← Rotas atualizadas
```

---

## 🔒 Medidas de Segurança

1. **Token obrigatório** em todas as rotas de sistema
2. **Backup automático** antes de qualquer update
3. **Rollback automático** em caso de falha
4. **Verificação de checksum** dos ficheiros
5. **Manifest.json** obrigatório para updates

---

## 📝 Notas Importantes

1. **Tamanho máximo de update:** 100MB
2. **Tamanho máximo de ficheiros:** 50MB
3. **Formato de update:** ZIP com `manifest.json`
4. **Token:** Alterar em produção!
5. **Backups:** Guardados em `storage/app/backups/`

---

## 🔗 Links Úteis

- **API de Produtos:** [API_PRODUTOS_IMAGES.md](API_PRODUTOS_IMAGES.md)
- **Documentação Geral:** [API.md](API.md)
- **Token de Update:** `SuperlojaUpdate2024!`

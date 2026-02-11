# API de Updates e Sistema - Superloja

API para gestão de updates, manutenção e backups do sistema Superloja.

---

## Autenticação

**Token:** `Popadic17`

Todas as rotas (excepto `GET /status`) requerem autenticação via:

| Método | Exemplo |
|--------|---------|
| **Header X-Update-Token** (recomendado) | `X-Update-Token: Popadic17` |
| **Query string** | `?token=Popadic17` |

**Base URL:** `https://superloja.vip/api/v1/system`

---

## Endpoints Disponíveis

| Método | Endpoint | Auth | Descrição |
|--------|----------|------|-----------|
| `GET` | `/status` | Não | Estado do sistema |
| `GET` | `/updates/check` | Sim | Verificar actualizações |
| `POST` | `/updates/upload` | Sim | Upload e instalar update via ZIP |
| `POST` | `/files/upload` | Sim | Upload de ficheiros |
| `POST` | `/commands/run` | Sim | Executar comandos Artisan |
| `GET` | `/backup/list` | Sim | Listar backups |
| `POST` | `/backup/create` | Sim | Criar backup (BD + ficheiros) |
| `POST` | `/backup/restore` | Sim | Restaurar backup |
| `POST` | `/optimize` | Sim | Limpar caches e optimizar |

---

## Guia Rápido para o Agente

### Como actualizar o sistema (fluxo recomendado)

O sistema Superloja é actualizado via **GitHub**. O repositório é `tiofox77/superloja`, branch `main`.

#### Opção A — Puxar última versão (via painel admin)

O utilizador acede a `https://superloja.vip/admin/system/update` e:
1. Clica **"Verificar Atualizações"** → compara versão local com última release do GitHub
2. Se houver update, clica **"Iniciar Atualização"** → automaticamente:
   - Cria backup (BD + ficheiros)
   - Faz `git stash` das alterações locais
   - Faz `git pull origin main`
   - Executa migrations pendentes
   - Limpa caches
   - Restaura stash
3. Se falhar, pode fazer **Rollback** (`git reset --hard HEAD~1`)

#### Opção B — Criar uma release no GitHub

Para publicar uma nova versão:

```bash
# 1. Fazer commit das alterações
git add .
git commit -m "v1.2.0 - Descrição das alterações"
git push origin main

# 2. Criar tag e release
git tag v1.2.0
git push origin v1.2.0
```

Depois, no GitHub: **Releases → Create new release → Seleccionar tag v1.2.0 → Publicar**.

O painel admin vai detectar a nova release automaticamente ao clicar "Verificar Atualizações".

#### Opção C — Upload manual via API

```bash
curl -X POST https://superloja.vip/api/v1/system/updates/upload \
  -H "X-Update-Token: Popadic17" \
  -F "update_file=@update-v1.2.0.zip" \
  -F "version=1.2.0" \
  -F "description=Nova versão com melhorias"
```

O ZIP deve conter um `manifest.json` com a lista de ficheiros, migrations e comandos:

```json
{
  "version": "1.2.0",
  "description": "Melhorias de performance",
  "files": ["app/Http/Controllers/ExemploController.php"],
  "migrations": ["2026_02_11_000000_add_coluna.php"],
  "commands": ["migrate --force", "cache:clear"]
}
```

---

## 1. Estado do Sistema

```bash
curl https://superloja.vip/api/v1/system/status
```

Resposta:
```json
{
  "success": true,
  "data": {
    "version": "1.0.0",
    "laravel_version": "12.30.1",
    "php_version": "8.3.26",
    "environment": "production",
    "debug_mode": false,
    "database_connection": "mysql",
    "storage_disk": "local",
    "last_backup": "2026-02-11 22:00:00",
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

## 2. Verificar Actualizações

```bash
curl -H "X-Update-Token: Popadic17" \
     https://superloja.vip/api/v1/system/updates/check
```

Resposta:
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
        "description": "Novas funcionalidades",
        "requires_db_migration": true,
        "breaking_changes": false
      }
    ]
  }
}
```

---

## 3. Upload e Instalação de Update

```bash
curl -X POST https://superloja.vip/api/v1/system/updates/upload \
  -H "X-Update-Token: Popadic17" \
  -F "update_file=@update-v1.1.0.zip" \
  -F "version=1.1.0" \
  -F "description=Nova funcionalidade"
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `update_file` | file | Sim | Ficheiro ZIP (max 100MB) |
| `version` | string | Sim | Versão (ex: `1.1.0`) |
| `description` | string | Não | Descrição |

Sucesso:
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
    "installed_at": "2026-02-11T22:00:00.000000Z"
  }
}
```

Falha (rollback automático):
```json
{
  "success": false,
  "message": "Falha no update: Ficheiro manifest.json não encontrado",
  "rolled_back": true,
  "backup_restored": true
}
```

---

## 4. Upload de Ficheiros

```bash
# Enviar plugin
curl -X POST https://superloja.vip/api/v1/system/files/upload \
  -H "X-Update-Token: Popadic17" \
  -F "file=@meu-plugin.zip" \
  -F "destination=plugins"

# Enviar imagem
curl -X POST https://superloja.vip/api/v1/system/files/upload \
  -H "X-Update-Token: Popadic17" \
  -F "file=@produto.jpg" \
  -F "destination=uploads"
```

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `file` | file | Sim | Ficheiro (max 50MB) |
| `destination` | string | Sim | `plugins`, `themes`, `assets` ou `uploads` |
| `filename` | string | Não | Nome personalizado |

Destinos e tipos aceites:

| Destino | Tipos Aceites |
|---------|---------------|
| `plugins` | ZIP, PHP |
| `themes` | ZIP, PHP |
| `assets` | Imagens, CSS, JS |
| `uploads` | Imagens, PDF, CSV |

---

## 5. Executar Comandos Artisan

```bash
curl -X POST https://superloja.vip/api/v1/system/commands/run \
  -H "X-Update-Token: Popadic17" \
  -H "Content-Type: application/json" \
  -d '{"command": "migrate", "force": true}'
```

Comandos permitidos:

| Comando | Descrição |
|---------|-----------|
| `migrate` | Executar migrations |
| `cache:clear` | Limpar cache da aplicação |
| `config:clear` | Limpar cache de configuração |
| `route:clear` | Limpar cache de rotas |
| `view:clear` | Limpar cache de views |
| `optimize` | Optimizar aplicação |
| `db:seed` | Executar seeders |

Resposta:
```json
{
  "success": true,
  "message": "Comando executado com sucesso.",
  "data": {
    "command": "migrate",
    "output": "Migrating: 2026_01_01_create_table\nMigrated: 2026_01_01_create_table",
    "exit_code": 0,
    "executed_at": "2026-02-11T22:00:00.000000Z"
  }
}
```

---

## 6. Backups

### Listar

```bash
curl -H "X-Update-Token: Popadic17" \
     https://superloja.vip/api/v1/system/backup/list
```

### Criar

```bash
curl -X POST -H "X-Update-Token: Popadic17" \
     https://superloja.vip/api/v1/system/backup/create
```

Resposta:
```json
{
  "success": true,
  "data": {
    "backup_path": "storage/app/backups/1707590400",
    "created_at": "2026-02-11 22:00:00"
  }
}
```

### Restaurar

```bash
curl -X POST https://superloja.vip/api/v1/system/backup/restore \
  -H "X-Update-Token: Popadic17" \
  -H "Content-Type: application/json" \
  -d '{"backup_path": "storage/app/backups/1707590400"}'
```

---

## 7. Optimizar Sistema

Limpa todos os caches e optimiza a aplicação.

```bash
curl -X POST -H "X-Update-Token: Popadic17" \
     https://superloja.vip/api/v1/system/optimize
```

Resposta:
```json
{
  "success": true,
  "message": "Sistema otimizado com sucesso.",
  "data": {
    "commands_run": [
      "optimize:clear", "view:clear", "config:clear",
      "route:clear", "cache:clear", "optimize"
    ],
    "optimized_at": "2026-02-11T22:00:00.000000Z"
  }
}
```

---

## Códigos de Erro

| Código | Significado | O que fazer |
|--------|-------------|-------------|
| `200` | Sucesso | — |
| `400` | Dados inválidos | Verificar campos enviados |
| `401` | Token inválido | Usar `X-Update-Token: Popadic17` |
| `500` | Erro interno | Rollback automático; verificar logs |

---

## Instruções para o Agente IA

### Workflow de actualização recomendado

```
1. GET /status                    → Verificar versão actual e estado
2. POST /backup/create            → Criar backup antes de qualquer alteração
3. GET /updates/check             → Ver se há update disponível
4. Se houver update:
   a. Informar o utilizador da nova versão
   b. POST /updates/upload        → Se for upload manual
   c. Ou instruir o utilizador a usar o painel admin
5. POST /commands/run (migrate)   → Executar migrations se necessário
6. POST /optimize                 → Limpar caches após actualização
7. GET /status                    → Confirmar nova versão
```

### Regras para o agente

1. **SEMPRE criar backup** antes de qualquer operação destrutiva
2. **NUNCA executar** `db:seed` sem confirmação explícita do utilizador
3. **Verificar o status** antes e depois de cada operação
4. **Se algo falhar**, informar o utilizador e sugerir restaurar backup
5. **Todas as chamadas** (excepto `/status`) precisam do header `X-Update-Token: Popadic17`

### Como o agente deve perguntar ao utilizador

```
Agente: "Detectei que o sistema está na versão 1.0.0 e a última release no GitHub é 1.1.0.
         Quer que eu inicie a actualização? Vou criar um backup primeiro."
Utilizador: "Sim, actualiza."
Agente: "Backup criado. A iniciar actualização..."
        → executa update, migrations, optimize
Agente: "Actualização concluída! Sistema na versão 1.1.0."
```

### Como criar uma release no GitHub (instruir o utilizador)

Se o utilizador quiser publicar uma nova versão:

```
Agente: "Para publicar a versão actual como release no GitHub, execute:
         1. git add . && git commit -m 'v1.X.0 - Descrição'
         2. git tag v1.X.0
         3. git push origin main --tags
         Depois, no GitHub crie a release a partir da tag.
         O painel admin detectará automaticamente a nova versão."
```

---

## Links

- **API de Produtos:** [API.md](API.md)
- **API de Imagens:** [API_PRODUTOS_IMAGES.md](API_PRODUTOS_IMAGES.md)
- **Token:** `Popadic17`
- **Repositório:** `tiofox77/superloja` (branch `main`)

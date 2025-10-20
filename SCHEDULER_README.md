# 🤖 Publicação Automática de Posts - Configuração

## ⚠️ IMPORTANTE: Ativar o Scheduler

Para que os posts sejam publicados automaticamente no horário agendado, você precisa **ativar o Laravel Scheduler**.

---

## 🚀 Opção 1: Rodar Manualmente (Desenvolvimento)

### Deixar Rodando em Terminal Separado

Abra um **novo terminal** e execute:

```bash
php artisan schedule:work
```

**Deixe este terminal aberto!** Ele vai verificar e publicar posts a cada minuto automaticamente.

### Ou Executar Quando Quiser

```bash
php artisan ai:publish-posts
```

Este comando publica **imediatamente** todos os posts que já passaram do horário agendado.

---

## ⚙️ Opção 2: Tarefa Agendada do Windows (Produção)

### Passo 1: Abrir Agendador de Tarefas

1. Pressione `Win + R`
2. Digite: `taskschd.msc`
3. Enter

### Passo 2: Criar Nova Tarefa

1. Clique em **"Criar Tarefa Básica..."**
2. Nome: `SuperLoja - Publicar Posts`
3. Descrição: `Publicação automática de posts no Facebook/Instagram`

### Passo 3: Configurar Disparador

1. Quando iniciar a tarefa: **Diariamente**
2. Recorrer a cada: **1 dias**
3. Repetir tarefa a cada: **1 minuto**
4. Por um período de: **Indefinidamente**

### Passo 4: Configurar Ação

1. Ação: **Iniciar um programa**
2. Programa/script: 
   ```
   C:\laragon\bin\php\php-8.3-Win32\php.exe
   ```
3. Adicionar argumentos:
   ```
   artisan schedule:run
   ```
4. Iniciar em:
   ```
   C:\laragon2\www\superloja
   ```

### Passo 5: Finalizar

- Marcar: **Executar com privilégios mais altos**
- Configurar para: **Windows 10**

---

## 🔍 Como Verificar Se Está Funcionando

### Ver Logs

```bash
tail -f storage/logs/laravel.log
```

Você verá mensagens como:
```
[INFO] Publicando posts agendados...
[INFO] Post publicado com sucesso
```

### Testar Manualmente

```bash
php artisan ai:publish-posts
```

Output esperado:
```
📱 Verificando posts agendados...
✅ 1 post(s) publicado(s) com sucesso!
```

---

## 📝 Como Funciona

1. **Scheduler** roda a cada minuto
2. Busca posts com:
   - Status = `scheduled`
   - `scheduled_for` <= agora
3. Publica automaticamente
4. Atualiza status para `posted`
5. Salva URL do post

---

## ⏰ Frequência de Verificação

- **Desenvolvimento:** `php artisan schedule:work` (verifica a cada minuto)
- **Produção:** Tarefa do Windows (a cada minuto)
- **Manual:** `php artisan ai:publish-posts` (quando quiser)

---

## 🐛 Troubleshooting

### Posts não publicam automaticamente?

1. **Verificar se scheduler está rodando:**
   ```bash
   # Ver processos
   tasklist | findstr php
   ```

2. **Rodar manualmente para testar:**
   ```bash
   php artisan ai:publish-posts
   ```

3. **Ver logs de erro:**
   ```bash
   tail -f storage/logs/laravel.log
   ```

### Erro "Token não configurado"?

1. Ir em: `/admin/ai-agent/settings`
2. Tab **Integrações**
3. Configurar **Facebook Access Token** + **Page ID**
4. Clicar **"💾 Salvar Token"**

### Imagem não aparece?

1. Executar:
   ```bash
   php artisan storage:link
   ```

---

## ✅ Checklist de Ativação

- [ ] Scheduler configurado em `routes/console.php` ✓ (já feito)
- [ ] Comando `ai:publish-posts` existe ✓ (já feito)
- [ ] **Scheduler rodando** (`schedule:work` ou Tarefa do Windows)
- [ ] Token do Facebook configurado
- [ ] Storage linkado
- [ ] Testar com `php artisan ai:publish-posts`

---

## 🎯 Recomendação

**Para Desenvolvimento (agora):**
```bash
php artisan schedule:work
```

**Para Produção (servidor):**
- Criar Tarefa Agendada do Windows (passos acima)
- Ou usar supervisor/pm2 para manter rodando

---

## 📞 Suporte

Se posts ainda não publicam:
1. Verificar logs: `storage/logs/laravel.log`
2. Testar manualmente: `php artisan ai:publish-posts`
3. Verificar tokens em Configurações → Integrações

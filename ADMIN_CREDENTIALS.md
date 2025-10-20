# 🔐 Credenciais de Administrador - SuperLoja

## 📋 Credenciais Atuais

**Email:** admin@superloja.ao  
**Senha:** Admin2017

---

## 🚀 Como Atualizar a Senha do Admin

### Opção 1: Via Seeder (Recomendado)

```bash
php artisan db:seed --class=UpdateAdminPasswordSeeder
```

**Resultado:**
```
✅ Senha do admin@superloja.ao atualizada para: Admin2017
```

---

### Opção 2: Via Command Artisan

**Atualizar para senha padrão:**
```bash
php artisan admin:update-password
```

**Atualizar com email e senha personalizados:**
```bash
php artisan admin:update-password admin@superloja.ao NovaSenha123
```

**Resultado:**
```
✅ Senha atualizada com sucesso!
📧 Email: admin@superloja.ao
🔑 Nova senha: Admin2017
```

---

## 🔑 Acessar Painel Admin

### 1. Acessar URL
```
http://superloja.test/admin
```

### 2. Fazer Login
- **Email:** admin@superloja.ao
- **Senha:** Admin2017

### 3. Você será redirecionado para
```
http://superloja.test/admin/dashboard
```

---

## 👤 Informações do Usuário Admin

```php
[
    'name' => 'Administrador',
    'first_name' => 'Admin',
    'last_name' => 'SuperLoja',
    'email' => 'admin@superloja.ao',
    'password' => 'Admin2017', // Hash: bcrypt
    'role' => 'admin',
    'is_admin' => true,
    'is_active' => true,
    'phone' => '+244 939 729 902',
]
```

---

## 🛡️ Segurança

### Alterar Senha via Interface

1. Fazer login no painel admin
2. Clicar no avatar no canto superior direito
3. Ir em "Meu Perfil"
4. Alterar senha
5. Salvar

### Boas Práticas

✅ **Fazer:**
- Usar senhas fortes (mínimo 8 caracteres)
- Combinar letras maiúsculas, minúsculas, números e símbolos
- Alterar senha regularmente
- Não compartilhar credenciais

❌ **Evitar:**
- Senhas óbvias (123456, password, admin)
- Usar mesma senha em vários sites
- Compartilhar senha por email/SMS
- Deixar senha anotada em local visível

---

## 🔧 Troubleshooting

### Esqueci a Senha

Execute o comando:
```bash
php artisan admin:update-password admin@superloja.ao NovaSenha
```

### Admin Não Existe

O seeder cria automaticamente se não existir:
```bash
php artisan db:seed --class=UpdateAdminPasswordSeeder
```

### Erro ao Fazer Login

1. Limpar cache:
```bash
php artisan cache:clear
php artisan config:clear
```

2. Verificar se o email está correto:
```bash
php artisan tinker
>>> User::where('email', 'admin@superloja.ao')->first()
```

3. Atualizar senha novamente:
```bash
php artisan admin:update-password
```

---

## 📞 Suporte

**Email:** contato@superloja.ao  
**Telefone:** +244 939 729 902

---

**Última Atualização:** 20/10/2025  
**Desenvolvido para SuperLoja Angola** 🇦🇴

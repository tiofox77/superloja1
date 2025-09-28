# 🛒 SuperLoja Angola

<div align="center">

![SuperLoja Angola](https://img.shields.io/badge/SuperLoja-Angola-orange)
![Laravel](https://img.shields.io/badge/Laravel-11.x-red)
![Livewire](https://img.shields.io/badge/Livewire-3.x-purple)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue)

**Plataforma de E-commerce Moderna para Angola**

*Desenvolvida com Laravel + Livewire + Tailwind CSS*

</div>

---

## 📋 Sobre o Projeto

**SuperLoja Angola** é uma plataforma completa de e-commerce desenvolvida especificamente para o mercado angolano, oferecendo uma experiência moderna e intuitiva para compras online.

### 🎯 Características Principais

- **🏪 E-commerce Completo**: Catálogo de produtos, carrinho, checkout e gestão de pedidos
- **💳 Múltiplos Pagamentos**: Transferência bancária, Multicaixa Express, pagamento na entrega
- **📱 100% Responsivo**: Interface otimizada para desktop, tablet e mobile
- **🔐 Sistema Seguro**: Autenticação, autorização e proteção de dados
- **📊 Painel Admin**: Gestão completa de produtos, pedidos e usuários
- **🎨 Design Moderno**: Interface limpa com gradientes laranja/vermelho
- **🚀 Performance**: Otimizado com Livewire para interações reativas

## 🛠️ Tecnologias Utilizadas

### Backend
- **Laravel 11.x** - Framework PHP robusto
- **Livewire 3.x** - Componentes reativos
- **MySQL** - Base de dados relacional
- **Laravel Breeze** - Autenticação simples

### Frontend
- **Tailwind CSS** - Framework CSS utilitário
- **Alpine.js** - JavaScript reativo
- **Blade Templates** - Motor de templates do Laravel
- **Responsive Design** - Mobile-first approach

### Funcionalidades Avançadas
- **Upload de Arquivos** - Comprovativos de pagamento
- **Sistema de Carrinho** - Sessões persistentes
- **Wishlist** - Lista de desejos
- **Notificações** - Toastr integrado
- **Gestão Admin** - Painel completo de administração

---

## 🚀 Instalação e Configuração

### Pré-requisitos

- **PHP** >= 8.2
- **Composer**
- **Node.js** & NPM
- **MySQL** ou MariaDB

### 1️⃣ Clone o Repositório

```bash
git clone https://github.com/tiofox77/superloja1.git
cd superloja1
```

### 2️⃣ Instalar Dependências

```bash
# Dependências PHP
composer install

# Dependências JavaScript
npm install
```

### 3️⃣ Configuração do Ambiente

```bash
# Copiar arquivo de configuração
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate
```

### 4️⃣ Configurar Base de Dados

Edite o arquivo `.env` com suas configurações:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=superloja
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 5️⃣ Executar Migrações

```bash
# Criar tabelas
php artisan migrate

# Popular com dados de exemplo (opcional)
php artisan db:seed
```

### 6️⃣ Configurar Storage

```bash
# Criar link simbólico para arquivos públicos
php artisan storage:link
```

### 7️⃣ Compilar Assets

```bash
# Para desenvolvimento
npm run dev

# Para produção
npm run build
```

### 8️⃣ Iniciar Servidor

```bash
php artisan serve
```

A aplicação estará disponível em `http://localhost:8000`

---

## 📱 Páginas Implementadas

### 🌐 Frontend (Clientes)
- **🏠 Homepage** - Página inicial com destaques
- **📦 Produtos** - Catálogo completo de produtos
- **📁 Categorias** - Navegação por categorias
- **🔥 Ofertas** - Produtos em promoção
- **⚡ Leilões** - Sistema de leilões online
- **🏷️ Marcas** - Produtos por marca
- **🏢 Sobre Nós** - História e informações da empresa
- **📞 Contacto** - Formulário e informações de contacto
- **❓ FAQ** - Perguntas frequentes interativas
- **🛒 Carrinho** - Gestão de itens selecionados
- **💳 Checkout** - Finalização de compras
- **👤 Perfil** - Área do cliente

### 🔧 Backend (Administração)
- **📊 Dashboard** - Visão geral do sistema
- **📦 Gestão de Produtos** - CRUD completo
- **📁 Gestão de Categorias** - Organização de produtos
- **👥 Gestão de Usuários** - Controle de clientes
- **📋 Gestão de Pedidos** - Acompanhamento completo
- **💰 Sistema POS** - Ponto de venda
- **🎨 Gerador de Catálogo** - Criação automática

---

## 💳 Sistema de Pagamento

### Métodos Suportados

1. **🏦 Transferência Bancária**
   - Dados bancários: BFA - Banco de Fomento Angola
   - Comprovativo obrigatório

2. **🏪 Depósito Bancário**
   - Depósito direto no banco
   - Comprovativo obrigatório

3. **📱 Multicaixa Express**
   - Número: +244 923 456 789
   - Comprovativo obrigatório

4. **💵 Pagamento na Entrega**
   - Cash on Delivery
   - Sem necessidade de comprovativo

### Upload de Comprovativos
- **Formatos aceitos**: JPG, PNG, PDF
- **Tamanho máximo**: 10MB
- **Armazenamento seguro**: `storage/app/public/payment-proofs`
- **Visualização admin**: Modal de pedidos

---

## 🏢 Informações da Empresa

### 📞 Contacto
- **Telefone/WhatsApp**: +244 939 729 902
- **Email**: contato@superloja.ao
- **Localização**: Kilamba J13, Luanda, Angola

### 🕐 Horário de Funcionamento
- **Segunda a Sexta**: 8h às 18h
- **Sábado**: 8h às 14h
- **Domingo**: Fechado

---

## 🎨 Design System

### Cores da Marca
- **Primary**: Gradiente Laranja (#F97316) → Vermelho (#DC2626)
- **Secondary**: Cinza (#6B7280)
- **Success**: Verde (#10B981)
- **Warning**: Amarelo (#F59E0B)

### Componentes UI
- **Cards**: Shadow suave com hover effects
- **Buttons**: Gradientes e transições
- **Forms**: Validação visual em tempo real
- **Modals**: Transições Alpine.js
- **Notifications**: Sistema Toastr integrado

---

## 📊 Funcionalidades Administrativas

### Gestão de Pedidos
- **Visualização completa**: Modal com todos os detalhes
- **Atualização de status**: Em tempo real
- **Impressão**: Layout otimizado para A4
- **Comprovativos**: Visualização e download
- **Filtros**: Por status, cliente, data
- **Exportação**: PDF e CSV

### Gestão de Produtos
- **CRUD completo**: Criar, editar, remover
- **Upload de imagens**: Múltiplas fotos por produto
- **Categorização**: Organização hierárquica
- **Stock**: Controle de inventário
- **SEO**: URLs amigáveis e meta tags

---

## 🚚 Sistema de Entregas

### Cobertura
- **Luanda**: 24-48 horas úteis
- **Interior**: 3-5 dias úteis
- **18 Províncias**: Cobertura nacional completa

### Acompanhamento
- **Status em tempo real**: Do processamento à entrega
- **Notificações**: Email e SMS
- **Área do cliente**: Histórico completo

---

## 🔒 Segurança

### Proteções Implementadas
- **Autenticação**: Laravel Breeze
- **Autorização**: Middleware personalizado
- **CSRF Protection**: Tokens em formulários
- **XSS Protection**: Validação de entrada
- **SQL Injection**: Eloquent ORM
- **File Upload**: Validação rigorosa

---

## 📈 Performance

### Otimizações
- **Livewire**: Componentes reativos sem page reload
- **Lazy Loading**: Carregamento otimizado de imagens
- **Database**: Queries otimizadas com relacionamentos
- **Caching**: Sistema de cache integrado
- **CDN Ready**: Preparado para distribuição

---

## 🤝 Contribuições

Contribuições são bem-vindas! Por favor:

1. **Fork** o projeto
2. Crie sua **feature branch** (`git checkout -b feature/AmazingFeature`)
3. **Commit** suas mudanças (`git commit -m 'Add some AmazingFeature'`)
4. **Push** para a branch (`git push origin feature/AmazingFeature`)
5. Abra um **Pull Request**

---

## 📄 Licença

Este projeto está licenciado sob a **MIT License** - veja o arquivo [LICENSE](LICENSE) para detalhes.

---

## 👨‍💻 Desenvolvedor

**TioFox77**
- GitHub: [@tiofox77](https://github.com/tiofox77)
- Projeto: [SuperLoja Angola](https://github.com/tiofox77/superloja1)

---

<div align="center">

**🛒 SuperLoja Angola - E-commerce do Futuro para Angola 🇦🇴**

*Desenvolvido com ❤️ em Angola*

</div>

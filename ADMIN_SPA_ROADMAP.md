# 🚀 ROADMAP: Reestruturação Completa Admin SPA

## 📋 Visão Geral

**Objetivo:** Transformar o painel administrativo em uma aplicação SPA moderna, limpa e profissional usando Livewire v3 com navegação SPA nativa.

### **🎨 Paleta de Cores SuperLoja:**
```css
--primary: #FF8C00;       /* Laranja SuperLoja */
--primary-dark: #E67E00;  /* Laranja Escuro */
--secondary: #8B1E5C;     /* Vinho/Magenta */
--secondary-dark: #6D1848; /* Vinho Escuro */
--accent: #FFC107;        /* Amarelo Destaque */
--success: #10B981;       /* Verde */
--warning: #F59E0B;       /* Amarelo Warning */
--danger: #EF4444;        /* Vermelho */
--dark: #1F2937;          /* Cinza Escuro */
--light: #F9FAFB;         /* Cinza Claro */
--white: #FFFFFF;         /* Branco */
```

### **✅ Tecnologias:**
- ✅ Livewire v3 (já instalado)
- 🆕 Livewire SPA Navigation (`wire:navigate`)
- 🆕 Alpine.js v3 (integrado)
- 🆕 Tailwind CSS v3+
- 🆕 Lucide Icons (substituir Heroicons)
- 🆕 Chart.js para gráficos
- 🆕 Toasts nativos (sem jQuery)

---

## 📊 FASES DO PROJETO

### **FASE 1: Infraestrutura Base** ✅ CONCLUÍDA
**Duração estimada: 2-3 dias**

#### 1.1 Layout Principal SPA
- [x] Criar novo layout `components/admin/layouts/app.blade.php`
- [x] Implementar `@livewireStyles` e `@livewireScripts`
- [x] Adicionar `wire:navigate` em todos os links
- [x] Configurar `@persist` para sidebar
- [x] Remover jQuery (usar Alpine.js)

#### 1.2 Sistema de Navegação SPA
- [x] Sidebar persistente com Alpine.js
- [x] Loading states com `wire:loading`
- [x] Transições suaves entre páginas
- [x] Breadcrumbs dinâmicos
- [x] Mobile responsive drawer

#### 1.3 Sistema de Notificações
- [x] Toast component nativo (sem Toastr)
- [x] Alert component reutilizável
- [x] Confirmação modal nativa
- [x] Loading overlay global

#### 1.4 Tema e Estilos
- [x] CSS Variables para cores
- [ ] Dark mode support (opcional)
- [x] Componentes base (buttons, inputs, cards)
- [x] Animações e transições CSS

---

### **FASE 2: Componentes UI Reutilizáveis** ✅ CONCLUÍDA
**Duração estimada: 3-4 dias**

#### 2.1 Componentes de Formulário ✅
```
components/admin/form/
├── input.blade.php        ✅
├── select.blade.php       ✅
├── textarea.blade.php     ✅
├── checkbox.blade.php     ✅
├── toggle.blade.php       ✅
├── search.blade.php       ✅
├── image-upload.blade.php ✅
├── date-picker.blade.php  (pendente)
├── color-picker.blade.php (pendente)
└── rich-editor.blade.php  (pendente)
```

#### 2.2 Componentes de Layout ✅
```
components/admin/ui/
├── card.blade.php         ✅
├── modal.blade.php        ✅
├── drawer.blade.php       ✅
├── dropdown.blade.php     ✅
├── dropdown-item.blade.php ✅
├── tabs.blade.php         ✅
├── tab.blade.php          ✅
├── tab-panel.blade.php    ✅
├── table.blade.php        ✅
├── pagination.blade.php   ✅
├── empty-state.blade.php  ✅
├── button.blade.php       ✅
├── badge.blade.php        ✅
├── stats-card.blade.php   ✅
├── alert.blade.php        ✅
├── avatar.blade.php       ✅
├── skeleton.blade.php     ✅
└── confirm-modal.blade.php ✅
```

#### 2.3 Componentes de Feedback
```
components/
├── admin/
│   ├── toast.blade.php
│   ├── alert.blade.php
│   ├── badge.blade.php
│   ├── progress.blade.php
│   ├── skeleton.blade.php
│   └── spinner.blade.php
```

#### 2.4 Componentes de Navegação
```
components/
├── admin/
│   ├── sidebar.blade.php
│   ├── header.blade.php
│   ├── breadcrumb.blade.php
│   ├── menu-item.blade.php
│   └── user-dropdown.blade.php
```

---

### **FASE 3: Dashboard Moderno** ✅ CONCLUÍDA
**Duração estimada: 2-3 dias**

#### 3.1 Widgets de Estatísticas
- [x] Cards de métricas principais (vendas, pedidos, produtos, clientes)
- [x] Gráfico de vendas (últimos 7/30 dias)
- [x] Gráfico de categorias mais vendidas
- [ ] Mini gráficos inline (sparklines)

#### 3.2 Seções do Dashboard
- [x] Resumo financeiro do dia
- [x] Pedidos pendentes
- [x] Produtos com baixo estoque
- [x] Últimas atividades
- [ ] Posts de redes sociais agendados
- [ ] Mensagens não lidas

#### 3.3 Quick Actions
- [x] Criar produto rápido
- [x] Nova venda (POS rápido)
- [ ] Enviar SMS em massa
- [ ] Criar post social

---

### **FASE 4: Módulos Principais (Refatoração)** 🔄 EM PROGRESSO
**Duração estimada: 5-7 dias**

#### 4.1 Produtos ✅
```
livewire/admin/products/
├── ProductsSpa.php           ✅ Lista com filtros SPA
└── views/index-spa.blade.php ✅
```

**Features:**
- [x] Grid/List view toggle
- [x] Filtros (busca, categoria, marca, status)
- [x] Bulk actions (ativar, desativar, deletar)
- [ ] Drag & drop para imagens
- [x] Preview em card
- [x] Toggle status
- [ ] Variantes em accordion

#### 4.2 Categorias ✅
```
livewire/admin/categories/
├── CategoriesSpa.php         ✅ Grid com modal criar/editar
└── views/index-spa.blade.php ✅
```

**Features:**
- [x] Grid de categorias
- [x] Modal criar/editar
- [x] Toggle status
- [x] Contadores de produtos

#### 4.3 Marcas ✅
```
livewire/admin/brands/
├── BrandsSpa.php             ✅ Grid com modal criar/editar
└── views/index-spa.blade.php ✅
```

#### 4.4 Pedidos ✅
```
livewire/admin/orders/
├── OrdersSpa.php             ✅ Lista com drawer detalhes
└── views/index-spa.blade.php ✅
```

#### 4.5 Usuários ✅
```
livewire/admin/users/
├── UsersSpa.php              ✅ Lista com modal criar/editar
└── views/index-spa.blade.php ✅
```

#### 4.6 Configurações ✅
```
livewire/admin/settings/
├── SettingsSpa.php           ✅ Tabs (geral, aparência, SEO, social, loja)
└── views/index-spa.blade.php ✅
```

#### 4.7 Posts IA ✅
```
livewire/admin/ai-agent/
├── PostsSpa.php              ✅ Grid com drawer detalhes
└── views/posts-spa.blade.php ✅
```

---

### **FASE 5: Módulos Restantes (Continuar)**
**Duração estimada: 3-5 dias**

#### 5.1 Pedidos (features antigas)
```
livewire/admin/orders/
├── OrderTimeline.php         # Timeline de eventos
└── components/
    ├── order-card.blade.php
    ├── order-status.blade.php
    └── order-items.blade.php
```

**Features:**
- [ ] Tabs por status
- [ ] Timeline de atualizações
- [ ] Impressão de recibo
- [ ] Atualização de status inline
- [ ] Notificações em tempo real

#### 4.4 Clientes/Usuários
```
livewire/admin/users/
├── UserIndex.php
├── UserShow.php              # Profile drawer
└── components/
    ├── user-avatar.blade.php
    └── user-stats.blade.php
```

#### 4.5 Configurações
```
livewire/admin/settings/
├── SettingsIndex.php         # Tabs de configurações
├── GeneralSettings.php
├── PaymentSettings.php
├── ShippingSettings.php
├── NotificationSettings.php
└── IntegrationSettings.php
```

---

### **FASE 5: Módulos Especiais**
**Duração estimada: 4-5 dias**

#### 5.1 POS (Ponto de Venda)
- [ ] Interface fullscreen
- [ ] Busca de produtos rápida
- [ ] Carrinho lateral
- [ ] Calculadora de troco
- [ ] Atalhos de teclado
- [ ] Impressão de recibo

#### 5.2 AI Agent
- [ ] Dashboard de posts
- [ ] Calendário de agendamentos
- [ ] Gerador de conteúdo
- [ ] Analytics de performance
- [ ] Configurações de automação

#### 5.3 SMS Marketing
- [ ] Composer de mensagens
- [ ] Templates salvos
- [ ] Segmentação de clientes
- [ ] Histórico de envios
- [ ] Analytics

#### 5.4 Leilões
- [ ] Lista de leilões
- [ ] Timer em tempo real
- [ ] Histórico de lances
- [ ] Notificações

---

### **FASE 6: Otimizações e Polimento**
**Duração estimada: 2-3 dias**

#### 6.1 Performance
- [ ] Lazy loading de componentes
- [ ] Cache de queries frequentes
- [ ] Otimização de imagens
- [ ] Minificação de assets

#### 6.2 UX/UI Final
- [ ] Animações micro-interactions
- [ ] Feedback visual em ações
- [ ] Empty states ilustrados
- [ ] Onboarding tour (opcional)

#### 6.3 Acessibilidade
- [ ] Keyboard navigation
- [ ] ARIA labels
- [ ] Focus management
- [ ] Screen reader support

---

## 🏗️ ESTRUTURA DE ARQUIVOS FINAL

```
resources/
├── views/
│   ├── components/
│   │   └── admin/
│   │       ├── layouts/
│   │       │   ├── app.blade.php          # Layout principal SPA
│   │       │   ├── sidebar.blade.php      # Sidebar persistente
│   │       │   ├── header.blade.php       # Header com user menu
│   │       │   └── footer.blade.php       # Footer (opcional)
│   │       ├── ui/
│   │       │   ├── button.blade.php
│   │       │   ├── card.blade.php
│   │       │   ├── modal.blade.php
│   │       │   ├── drawer.blade.php
│   │       │   ├── dropdown.blade.php
│   │       │   ├── table.blade.php
│   │       │   ├── pagination.blade.php
│   │       │   ├── badge.blade.php
│   │       │   ├── alert.blade.php
│   │       │   ├── toast.blade.php
│   │       │   ├── tabs.blade.php
│   │       │   ├── accordion.blade.php
│   │       │   ├── tooltip.blade.php
│   │       │   ├── skeleton.blade.php
│   │       │   └── empty-state.blade.php
│   │       ├── form/
│   │       │   ├── input.blade.php
│   │       │   ├── select.blade.php
│   │       │   ├── textarea.blade.php
│   │       │   ├── checkbox.blade.php
│   │       │   ├── toggle.blade.php
│   │       │   ├── radio.blade.php
│   │       │   ├── file-upload.blade.php
│   │       │   ├── image-upload.blade.php
│   │       │   └── date-picker.blade.php
│   │       └── charts/
│   │           ├── line-chart.blade.php
│   │           ├── bar-chart.blade.php
│   │           ├── pie-chart.blade.php
│   │           └── sparkline.blade.php
│   │
│   └── livewire/
│       └── admin/
│           ├── dashboard/
│           │   └── index.blade.php
│           ├── products/
│           │   ├── index.blade.php
│           │   ├── create.blade.php
│           │   └── edit.blade.php
│           ├── categories/
│           │   └── index.blade.php
│           ├── orders/
│           │   ├── index.blade.php
│           │   └── show.blade.php
│           ├── users/
│           │   └── index.blade.php
│           ├── settings/
│           │   └── index.blade.php
│           ├── pos/
│           │   └── index.blade.php
│           ├── ai-agent/
│           │   ├── posts.blade.php
│           │   ├── carousels.blade.php
│           │   └── settings.blade.php
│           └── sms/
│               └── index.blade.php
│
├── css/
│   └── admin/
│       ├── app.css              # Estilos principais
│       ├── variables.css        # CSS Variables
│       └── components.css       # Componentes
│
└── js/
    └── admin/
        ├── app.js               # Alpine.js setup
        └── charts.js            # Chart.js config
```

---

## 🎨 DESIGN SYSTEM

### **Cores Primárias**
```css
:root {
    /* Cores Principais SuperLoja */
    --color-primary-50: #FFF7ED;
    --color-primary-100: #FFEDD5;
    --color-primary-200: #FED7AA;
    --color-primary-300: #FDBA74;
    --color-primary-400: #FB923C;
    --color-primary-500: #FF8C00;  /* Principal */
    --color-primary-600: #EA580C;
    --color-primary-700: #C2410C;
    --color-primary-800: #9A3412;
    --color-primary-900: #7C2D12;
    
    /* Cores Secundárias (Vinho) */
    --color-secondary-50: #FDF2F8;
    --color-secondary-100: #FCE7F3;
    --color-secondary-200: #FBCFE8;
    --color-secondary-300: #F9A8D4;
    --color-secondary-400: #F472B6;
    --color-secondary-500: #8B1E5C;  /* Principal */
    --color-secondary-600: #6D1848;
    --color-secondary-700: #5A1239;
    --color-secondary-800: #470E2D;
    --color-secondary-900: #360A22;
    
    /* Neutros */
    --color-gray-50: #F9FAFB;
    --color-gray-100: #F3F4F6;
    --color-gray-200: #E5E7EB;
    --color-gray-300: #D1D5DB;
    --color-gray-400: #9CA3AF;
    --color-gray-500: #6B7280;
    --color-gray-600: #4B5563;
    --color-gray-700: #374151;
    --color-gray-800: #1F2937;
    --color-gray-900: #111827;
}
```

### **Tipografia**
```css
:root {
    --font-sans: 'Inter', system-ui, sans-serif;
    --font-mono: 'JetBrains Mono', monospace;
    
    --text-xs: 0.75rem;
    --text-sm: 0.875rem;
    --text-base: 1rem;
    --text-lg: 1.125rem;
    --text-xl: 1.25rem;
    --text-2xl: 1.5rem;
    --text-3xl: 1.875rem;
}
```

### **Espaçamento**
```css
:root {
    --spacing-1: 0.25rem;
    --spacing-2: 0.5rem;
    --spacing-3: 0.75rem;
    --spacing-4: 1rem;
    --spacing-5: 1.25rem;
    --spacing-6: 1.5rem;
    --spacing-8: 2rem;
    --spacing-10: 2.5rem;
    --spacing-12: 3rem;
}
```

### **Bordas e Sombras**
```css
:root {
    --radius-sm: 0.375rem;
    --radius-md: 0.5rem;
    --radius-lg: 0.75rem;
    --radius-xl: 1rem;
    --radius-2xl: 1.5rem;
    --radius-full: 9999px;
    
    --shadow-sm: 0 1px 2px rgba(0, 0, 0, 0.05);
    --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}
```

---

## 📱 PREVIEW DO LAYOUT

### **Desktop Layout**
```
┌─────────────────────────────────────────────────────────────────────┐
│ ┌─────────┬───────────────────────────────────────────────────────┐ │
│ │         │  🔔  🔍 Search...                    👤 Admin ▼       │ │
│ │  LOGO   ├───────────────────────────────────────────────────────┤ │
│ │         │                                                       │ │
│ │ ═══════ │  Dashboard / Produtos                                 │ │
│ │         │  ────────────────────────────────────────────────     │ │
│ │ 📊 Dash │                                                       │ │
│ │ 📦 Prod │  ┌──────────┐  ┌──────────┐  ┌──────────┐            │ │
│ │ 📁 Cat  │  │ 💰 12.5M │  │ 📦 1,234 │  │ 👥 567   │            │ │
│ │ 🛒 Ped  │  │ Vendas   │  │ Produtos │  │ Clientes │            │ │
│ │ 👥 User │  └──────────┘  └──────────┘  └──────────┘            │ │
│ │         │                                                       │ │
│ │ ═══════ │  ┌─────────────────────────────────────────────────┐ │ │
│ │ 🤖 AI   │  │  📈 Gráfico de Vendas                           │ │ │
│ │ 📱 SMS  │  │                                                  │ │ │
│ │ 🎪 Leil │  │     ▄▄    ▄▄                                    │ │ │
│ │         │  │  ▄▄ ██ ▄▄ ██ ▄▄                                 │ │ │
│ │ ═══════ │  │  ██ ██ ██ ██ ██ ▄▄                              │ │ │
│ │ ⚙️ Conf │  │  ──────────────────                              │ │ │
│ │         │  └─────────────────────────────────────────────────┘ │ │
│ └─────────┴───────────────────────────────────────────────────────┘ │
└─────────────────────────────────────────────────────────────────────┘
```

### **Mobile Layout**
```
┌─────────────────────┐
│ ☰  SuperLoja   👤   │
├─────────────────────┤
│                     │
│  ┌───────────────┐  │
│  │ 💰 12.5M Kz   │  │
│  │ Vendas Hoje   │  │
│  └───────────────┘  │
│                     │
│  ┌───────────────┐  │
│  │ 📦 1,234      │  │
│  │ Produtos      │  │
│  └───────────────┘  │
│                     │
│  ┌───────────────┐  │
│  │ 📊 Gráfico    │  │
│  │               │  │
│  └───────────────┘  │
│                     │
└─────────────────────┘
```

---

## ⏱️ CRONOGRAMA ESTIMADO

| Fase | Descrição | Duração | Status |
|------|-----------|---------|--------|
| 1 | Infraestrutura Base | 2-3 dias | 🔲 Pendente |
| 2 | Componentes UI | 3-4 dias | 🔲 Pendente |
| 3 | Dashboard | 2-3 dias | 🔲 Pendente |
| 4 | Módulos Principais | 5-7 dias | 🔲 Pendente |
| 5 | Módulos Especiais | 4-5 dias | 🔲 Pendente |
| 6 | Otimizações | 2-3 dias | 🔲 Pendente |

**Total Estimado: 18-25 dias**

---

## 🚦 PRÓXIMOS PASSOS

### **Iniciar pela FASE 1:**

1. **Criar novo layout SPA** (`admin-spa.blade.php`)
2. **Implementar sidebar persistente** com Alpine.js
3. **Adicionar sistema de toasts** nativo
4. **Configurar variáveis CSS** com cores SuperLoja
5. **Testar navegação SPA** com `wire:navigate`

### **Comando para iniciar:**
```bash
# Criar estrutura de diretórios
mkdir -p resources/views/components/admin/{layouts,ui,form,charts}
mkdir -p resources/css/admin
mkdir -p resources/js/admin
```

---

## ✅ CHECKLIST DE VALIDAÇÃO

Antes de considerar cada fase completa:

- [ ] Navegação SPA funcionando sem page reloads
- [ ] Loading states visíveis durante transições
- [ ] Responsive em todos os breakpoints
- [ ] Toasts funcionando para feedback
- [ ] Modals/Drawers abrindo corretamente
- [ ] Formulários validando e salvando
- [ ] Tabelas paginando corretamente
- [ ] Filtros aplicando em tempo real
- [ ] Performance < 3s de carregamento inicial

---

**Deseja iniciar pela FASE 1?** 🚀

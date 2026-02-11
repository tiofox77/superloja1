# 📸 Sistema de Processamento de Imagens para Redes Sociais

## ✨ Melhorias Implementadas

### 🎨 **Fonte Poppins Integrada**
- **Baixada e integrada** a fonte **Poppins** (Bold e Regular) do Google Fonts
- Localização: `storage/fonts/`
- Fonte moderna, suave e profissional
- Usada em todos os textos da imagem processada

### 🖼️ **Logo da Aplicação**
O sistema agora usa o **logo real da aplicação** ao invés de texto:

1. **Logo Dinâmico**: Busca automaticamente o logo configurado em Configurações
2. **Fallback Inteligente**: Se não houver logo, usa o nome da aplicação com fonte Poppins
3. **Redimensionamento Automático**: Logo é redimensionado mantendo proporção (máx 280x70px)
4. **Localização no Header**: Logo aparece no topo da imagem, centralizado em um card branco arredondado

### 📐 **Elementos com Fonte Poppins**

#### **1. Logo/Nome da Loja (Header)**
- Fonte: **Poppins Bold**
- Tamanho: **32px**
- Cor: **Laranja (#FF8C00)**
- Posição: **Topo centralizado**

#### **2. Nome do Produto**
- Fonte: **Poppins Regular**
- Tamanho: **22px**
- Cor: **Vinho (#8B1E5C)**
- Posição: **Abaixo da imagem do produto**
- Quebra automática em até 3 linhas

#### **3. Preço do Produto**
- Fonte: **Poppins Bold**
- Tamanho: **36px**
- Cor: **Preto (#000000)**
- Formato: **1.234,56 Kz**

#### **4. Website (Rodapé)**
- Fonte: **Poppins Bold**
- Tamanho: **28px**
- Cor: **Vinho Escuro (#8B1E5C)**
- Texto: **superloja.vip**
- Fundo: **Faixa laranja com bordas arredondadas**

## 🎯 **Como Funciona**

### **Busca do Logo**
```php
$logoPath = $this->getApplicationLogo();
// Busca em:
// 1. public/storage/[caminho_do_logo]
// 2. storage/app/public/[caminho_do_logo]
// 3. public/[caminho_do_logo]
```

### **Prioridades de Renderização**
1. **Logo existe?** → Usa o logo da aplicação
2. **Logo não existe?** → Usa nome da aplicação com Poppins
3. **Poppins não existe?** → Fallback para fonte padrão GD

## 🚀 **Benefícios**

### **Design Profissional**
- ✅ Fonte moderna e elegante
- ✅ Identidade visual consistente
- ✅ Logo da marca sempre presente

### **Flexibilidade**
- ✅ Adapta-se automaticamente ao logo configurado
- ✅ Funciona com ou sem logo
- ✅ Múltiplos fallbacks para garantir funcionalidade

### **Qualidade Tipográfica**
- ✅ Anti-aliasing nativo do TrueType
- ✅ Texto mais legível e suave
- ✅ Melhor em telas de alta resolução

## 📁 **Estrutura de Arquivos**

```
storage/
├── fonts/
│   ├── Poppins-Bold.ttf       # Fonte principal (logo, preço, rodapé)
│   ├── Poppins-Regular.ttf    # Fonte secundária (nome do produto)
│   └── download_fonts.php     # Script para baixar fontes
│
└── app/
    └── public/
        └── social_media/      # Imagens processadas
            └── YYYY/
                └── MM/
                    └── DD/
                        └── processed_*.jpg
```

## 🔧 **Configuração**

### **Para usar seu próprio logo:**
1. Vá em **Admin → Configurações**
2. Faça upload do logo da loja
3. O sistema automaticamente usará esse logo nas imagens

### **Para alterar o nome da loja:**
1. Vá em **Admin → Configurações**
2. Altere o campo **Nome da Aplicação**
3. Será usado quando não houver logo

## 🎨 **Especificações de Design**

### **Canvas**
- Dimensões: **1080x1080px** (quadrado perfeito para Instagram/Facebook)
- Fundo: **Gradiente vinho (#8B1E5C)** com padrão de bolinhas

### **Card Principal**
- Dimensões: **880x920px**
- Cor: **Branco (#FFFFFF)**
- Bordas: **Arredondadas (70px)**

### **Header do Logo**
- Dimensões: **350x100px**
- Cor: **Branco (#FFFFFF)**
- Bordas: **Arredondadas (50px)**
- Posição: **40px do topo**

### **Rodapé**
- Dimensões: **680x75px**
- Cor: **Laranja (#FF8C00)**
- Bordas: **Arredondadas (15px)**
- Posição: **25px da base**

## 🖼️ **Exemplo de Resultado**

```
┌─────────────────────────────────────┐
│  ╔═══════════════════════════╗      │  ← Header branco
│  ║   [LOGO ou SuperLoja]     ║      │     com logo/nome
│  ╚═══════════════════════════╝      │
│  ╔═══════════════════════════════╗  │
│  ║                               ║  │
│  ║      [Imagem do Produto]      ║  │  ← Card principal
│  ║                               ║  │     branco
│  ║   Nome do Produto em          ║  │
│  ║   Poppins Regular             ║  │
│  ║                               ║  │
│  ║   1.234,56 Kz                 ║  │  ← Preço em
│  ║   (Poppins Bold)              ║  │     destaque
│  ╚═══════════════════════════════╝  │
│                                      │
│  ╔══════════════════════════╗       │  ← Rodapé laranja
│  ║    superloja.vip         ║       │     com site
│  ╚══════════════════════════╝       │
└─────────────────────────────────────┘
```

## 🔄 **Reprocessamento**

Se quiser reprocessar imagens existentes com o novo design:
1. As novas imagens já usarão automaticamente o logo e Poppins
2. Imagens antigas permanecem como estão (não são alteradas)
3. Para atualizar antigas, basta reprocessá-las manualmente

## 💡 **Dicas**

### **Para melhor resultado:**
- Use um **logo horizontal** (mais largo que alto)
- Formato **PNG com fundo transparente** é ideal
- Dimensões recomendadas: **entre 500-1000px de largura**
- O sistema redimensiona automaticamente, mas qualidade original importa

### **Nome da loja ideal:**
- **Curto e memorável**: "SuperLoja" funciona melhor que "Super Loja Online de Angola Ltda"
- **Máximo 20 caracteres** para melhor visualização

---

**Desenvolvido com ❤️ usando Intervention Image, GD Library e Fonte Poppins**

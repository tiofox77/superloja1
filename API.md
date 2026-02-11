# Superloja API - Documentação

## Visão Geral

API REST para gerenciamento de produtos, categorias, subcategorias, marcas e vendas POS.

- **Base URL:** `https://superloja.vip/api/v1`
- **Formato:** JSON
- **Autenticação:** Token Bearer

---

## Autenticação

Todas as rotas exigem um token de autenticação.

### Token padrão

```
Popadic17
```

> O token padrão é `Popadic17`. Para alterar, use o comando abaixo ou defina manualmente em **Configurações > API**.

```bash
php artisan api:generate-token
```

Para ver o token atual:

```bash
php artisan api:generate-token --show
```

### Formas de enviar o token

| Método | Exemplo |
|--------|---------|
| **Header Authorization** (recomendado) | `Authorization: Bearer Popadic17` |
| **Header customizado** | `X-API-Token: Popadic17` |
| **Query string** | `?api_token=Popadic17` |

### Exemplo com cURL

```bash
curl -H "Authorization: Bearer Popadic17" \
     -H "Accept: application/json" \
     https://superloja.vip/api/v1/products
```

---

## Respostas Padrão

### Sucesso

```json
{
  "success": true,
  "data": { ... },
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 15,
    "total": 73
  }
}
```

### Erro

```json
{
  "success": false,
  "message": "Descrição do erro."
}
```

### Códigos HTTP

| Código | Descrição |
|--------|-----------|
| `200` | Sucesso |
| `201` | Criado com sucesso |
| `401` | Token inválido ou ausente |
| `404` | Recurso não encontrado |
| `422` | Erro de validação |
| `500` | Erro interno |

---

## 1. Produtos

### Listar Produtos

```
GET /api/v1/products
```

**Query Parameters:**

| Param | Tipo | Descrição |
|-------|------|-----------|
| `search` | string | Buscar por nome, descrição |
| `category_id` | int | Filtrar por categoria |
| `brand_id` | int | Filtrar por marca |
| `is_active` | bool | Filtrar por status ativo |
| `is_featured` | bool | Filtrar por destaque |
| `in_stock` | bool | Apenas com estoque > 0 |
| `min_price` | float | Preço mínimo |
| `max_price` | float | Preço máximo |
| `sort_by` | string | Ordenar por: `name`, `price`, `stock_quantity`, `created_at`, `order_count`, `view_count` |
| `sort_dir` | string | Direção: `asc` ou `desc` |
| `per_page` | int | Itens por página (max 100, default 15) |
| `page` | int | Número da página |

**Exemplo:**

```bash
curl -H "Authorization: Bearer Popadic17" \
     "https://superloja.vip/api/v1/products?category_id=3&is_active=true&sort_by=price&sort_dir=asc&per_page=20"
```

### Ver Produto

```
GET /api/v1/products/{id}
```

**Resposta:**

```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Samsung Galaxy A54 128GB",
    "description": "Smartphone Samsung Galaxy A54 com 128GB de armazenamento, 6GB RAM, tela Super AMOLED 6.4 polegadas.",
    "price": 45000.00,
    "sale_price": 39900.00,
    "stock_quantity": 25,
    "featured_image_url": "https://superloja.vip/storage/products/abc123def456.jpg",
    "image_urls": [
      "https://superloja.vip/storage/products/img1.jpg",
      "https://superloja.vip/storage/products/img2.jpg",
      "https://superloja.vip/storage/products/img3.jpg"
    ]
  }
}
```

### Criar Produto

```
POST /api/v1/products
```

**Body (JSON):**

```json
{
  "name": "Smartphone Galaxy A54",
  "price": 45000.00,
  "sale_price": 39900.00,
  "cost_price": 30000.00,
  "sku": "SAM-A54-001",
  "barcode": "7891234567890",
  "category_id": 3,
  "brand_id": 2,
  "stock_quantity": 25,
  "manage_stock": true,
  "low_stock_threshold": 5,
  "description": "Smartphone Samsung Galaxy A54 128GB",
  "short_description": "Galaxy A54 128GB",
  "is_active": true,
  "is_featured": true,
  "condition": "new",
  "images": ["products/galaxy-a54-1.jpg", "products/galaxy-a54-2.jpg"],
  "featured_image": "products/galaxy-a54-1.jpg",
  "specifications": {
    "Memória": "128GB",
    "RAM": "6GB",
    "Tela": "6.4 polegadas"
  }
}
```

**Campos obrigatórios:** `name`, `price`

### Atualizar Produto

```
PUT /api/v1/products/{id}
```

**Body (JSON) — apenas os campos a alterar:**

```json
{
  "price": 42000.00,
  "stock_quantity": 30,
  "is_featured": true
}
```

### Excluir Produto

```
DELETE /api/v1/products/{id}
```

---

## 2. Categorias

Categorias raiz (sem `parent_id`). Para subcategorias, veja a seção 3.

### Listar Categorias

```
GET /api/v1/categories
```

**Query Parameters:**

| Param | Tipo | Descrição |
|-------|------|-----------|
| `search` | string | Buscar por nome |
| `is_active` | bool | Filtrar por status |
| `with_children` | bool | Incluir subcategorias na resposta |
| `per_page` | int | Itens por página (max 100) |
| `page` | int | Número da página |

**Exemplo com subcategorias:**

```bash
curl -H "Authorization: Bearer Popadic17" \
     "https://superloja.vip/api/v1/categories?with_children=true"
```

### Ver Categoria

```
GET /api/v1/categories/{id}
```

### Criar Categoria

```
POST /api/v1/categories
```

**Body:**

```json
{
  "name": "Eletrônicos",
  "description": "Produtos eletrônicos em geral",
  "icon": "smartphone",
  "color": "#3B82F6",
  "is_active": true,
  "sort_order": 1
}
```

**Campo obrigatório:** `name`

### Atualizar Categoria

```
PUT /api/v1/categories/{id}
```

```json
{
  "name": "Eletrônicos e Gadgets",
  "sort_order": 2
}
```

### Excluir Categoria

```
DELETE /api/v1/categories/{id}
```

> ⚠️ Não é possível excluir categorias com produtos ou subcategorias vinculadas.

---

## 3. Subcategorias

Subcategorias são categorias com `parent_id` definido (vinculadas a uma categoria raiz).

### Listar Subcategorias

```
GET /api/v1/subcategories
```

**Query Parameters:**

| Param | Tipo | Descrição |
|-------|------|-----------|
| `search` | string | Buscar por nome |
| `parent_id` | int | Filtrar por categoria pai |
| `is_active` | bool | Filtrar por status |
| `per_page` | int | Itens por página (max 100) |
| `page` | int | Número da página |

**Exemplo:**

```bash
curl -H "Authorization: Bearer Popadic17" \
     "https://superloja.vip/api/v1/subcategories?parent_id=3"
```

### Ver Subcategoria

```
GET /api/v1/subcategories/{id}
```

### Criar Subcategoria

```
POST /api/v1/subcategories
```

**Body:**

```json
{
  "name": "Smartphones",
  "parent_id": 3,
  "description": "Telefones celulares inteligentes",
  "icon": "phone",
  "is_active": true,
  "sort_order": 1
}
```

**Campos obrigatórios:** `name`, `parent_id`

> `parent_id` deve referenciar uma categoria raiz (sem `parent_id` próprio).

### Atualizar Subcategoria

```
PUT /api/v1/subcategories/{id}
```

```json
{
  "name": "Smartphones e Tablets",
  "parent_id": 5
}
```

### Excluir Subcategoria

```
DELETE /api/v1/subcategories/{id}
```

> ⚠️ Não é possível excluir subcategorias com produtos vinculados.

---

## 4. Marcas

### Listar Marcas

```
GET /api/v1/brands
```

**Query Parameters:**

| Param | Tipo | Descrição |
|-------|------|-----------|
| `search` | string | Buscar por nome |
| `is_active` | bool | Filtrar por status |
| `per_page` | int | Itens por página (max 100) |
| `page` | int | Número da página |

### Ver Marca

```
GET /api/v1/brands/{id}
```

### Criar Marca

```
POST /api/v1/brands
```

**Body:**

```json
{
  "name": "Samsung",
  "description": "Marca líder em eletrônicos",
  "website": "https://samsung.com",
  "logo": "brands/samsung.png",
  "is_active": true,
  "sort_order": 1
}
```

**Campo obrigatório:** `name`

### Atualizar Marca

```
PUT /api/v1/brands/{id}
```

```json
{
  "name": "Samsung Electronics",
  "website": "https://samsung.com.br"
}
```

### Excluir Marca

```
DELETE /api/v1/brands/{id}
```

> ⚠️ Não é possível excluir marcas com produtos vinculados.

---

## 5. POS (Ponto de Venda)

### Listar Produtos POS

Retorna produtos ativos otimizados para o PDV.

```
GET /api/v1/pos/products
```

**Query Parameters:**

| Param | Tipo | Descrição |
|-------|------|-----------|
| `search` | string | Buscar por nome, SKU ou código de barras |
| `category_id` | int | Filtrar por categoria |
| `brand_id` | int | Filtrar por marca |
| `in_stock` | bool | Apenas com estoque |
| `per_page` | int | Itens por página (max 200, default 50) |

### Buscar Produto por Código de Barras

```
GET /api/v1/pos/products/barcode/{barcode}
```

**Exemplo:**

```bash
curl -H "Authorization: Bearer Popadic17" \
     "https://superloja.vip/api/v1/pos/products/barcode/7891234567890"
```

### Listar Categorias POS

```
GET /api/v1/pos/categories
```

Retorna lista simplificada (id, name) de categorias ativas.

### Registrar Venda

```
POST /api/v1/pos/sale
```

**Body:**

```json
{
  "items": [
    { "product_id": 1, "quantity": 2, "unit_price": 15000.00 },
    { "product_id": 5, "quantity": 1, "unit_price": 8500.00 }
  ],
  "customer_name": "João Silva",
  "customer_phone": "+244923456789",
  "customer_email": "joao@email.com",
  "payment_method": "cash",
  "amount_received": 40000.00,
  "discount_percentage": 5,
  "tax_rate": 14,
  "notes": "Venda presencial"
}
```

**Campos obrigatórios:** `items` (array com `product_id`, `quantity`, `unit_price`), `payment_method`

**Métodos de pagamento aceitos:** `cash`, `card`, `transfer`, `mbway`, `multicaixa`

**Resposta:**

```json
{
  "success": true,
  "message": "Venda processada com sucesso.",
  "data": {
    "order": {
      "id": 42,
      "order_number": "POS-20260209-0001",
      "status": "completed",
      "payment_status": "paid",
      "total_amount": "36575.00",
      "items": [...]
    },
    "totals": {
      "subtotal": 38500.00,
      "discount": 1925.00,
      "tax": 5120.50,
      "total": 41695.50,
      "amount_received": 42000.00,
      "change": 304.50
    }
  }
}
```

### Listar Vendas POS

```
GET /api/v1/pos/sales
```

**Query Parameters:**

| Param | Tipo | Descrição |
|-------|------|-----------|
| `date` | date | Data exata (YYYY-MM-DD) |
| `date_from` | date | Data início |
| `date_to` | date | Data fim |
| `payment_method` | string | Método de pagamento |
| `per_page` | int | Itens por página (max 100) |

**Exemplo:**

```bash
curl -H "Authorization: Bearer Popadic17" \
     "https://superloja.vip/api/v1/pos/sales?date_from=2026-02-01&date_to=2026-02-09"
```

### Ver Venda POS

```
GET /api/v1/pos/sales/{id}
```

---

## ⚠️ Observação para Agentes de Redes Sociais

> **Esta API foi otimizada para ser consumida por agentes/bots que publicam produtos nas redes sociais (Facebook, Instagram, etc.).**

### Árvore de dados do produto

A API retorna **apenas os campos essenciais** para manter a resposta leve e rápida:

```
product
├── id                  → Identificador único do produto
├── name                → Nome do produto (usar como título do post)
├── description         → Descrição completa (usar como corpo/caption do post)
├── price               → Preço original (float, em Kz)
├── sale_price          → Preço com desconto (null se não houver promoção)
├── stock_quantity      → Quantidade em stock (0 = sem stock, não postar)
├── featured_image_url  → URL completa da imagem principal (usar como imagem do post)
└── image_urls[]        → Array de URLs de imagens adicionais (usar para carrosséis)
```

### Regras para o agente

1. **Não postar produtos com `stock_quantity = 0`** — produto esgotado.
2. **Se `sale_price` existir**, destacar a promoção no post (ex: "De ~~45.000 Kz~~ por **39.900 Kz**").
3. **Usar `featured_image_url`** como imagem principal do post.
4. **Usar `image_urls`** para criar carrosséis no Instagram/Facebook (mínimo 2, máximo 10 imagens).
5. **Se `featured_image_url` for `null`**, ignorar o produto (sem imagem = não postar).
6. **Formatar preços** no padrão angolano: `39.900,00 Kz` (ponto para milhar, vírgula para decimal).
7. **Usar `per_page=10`** e `in_stock=true` para obter lotes pequenos de produtos disponíveis.
8. **Usar `is_featured=true`** para obter apenas produtos em destaque (prioridade para posts).

### Exemplo de consulta otimizada para o agente

```bash
# Buscar 10 produtos em destaque, com stock, ordenados por mais recentes
curl -H "Authorization: Bearer Popadic17" \
     "https://superloja.vip/api/v1/products?is_featured=true&in_stock=true&per_page=10&sort_by=created_at&sort_dir=desc"
```

### Exemplo de resposta usada pelo agente

```json
{
  "success": true,
  "data": [
    {
      "id": 42,
      "name": "Samsung Galaxy A54 128GB",
      "description": "Smartphone Samsung Galaxy A54, 128GB, 6GB RAM, Tela 6.4 AMOLED",
      "price": 45000.00,
      "sale_price": 39900.00,
      "stock_quantity": 25,
      "featured_image_url": "https://superloja.vip/storage/products/abc123.jpg",
      "image_urls": [
        "https://superloja.vip/storage/products/img1.jpg",
        "https://superloja.vip/storage/products/img2.jpg"
      ]
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 3,
    "per_page": 10,
    "total": 27
  }
}
```

### Template sugerido para o post

```
🔥 {name}

{description}

💰 Preço: {price} Kz
🌟 Promoção: {sale_price} Kz  ← (só se sale_price != null)

🛍️ Compre agora: superloja.vip
📦 Stock: {stock_quantity} unidades

#SuperLoja #Angola #Promoção
```

---

## 🤖 Guia do Agente para Criar Produtos

> **Esta secção é destinada ao agente/bot de IA que vai interagir com o utilizador para criar produtos na SuperLoja via API.**

### Fluxo de trabalho do agente

O agente deve seguir esta ordem **antes** de criar um produto:

```
1. Listar categorias existentes     → GET /api/v1/categories?with_children=true&is_active=true&per_page=100
2. Listar marcas existentes         → GET /api/v1/brands?is_active=true&per_page=100
3. Perguntar ao utilizador os dados do produto
4. Montar o JSON com os dados
5. Enviar o produto                 → POST /api/v1/products
```

---

### Passo 1 — Descobrir Categorias e Subcategorias

```bash
curl -H "Authorization: Bearer Popadic17" \
     "https://superloja.vip/api/v1/categories?with_children=true&is_active=true&per_page=100"
```

**Resposta exemplo:**

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Eletrónicos",
      "children": [
        { "id": 10, "name": "Smartphones" },
        { "id": 11, "name": "Acessórios" },
        { "id": 12, "name": "Computadores" }
      ]
    },
    {
      "id": 2,
      "name": "Casa e Cozinha",
      "children": [
        { "id": 20, "name": "Eletrodomésticos" },
        { "id": 21, "name": "Utensílios" }
      ]
    }
  ]
}
```

> **Regra:** O campo `category_id` no produto aceita **tanto** o `id` de uma categoria pai **como** o `id` de uma subcategoria (children). Subcategorias são categorias com `parent_id`.

**O agente deve:**
1. Guardar a lista de categorias e subcategorias em memória
2. Apresentar ao utilizador de forma legível (ex: "Eletrónicos > Smartphones")
3. Perguntar: *"Em que categoria quer colocar o produto?"*
4. Usar o `id` da categoria/subcategoria escolhida no campo `category_id`

---

### Passo 2 — Descobrir Marcas

```bash
curl -H "Authorization: Bearer Popadic17" \
     "https://superloja.vip/api/v1/brands?is_active=true&per_page=100"
```

**Resposta exemplo:**

```json
{
  "success": true,
  "data": [
    { "id": 1, "name": "Samsung" },
    { "id": 2, "name": "Apple" },
    { "id": 3, "name": "Xiaomi" },
    { "id": 4, "name": "Genérico" }
  ]
}
```

**O agente deve:**
1. Guardar a lista de marcas
2. Perguntar: *"Qual é a marca do produto?"*
3. Se o utilizador disser uma marca que não existe, o agente pode criar:
   ```bash
   curl -X POST "https://superloja.vip/api/v1/brands" \
        -H "Authorization: Bearer Popadic17" \
        -H "Content-Type: application/json" \
        -d '{"name": "Nova Marca", "is_active": true}'
   ```
4. Usar o `id` da marca no campo `brand_id`

---

### Passo 3 — Perguntar dados ao utilizador

O agente deve perguntar ao utilizador os seguintes dados, **um de cada vez ou agrupados de forma natural**:

#### Campos obrigatórios (o agente DEVE perguntar)

| Campo | Pergunta sugerida |
|-------|-------------------|
| `name` | *"Qual é o nome do produto?"* |
| `price` | *"Qual é o preço? (em Kz)"* |

#### Campos importantes (o agente DEVE perguntar)

| Campo | Pergunta sugerida |
|-------|-------------------|
| `description` | *"Descreva o produto (detalhes, características)"* |
| `category_id` | *"Em que categoria?"* (mostrar lista do Passo 1) |
| `stock_quantity` | *"Quantas unidades em stock?"* |
| `sale_price` | *"Tem preço promocional? Se sim, qual?"* |

#### Campos opcionais (o agente pode perguntar se relevante)

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `short_description` | string | Descrição curta (max 500 chars) |
| `sku` | string | Código interno (max 100 chars, único) |
| `barcode` | string | Código de barras |
| `brand_id` | int | ID da marca (do Passo 2) |
| `cost_price` | float | Preço de custo |
| `low_stock_threshold` | int | Alerta de stock baixo |
| `manage_stock` | bool | Gerir stock automaticamente |
| `weight` | float | Peso (kg) |
| `length`, `width`, `height` | float | Dimensões (cm) |
| `is_active` | bool | Produto ativo (default: true) |
| `is_featured` | bool | Produto em destaque |
| `condition` | string | `new`, `used` ou `refurbished` |
| `condition_notes` | string | Notas sobre condição |
| `meta_title` | string | SEO: título |
| `meta_description` | string | SEO: descrição |
| `meta_keywords` | string | SEO: palavras-chave |
| `attributes` | object | Atributos livres `{"cor": "preto"}` |
| `specifications` | object | Especificações `{"RAM": "6GB"}` |

#### Imagens (upload via multipart/form-data)

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `featured_image` | file | Imagem principal (max 5MB, jpeg/png/jpg/gif/webp) |
| `images[]` | files | Galeria de imagens (múltiplos ficheiros) |

> **Nota:** Se o agente não enviar `featured_image` mas enviar `images[]`, a primeira imagem será usada como destaque automaticamente.

---

### Passo 4 — Montar o JSON e enviar

#### Exemplo mínimo (só campos obrigatórios)

```bash
curl -X POST "https://superloja.vip/api/v1/products" \
     -H "Authorization: Bearer Popadic17" \
     -H "Content-Type: application/json" \
     -d '{
       "name": "Fone Bluetooth TWS",
       "price": 3500.00
     }'
```

#### Exemplo completo (campos recomendados)

```bash
curl -X POST "https://superloja.vip/api/v1/products" \
     -H "Authorization: Bearer Popadic17" \
     -H "Content-Type: application/json" \
     -d '{
       "name": "Samsung Galaxy A54 128GB",
       "description": "Smartphone Samsung Galaxy A54 com 128GB de armazenamento, 6GB RAM, tela Super AMOLED 6.4 polegadas, câmara tripla 50MP.",
       "short_description": "Galaxy A54 128GB Preto",
       "price": 45000.00,
       "sale_price": 39900.00,
       "cost_price": 30000.00,
       "sku": "SAM-A54-128-BLK",
       "barcode": "7891234567890",
       "category_id": 10,
       "brand_id": 1,
       "stock_quantity": 25,
       "manage_stock": true,
       "low_stock_threshold": 5,
       "is_active": true,
       "is_featured": true,
       "condition": "new",
       "specifications": {
         "Memória": "128GB",
         "RAM": "6GB",
         "Tela": "6.4 polegadas",
         "Câmara": "50MP + 12MP + 5MP"
       }
     }'
```

#### Exemplo com imagens (multipart/form-data)

```bash
curl -X POST "https://superloja.vip/api/v1/products" \
     -H "Authorization: Bearer Popadic17" \
     -F "name=Samsung Galaxy A54 128GB" \
     -F "price=45000.00" \
     -F "sale_price=39900.00" \
     -F "category_id=10" \
     -F "brand_id=1" \
     -F "stock_quantity=25" \
     -F "description=Smartphone Samsung Galaxy A54 128GB" \
     -F "is_active=true" \
     -F "featured_image=@/caminho/foto-principal.jpg" \
     -F "images[]=@/caminho/foto2.jpg" \
     -F "images[]=@/caminho/foto3.jpg"
```

---

### Passo 5 — Resposta de sucesso

```json
{
  "success": true,
  "message": "Produto criado com sucesso.",
  "data": {
    "id": 99,
    "name": "Samsung Galaxy A54 128GB",
    "description": "Smartphone Samsung Galaxy A54 128GB...",
    "price": 45000.00,
    "sale_price": 39900.00,
    "stock_quantity": 25,
    "featured_image_url": "https://superloja.vip/storage/products/sam-galaxy-a54.jpg",
    "image_urls": [
      "https://superloja.vip/storage/products/foto2.jpg",
      "https://superloja.vip/storage/products/foto3.jpg"
    ]
  }
}
```

---

### Comportamento esperado do agente (resumo)

```
AGENTE: Vou criar um produto. Primeiro, deixe-me verificar as categorias disponíveis...
        [GET /categories?with_children=true]
        
AGENTE: Categorias disponíveis:
        1. Eletrónicos > Smartphones, Acessórios, Computadores
        2. Casa e Cozinha > Eletrodomésticos, Utensílios
        3. Moda > Masculino, Feminino
        
AGENTE: Qual é o nome do produto?
USER:   Fone de ouvido Bluetooth JBL

AGENTE: Qual é o preço? (em Kz)
USER:   8500

AGENTE: Tem preço promocional?
USER:   Sim, 6900

AGENTE: Em que categoria?
USER:   Eletrónicos > Acessórios

AGENTE: Qual a marca?
USER:   JBL

AGENTE: [JBL não existe, criando...]  [POST /brands]
AGENTE: Quantas unidades em stock?
USER:   50

AGENTE: Alguma descrição?
USER:   Fone JBL Tune 510BT, Bluetooth 5.0, bateria 40h, dobrável

AGENTE: Vou criar o produto com os seguintes dados:
        Nome: Fone de ouvido Bluetooth JBL
        Preço: 8.500 Kz → Promoção: 6.900 Kz
        Categoria: Acessórios (id: 11)
        Marca: JBL (id: 5)
        Stock: 50
        Confirma?
USER:   Sim

AGENTE: [POST /products com JSON completo]
AGENTE: ✅ Produto criado com sucesso! ID: 103
```

### Tratamento de erros

| Código | Causa | O que o agente deve fazer |
|--------|-------|---------------------------|
| `422` | Validação falhou | Ler `errors` e corrigir os campos (ex: nome duplicado, preço inválido) |
| `401` | Token inválido | Verificar se o token `Popadic17` está correto |
| `404` | `category_id` ou `brand_id` inválido | Re-listar categorias/marcas e perguntar novamente |
| `500` | Erro interno | Tentar novamente em 5 segundos, máximo 2 tentativas |

---

## Exemplos Completos

### Python

```python
import requests

BASE_URL = "https://superloja.vip/api/v1"
HEADERS = {
    "Authorization": "Bearer Popadic17",
    "Accept": "application/json",
    "Content-Type": "application/json"
}

# Listar produtos
r = requests.get(f"{BASE_URL}/products", headers=HEADERS, params={"is_active": "true", "per_page": 20})
print(r.json())

# Criar produto
produto = {
    "name": "Fone Bluetooth",
    "price": 5000.00,
    "category_id": 3,
    "stock_quantity": 100,
    "manage_stock": True,
    "is_active": True
}
r = requests.post(f"{BASE_URL}/products", headers=HEADERS, json=produto)
print(r.json())

# Registrar venda POS
venda = {
    "items": [
        {"product_id": 1, "quantity": 2, "unit_price": 5000.00}
    ],
    "payment_method": "cash",
    "amount_received": 10000.00,
    "customer_name": "Maria"
}
r = requests.post(f"{BASE_URL}/pos/sale", headers=HEADERS, json=venda)
print(r.json())
```

### JavaScript (fetch)

```javascript
const BASE_URL = 'https://superloja.vip/api/v1';
const TOKEN = 'Popadic17';

const headers = {
  'Authorization': `Bearer Popadic17`,
  'Accept': 'application/json',
  'Content-Type': 'application/json'
};

// Listar categorias com subcategorias
const res = await fetch(`${BASE_URL}/categories?with_children=true`, { headers });
const data = await res.json();
console.log(data);

// Criar marca
const brand = await fetch(`${BASE_URL}/brands`, {
  method: 'POST',
  headers,
  body: JSON.stringify({ name: 'Apple', website: 'https://apple.com', is_active: true })
});
console.log(await brand.json());

// Buscar produto por código de barras (POS)
const barcode = await fetch(`${BASE_URL}/pos/products/barcode/7891234567890`, { headers });
console.log(await barcode.json());
```

### PHP (Guzzle)

```php
use GuzzleHttp\Client;

$client = new Client([
    'base_uri' => 'https://superloja.vip/api/v1/',
    'headers' => [
        'Authorization' => 'Bearer Popadic17',
        'Accept' => 'application/json',
    ],
]);

// Listar marcas ativas
$response = $client->get('brands', ['query' => ['is_active' => 'true']]);
$brands = json_decode($response->getBody(), true);

// Atualizar produto
$response = $client->put('products/1', [
    'json' => ['price' => 42000.00, 'stock_quantity' => 50]
]);

// Venda POS
$response = $client->post('pos/sale', [
    'json' => [
        'items' => [['product_id' => 1, 'quantity' => 1, 'unit_price' => 15000]],
        'payment_method' => 'card',
    ]
]);
```

---

## Tabela de Rotas

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| `GET` | `/api/v1/products` | Listar produtos |
| `POST` | `/api/v1/products` | Criar produto |
| `GET` | `/api/v1/products/{id}` | Ver produto |
| `PUT` | `/api/v1/products/{id}` | Atualizar produto |
| `DELETE` | `/api/v1/products/{id}` | Excluir produto |
| `GET` | `/api/v1/categories` | Listar categorias |
| `POST` | `/api/v1/categories` | Criar categoria |
| `GET` | `/api/v1/categories/{id}` | Ver categoria |
| `PUT` | `/api/v1/categories/{id}` | Atualizar categoria |
| `DELETE` | `/api/v1/categories/{id}` | Excluir categoria |
| `GET` | `/api/v1/subcategories` | Listar subcategorias |
| `POST` | `/api/v1/subcategories` | Criar subcategoria |
| `GET` | `/api/v1/subcategories/{id}` | Ver subcategoria |
| `PUT` | `/api/v1/subcategories/{id}` | Atualizar subcategoria |
| `DELETE` | `/api/v1/subcategories/{id}` | Excluir subcategoria |
| `GET` | `/api/v1/brands` | Listar marcas |
| `POST` | `/api/v1/brands` | Criar marca |
| `GET` | `/api/v1/brands/{id}` | Ver marca |
| `PUT` | `/api/v1/brands/{id}` | Atualizar marca |
| `DELETE` | `/api/v1/brands/{id}` | Excluir marca |
| `GET` | `/api/v1/pos/products` | Produtos para POS |
| `GET` | `/api/v1/pos/products/barcode/{code}` | Produto por código de barras |
| `GET` | `/api/v1/pos/categories` | Categorias para POS |
| `POST` | `/api/v1/pos/sale` | Registrar venda POS |
| `GET` | `/api/v1/pos/sales` | Listar vendas POS |
| `GET` | `/api/v1/pos/sales/{id}` | Ver venda POS |

# Superloja API - Documentação

## Visão Geral

API REST para gerenciamento de produtos, categorias, subcategorias, marcas e vendas POS.

- **Base URL:** `https://superloja.vip/api/v1`
- **Formato:** JSON
- **Autenticação:** Token Bearer
- **Rate Limit:** 30 pedidos/minuto por IP
- **Máximo por página:** 30 itens (`per_page` max 30)

---

## ⚠️ REGRAS OBRIGATÓRIAS PARA AGENTES IA

> **LEIA ANTES DE FAZER QUALQUER PEDIDO. O servidor tem recursos limitados.**

1. **Máximo 30 pedidos por minuto** — se exceder, recebe HTTP `429 Too Many Requests`
2. **Esperar 2 segundos entre cada pedido** — NUNCA fazer pedidos em paralelo/simultâneos
3. **Usar `per_page=10` a `per_page=15`** — NUNCA pedir mais de 30 por página
4. **Respostas são cached 60-120s** — não repetir o mesmo pedido em menos de 1 minuto
5. **Se receber erro 429 ou timeout**, parar por 30 segundos antes de tentar novamente
6. **NUNCA fazer loops rápidos** (ex: iterar todas as páginas sem delay)
7. **Fazer apenas os pedidos necessários** — guardar dados em memória e reutilizar

### Exemplo correcto (com delay)
```python
import time

# BOM: esperar entre pedidos
for page in range(1, 4):
    response = requests.get(f"{BASE_URL}/products?page={page}&per_page=10", headers=HEADERS)
    time.sleep(2)  # OBRIGATÓRIO: esperar 2s
```

### Exemplo ERRADO (vai derrubar o servidor)
```python
# MAU: pedidos simultâneos sem delay — VAI CAUSAR TIMEOUT
import asyncio
tasks = [fetch(f"/products?page={i}") for i in range(1, 50)]  # PROIBIDO!
await asyncio.gather(*tasks)  # NUNCA FAZER ISTO
```

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
| `per_page` | int | Itens por página (max 30, default 15) |
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

**Campos obrigatórios:** apenas `name` e `price`

> **Defaults automáticos:** Se não forem enviados, a API preenche automaticamente:
> - `description` → usa o `name`
> - `sku` → gera código aleatório `API-XXXXXXXX`
> - `slug` → gerado a partir do `name`
> - `category_id` → usa a primeira categoria existente

**Exemplo mínimo (só obrigatórios):**

```json
{
  "name": "Fone Bluetooth JBL",
  "price": 8500.00
}
```

**Exemplo completo (recomendado para agentes IA):**

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
  "featured_image_url": "https://example.com/images/galaxy-a54-front.jpg",
  "image_urls": [
    "https://example.com/images/galaxy-a54-back.jpg",
    "https://example.com/images/galaxy-a54-side.jpg"
  ],
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
| `per_page` | int | Itens por página (max 30) |
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
| `per_page` | int | Itens por página (max 30) |
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
| `per_page` | int | Itens por página (max 30) |
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
9. **Esperar 2 segundos entre cada pedido à API** — o servidor tem recursos limitados.
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
1. Listar categorias existentes     → GET /api/v1/categories?with_children=true&is_active=true&per_page=30
2. Listar marcas existentes         → GET /api/v1/brands?is_active=true&per_page=30
   ⏱️ IMPORTANTE: Esperar 2 segundos entre cada pedido!
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

#### Imagens via URL (recomendado para agentes IA)

> **O servidor faz download automático das imagens.** Basta enviar as URLs no JSON.

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `featured_image_url` | string (URL) | URL da imagem principal (o servidor faz download, max 5MB) |
| `image_urls` | array de strings (URLs) | URLs de imagens para a galeria |

**Exemplo com URLs:**
```json
{
  "name": "Fone JBL Tune 510BT",
  "price": 8500,
  "featured_image_url": "https://example.com/images/jbl-tune-510bt.jpg",
  "image_urls": [
    "https://example.com/images/jbl-tune-510bt-2.jpg",
    "https://example.com/images/jbl-tune-510bt-3.jpg"
  ]
}
```

> Se o agente enviar `image_urls` mas não `featured_image_url`, a primeira imagem da galeria será usada como destaque.
> Formatos aceites: jpeg, png, gif, webp. Max 5MB por imagem.
> Se o download de uma URL falhar, é silenciosamente ignorado (o produto é criado sem essa imagem).

#### Imagens via upload (alternativa — multipart/form-data)

| Campo | Tipo | Descrição |
|-------|------|-----------|
| `featured_image` | file | Imagem principal (max 5MB, jpeg/png/jpg/gif/webp) |
| `images[]` | files | Galeria de imagens (múltiplos ficheiros) |

> Upload de ficheiros requer `Content-Type: multipart/form-data` em vez de `application/json`.

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

#### Exemplo completo com imagens via URL (recomendado para agentes IA)

> **O agente só precisa de enviar URLs de imagens no JSON.** O servidor faz download automático.

```bash
curl -X POST "https://superloja.vip/api/v1/products" \
     -H "Authorization: Bearer Popadic17" \
     -H "Content-Type: application/json" \
     -d '{
       "name": "Samsung Galaxy A54 128GB",
       "description": "Smartphone Samsung Galaxy A54 com 128GB, 6GB RAM, tela Super AMOLED 6.4 polegadas, câmara tripla 50MP.",
       "short_description": "Galaxy A54 128GB Preto",
       "price": 45000.00,
       "sale_price": 39900.00,
       "category_id": 10,
       "brand_id": 1,
       "stock_quantity": 25,
       "is_active": true,
       "is_featured": true,
       "condition": "new",
       "featured_image_url": "https://example.com/images/galaxy-a54-front.jpg",
       "image_urls": [
         "https://example.com/images/galaxy-a54-back.jpg",
         "https://example.com/images/galaxy-a54-side.jpg"
       ],
       "specifications": {
         "Memória": "128GB",
         "RAM": "6GB",
         "Tela": "6.4 polegadas",
         "Câmara": "50MP + 12MP + 5MP"
       }
     }'
```

> **Regras das imagens por URL:**
> - Formatos aceites: jpeg, png, gif, webp
> - Max 5MB por imagem
> - Se `featured_image_url` não for enviado mas `image_urls` sim, a primeira imagem da galeria é usada como destaque
> - Se o download de uma URL falhar, é ignorado silenciosamente (produto criado sem essa imagem)
> - O servidor guarda as imagens localmente — as URLs originais não são mantidas

#### Exemplo sem imagens (só JSON)

```bash
curl -X POST "https://superloja.vip/api/v1/products" \
     -H "Authorization: Bearer Popadic17" \
     -H "Content-Type: application/json" \
     -d '{
       "name": "Fone Bluetooth TWS",
       "price": 3500.00,
       "stock_quantity": 100
     }'
```

#### Exemplo com upload de ficheiros (alternativa — multipart/form-data)

```bash
curl -X POST "https://superloja.vip/api/v1/products" \
     -H "Authorization: Bearer Popadic17" \
     -F "name=Samsung Galaxy A54 128GB" \
     -F "price=45000.00" \
     -F "category_id=10" \
     -F "stock_quantity=25" \
     -F "description=Smartphone Samsung Galaxy A54 128GB" \
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
| `429` | Rate limit excedido | **Parar por 30 segundos**, depois tentar novamente |
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

---

## 🤖 Guia Completo para Agentes IA — Como Consumir a API Sem Derrubar o Servidor

> **ATENÇÃO: Este servidor está em shared hosting com recursos limitados.**
> Se não seguires estas regras, o servidor vai cair e o teu IP será banido temporariamente.

### Regras de Ouro

| Regra | Valor | Consequência se violar |
|-------|-------|----------------------|
| Rate limit | **30 requests/minuto** | HTTP 429 + possível ban de IP |
| Delay entre requests | **mínimo 2 segundos** | Servidor sobrecarrega e cai |
| Requests paralelas | **PROIBIDO** | Ban imediato de IP |
| Max por página | **30 itens** (`per_page=30`) | Resposta truncada |
| Tamanho recomendado | `per_page=10` a `per_page=15` | — |
| Cache das respostas | **60s produtos, 120s categorias** | Pedido repetido devolve mesmos dados |
| Timeout de segurança | **Se receber 429 ou timeout, parar 30s** | IP banido pelo firewall |

---

### Fluxo Correcto para Baixar Todos os Produtos

```
1. GET /products?page=1&per_page=15  → ler meta.last_page
2. Esperar 2 segundos
3. GET /products?page=2&per_page=15
4. Esperar 2 segundos
5. ... repetir até last_page
6. Guardar tudo em memória/ficheiro
7. NÃO repetir o mesmo pedido durante 60 segundos (cache)
```

### Exemplo Python Completo (Seguro)

```python
import requests
import time
import json

BASE_URL = "https://superloja.vip/api/v1"
HEADERS = {
    "Authorization": "Bearer Popadic17",
    "Accept": "application/json",
    "Content-Type": "application/json"
}

def safe_request(method, endpoint, **kwargs):
    """Fazer request seguro com retry e delay"""
    url = f"{BASE_URL}/{endpoint}"
    max_retries = 3
    
    for attempt in range(max_retries):
        try:
            response = requests.request(method, url, headers=HEADERS, timeout=15, **kwargs)
            
            if response.status_code == 429:
                print("⚠️ Rate limited! Aguardando 30s...")
                time.sleep(30)
                continue
            
            if response.status_code >= 500:
                print(f"⚠️ Erro servidor ({response.status_code}). Aguardando 10s...")
                time.sleep(10)
                continue
            
            return response
            
        except requests.exceptions.Timeout:
            print(f"⚠️ Timeout! Tentativa {attempt + 1}/{max_retries}. Aguardando 15s...")
            time.sleep(15)
        except requests.exceptions.ConnectionError:
            print(f"⚠️ Conexão recusada! IP pode estar banido. Aguardando 60s...")
            time.sleep(60)
    
    return None

# ==========================================
# BAIXAR TODOS OS PRODUTOS (forma segura)
# ==========================================
def download_all_products():
    all_products = []
    page = 1
    last_page = 1
    
    while page <= last_page:
        response = safe_request("GET", f"products?page={page}&per_page=15")
        
        if not response or response.status_code != 200:
            print(f"❌ Falha na página {page}")
            break
        
        data = response.json()
        last_page = data["meta"]["last_page"]
        
        for p in data["data"]:
            all_products.append({
                "id": p["id"],
                "name": p["name"],
                "description": p.get("description", ""),
                "price": p["price"],
                "sale_price": p.get("sale_price"),
                "stock_quantity": p["stock_quantity"],
                "featured_image_url": p.get("featured_image_url")
            })
        
        print(f"✅ Página {page}/{last_page} — {len(data['data'])} produtos")
        page += 1
        
        if page <= last_page:
            time.sleep(2)  # ⏱️ OBRIGATÓRIO: esperar 2s
    
    # Guardar em ficheiro
    with open("produtos.json", "w", encoding="utf-8") as f:
        json.dump(all_products, f, ensure_ascii=False, indent=2)
    
    print(f"\n📦 Total: {len(all_products)} produtos guardados em produtos.json")
    return all_products

# ==========================================
# CRIAR PRODUTO COM IMAGEM (forma segura)
# ==========================================
def create_product(name, price, image_url=None, **extras):
    product_data = {
        "name": name,
        "price": price,
        **extras
    }
    
    if image_url:
        product_data["featured_image_url"] = image_url
    
    response = safe_request("POST", "products", json=product_data)
    
    if response and response.status_code == 201:
        result = response.json()
        print(f"✅ Produto criado: ID {result['data']['id']} — {name}")
        return result["data"]
    else:
        print(f"❌ Erro ao criar produto: {name}")
        return None

# ==========================================
# ATUALIZAR PRODUTO (forma segura)
# ==========================================
def update_product(product_id, **fields):
    response = safe_request("PUT", f"products/{product_id}", json=fields)
    
    if response and response.status_code == 200:
        print(f"✅ Produto {product_id} atualizado")
        return response.json()["data"]
    else:
        print(f"❌ Erro ao atualizar produto {product_id}")
        return None

# ==========================================
# CRIAR VÁRIOS PRODUTOS (com delay seguro)
# ==========================================
def create_multiple_products(products_list):
    created = []
    for i, product in enumerate(products_list):
        result = create_product(**product)
        if result:
            created.append(result)
        
        # Delay entre criações
        if i < len(products_list) - 1:
            time.sleep(3)  # ⏱️ 3s entre criações (mais pesado que GET)
    
    print(f"\n📦 Criados {len(created)}/{len(products_list)} produtos")
    return created

# ==========================================
# EXEMPLO DE USO
# ==========================================
if __name__ == "__main__":
    # Baixar catálogo completo
    produtos = download_all_products()
    
    time.sleep(5)  # Pausa entre operações diferentes
    
    # Criar um produto com imagem
    create_product(
        name="Fone JBL Tune 510BT",
        price=8500,
        image_url="https://example.com/images/jbl-510bt.jpg",
        description="Fone Bluetooth JBL Tune 510BT com som Pure Bass",
        stock_quantity=50,
        category_id=3,
        is_active=True
    )
    
    time.sleep(3)
    
    # Criar vários produtos
    novos = [
        {"name": "Cabo USB-C 1m", "price": 1500, "stock_quantity": 200},
        {"name": "Carregador 20W", "price": 3500, "stock_quantity": 100},
        {"name": "Película iPhone 15", "price": 2000, "stock_quantity": 150},
    ]
    create_multiple_products(novos)
```

### O que a IA NUNCA Deve Fazer

```python
# ❌ PROIBIDO: Requests em paralelo
import asyncio
tasks = [fetch(f"/products?page={i}") for i in range(1, 50)]
await asyncio.gather(*tasks)  # VAI DERRUBAR O SERVIDOR

# ❌ PROIBIDO: Loop sem delay
for page in range(1, 100):
    requests.get(f"{BASE_URL}/products?page={page}")  # Sem sleep = ban

# ❌ PROIBIDO: per_page muito alto
requests.get(f"{BASE_URL}/products?per_page=1000")  # Max é 30

# ❌ PROIBIDO: Repetir mesma request em loop
while True:
    requests.get(f"{BASE_URL}/products")  # Dados são cached 60s, não muda

# ❌ PROIBIDO: Ignorar erros 429
response = requests.get(url)
# Se response.status_code == 429 → PARAR 30 SEGUNDOS, não continuar!

# ❌ PROIBIDO: Muitas criações seguidas sem delay
for p in range(100):
    requests.post(url, json=data)  # Sem sleep = servidor crash
```

### Resumo de Tempos de Espera

| Situação | Tempo de espera |
|----------|----------------|
| Entre GETs normais | **2 segundos** |
| Entre POSTs/PUTs (escrita) | **3 segundos** |
| Após receber HTTP 429 | **30 segundos** |
| Após timeout/erro de conexão | **60 segundos** |
| Após erro 500 do servidor | **10 segundos** |
| Entre operações diferentes (ex: após baixar tudo, antes de criar) | **5 segundos** |
| Mesmo endpoint já chamado (cache) | **Não repetir antes de 60s** |

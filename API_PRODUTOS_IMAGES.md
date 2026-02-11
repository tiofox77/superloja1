# API de Produtos com Imagens - Superloja

Guia completo para CRUD de produtos com upload de imagens.

## 📁 Endpoints

| Método | Endpoint | Descrição |
|--------|----------|-----------|
| `GET` | `/api/v1/products` | Listar produtos |
| `POST` | `/api/v1/products` | Criar produto |
| `GET` | `/api/v1/products/{id}` | Ver produto |
| `PUT` | `/api/v1/products/{id}` | Atualizar produto |
| `DELETE` | `/api/v1/products/{id}` | Eliminar produto |

---

## 🔐 Autenticação

```bash
# Header obrigatório em todas as requisições
Authorization: Bearer Popadic17
```

---

## 1️⃣ CRIAR PRODUTO (com imagens)

### Endpoint
```
POST https://superloja.vip/api/v1/products
```

### Content-Type: `multipart/form-data`

### Campos do Formulário

| Campo | Tipo | Obrigatório | Descrição |
|-------|------|-------------|-----------|
| `name` | string | ✅ | Nome do produto |
| `price` | number | ✅ | Preço |
| `description` | string | ❌ | Descrição completa |
| `short_description` | string | ❌ | Descrição curta |
| `sku` | string | ❌ | Código SKU |
| `barcode` | string | ❌ | Código de barras |
| `category_id` | number | ❌ | ID da categoria |
| `brand_id` | number | ❌ | ID da marca |
| `stock_quantity` | number | ❌ | Quantidade em stock |
| `sale_price` | number | ❌ | Preço de promoção |
| `cost_price` | number | ❌ | Preço de custo |
| `is_active` | boolean | ❌ | Produto ativo (default: true) |
| `is_featured` | boolean | ❌ | Produto em destaque |
| `featured_image` | file | ❌ | Imagem de destaque |
| `images[]` | files | ❌ | Galeria de imagens |

### Exemplo cURL

```bash
curl -X POST https://superloja.vip/api/v1/products \
  -H "Authorization: Bearer Popadic17" \
  -F "name=Smartphone Galaxy A54" \
  -F "price=45000.00" \
  -F "sale_price=39900.00" \
  -F "cost_price=30000.00" \
  -F "sku=SAM-A54-001" \
  -F "barcode=7891234567890" \
  -F "category_id=3" \
  -F "brand_id=2" \
  -F "stock_quantity=25" \
  -F "description=Smartphone Samsung Galaxy A54 128GB" \
  -F "is_active=true" \
  -F "is_featured=true" \
  -F "featured_image=@/caminho/imagem1.jpg" \
  -F "images[]=@/caminho/imagem2.jpg" \
  -F "images[]=@/caminho/imagem3.jpg"
```

### Exemplo JavaScript (Fetch)

```javascript
const formData = new FormData();
formData.append('name', 'Smartphone Galaxy A54');
formData.append('price', '45000.00');
formData.append('sale_price', '39900.00');
formData.append('sku', 'SAM-A54-001');
formData.append('category_id', '3');
formData.append('brand_id', '2');
formData.append('stock_quantity', '25');
formData.append('description', 'Smartphone Samsung Galaxy A54 128GB');
formData.append('is_active', 'true');

// Imagem de destaque
const featuredImage = document.querySelector('#featured_image').files[0];
formData.append('featured_image', featuredImage);

// Múltiplas imagens
const galleryImages = document.querySelector('#gallery_images').files;
for (let i = 0; i < galleryImages.length; i++) {
  formData.append('images[]', galleryImages[i]);
}

const response = await fetch('https://superloja.vip/api/v1/products', {
  method: 'POST',
  headers: {
    'Authorization': 'Bearer Popadic17',
  },
  body: formData
});

const data = await response.json();
console.log(data);
```

### Exemplo Python

```python
import requests

url = 'https://superloja.vip/api/v1/products'

files = {
    'featured_image': ('imagem1.jpg', open('imagem1.jpg', 'rb'), 'image/jpeg'),
    'images': [
        ('images', ('imagem2.jpg', open('imagem2.jpg', 'rb'), 'image/jpeg')),
        ('images', ('imagem3.jpg', open('imagem3.jpg', 'rb'), 'image/jpeg')),
    ]
}

data = {
    'name': 'Smartphone Galaxy A54',
    'price': '45000.00',
    'sale_price': '39900.00',
    'sku': 'SAM-A54-001',
    'category_id': '3',
    'brand_id': '2',
    'stock_quantity': '25',
    'description': 'Smartphone Samsung Galaxy A54 128GB',
    'is_active': 'true',
}

response = requests.post(
    url,
    headers={'Authorization': 'Bearer Popadic17'},
    data=data,
    files=files
)

print(response.json())
```

### Resposta de Sucesso (201 Created)

```json
{
  "success": true,
  "message": "Produto criado com sucesso.",
  "data": {
    "id": 42,
    "name": "Smartphone Galaxy A54",
    "slug": "smartphone-galaxy-a54",
    "price": "45000.00",
    "sale_price": "39900.00",
    "stock_quantity": 25,
    "category": { "id": 3, "name": "Eletrônicos", "slug": "eletronicos" },
    "brand": { "id": 2, "name": "Samsung", "slug": "samsung" },
    "is_active": true,
    "is_featured": true,
    "featured_image": "products/abc123def456.jpg",
    "featured_image_url": "https://superloja.vip/storage/products/abc123def456.jpg",
    "images": [
      "products/abc123def456.jpg",
      "products/xyz789ghi012.jpg"
    ],
    "image_urls": [
      "https://superloja.vip/storage/products/abc123def456.jpg",
      "https://superloja.vip/storage/products/xyz789ghi012.jpg"
    ],
    "created_at": "2026-02-10T20:30:00.000000Z"
  }
}
```

---

## 2️⃣ ATUALIZAR PRODUTO (com imagens)

### Endpoint
```
PUT https://superloja.vip/api/v1/products/{id}
```

### Exemplos

#### Atualizar apenas dados (sem imagens)
```bash
curl -X PUT https://superloja.vip/api/v1/products/42 \
  -H "Authorization: Bearer Popadic17" \
  -H "Content-Type: application/json" \
  -d '{"price": 42000.00, "stock_quantity": 30, "is_featured": true}'
```

#### Substituir imagem de destaque
```bash
curl -X PUT https://superloja.vip/api/v1/products/42 \
  -H "Authorization: Bearer Popadic17" \
  -F "featured_image=@/nova-imagem.jpg"
```

#### Adicionar novas imagens à galeria
```bash
curl -X PUT https://superloja.vip/api/v1/products/42 \
  -H "Authorization: Bearer Popadic17" \
  -F "images[]=@/imagem4.jpg" \
  -F "images[]=@/imagem5.jpg"
```

#### Eliminar imagens específicas
```bash
curl -X PUT https://superloja.vip/api/v1/products/42 \
  -H "Authorization: Bearer Popadic17" \
  -H "Content-Type: application/json" \
  -d '{"delete_images": ["products/xyz789ghi012.jpg"]}'
```

#### Atualização completa com novas imagens
```bash
curl -X PUT https://superloja.vip/api/v1/products/42 \
  -H "Authorization: Bearer Popadic17" \
  -F "name=Smartphone Galaxy A55" \
  -F "price=48000.00" \
  -F "featured_image=@/nova-destaque.jpg" \
  -F "images[]=@/galeria1.jpg" \
  -F "images[]=@/galeria2.jpg" \
  -F "delete_images=[\"products/antiga.jpg\"]"
```

### Resposta de Sucesso (200 OK)

```json
{
  "success": true,
  "message": "Produto atualizado com sucesso.",
  "data": {
    "id": 42,
    "name": "Smartphone Galaxy A55",
    "price": "48000.00",
    "featured_image": "products/nova-destaque.jpg",
    "featured_image_url": "https://superloja.vip/storage/products/nova-destaque.jpg",
    "images": [
      "products/nova-destaque.jpg",
      "products/galeria1.jpg",
      "products/galeria2.jpg"
    ],
    "image_urls": [
      "https://superloja.vip/storage/products/nova-destaque.jpg",
      "https://superloja.vip/storage/products/galeria1.jpg",
      "https://superloja.vip/storage/products/galeria2.jpg"
    ],
    "updated_at": "2026-02-10T21:00:00.000000Z"
  }
}
```

---

## 3️⃣ VER PRODUTO

### Endpoint
```
GET https://superloja.vip/api/v1/products/{id}
```

### Exemplo
```bash
curl -H "Authorization: Bearer Popadic17" \
     https://superloja.vip/api/v1/products/42
```

### Resposta

```json
{
  "success": true,
  "data": {
    "id": 42,
    "name": "Smartphone Galaxy A54",
    "slug": "smartphone-galaxy-a54",
    "price": "45000.00",
    "sale_price": "39900.00",
    "stock_quantity": 25,
    "description": "...",
    "category": { "id": 3, "name": "Eletrônicos", "slug": "eletronicos" },
    "brand": { "id": 2, "name": "Samsung", "slug": "samsung" },
    "is_active": true,
    "is_featured": true,
    "featured_image": "products/abc123def456.jpg",
    "featured_image_url": "https://superloja.vip/storage/products/abc123def456.jpg",
    "images": [
      "products/abc123def456.jpg",
      "products/xyz789ghi012.jpg"
    ],
    "image_urls": [
      "https://superloja.vip/storage/products/abc123def456.jpg",
      "https://superloja.vip/storage/products/xyz789ghi012.jpg"
    ],
    "created_at": "2026-02-10T20:30:00.000000Z"
  }
}
```

---

## 4️⃣ ELIMINAR PRODUTO

### Endpoint
```
DELETE https://superloja.vip/api/v1/products/{id}
```

### Exemplo
```bash
curl -X DELETE https://superloja.vip/api/v1/products/42 \
  -H "Authorization: Bearer Popadic17"
```

### Resposta de Sucesso

```json
{
  "success": true,
  "message": "Produto excluído com sucesso."
}
```

### Resposta de Erro (Produto não encontrado)

```json
{
  "success": false,
  "message": "Produto não encontrado."
}
```

---

## 5️⃣ LISTAR PRODUTOS (com filtros)

### Endpoint
```
GET https://superloja.vip/api/v1/products
```

### Parâmetros de Query

| Parâmetro | Tipo | Descrição |
|-----------|------|-----------|
| `search` | string | Buscar por nome/descrição |
| `category_id` | int | Filtrar por categoria |
| `brand_id` | int | Filtrar por marca |
| `is_active` | boolean | Apenas ativos |
| `is_featured` | boolean | Apenas em destaque |
| `in_stock` | boolean | Apenas com stock |
| `min_price` | float | Preço mínimo |
| `max_price` | float | Preço máximo |
| `sort_by` | string | Ordenar por: name, price, stock_quantity, created_at |
| `sort_dir` | string | Direção: asc ou desc |
| `per_page` | int | Itens por página (max 100) |
| `page` | int | Número da página |

### Exemplo
```bash
curl "https://superloja.vip/api/v1/products?category_id=3&is_active=true&sort_by=price&sort_dir=asc&per_page=20" \
  -H "Authorization: Bearer Popadic17"
```

### Resposta (com paginação)

```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Produto 1",
      "price": "150.00",
      "featured_image_url": "https://superloja.vip/storage/products/img1.jpg",
      "image_urls": [...]
    },
    {
      "id": 2,
      "name": "Produto 2",
      "price": "200.00",
      "featured_image_url": "https://superloja.vip/storage/products/img2.jpg",
      "image_urls": [...]
    }
  ],
  "meta": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 15,
    "total": 73
  }
}
```

---

## ⚠️ Códigos de Erro

| Código | Descrição |
|--------|-----------|
| `200` | Sucesso |
| `201` | Criado com sucesso |
| `400` | Erro na requisição / Validação |
| `401` | Token inválido ou ausente |
| `404` | Produto não encontrado |
| `422` | Erro de validação |
| `500` | Erro interno |

### Exemplo de Erro de Validação

```json
{
  "success": false,
  "message": "Erro de validação",
  "errors": {
    "name": ["O campo nome é obrigatório."],
    "price": ["O campo preço é obrigatório."]
  }
}
```

---

## 📝 Notas Importantes

1. **Tamanho máximo por imagem:** 5MB
2. **Formatos aceitos:** jpeg, png, jpg, gif, webp
3. **Quantidade de imagens:** Ilimitadas (aconselhável até 10)
4. **Armazenamento:** As imagens são salvas em `storage/app/public/products/`
5. **URLs públicas:** Use `asset('storage/'.$path)` para acessar as imagens

---

## 🔗 Links Úteis

- **Documentação geral da API:** [API.md](API.md)
- **Loja:** https://superloja.vip/admin
- **Token padrão:** `Popadic17`

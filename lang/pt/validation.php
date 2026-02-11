<?php

return [
    'required' => 'O campo :attribute é obrigatório.',
    'exists' => 'O :attribute selecionado não é válido.',
    'string' => 'O campo :attribute deve ser um texto.',
    'max' => [
        'string' => 'O campo :attribute não pode ter mais de :max caracteres.',
        'numeric' => 'O campo :attribute não pode ser maior que :max.',
    ],
    'min' => [
        'string' => 'O campo :attribute deve ter pelo menos :min caracteres.',
        'numeric' => 'O campo :attribute deve ser pelo menos :min.',
    ],
    'numeric' => 'O campo :attribute deve ser um número.',
    'integer' => 'O campo :attribute deve ser um número inteiro.',
    'unique' => 'Este :attribute já está em uso.',
    'lt' => [
        'numeric' => 'O campo :attribute deve ser menor que :value.',
    ],
    'image' => 'O campo :attribute deve ser uma imagem.',
    'in' => 'O :attribute selecionado não é válido.',
    
    'attributes' => [
        'name' => 'nome do produto',
        'description' => 'descrição',
        'short_description' => 'descrição curta',
        'sku' => 'SKU/Código',
        'barcode' => 'código de barras',
        'price' => 'preço de venda',
        'sale_price' => 'preço promocional',
        'cost_price' => 'preço de custo',
        'stock_quantity' => 'quantidade em estoque',
        'low_stock_threshold' => 'limite de estoque baixo',
        'parent_category_id' => 'categoria principal',
        'category_id' => 'subcategoria',
        'brand_id' => 'marca',
        'condition' => 'condição',
        'weight' => 'peso',
        'length' => 'comprimento',
        'width' => 'largura',
        'height' => 'altura',
        'featuredImageUpload' => 'imagem principal',
        'galleryUploads' => 'galeria de imagens',
    ],
];

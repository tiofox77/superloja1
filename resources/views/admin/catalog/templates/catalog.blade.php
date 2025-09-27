<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        
        .catalog-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        
        .catalog-header {
            text-align: center;
            margin-bottom: 40px;
            padding: 40px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        
        .catalog-title {
            font-size: 3rem;
            font-weight: bold;
            margin-bottom: 10px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }
        
        .catalog-description {
            font-size: 1.2rem;
            opacity: 0.9;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }
        
        .products-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        
        .product-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.15);
        }
        
        .product-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 3px solid #f1f5f9;
        }
        
        .product-placeholder {
            width: 100%;
            height: 200px;
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 0.9rem;
            border-bottom: 3px solid #e2e8f0;
        }
        
        .product-info {
            padding: 20px;
        }
        
        .product-name {
            font-size: 1.1rem;
            font-weight: bold;
            margin-bottom: 8px;
            color: #1e293b;
            line-height: 1.4;
        }
        
        .product-category {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .product-description {
            font-size: 0.9rem;
            color: #475569;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        
        .product-price {
            font-size: 1.3rem;
            font-weight: bold;
            color: #059669;
            background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
            padding: 8px 15px;
            border-radius: 25px;
            display: inline-block;
            box-shadow: 0 2px 8px rgba(5, 150, 105, 0.2);
        }
        
        .product-list-item {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            padding: 20px;
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .list-product-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            flex-shrink: 0;
        }
        
        .list-product-info {
            flex: 1;
        }
        
        .page-break {
            page-break-before: always;
        }
        
        .catalog-footer {
            text-align: center;
            margin-top: 50px;
            padding: 30px;
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            color: white;
            border-radius: 15px;
        }
        
        .stats-section {
            margin: 40px 0;
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        
        .stat-item {
            padding: 20px;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 10px;
            border-left: 4px solid #3b82f6;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #1e293b;
        }
        
        .stat-label {
            font-size: 0.9rem;
            color: #64748b;
            margin-top: 5px;
        }
        
        @media print {
            body { 
                background: white !important; 
            }
            .catalog-container {
                max-width: none;
                padding: 0;
            }
            .product-card:hover {
                transform: none;
                box-shadow: 0 8px 25px rgba(0,0,0,0.1);
            }
        }

        /* Estilos específicos para PDF */
        @if($forPdf ?? false)
        <style>
            body {
                background: white !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            .catalog-container {
                max-width: none;
                padding: 10px;
            }
            .product-card {
                break-inside: avoid;
                page-break-inside: avoid;
            }
            .product-image, .list-product-image {
                max-width: 100% !important;
                height: auto !important;
            }
            .page-break {
                page-break-before: always;
            }
        </style>
        @endif
        
        @media (max-width: 768px) {
            .catalog-title {
                font-size: 2rem;
            }
            .products-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                gap: 20px;
            }
            .product-list-item {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="catalog-container">
        <!-- Header -->
        <div class="catalog-header">
            <h1 class="catalog-title">{{ $title }}</h1>
            <p class="catalog-description">{{ $description }}</p>
        </div>

        <!-- Stats Section -->
        <div class="stats-section">
            <h2 style="margin-bottom: 20px; color: #1e293b;">Resumo do Catálogo</h2>
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-number">{{ $products->count() }}</div>
                    <div class="stat-label">Produtos</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $products->unique('category_id')->count() }}</div>
                    <div class="stat-label">Categorias</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ $products->unique('brand_id')->count() }}</div>
                    <div class="stat-label">Marcas</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">{{ number_format($products->avg('price'), 2) }} Kz</div>
                    <div class="stat-label">Preço Médio</div>
                </div>
            </div>
        </div>

        <!-- Products -->
        @if($layout === 'grid')
            <div class="products-grid">
                @foreach($products->chunk($productsPerPage) as $chunk)
                    @foreach($chunk as $product)
                        <div class="product-card">
                            @if($includeImages)
                                @php
                                    $imageUrl = null;
                                    if ($product->featured_image) {
                                        $imageUrl = $forPdf ? public_path('storage/' . $product->featured_image) : asset('storage/' . $product->featured_image);
                                    } elseif ($product->images && count($product->images) > 0) {
                                        $imageUrl = $forPdf ? public_path('storage/' . $product->images[0]) : asset('storage/' . $product->images[0]);
                                    }
                                @endphp
                                
                                @if($imageUrl)
                                    <img src="{{ $imageUrl }}" 
                                         alt="{{ $product->name }}" 
                                         class="product-image"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="product-placeholder" style="display: none;">
                                        <span>Imagem não disponível</span>
                                    </div>
                                @else
                                    <div class="product-placeholder">
                                        <span>Imagem não disponível</span>
                                    </div>
                                @endif
                            @endif
                            
                            <div class="product-info">
                                <h3 class="product-name">{{ $product->name }}</h3>
                                <p class="product-category">{{ $product->category->name }} • {{ $product->brand->name }}</p>
                                
                                @if($includeDescriptions && $product->description)
                                    <p class="product-description">{{ Str::limit($product->description, 120) }}</p>
                                @endif
                                
                                @if($includePrices)
                                    <div class="product-price">{{ number_format($product->price, 2) }} Kz</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    
                    @if(!$loop->last && $forPdf)
                        <div class="page-break"></div>
                    @endif
                @endforeach
            </div>
        @else
            <!-- List Layout -->
            <div class="products-list">
                @foreach($products->chunk($productsPerPage) as $chunk)
                    @foreach($chunk as $product)
                        <div class="product-list-item">
                            @if($includeImages)
                                @php
                                    $imageUrl = null;
                                    if ($product->featured_image) {
                                        $imageUrl = $forPdf ? public_path('storage/' . $product->featured_image) : asset('storage/' . $product->featured_image);
                                    } elseif ($product->images && count($product->images) > 0) {
                                        $imageUrl = $forPdf ? public_path('storage/' . $product->images[0]) : asset('storage/' . $product->images[0]);
                                    }
                                @endphp
                                
                                @if($imageUrl)
                                    <img src="{{ $imageUrl }}" 
                                         alt="{{ $product->name }}" 
                                         class="list-product-image"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="list-product-image product-placeholder" style="display: none;">
                                        <span style="font-size: 0.7rem;">Sem imagem</span>
                                    </div>
                                @else
                                    <div class="list-product-image product-placeholder">
                                        <span style="font-size: 0.7rem;">Sem imagem</span>
                                    </div>
                                @endif
                            @endif
                            
                            <div class="list-product-info">
                                <h3 class="product-name">{{ $product->name }}</h3>
                                <p class="product-category">{{ $product->category->name }} • {{ $product->brand->name }}</p>
                                
                                @if($includeDescriptions && $product->description)
                                    <p class="product-description">{{ Str::limit($product->description, 200) }}</p>
                                @endif
                                
                                @if($includePrices)
                                    <div class="product-price" style="margin-top: 10px;">{{ number_format($product->price, 2) }} Kz</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                    
                    @if(!$loop->last && $forPdf)
                        <div class="page-break"></div>
                    @endif
                @endforeach
            </div>
        @endif

        <!-- Footer -->
        <div class="catalog-footer">
            <h3 style="margin-bottom: 15px;">SuperLoja</h3>
            <p>Catálogo gerado em {{ date('d/m/Y H:i') }}</p>
            <p style="margin-top: 10px; opacity: 0.8;">www.superloja.com • contato@superloja.com</p>
        </div>
    </div>
</body>
</html>

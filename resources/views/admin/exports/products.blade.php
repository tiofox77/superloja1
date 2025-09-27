<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Produtos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #333;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0;
        }
        .filters {
            background-color: #f5f5f5;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .filters h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .filter-item {
            display: inline-block;
            margin-right: 20px;
            margin-bottom: 5px;
        }
        .stats {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background-color: #e8f4fd;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #495057;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .status-active {
            color: #28a745;
            font-weight: bold;
        }
        .status-inactive {
            color: #dc3545;
            font-weight: bold;
        }
        .featured {
            color: #ffc107;
            font-weight: bold;
        }
        .price {
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 15px;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Relatório de Produtos</h1>
        <p>SuperLoja - Sistema de Gestão</p>
        <p>Gerado em: {{ $exportDate }}</p>
    </div>

    @if($filters['search'] || $filters['category'] || $filters['brand'] || $filters['status'] || $filters['selected_products'])
    <div class="filters">
        <h3>Filtros Aplicados:</h3>
        @if($filters['selected_products'])
            <span class="filter-item"><strong>Tipo:</strong> {{ $filters['selected_products'] }}</span>
        @endif
        @if($filters['search'])
            <span class="filter-item"><strong>Busca:</strong> {{ $filters['search'] }}</span>
        @endif
        @if($filters['category'])
            <span class="filter-item"><strong>Categoria:</strong> {{ $filters['category'] }}</span>
        @endif
        @if($filters['brand'])
            <span class="filter-item"><strong>Marca:</strong> {{ $filters['brand'] }}</span>
        @endif
        @if($filters['status'])
            <span class="filter-item"><strong>Status:</strong> {{ ucfirst($filters['status']) }}</span>
        @endif
    </div>
    @endif

    <div class="stats">
        <strong>Total de Produtos: {{ $totalProducts }}</strong>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">#</th>
                <th width="25%">Nome</th>
                <th width="10%">SKU</th>
                <th width="12%">Categoria</th>
                <th width="10%">Marca</th>
                <th width="8%">Preço</th>
                <th width="8%">Oferta</th>
                <th width="6%">Stock</th>
                <th width="6%">Status</th>
                <th width="6%">Destaque</th>
                <th width="8%">Criado</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->sku }}</td>
                <td>{{ $product->category->name ?? '-' }}</td>
                <td>{{ $product->brand->name ?? '-' }}</td>
                <td class="price">€{{ number_format($product->price, 2, ',', '.') }}</td>
                <td class="price">
                    @if($product->sale_price)
                        €{{ number_format($product->sale_price, 2, ',', '.') }}
                    @else
                        -
                    @endif
                </td>
                <td style="text-align: center;">{{ $product->stock_quantity }}</td>
                <td class="{{ $product->is_active ? 'status-active' : 'status-inactive' }}">
                    {{ $product->is_active ? 'Ativo' : 'Inativo' }}
                </td>
                <td class="{{ $product->is_featured ? 'featured' : '' }}" style="text-align: center;">
                    {{ $product->is_featured ? '★' : '-' }}
                </td>
                <td>{{ $product->created_at->format('d/m/Y') }}</td>
            </tr>
            @if(($index + 1) % 30 == 0 && $index + 1 < count($products))
            </tbody>
        </table>
        <div class="page-break"></div>
        <table>
            <thead>
                <tr>
                    <th width="3%">#</th>
                    <th width="25%">Nome</th>
                    <th width="10%">SKU</th>
                    <th width="12%">Categoria</th>
                    <th width="10%">Marca</th>
                    <th width="8%">Preço</th>
                    <th width="8%">Oferta</th>
                    <th width="6%">Stock</th>
                    <th width="6%">Status</th>
                    <th width="6%">Destaque</th>
                    <th width="8%">Criado</th>
                </tr>
            </thead>
            <tbody>
            @endif
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>SuperLoja - Sistema de Gestão de Produtos</p>
        <p>Este relatório foi gerado automaticamente em {{ $exportDate }}</p>
    </div>
</body>
</html>

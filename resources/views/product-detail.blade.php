<!DOCTYPE html>
<html lang="pt-AO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - SuperLoja Angola</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-4 text-sm">
            <a href="/" class="text-blue-600 hover:underline">Início</a>
            <span class="mx-2">›</span>
            <a href="/produtos" class="text-blue-600 hover:underline">Produtos</a>
            <span class="mx-2">›</span>
            <span class="text-gray-600">{{ $product->name }}</span>
        </nav>

        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="grid md:grid-cols-2 gap-8 p-6">
                <!-- Imagem do Produto -->
                <div class="flex items-center justify-center bg-gray-100 rounded-lg p-4">
                    @if($product->featured_image)
                        <img src="{{ asset('storage/' . $product->featured_image) }}" 
                             alt="{{ $product->name }}"
                             class="max-w-full h-auto max-h-96 object-contain">
                    @else
                        <div class="w-full h-64 flex items-center justify-center text-gray-400">
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Detalhes do Produto -->
                <div class="flex flex-col">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                    @if($product->category)
                        <p class="text-sm text-gray-600 mb-2">
                            <span class="font-semibold">Categoria:</span> {{ $product->category->name }}
                        </p>
                    @endif

                    @if($product->brand)
                        <p class="text-sm text-gray-600 mb-4">
                            <span class="font-semibold">Marca:</span> {{ $product->brand->name }}
                        </p>
                    @endif

                    <!-- Preço -->
                    <div class="mb-6">
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <div class="flex items-center gap-3">
                                <span class="text-3xl font-bold text-red-600">
                                    {{ number_format((float)$product->sale_price, 2, ',', '.') }} Kz
                                </span>
                                <span class="text-xl text-gray-500 line-through">
                                    {{ number_format((float)$product->price, 2, ',', '.') }} Kz
                                </span>
                                @php
                                    $discount = round((1 - $product->sale_price/$product->price) * 100);
                                @endphp
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm font-bold">
                                    -{{ $discount }}%
                                </span>
                            </div>
                        @else
                            <span class="text-3xl font-bold text-gray-900">
                                {{ number_format((float)$product->price, 2, ',', '.') }} Kz
                            </span>
                        @endif
                    </div>

                    <!-- Estoque -->
                    <div class="mb-6">
                        @if($product->stock_quantity > 0)
                            @if($product->stock_quantity <= 5)
                                <p class="text-orange-600 font-semibold">
                                    ⚠️ Últimas {{ $product->stock_quantity }} unidades!
                                </p>
                            @else
                                <p class="text-green-600 font-semibold">
                                    ✅ Em estoque ({{ $product->stock_quantity }} disponíveis)
                                </p>
                            @endif
                        @else
                            <p class="text-red-600 font-semibold">
                                ❌ Fora de estoque
                            </p>
                        @endif
                    </div>

                    <!-- Descrição -->
                    @if($product->short_description)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2">Descrição</h3>
                            <p class="text-gray-700">{{ $product->short_description }}</p>
                        </div>
                    @endif

                    @if($product->description)
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold mb-2">Detalhes</h3>
                            <div class="text-gray-700 prose">
                                {!! nl2br(e($product->description)) !!}
                            </div>
                        </div>
                    @endif

                    <!-- Botões de Ação -->
                    <div class="mt-auto space-y-3">
                        @if($product->stock_quantity > 0)
                            <a href="https://wa.me/244939729902?text=Olá! Gostaria de encomendar: {{ urlencode($product->name) }}" 
                               class="block w-full bg-green-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-green-700 transition">
                                📱 Encomendar via WhatsApp
                            </a>
                        @endif
                        
                        <a href="/produtos" 
                           class="block w-full bg-blue-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                            🔍 Ver Mais Produtos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

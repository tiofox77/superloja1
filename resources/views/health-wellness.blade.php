@extends('layouts.app')

@section('title', 'Saúde e Bem-estar - SuperLoja')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Saúde e Bem-estar</h1>
            <p class="text-xl text-green-100 max-w-3xl mx-auto">
                Cuide da sua saúde com produtos de qualidade. Suplementos, equipamentos fitness, 
                produtos naturais e muito mais para o seu bem-estar.
            </p>
        </div>
    </div>

    <!-- Categories Section -->
    <div class="container mx-auto px-4 py-12">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Categorias de Saúde</h2>
            <p class="text-gray-600">Explore nossa seleção de produtos para sua saúde e bem-estar</p>
        </div>

        @if($healthCategory && $healthCategory->children->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($healthCategory->children as $index => $subcategory)
                    @php
                        $colors = [
                            ['from' => 'green', 'to' => 'emerald', 'bg' => 'green'],
                            ['from' => 'blue', 'to' => 'indigo', 'bg' => 'blue'],
                            ['from' => 'amber', 'to' => 'orange', 'bg' => 'amber'],
                            ['from' => 'pink', 'to' => 'rose', 'bg' => 'pink'],
                            ['from' => 'red', 'to' => 'rose', 'bg' => 'red'],
                            ['from' => 'purple', 'to' => 'violet', 'bg' => 'purple'],
                            ['from' => 'cyan', 'to' => 'blue', 'bg' => 'cyan'],
                            ['from' => 'teal', 'to' => 'emerald', 'bg' => 'teal'],
                        ];
                        $color = $colors[$index % count($colors)];
                        
                        $icons = [
                            'M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z',
                            'M13 10V3L4 14h7v7l9-11h-7z',
                            'M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z',
                            'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                            'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z',
                            'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                            'M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z',
                            'M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'
                        ];
                        $icon = $icons[$index % count($icons)];
                    @endphp
                    
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 transform hover:scale-105">
                        <div class="bg-gradient-to-br from-{{ $color['from'] }}-100 to-{{ $color['to'] }}-100 p-6 text-center">
                            <!-- Category Image -->
                            @if($subcategory->image_url)
                                <div class="w-16 h-16 mx-auto mb-4 rounded-xl overflow-hidden">
                                    <img src="{{ $subcategory->image_url }}" alt="{{ $subcategory->name }}" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-16 h-16 bg-{{ $color['bg'] }}-500 rounded-xl flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <h3 class="text-xl font-bold text-gray-900 mb-3">{{ $subcategory->name }}</h3>
                            
                            @if($subcategory->description)
                                <p class="text-gray-600 mb-4 text-sm leading-relaxed">{{ Str::limit($subcategory->description, 80) }}</p>
                            @endif
                            
                            <!-- Products Count -->
                            <div class="mb-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-{{ $color['bg'] }}-100 text-{{ $color['bg'] }}-800">
                                    📦 {{ $subcategory->products_count ?? 0 }} produtos
                                </span>
                            </div>
                            
                            <a href="{{ route('products') }}?category={{ $subcategory->id }}" 
                               class="bg-{{ $color['bg'] }}-500 text-white px-6 py-3 rounded-xl hover:bg-{{ $color['bg'] }}-600 transition-all duration-300 inline-flex items-center font-semibold shadow-lg hover:shadow-xl">
                                Ver Produtos
                                <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Fallback if no subcategories found -->
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Em breve!</h3>
                <p class="text-gray-600 mb-6">Estamos a organizar os produtos desta categoria. Volte em breve!</p>
                <a href="{{ route('request.product') }}" 
                   class="bg-green-500 text-white px-6 py-3 rounded-xl hover:bg-green-600 transition-colors inline-flex items-center font-semibold">
                    Solicitar Produto Específico
                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        @endif
    </div>

    <!-- Call to Action -->
    <div class="bg-gradient-to-r from-green-600 to-emerald-600 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Precisa de um produto específico?</h2>
            <p class="text-xl text-green-100 mb-8">
                Não encontrou o que procura? Solicite o produto e nós encontramos para si!
            </p>
            <a href="{{ route('request.product') }}" 
               class="bg-white text-green-600 px-8 py-4 rounded-lg font-semibold text-lg hover:bg-gray-100 transition-colors inline-flex items-center">
                Solicitar Produto
                <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
    </div>
</div>
@endsection

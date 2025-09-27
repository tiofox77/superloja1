@extends('layouts.app')

@section('title', 'Marcas - SuperLoja')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Nossas Marcas</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Trabalhamos com as melhores marcas do mercado tecnológico mundial.</p>
        </div>
        
        <!-- Featured Brands -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-8 mb-16">
            @php
                $brands = [
                    ['name' => 'Apple', 'logo' => '🍎'],
                    ['name' => 'Samsung', 'logo' => '📱'],
                    ['name' => 'Sony', 'logo' => '🎮'],
                    ['name' => 'Dell', 'logo' => '💻'],
                    ['name' => 'HP', 'logo' => '🖥️'],
                    ['name' => 'Xiaomi', 'logo' => '📲'],
                    ['name' => 'Huawei', 'logo' => '📡'],
                    ['name' => 'LG', 'logo' => '📺'],
                    ['name' => 'Asus', 'logo' => '⚡'],
                    ['name' => 'Microsoft', 'logo' => '🎯'],
                    ['name' => 'Nintendo', 'logo' => '🎮'],
                    ['name' => 'Lenovo', 'logo' => '💼']
                ];
            @endphp
            
            @foreach($brands as $brand)
                <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 text-center group cursor-pointer">
                    <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">{{ $brand['logo'] }}</div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-orange-500 transition-colors">{{ $brand['name'] }}</h3>
                </div>
            @endforeach
        </div>
        
        <!-- Brand Promise -->
        <div class="bg-white rounded-xl p-8 shadow-md text-center">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Qualidade Garantida</h2>
            <p class="text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Todos os nossos produtos são originais e vêm com garantia oficial das marcas. 
                Trabalhamos apenas com fornecedores autorizados para garantir que você receba 
                produtos autênticos com o melhor suporte pós-venda.
            </p>
        </div>
    </div>
</div>
@endsection

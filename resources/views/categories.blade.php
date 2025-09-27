@extends('layouts.app')

@section('title', 'Categorias - SuperLoja')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Categorias de Produtos</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Explore nossa ampla variedade de produtos organizados por categorias.</p>
        </div>
        
        <livewire:components.featured-categories />
    </div>
</div>
@endsection

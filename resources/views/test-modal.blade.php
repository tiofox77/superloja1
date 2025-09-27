@extends('layouts.app')

@section('title', 'Teste Modal e Notificações')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Teste do Sistema de Modal e Notificações</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Teste de Notificações -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Teste de Notificações</h2>
                <div class="space-y-3">
                    <button onclick="testNotification('success', 'Sucesso! Tudo funcionando perfeitamente.')" 
                            class="w-full bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                        Notificação de Sucesso
                    </button>
                    <button onclick="testNotification('error', 'Erro! Algo deu errado.')" 
                            class="w-full bg-red-500 text-white py-2 px-4 rounded hover:bg-red-600">
                        Notificação de Erro
                    </button>
                    <button onclick="testNotification('warning', 'Atenção! Verifique os dados.')" 
                            class="w-full bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600">
                        Notificação de Aviso
                    </button>
                    <button onclick="testNotification('info', 'Informação importante para você.')" 
                            class="w-full bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600">
                        Notificação de Info
                    </button>
                </div>
            </div>
            
            <!-- Teste de Modal -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Teste de Modal</h2>
                <div class="space-y-3">
                    <button onclick="openProductModal(1)" 
                            class="w-full bg-orange-500 text-white py-2 px-4 rounded hover:bg-orange-600">
                        Abrir Modal Produto 1
                    </button>
                    <button onclick="openProductModal(2)" 
                            class="w-full bg-orange-500 text-white py-2 px-4 rounded hover:bg-orange-600">
                        Abrir Modal Produto 2
                    </button>
                    <button onclick="openProductModal(3)" 
                            class="w-full bg-orange-500 text-white py-2 px-4 rounded hover:bg-orange-600">
                        Abrir Modal Produto 3
                    </button>
                    <button onclick="openProductModal(999)" 
                            class="w-full bg-gray-500 text-white py-2 px-4 rounded hover:bg-gray-600">
                        Produto Inexistente (Teste Erro)
                    </button>
                </div>
            </div>
            
            <!-- Produtos em Destaque -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold mb-4">Produtos em Destaque</h2>
                <p class="text-gray-600 mb-4">Teste os produtos reais do banco de dados:</p>
                @livewire('components.featured-products-mini')
            </div>
        </div>
        
        <!-- Instruções -->
        <div class="mt-8 bg-blue-50 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">Instruções de Teste</h3>
            <ul class="list-disc list-inside text-blue-800 space-y-2">
                <li>Teste as notificações clicando nos botões coloridos</li>
                <li>Teste o modal de produtos clicando nos botões laranja</li>
                <li>Teste produtos reais usando os botões "Ver Detalhes" nos produtos em destaque</li>
                <li>Teste adicionar produtos ao carrinho</li>
                <li>Verifique se as notificações aparecem corretamente</li>
                <li>Verifique se o modal abre e fecha corretamente</li>
            </ul>
        </div>
    </div>
</div>

<script>
function testNotification(type, message) {
    if (typeof Livewire !== 'undefined') {
        Livewire.dispatch('show-notification', {
            type: type,
            message: message
        });
    } else if (typeof toastr !== 'undefined') {
        toastr[type](message);
    } else {
        alert(type.toUpperCase() + ': ' + message);
    }
}

function openProductModal(productId) {
    if (typeof Livewire !== 'undefined') {
        Livewire.dispatch('open-product-modal', productId);
    } else {
        alert('Livewire não carregado');
    }
}
</script>
@endsection

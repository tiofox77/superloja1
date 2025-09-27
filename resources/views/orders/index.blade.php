@extends('layouts.app')

@section('title', 'Meus Pedidos - SuperLoja')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Meus Pedidos</h1>
                <p class="text-gray-600">Acompanhe o status dos seus pedidos</p>
            </div>

            @if($orders->count() > 0)
                <div class="space-y-6">
                    @foreach($orders as $order)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-900">Pedido #{{ $order->id }}</h3>
                                        <p class="text-sm text-gray-600">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium
                                            @if($order->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status === 'completed') bg-green-100 text-green-800
                                            @elseif($order->status === 'cancelled') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                        <p class="text-lg font-bold text-gray-900 mt-1">{{ number_format($order->total_amount, 0, ',', '.') }} Kz</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="px-6 py-4">
                                @if($order->notes)
                                    <p class="text-gray-600 mb-3">{{ $order->notes }}</p>
                                @endif
                                
                                <div class="flex justify-between items-center">
                                    <div class="text-sm text-gray-500">
                                        <p><strong>Status de Pagamento:</strong> 
                                            <span class="
                                                @if($order->payment_status === 'pending') text-yellow-600
                                                @elseif($order->payment_status === 'paid') text-green-600  
                                                @elseif($order->payment_status === 'failed') text-red-600
                                                @else text-gray-600
                                                @endif">
                                                {{ ucfirst($order->payment_status) }}
                                            </span>
                                        </p>
                                        @if($order->shipping_address)
                                            <p><strong>Endereço:</strong> {{ $order->shipping_address }}</p>
                                        @endif
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        <button class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm hover:bg-purple-700 transition-colors">
                                            Ver Detalhes
                                        </button>
                                        @if($order->status === 'pending')
                                            <button class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm hover:bg-red-700 transition-colors">
                                                Cancelar
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-16">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Nenhum Pedido Encontrado</h3>
                    <p class="text-gray-600 mb-8 max-w-md mx-auto">
                        Você ainda não fez nenhum pedido. Explore nossos produtos e leilões!
                    </p>
                    <div class="flex justify-center space-x-4">
                        <a href="{{ route('home') }}" 
                           class="inline-flex items-center bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition-colors">
                            Explorar Produtos
                        </a>
                        <a href="{{ route('auctions') }}" 
                           class="inline-flex items-center bg-green-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-green-700 transition-colors">
                            Ver Leilões
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

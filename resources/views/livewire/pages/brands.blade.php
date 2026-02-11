<div class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-4">Nossas Marcas</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Trabalhamos com as melhores marcas do mercado tecnológico mundial.</p>
        </div>
        
        <!-- Brands Grid -->
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-16">
            @forelse($brands as $brand)
                <div class="bg-white rounded-xl p-6 shadow-md hover:shadow-lg transition-all duration-300 text-center group cursor-pointer">
                    @if($brand->logo)
                        <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" class="h-16 w-auto mx-auto mb-3 object-contain group-hover:scale-110 transition-transform">
                    @else
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform">🏷️</div>
                    @endif
                    <h3 class="font-semibold text-gray-900 group-hover:text-orange-500 transition-colors">{{ $brand->name }}</h3>
                    @if($brand->products_count > 0)
                        <p class="text-sm text-gray-500 mt-2">{{ $brand->products_count }} produtos</p>
                    @endif
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500">Nenhuma marca disponível no momento.</p>
                </div>
            @endforelse
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

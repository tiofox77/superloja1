<!-- Product Delete Modal -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" id="productDeleteModal">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900">
                Eliminar Produto
            </h3>
            <button wire:click="closeDeleteModal" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Modal Body -->
        <div class="mt-6">
            <!-- Warning Icon -->
            <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.865-.833-2.632 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
            </div>

            <!-- Message -->
            <div class="text-center">
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    Tem certeza?
                </h3>
                <p class="text-sm text-gray-600 mb-4">
                    Esta ação não pode ser desfeita. O produto será permanentemente eliminado do sistema.
                </p>
                
                @if($selectedProduct)
                    <div class="bg-gray-50 rounded-lg p-3 mb-4">
                        <div class="flex items-center justify-center">
                            @if($selectedProduct->image_url)
                                <img class="h-12 w-12 rounded-lg object-cover mr-3" src="{{ Storage::url($selectedProduct->image_url) }}" alt="{{ $selectedProduct->name }}">
                            @else
                                <div class="h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="text-left">
                                <p class="font-medium text-gray-900">{{ $selectedProduct->name }}</p>
                                <p class="text-sm text-gray-500">SKU: {{ $selectedProduct->sku }}</p>
                                <p class="text-sm text-gray-500">{{ number_format($selectedProduct->price, 2) }} Kz</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Consequences Warning -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">
                                Consequências da eliminação:
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc space-y-1 pl-5">
                                    <li>O produto será removido permanentemente</li>
                                    <li>Histórico de vendas será mantido para relatórios</li>
                                    <li>Imagens associadas serão eliminadas</li>
                                    <li>Avaliações e comentários serão mantidos</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
            <button type="button" 
                    wire:click="closeDeleteModal"
                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                Cancelar
            </button>
            <button type="button" 
                    wire:click="confirmDelete"
                    class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
                Sim, Eliminar
            </button>
        </div>
    </div>
</div>

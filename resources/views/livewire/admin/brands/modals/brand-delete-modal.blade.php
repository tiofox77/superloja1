<!-- Brand Delete Modal -->
<div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" id="brandDeleteModal">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <!-- Modal Header -->
        <div class="flex items-center justify-between pb-4 border-b border-gray-200">
            <h3 class="text-xl font-semibold text-gray-900">
                Eliminar Marca
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
                    Esta ação não pode ser desfeita. A marca será permanentemente eliminada do sistema.
                </p>
                
                @if($selectedBrand)
                    <div class="bg-gray-50 rounded-lg p-3 mb-4">
                        <div class="flex items-center justify-center">
                            @if($selectedBrand->logo_url)
                                <img class="h-12 w-12 rounded-lg object-contain bg-white mr-3" src="{{ Storage::url($selectedBrand->logo_url) }}" alt="{{ $selectedBrand->name }}">
                            @else
                                <div class="h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="text-left">
                                <p class="font-medium text-gray-900">{{ $selectedBrand->name }}</p>
                                <p class="text-sm text-gray-500">{{ $selectedBrand->products_count }} produtos associados</p>
                                @if($selectedBrand->website)
                                    <p class="text-sm text-blue-500">{{ $selectedBrand->website }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Products Warning -->
                @if($selectedBrand && $selectedBrand->products_count > 0)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-3 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">
                                    Atenção: Esta marca tem produtos associados!
                                </h3>
                                <div class="mt-2 text-sm text-red-700">
                                    <p>Esta marca não pode ser eliminada porque tem {{ $selectedBrand->products_count }} produto(s) associado(s).</p>
                                    <p class="mt-1">Para eliminar esta marca, primeiro remova ou transfira todos os produtos para outras marcas.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- Safe to Delete -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">
                                    Consequências da eliminação:
                                </h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <ul class="list-disc space-y-1 pl-5">
                                        <li>A marca será removida permanentemente</li>
                                        <li>Logo associado será eliminado</li>
                                        <li>Histórico será mantido para relatórios</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Modal Footer -->
        <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
            <button type="button" 
                    wire:click="closeDeleteModal"
                    class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors duration-200">
                Cancelar
            </button>
            
            @if($selectedBrand && $selectedBrand->products_count == 0)
                <button type="button" 
                        wire:click="confirmDelete"
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-200">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Sim, Eliminar
                </button>
            @else
                <button type="button" 
                        disabled
                        class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-400 cursor-not-allowed">
                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                    </svg>
                    Não é Possível Eliminar
                </button>
            @endif
        </div>
    </div>
</div>

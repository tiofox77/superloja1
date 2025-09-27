<div>
    <button type="button"
            wire:click="openModal"
            class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
        Abrir teste de upload
    </button>

    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center bg-black/40 z-50">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-md p-6">
                <div class="flex items-start justify-between">
                    <h2 class="text-lg font-semibold text-gray-800">Testar Upload Livewire</h2>
                    <button type="button"
                            wire:click="closeModal"
                            class="text-gray-500 hover:text-gray-700">
                        &times;
                    </button>
                </div>

                <div class="mt-4 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Selecionar imagem</label>
                        <input type="file"
                               wire:model="image"
                               accept="image/*"
                               class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer focus:outline-none" />
                        @error('image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    @if($image)
                        <div class="space-y-2">
                            <p class="text-sm text-gray-600">Preview:</p>
                            <img src="{{ $image->temporaryUrl() }}"
                                 alt="Preview"
                                 class="w-48 h-48 object-cover rounded-lg border border-gray-200" />
                        </div>
                    @endif
                </div>

                <div class="mt-6 flex justify-end space-x-2">
                    <button type="button"
                            wire:click="closeModal"
                            class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100">
                        Cancelar
                    </button>
                    <button type="button"
                            wire:click="submit"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Enviar teste
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>

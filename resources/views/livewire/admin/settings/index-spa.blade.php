<div>
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Configurações do Sistema</h1>
        <p class="text-gray-500">Gerencie todas as configurações da sua loja</p>
    </div>
    
    <div class="flex flex-col lg:flex-row gap-6">
        <!-- Sidebar Tabs -->
        <div class="lg:w-72 flex-shrink-0">
            <nav class="bg-white rounded-xl border border-gray-200 divide-y divide-gray-100 overflow-hidden">
                <!-- Geral -->
                <div>
                    <div class="px-3 py-2 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Sistema</p>
                    </div>
                    <button wire:click="$set('activeTab', 'general')"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium transition-colors
                                   {{ $activeTab === 'general' ? 'bg-primary-50 text-primary-700 border-l-4 border-primary-500' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                        <span>Configurações Gerais</span>
                    </button>
                    <button wire:click="$set('activeTab', 'appearance')"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium transition-colors
                                   {{ $activeTab === 'appearance' ? 'bg-primary-50 text-primary-700 border-l-4 border-primary-500' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i data-lucide="palette" class="w-5 h-5"></i>
                        <span>Aparência & Logo</span>
                    </button>
                </div>
                
                <!-- Marketing -->
                <div>
                    <div class="px-3 py-2 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Marketing</p>
                    </div>
                    <button wire:click="$set('activeTab', 'seo')"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium transition-colors
                                   {{ $activeTab === 'seo' ? 'bg-primary-50 text-primary-700 border-l-4 border-primary-500' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i data-lucide="search" class="w-5 h-5"></i>
                        <span>SEO & Analytics</span>
                    </button>
                    <button wire:click="$set('activeTab', 'social')"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium transition-colors
                                   {{ $activeTab === 'social' ? 'bg-primary-50 text-primary-700 border-l-4 border-primary-500' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i data-lucide="share-2" class="w-5 h-5"></i>
                        <span>Redes Sociais</span>
                    </button>
                </div>
                
                <!-- Loja -->
                <div>
                    <div class="px-3 py-2 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Loja</p>
                    </div>
                    <button wire:click="$set('activeTab', 'store')"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium transition-colors
                                   {{ $activeTab === 'store' ? 'bg-primary-50 text-primary-700 border-l-4 border-primary-500' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i data-lucide="shopping-cart" class="w-5 h-5"></i>
                        <span>Configurações da Loja</span>
                    </button>
                </div>
                
                <!-- Notificações -->
                <div>
                    <div class="px-3 py-2 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Notificações</p>
                    </div>
                    <button wire:click="$set('activeTab', 'sms')"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium transition-colors
                                   {{ $activeTab === 'sms' ? 'bg-primary-50 text-primary-700 border-l-4 border-primary-500' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i data-lucide="message-square" class="w-5 h-5"></i>
                        <span>SMS</span>
                    </button>
                    <button wire:click="$set('activeTab', 'email')"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium transition-colors
                                   {{ $activeTab === 'email' ? 'bg-primary-50 text-primary-700 border-l-4 border-primary-500' : 'text-gray-600 hover:bg-gray-50' }}">
                        <i data-lucide="mail" class="w-5 h-5"></i>
                        <span>Email (SMTP)</span>
                    </button>
                </div>
                
                <!-- Ferramentas -->
                <div>
                    <div class="px-3 py-2 bg-gray-50">
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Ferramentas</p>
                    </div>
                    <div class="p-3">
                        <button wire:click="runSettingsSeeder"
                                wire:confirm="Isto vai preencher todas as configurações em falta com valores padrão. Configurações já existentes NÃO serão alteradas. Continuar?"
                                wire:loading.attr="disabled"
                                class="w-full flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium rounded-lg
                                       bg-amber-50 text-amber-700 border border-amber-200 hover:bg-amber-100 transition-colors
                                       disabled:opacity-50 disabled:cursor-wait">
                            <i data-lucide="database" class="w-4 h-4" wire:loading.class="animate-spin" wire:target="runSettingsSeeder"></i>
                            <span wire:loading.remove wire:target="runSettingsSeeder">Restaurar Padrões</span>
                            <span wire:loading wire:target="runSettingsSeeder">A processar...</span>
                        </button>
                        <p class="text-[10px] text-gray-400 mt-1.5 text-center">Preenche configurações em falta sem sobrescrever as existentes</p>
                    </div>
                </div>
            </nav>
        </div>
        
        <!-- Content -->
        <div class="flex-1">
            <!-- General Settings -->
            @if($activeTab === 'general')
                <div class="space-y-6">
                    <x-admin.ui.card title="Informações da Loja" icon="store">
                        <form wire:submit="saveGeneral" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <x-admin.form.input 
                                    wire:model="app_name"
                                    label="Nome da Loja"
                                    icon="store"
                                    placeholder="SuperLoja" 
                                    required />
                                
                                <x-admin.form.input 
                                    wire:model="contact_email"
                                    type="email"
                                    label="Email de Contato"
                                    icon="mail"
                                    placeholder="contato@superloja.vip" />
                                
                                <x-admin.form.input 
                                    wire:model="contact_phone"
                                    label="Telefone"
                                    icon="phone"
                                    placeholder="+244 923 456 789" />
                                
                                <x-admin.form.input 
                                    wire:model="whatsapp_number"
                                    label="WhatsApp"
                                    icon="message-circle"
                                    placeholder="244923456789"
                                    hint="Apenas números, com código do país" />
                            </div>
                            
                            <x-admin.form.textarea 
                                wire:model="app_description"
                                label="Descrição da Loja"
                                rows="3"
                                placeholder="Uma breve descrição da sua loja..." />
                            
                            <x-admin.form.textarea 
                                wire:model="address"
                                label="Endereço Completo"
                                rows="2"
                                placeholder="Endereço completo da loja..." />
                            
                            <x-admin.form.select 
                                wire:model="timezone"
                                label="Fuso Horário"
                                icon="clock">
                                <option value="Africa/Luanda">Luanda (GMT+1)</option>
                                <option value="Africa/Lagos">Lagos (GMT+1)</option>
                                <option value="Africa/Maputo">Maputo (GMT+2)</option>
                                <option value="Africa/Johannesburg">Johannesburg (GMT+2)</option>
                                <option value="Europe/Lisbon">Lisboa (GMT+0)</option>
                            </x-admin.form.select>
                            
                            <div class="flex justify-end pt-4 border-t border-gray-200">
                                <x-admin.ui.button type="submit" icon="save">
                                    Salvar Alterações
                                </x-admin.ui.button>
                            </div>
                        </form>
                    </x-admin.ui.card>
                </div>
            @endif
            
            <!-- Appearance Settings -->
            @if($activeTab === 'appearance')
                <x-admin.ui.card title="Aparência" icon="palette">
                    <form wire:submit="saveAppearance" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Logo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Logo da Loja</label>
                                <div class="flex items-center gap-4">
                                    @if($currentLogo)
                                        <img src="{{ asset('storage/' . $currentLogo) }}" alt="Logo" class="h-16 w-16 object-contain rounded-lg bg-gray-100">
                                    @else
                                        <div class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center">
                                            <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                                        </div>
                                    @endif
                                    <input type="file" wire:model="site_logo" accept="image/*" class="text-sm">
                                </div>
                                @if($site_logo)
                                    <p class="text-xs text-green-600 mt-2">Nova imagem selecionada</p>
                                @endif
                            </div>
                            
                            <!-- Favicon -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                                <div class="flex items-center gap-4">
                                    @if($currentFavicon)
                                        <img src="{{ asset('storage/' . $currentFavicon) }}" alt="Favicon" class="h-10 w-10 object-contain rounded bg-gray-100">
                                    @else
                                        <div class="h-10 w-10 rounded bg-gray-100 flex items-center justify-center">
                                            <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                                        </div>
                                    @endif
                                    <input type="file" wire:model="site_favicon" accept="image/*" class="text-sm">
                                </div>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cor Primária</label>
                                <div class="flex items-center gap-3">
                                    <input type="color" wire:model="primary_color" class="h-10 w-20 rounded cursor-pointer">
                                    <input type="text" wire:model="primary_color" class="flex-1 rounded-xl border-gray-300 text-sm">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Cor Secundária</label>
                                <div class="flex items-center gap-3">
                                    <input type="color" wire:model="secondary_color" class="h-10 w-20 rounded cursor-pointer">
                                    <input type="text" wire:model="secondary_color" class="flex-1 rounded-xl border-gray-300 text-sm">
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end">
                            <x-admin.ui.button type="submit" icon="save">
                                Salvar Alterações
                            </x-admin.ui.button>
                        </div>
                    </form>
                </x-admin.ui.card>
            @endif
            
            <!-- SEO Settings -->
            @if($activeTab === 'seo')
                <div class="space-y-6">
                    <!-- Google Preview -->
                    <x-admin.ui.card title="Pré-visualização no Google" icon="eye">
                        <div class="p-4 bg-white border border-gray-200 rounded-xl">
                            <div class="max-w-xl">
                                <p class="text-sm text-green-700 truncate">{{ url('/') }}</p>
                                <h3 class="text-xl text-blue-700 hover:underline cursor-pointer truncate" style="font-family: arial, sans-serif;">
                                    {{ $meta_title ?: ($app_name . ' - Sua Loja Online de Confiança') }}
                                </h3>
                                <p class="text-sm text-gray-600 line-clamp-2" style="font-family: arial, sans-serif;">
                                    {{ $meta_description ?: 'Configure a meta descrição para aparecer nos resultados de busca do Google.' }}
                                </p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Esta é uma simulação de como o site aparece no Google.</p>
                    </x-admin.ui.card>

                    <x-admin.ui.card title="SEO - Meta Tags" icon="search">
                        <form wire:submit="saveSeo" class="space-y-6">
                            <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
                                <p class="text-sm text-blue-800">
                                    <strong>🔍 Dica:</strong> Configure os meta tags para melhorar o posicionamento da sua loja no Google. Estas informações aparecem nos resultados de busca.
                                </p>
                            </div>
                            
                            <div>
                                <x-admin.form.input 
                                    wire:model.live="meta_title"
                                    label="Título SEO (Title Tag)"
                                    icon="text"
                                    placeholder="SuperLoja - As Melhores Ofertas de Angola" />
                                <p class="text-xs mt-1 {{ strlen($meta_title) > 60 ? 'text-red-500' : 'text-gray-400' }}">
                                    {{ strlen($meta_title) }}/60 caracteres {{ strlen($meta_title) > 60 ? '— muito longo, será cortado no Google' : '' }}
                                </p>
                            </div>
                            
                            <div>
                                <x-admin.form.textarea 
                                    wire:model.live="meta_description"
                                    label="Meta Descrição"
                                    rows="3"
                                    placeholder="Descrição da sua loja para os motores de busca..." />
                                <p class="text-xs mt-1 {{ strlen($meta_description) > 160 ? 'text-red-500' : 'text-gray-400' }}">
                                    {{ strlen($meta_description) }}/160 caracteres {{ strlen($meta_description) > 160 ? '— muito longo, será cortado' : '' }}
                                </p>
                            </div>
                            
                            <x-admin.form.textarea 
                                wire:model="meta_keywords"
                                label="Palavras-chave"
                                rows="2"
                                placeholder="loja, angola, produtos, eletrônicos, compras online"
                                hint="Separe as palavras-chave por vírgula" />
                            
                            <!-- OG Image -->
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i data-lucide="image" class="w-4 h-4"></i>
                                    Imagem de Partilha (Open Graph)
                                </h4>
                                <p class="text-xs text-gray-500 mb-3">Esta imagem aparece quando o site é partilhado no Facebook, WhatsApp, Twitter, etc. Tamanho recomendado: 1200x630px.</p>
                                <div class="flex items-start gap-4">
                                    @if($currentOgImage)
                                        <img src="{{ asset('storage/' . $currentOgImage) }}" alt="OG Image" class="h-24 w-40 object-cover rounded-lg bg-gray-100 border">
                                    @else
                                        <div class="h-24 w-40 rounded-lg bg-gray-100 border flex items-center justify-center">
                                            <div class="text-center">
                                                <i data-lucide="image" class="w-6 h-6 text-gray-400 mx-auto"></i>
                                                <p class="text-xs text-gray-400 mt-1">Sem imagem</p>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <input type="file" wire:model="og_image" accept="image/*" class="text-sm">
                                        @if($og_image)
                                            <p class="text-xs text-green-600 mt-2">✓ Nova imagem selecionada</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Tracking Codes -->
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i data-lucide="bar-chart-2" class="w-4 h-4"></i>
                                    Códigos de Rastreamento
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <x-admin.form.input 
                                        wire:model="google_analytics"
                                        label="Google Analytics ID"
                                        icon="bar-chart-2"
                                        placeholder="G-XXXXXXXXXX"
                                        hint="ID de medição do GA4" />
                                    
                                    <x-admin.form.input 
                                        wire:model="facebook_pixel"
                                        label="Facebook Pixel ID"
                                        icon="facebook"
                                        placeholder="123456789012345"
                                        hint="ID do Pixel do Facebook/Meta" />
                                </div>
                            </div>
                            
                            <div class="flex justify-end pt-4 border-t border-gray-200">
                                <x-admin.ui.button type="submit" icon="save">
                                    Salvar Configurações SEO
                                </x-admin.ui.button>
                            </div>
                        </form>
                    </x-admin.ui.card>
                    
                    <!-- SEO Status -->
                    <x-admin.ui.card title="Status do SEO" icon="check-circle">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="flex items-center gap-3 p-3 rounded-lg {{ !empty($meta_title) ? 'bg-green-50' : 'bg-red-50' }}">
                                <i data-lucide="{{ !empty($meta_title) ? 'check-circle' : 'x-circle' }}" class="w-5 h-5 {{ !empty($meta_title) ? 'text-green-600' : 'text-red-500' }}"></i>
                                <span class="text-sm font-medium {{ !empty($meta_title) ? 'text-green-800' : 'text-red-700' }}">Título SEO</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg {{ !empty($meta_description) ? 'bg-green-50' : 'bg-red-50' }}">
                                <i data-lucide="{{ !empty($meta_description) ? 'check-circle' : 'x-circle' }}" class="w-5 h-5 {{ !empty($meta_description) ? 'text-green-600' : 'text-red-500' }}"></i>
                                <span class="text-sm font-medium {{ !empty($meta_description) ? 'text-green-800' : 'text-red-700' }}">Meta Descrição</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg {{ !empty($meta_keywords) ? 'bg-green-50' : 'bg-yellow-50' }}">
                                <i data-lucide="{{ !empty($meta_keywords) ? 'check-circle' : 'alert-circle' }}" class="w-5 h-5 {{ !empty($meta_keywords) ? 'text-green-600' : 'text-yellow-500' }}"></i>
                                <span class="text-sm font-medium {{ !empty($meta_keywords) ? 'text-green-800' : 'text-yellow-700' }}">Palavras-chave</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg {{ $currentOgImage ? 'bg-green-50' : 'bg-yellow-50' }}">
                                <i data-lucide="{{ $currentOgImage ? 'check-circle' : 'alert-circle' }}" class="w-5 h-5 {{ $currentOgImage ? 'text-green-600' : 'text-yellow-500' }}"></i>
                                <span class="text-sm font-medium {{ $currentOgImage ? 'text-green-800' : 'text-yellow-700' }}">Imagem OG</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg {{ !empty($google_analytics) ? 'bg-green-50' : 'bg-gray-50' }}">
                                <i data-lucide="{{ !empty($google_analytics) ? 'check-circle' : 'minus-circle' }}" class="w-5 h-5 {{ !empty($google_analytics) ? 'text-green-600' : 'text-gray-400' }}"></i>
                                <span class="text-sm font-medium {{ !empty($google_analytics) ? 'text-green-800' : 'text-gray-500' }}">Google Analytics</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg {{ !empty($facebook_pixel) ? 'bg-green-50' : 'bg-gray-50' }}">
                                <i data-lucide="{{ !empty($facebook_pixel) ? 'check-circle' : 'minus-circle' }}" class="w-5 h-5 {{ !empty($facebook_pixel) ? 'text-green-600' : 'text-gray-400' }}"></i>
                                <span class="text-sm font-medium {{ !empty($facebook_pixel) ? 'text-green-800' : 'text-gray-500' }}">Facebook Pixel</span>
                            </div>
                        </div>
                    </x-admin.ui.card>
                </div>
            @endif
            
            <!-- Social Media Settings -->
            @if($activeTab === 'social')
                <x-admin.ui.card title="Links das Redes Sociais" icon="share-2">
                    <form wire:submit="saveSocial" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-admin.form.input 
                                wire:model="facebook_url"
                                label="Facebook"
                                icon="facebook"
                                placeholder="https://facebook.com/superloja" />
                            
                            <x-admin.form.input 
                                wire:model="instagram_url"
                                label="Instagram"
                                icon="instagram"
                                placeholder="https://instagram.com/superloja" />
                            
                            <x-admin.form.input 
                                wire:model="twitter_url"
                                label="Twitter / X"
                                icon="twitter"
                                placeholder="https://twitter.com/superloja" />
                            
                            <x-admin.form.input 
                                wire:model="youtube_url"
                                label="YouTube"
                                icon="youtube"
                                placeholder="https://youtube.com/@superloja" />
                            
                            <x-admin.form.input 
                                wire:model="linkedin_url"
                                label="LinkedIn"
                                icon="linkedin"
                                placeholder="https://linkedin.com/company/superloja" />
                            
                            <x-admin.form.input 
                                wire:model="tiktok_url"
                                label="TikTok"
                                icon="video"
                                placeholder="https://tiktok.com/@superloja" />
                        </div>
                        
                        <div class="flex justify-end pt-4 border-t border-gray-200">
                            <x-admin.ui.button type="submit" icon="save">
                                Salvar Alterações
                            </x-admin.ui.button>
                        </div>
                    </form>
                </x-admin.ui.card>
            @endif
            
            <!-- Store Settings -->
            @if($activeTab === 'store')
                <div class="space-y-6">
                    <x-admin.ui.card title="Moeda e Formatação" icon="dollar-sign">
                        <form wire:submit="saveStore" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <x-admin.form.input 
                                    wire:model="currency"
                                    label="Símbolo da Moeda"
                                    icon="dollar-sign"
                                    placeholder="Kz" />
                                
                                <x-admin.form.select 
                                    wire:model="currency_position"
                                    label="Posição da Moeda">
                                    <option value="before">Antes (Kz 100)</option>
                                    <option value="after">Depois (100 Kz)</option>
                                </x-admin.form.select>
                                
                                <x-admin.form.input 
                                    wire:model="low_stock_threshold"
                                    type="number"
                                    label="Limite Estoque Baixo"
                                    icon="alert-triangle"
                                    hint="Alerta quando estoque ficar abaixo" />
                            </div>
                            
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i data-lucide="toggle-left" class="w-4 h-4"></i>
                                    Funcionalidades da Loja
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <x-admin.form.toggle 
                                        wire:model="enable_reviews"
                                        label="Avaliações de Produtos"
                                        hint="Permitir que clientes avaliem produtos" />
                                    
                                    <x-admin.form.toggle 
                                        wire:model="enable_wishlist"
                                        label="Lista de Desejos"
                                        hint="Permitir salvar produtos favoritos" />
                                    
                                    <x-admin.form.toggle 
                                        wire:model="enable_compare"
                                        label="Comparar Produtos"
                                        hint="Permitir comparação entre produtos" />
                                    
                                    <x-admin.form.toggle 
                                        wire:model="enable_quick_view"
                                        label="Visualização Rápida"
                                        hint="Modal de preview rápido do produto" />
                                </div>
                            </div>
                            
                            <div class="flex justify-end pt-4 border-t border-gray-200">
                                <x-admin.ui.button type="submit" icon="save">
                                    Salvar Alterações
                                </x-admin.ui.button>
                            </div>
                        </form>
                    </x-admin.ui.card>
                </div>
            @endif
            
            <!-- SMS Settings -->
            @if($activeTab === 'sms')
                <x-admin.ui.card title="Configurações de SMS" icon="message-square">
                    <form wire:submit="saveSms" class="space-y-6">
                        <div class="p-4 bg-green-50 border border-green-200 rounded-xl">
                            <p class="text-sm text-green-800">
                                <strong>📱 SMS Marketing:</strong> Configure a integração com o provedor Unimtx para enviar SMS aos clientes.
                            </p>
                        </div>
                        
                        <x-admin.form.toggle 
                            wire:model="sms_enabled"
                            label="Habilitar Envio de SMS"
                            hint="Ativar/desativar o envio de SMS" />
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-admin.form.select 
                                wire:model="sms_provider"
                                label="Provedor SMS"
                                icon="server">
                                <option value="unimtx">Unimtx</option>
                            </x-admin.form.select>
                            
                            <x-admin.form.input 
                                wire:model="sms_sender_name"
                                label="Nome do Remetente"
                                icon="user"
                                placeholder="SUPERLOJA"
                                hint="Nome que aparece no SMS (máx. 11 caracteres)" />
                        </div>
                        
                        <x-admin.form.input 
                            wire:model="sms_access_key"
                            label="Access Key (API Key)"
                            type="password"
                            icon="key"
                            placeholder="Cole sua chave de API da Unimtx" />
                        
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                            <p class="text-xs text-yellow-800">
                                <strong>⚠️ Importante:</strong> A Access Key é confidencial. Não compartilhe com terceiros.
                            </p>
                        </div>
                        
                        <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.sms.index') }}" wire:navigate class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                                Ir para Templates SMS →
                            </a>
                            <x-admin.ui.button type="submit" icon="save">
                                Salvar Alterações
                            </x-admin.ui.button>
                        </div>
                    </form>
                </x-admin.ui.card>
            @endif
            
            <!-- Email Settings -->
            @if($activeTab === 'email')
                <x-admin.ui.card title="Configurações de Email (SMTP)" icon="mail">
                    <form wire:submit="saveEmail" class="space-y-6">
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
                            <p class="text-sm text-blue-800">
                                <strong>📧 Email Transacional:</strong> Configure o servidor SMTP para enviar emails de pedidos, confirmações, etc.
                            </p>
                        </div>
                        
                        <x-admin.form.toggle 
                            wire:model="email_enabled"
                            label="Habilitar Envio de Emails"
                            hint="Ativar/desativar o envio de emails" />
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-admin.form.input 
                                wire:model="smtp_host"
                                label="Servidor SMTP"
                                icon="server"
                                placeholder="smtp.gmail.com" />
                            
                            <x-admin.form.input 
                                wire:model="smtp_port"
                                label="Porta"
                                type="number"
                                icon="hash"
                                placeholder="587" />
                            
                            <x-admin.form.input 
                                wire:model="smtp_username"
                                label="Usuário / Email"
                                icon="user"
                                placeholder="contato@superloja.vip" />
                            
                            <x-admin.form.input 
                                wire:model="smtp_password"
                                label="Senha"
                                type="password"
                                icon="lock"
                                placeholder="••••••••" />
                            
                            <x-admin.form.select 
                                wire:model="smtp_encryption"
                                label="Criptografia"
                                icon="shield">
                                <option value="tls">TLS (Recomendado)</option>
                                <option value="ssl">SSL</option>
                                <option value="">Nenhuma</option>
                            </x-admin.form.select>
                        </div>
                        
                        <div class="p-4 bg-green-50 border border-green-200 rounded-xl">
                            <p class="text-xs text-green-800">
                                <strong>💡 Dica:</strong> Para Gmail, use smtp.gmail.com:587 com TLS e crie uma "Senha de App" nas configurações do Google.
                            </p>
                        </div>
                        
                        <div class="flex justify-end pt-4 border-t border-gray-200">
                            <x-admin.ui.button type="submit" icon="save">
                                Salvar Alterações
                            </x-admin.ui.button>
                        </div>
                    </form>
                </x-admin.ui.card>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Função para inicializar ícones Lucide com debounce
    let iconInitTimeout;
    function initIcons() {
        if (typeof lucide !== 'undefined') {
            clearTimeout(iconInitTimeout);
            iconInitTimeout = setTimeout(() => {
                lucide.createIcons();
            }, 50);
        }
    }
    
    // Inicializar após carregamento
    document.addEventListener('DOMContentLoaded', initIcons);
    
    // Listener para atualizações do Livewire (troca de tabs)
    document.addEventListener('livewire:init', () => {
        Livewire.hook('morph.updated', initIcons);
    });
</script>
@endpush

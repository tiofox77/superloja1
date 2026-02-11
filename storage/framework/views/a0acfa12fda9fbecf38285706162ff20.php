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
                                   <?php echo e($activeTab === 'general' ? 'bg-primary-50 text-primary-700 border-l-4 border-primary-500' : 'text-gray-600 hover:bg-gray-50'); ?>">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                        <span>Configurações Gerais</span>
                    </button>
                    <button wire:click="$set('activeTab', 'appearance')"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium transition-colors
                                   <?php echo e($activeTab === 'appearance' ? 'bg-primary-50 text-primary-700 border-l-4 border-primary-500' : 'text-gray-600 hover:bg-gray-50'); ?>">
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
                                   <?php echo e($activeTab === 'seo' ? 'bg-primary-50 text-primary-700 border-l-4 border-primary-500' : 'text-gray-600 hover:bg-gray-50'); ?>">
                        <i data-lucide="search" class="w-5 h-5"></i>
                        <span>SEO & Analytics</span>
                    </button>
                    <button wire:click="$set('activeTab', 'social')"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium transition-colors
                                   <?php echo e($activeTab === 'social' ? 'bg-primary-50 text-primary-700 border-l-4 border-primary-500' : 'text-gray-600 hover:bg-gray-50'); ?>">
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
                                   <?php echo e($activeTab === 'store' ? 'bg-primary-50 text-primary-700 border-l-4 border-primary-500' : 'text-gray-600 hover:bg-gray-50'); ?>">
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
                                   <?php echo e($activeTab === 'sms' ? 'bg-primary-50 text-primary-700 border-l-4 border-primary-500' : 'text-gray-600 hover:bg-gray-50'); ?>">
                        <i data-lucide="message-square" class="w-5 h-5"></i>
                        <span>SMS</span>
                    </button>
                    <button wire:click="$set('activeTab', 'email')"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm font-medium transition-colors
                                   <?php echo e($activeTab === 'email' ? 'bg-primary-50 text-primary-700 border-l-4 border-primary-500' : 'text-gray-600 hover:bg-gray-50'); ?>">
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
            <!--[if BLOCK]><![endif]--><?php if($activeTab === 'general'): ?>
                <div class="space-y-6">
                    <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Informações da Loja','icon' => 'store']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Informações da Loja','icon' => 'store']); ?>
                        <form wire:submit="saveGeneral" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'app_name','label' => 'Nome da Loja','icon' => 'store','placeholder' => 'SuperLoja','required' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'app_name','label' => 'Nome da Loja','icon' => 'store','placeholder' => 'SuperLoja','required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                                
                                <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'contact_email','type' => 'email','label' => 'Email de Contato','icon' => 'mail','placeholder' => 'contato@superloja.vip']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'contact_email','type' => 'email','label' => 'Email de Contato','icon' => 'mail','placeholder' => 'contato@superloja.vip']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                                
                                <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'contact_phone','label' => 'Telefone','icon' => 'phone','placeholder' => '+244 923 456 789']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'contact_phone','label' => 'Telefone','icon' => 'phone','placeholder' => '+244 923 456 789']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                                
                                <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'whatsapp_number','label' => 'WhatsApp','icon' => 'message-circle','placeholder' => '244923456789','hint' => 'Apenas números, com código do país']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'whatsapp_number','label' => 'WhatsApp','icon' => 'message-circle','placeholder' => '244923456789','hint' => 'Apenas números, com código do país']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                            </div>
                            
                            <?php if (isset($component)) { $__componentOriginal5f8711bac92b9cbfae758724ea0086d0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5f8711bac92b9cbfae758724ea0086d0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.textarea','data' => ['wire:model' => 'app_description','label' => 'Descrição da Loja','rows' => '3','placeholder' => 'Uma breve descrição da sua loja...']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'app_description','label' => 'Descrição da Loja','rows' => '3','placeholder' => 'Uma breve descrição da sua loja...']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5f8711bac92b9cbfae758724ea0086d0)): ?>
<?php $attributes = $__attributesOriginal5f8711bac92b9cbfae758724ea0086d0; ?>
<?php unset($__attributesOriginal5f8711bac92b9cbfae758724ea0086d0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5f8711bac92b9cbfae758724ea0086d0)): ?>
<?php $component = $__componentOriginal5f8711bac92b9cbfae758724ea0086d0; ?>
<?php unset($__componentOriginal5f8711bac92b9cbfae758724ea0086d0); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginal5f8711bac92b9cbfae758724ea0086d0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5f8711bac92b9cbfae758724ea0086d0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.textarea','data' => ['wire:model' => 'address','label' => 'Endereço Completo','rows' => '2','placeholder' => 'Endereço completo da loja...']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'address','label' => 'Endereço Completo','rows' => '2','placeholder' => 'Endereço completo da loja...']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5f8711bac92b9cbfae758724ea0086d0)): ?>
<?php $attributes = $__attributesOriginal5f8711bac92b9cbfae758724ea0086d0; ?>
<?php unset($__attributesOriginal5f8711bac92b9cbfae758724ea0086d0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5f8711bac92b9cbfae758724ea0086d0)): ?>
<?php $component = $__componentOriginal5f8711bac92b9cbfae758724ea0086d0; ?>
<?php unset($__componentOriginal5f8711bac92b9cbfae758724ea0086d0); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginal8ef619d218616cae7277f2a386a20785 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ef619d218616cae7277f2a386a20785 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.select','data' => ['wire:model' => 'timezone','label' => 'Fuso Horário','icon' => 'clock']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'timezone','label' => 'Fuso Horário','icon' => 'clock']); ?>
                                <option value="Africa/Luanda">Luanda (GMT+1)</option>
                                <option value="Africa/Lagos">Lagos (GMT+1)</option>
                                <option value="Africa/Maputo">Maputo (GMT+2)</option>
                                <option value="Africa/Johannesburg">Johannesburg (GMT+2)</option>
                                <option value="Europe/Lisbon">Lisboa (GMT+0)</option>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $attributes = $__attributesOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__attributesOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $component = $__componentOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__componentOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
                            
                            <div class="flex justify-end pt-4 border-t border-gray-200">
                                <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['type' => 'submit','icon' => 'save']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','icon' => 'save']); ?>
                                    Salvar Alterações
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $attributes = $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $component = $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
                            </div>
                        </form>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            
            <!-- Appearance Settings -->
            <!--[if BLOCK]><![endif]--><?php if($activeTab === 'appearance'): ?>
                <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Aparência','icon' => 'palette']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Aparência','icon' => 'palette']); ?>
                    <form wire:submit="saveAppearance" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Logo -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Logo da Loja</label>
                                <div class="flex items-center gap-4">
                                    <!--[if BLOCK]><![endif]--><?php if($currentLogo): ?>
                                        <img src="<?php echo e(asset('storage/' . $currentLogo)); ?>" alt="Logo" class="h-16 w-16 object-contain rounded-lg bg-gray-100">
                                    <?php else: ?>
                                        <div class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center">
                                            <i data-lucide="image" class="w-6 h-6 text-gray-400"></i>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <input type="file" wire:model="site_logo" accept="image/*" class="text-sm">
                                </div>
                                <!--[if BLOCK]><![endif]--><?php if($site_logo): ?>
                                    <p class="text-xs text-green-600 mt-2">Nova imagem selecionada</p>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            
                            <!-- Favicon -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Favicon</label>
                                <div class="flex items-center gap-4">
                                    <!--[if BLOCK]><![endif]--><?php if($currentFavicon): ?>
                                        <img src="<?php echo e(asset('storage/' . $currentFavicon)); ?>" alt="Favicon" class="h-10 w-10 object-contain rounded bg-gray-100">
                                    <?php else: ?>
                                        <div class="h-10 w-10 rounded bg-gray-100 flex items-center justify-center">
                                            <i data-lucide="star" class="w-4 h-4 text-gray-400"></i>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
                            <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['type' => 'submit','icon' => 'save']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','icon' => 'save']); ?>
                                Salvar Alterações
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $attributes = $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $component = $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
                        </div>
                    </form>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            
            <!-- SEO Settings -->
            <!--[if BLOCK]><![endif]--><?php if($activeTab === 'seo'): ?>
                <div class="space-y-6">
                    <!-- Google Preview -->
                    <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Pré-visualização no Google','icon' => 'eye']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Pré-visualização no Google','icon' => 'eye']); ?>
                        <div class="p-4 bg-white border border-gray-200 rounded-xl">
                            <div class="max-w-xl">
                                <p class="text-sm text-green-700 truncate"><?php echo e(url('/')); ?></p>
                                <h3 class="text-xl text-blue-700 hover:underline cursor-pointer truncate" style="font-family: arial, sans-serif;">
                                    <?php echo e($meta_title ?: ($app_name . ' - Sua Loja Online de Confiança')); ?>

                                </h3>
                                <p class="text-sm text-gray-600 line-clamp-2" style="font-family: arial, sans-serif;">
                                    <?php echo e($meta_description ?: 'Configure a meta descrição para aparecer nos resultados de busca do Google.'); ?>

                                </p>
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Esta é uma simulação de como o site aparece no Google.</p>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>

                    <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'SEO - Meta Tags','icon' => 'search']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'SEO - Meta Tags','icon' => 'search']); ?>
                        <form wire:submit="saveSeo" class="space-y-6">
                            <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
                                <p class="text-sm text-blue-800">
                                    <strong>🔍 Dica:</strong> Configure os meta tags para melhorar o posicionamento da sua loja no Google. Estas informações aparecem nos resultados de busca.
                                </p>
                            </div>
                            
                            <div>
                                <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model.live' => 'meta_title','label' => 'Título SEO (Title Tag)','icon' => 'text','placeholder' => 'SuperLoja - As Melhores Ofertas de Angola']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'meta_title','label' => 'Título SEO (Title Tag)','icon' => 'text','placeholder' => 'SuperLoja - As Melhores Ofertas de Angola']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                                <p class="text-xs mt-1 <?php echo e(strlen($meta_title) > 60 ? 'text-red-500' : 'text-gray-400'); ?>">
                                    <?php echo e(strlen($meta_title)); ?>/60 caracteres <?php echo e(strlen($meta_title) > 60 ? '— muito longo, será cortado no Google' : ''); ?>

                                </p>
                            </div>
                            
                            <div>
                                <?php if (isset($component)) { $__componentOriginal5f8711bac92b9cbfae758724ea0086d0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5f8711bac92b9cbfae758724ea0086d0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.textarea','data' => ['wire:model.live' => 'meta_description','label' => 'Meta Descrição','rows' => '3','placeholder' => 'Descrição da sua loja para os motores de busca...']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'meta_description','label' => 'Meta Descrição','rows' => '3','placeholder' => 'Descrição da sua loja para os motores de busca...']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5f8711bac92b9cbfae758724ea0086d0)): ?>
<?php $attributes = $__attributesOriginal5f8711bac92b9cbfae758724ea0086d0; ?>
<?php unset($__attributesOriginal5f8711bac92b9cbfae758724ea0086d0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5f8711bac92b9cbfae758724ea0086d0)): ?>
<?php $component = $__componentOriginal5f8711bac92b9cbfae758724ea0086d0; ?>
<?php unset($__componentOriginal5f8711bac92b9cbfae758724ea0086d0); ?>
<?php endif; ?>
                                <p class="text-xs mt-1 <?php echo e(strlen($meta_description) > 160 ? 'text-red-500' : 'text-gray-400'); ?>">
                                    <?php echo e(strlen($meta_description)); ?>/160 caracteres <?php echo e(strlen($meta_description) > 160 ? '— muito longo, será cortado' : ''); ?>

                                </p>
                            </div>
                            
                            <?php if (isset($component)) { $__componentOriginal5f8711bac92b9cbfae758724ea0086d0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5f8711bac92b9cbfae758724ea0086d0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.textarea','data' => ['wire:model' => 'meta_keywords','label' => 'Palavras-chave','rows' => '2','placeholder' => 'loja, angola, produtos, eletrônicos, compras online','hint' => 'Separe as palavras-chave por vírgula']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.textarea'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'meta_keywords','label' => 'Palavras-chave','rows' => '2','placeholder' => 'loja, angola, produtos, eletrônicos, compras online','hint' => 'Separe as palavras-chave por vírgula']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5f8711bac92b9cbfae758724ea0086d0)): ?>
<?php $attributes = $__attributesOriginal5f8711bac92b9cbfae758724ea0086d0; ?>
<?php unset($__attributesOriginal5f8711bac92b9cbfae758724ea0086d0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5f8711bac92b9cbfae758724ea0086d0)): ?>
<?php $component = $__componentOriginal5f8711bac92b9cbfae758724ea0086d0; ?>
<?php unset($__componentOriginal5f8711bac92b9cbfae758724ea0086d0); ?>
<?php endif; ?>
                            
                            <!-- OG Image -->
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i data-lucide="image" class="w-4 h-4"></i>
                                    Imagem de Partilha (Open Graph)
                                </h4>
                                <p class="text-xs text-gray-500 mb-3">Esta imagem aparece quando o site é partilhado no Facebook, WhatsApp, Twitter, etc. Tamanho recomendado: 1200x630px.</p>
                                <div class="flex items-start gap-4">
                                    <!--[if BLOCK]><![endif]--><?php if($currentOgImage): ?>
                                        <img src="<?php echo e(asset('storage/' . $currentOgImage)); ?>" alt="OG Image" class="h-24 w-40 object-cover rounded-lg bg-gray-100 border">
                                    <?php else: ?>
                                        <div class="h-24 w-40 rounded-lg bg-gray-100 border flex items-center justify-center">
                                            <div class="text-center">
                                                <i data-lucide="image" class="w-6 h-6 text-gray-400 mx-auto"></i>
                                                <p class="text-xs text-gray-400 mt-1">Sem imagem</p>
                                            </div>
                                        </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="flex-1">
                                        <input type="file" wire:model="og_image" accept="image/*" class="text-sm">
                                        <!--[if BLOCK]><![endif]--><?php if($og_image): ?>
                                            <p class="text-xs text-green-600 mt-2">✓ Nova imagem selecionada</p>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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
                                    <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'google_analytics','label' => 'Google Analytics ID','icon' => 'bar-chart-2','placeholder' => 'G-XXXXXXXXXX','hint' => 'ID de medição do GA4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'google_analytics','label' => 'Google Analytics ID','icon' => 'bar-chart-2','placeholder' => 'G-XXXXXXXXXX','hint' => 'ID de medição do GA4']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                                    
                                    <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'facebook_pixel','label' => 'Facebook Pixel ID','icon' => 'facebook','placeholder' => '123456789012345','hint' => 'ID do Pixel do Facebook/Meta']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'facebook_pixel','label' => 'Facebook Pixel ID','icon' => 'facebook','placeholder' => '123456789012345','hint' => 'ID do Pixel do Facebook/Meta']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="flex justify-end pt-4 border-t border-gray-200">
                                <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['type' => 'submit','icon' => 'save']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','icon' => 'save']); ?>
                                    Salvar Configurações SEO
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $attributes = $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $component = $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
                            </div>
                        </form>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
                    
                    <!-- SEO Status -->
                    <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Status do SEO','icon' => 'check-circle']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Status do SEO','icon' => 'check-circle']); ?>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="flex items-center gap-3 p-3 rounded-lg <?php echo e(!empty($meta_title) ? 'bg-green-50' : 'bg-red-50'); ?>">
                                <i data-lucide="<?php echo e(!empty($meta_title) ? 'check-circle' : 'x-circle'); ?>" class="w-5 h-5 <?php echo e(!empty($meta_title) ? 'text-green-600' : 'text-red-500'); ?>"></i>
                                <span class="text-sm font-medium <?php echo e(!empty($meta_title) ? 'text-green-800' : 'text-red-700'); ?>">Título SEO</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg <?php echo e(!empty($meta_description) ? 'bg-green-50' : 'bg-red-50'); ?>">
                                <i data-lucide="<?php echo e(!empty($meta_description) ? 'check-circle' : 'x-circle'); ?>" class="w-5 h-5 <?php echo e(!empty($meta_description) ? 'text-green-600' : 'text-red-500'); ?>"></i>
                                <span class="text-sm font-medium <?php echo e(!empty($meta_description) ? 'text-green-800' : 'text-red-700'); ?>">Meta Descrição</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg <?php echo e(!empty($meta_keywords) ? 'bg-green-50' : 'bg-yellow-50'); ?>">
                                <i data-lucide="<?php echo e(!empty($meta_keywords) ? 'check-circle' : 'alert-circle'); ?>" class="w-5 h-5 <?php echo e(!empty($meta_keywords) ? 'text-green-600' : 'text-yellow-500'); ?>"></i>
                                <span class="text-sm font-medium <?php echo e(!empty($meta_keywords) ? 'text-green-800' : 'text-yellow-700'); ?>">Palavras-chave</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg <?php echo e($currentOgImage ? 'bg-green-50' : 'bg-yellow-50'); ?>">
                                <i data-lucide="<?php echo e($currentOgImage ? 'check-circle' : 'alert-circle'); ?>" class="w-5 h-5 <?php echo e($currentOgImage ? 'text-green-600' : 'text-yellow-500'); ?>"></i>
                                <span class="text-sm font-medium <?php echo e($currentOgImage ? 'text-green-800' : 'text-yellow-700'); ?>">Imagem OG</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg <?php echo e(!empty($google_analytics) ? 'bg-green-50' : 'bg-gray-50'); ?>">
                                <i data-lucide="<?php echo e(!empty($google_analytics) ? 'check-circle' : 'minus-circle'); ?>" class="w-5 h-5 <?php echo e(!empty($google_analytics) ? 'text-green-600' : 'text-gray-400'); ?>"></i>
                                <span class="text-sm font-medium <?php echo e(!empty($google_analytics) ? 'text-green-800' : 'text-gray-500'); ?>">Google Analytics</span>
                            </div>
                            <div class="flex items-center gap-3 p-3 rounded-lg <?php echo e(!empty($facebook_pixel) ? 'bg-green-50' : 'bg-gray-50'); ?>">
                                <i data-lucide="<?php echo e(!empty($facebook_pixel) ? 'check-circle' : 'minus-circle'); ?>" class="w-5 h-5 <?php echo e(!empty($facebook_pixel) ? 'text-green-600' : 'text-gray-400'); ?>"></i>
                                <span class="text-sm font-medium <?php echo e(!empty($facebook_pixel) ? 'text-green-800' : 'text-gray-500'); ?>">Facebook Pixel</span>
                            </div>
                        </div>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            
            <!-- Social Media Settings -->
            <!--[if BLOCK]><![endif]--><?php if($activeTab === 'social'): ?>
                <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Links das Redes Sociais','icon' => 'share-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Links das Redes Sociais','icon' => 'share-2']); ?>
                    <form wire:submit="saveSocial" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'facebook_url','label' => 'Facebook','icon' => 'facebook','placeholder' => 'https://facebook.com/superloja']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'facebook_url','label' => 'Facebook','icon' => 'facebook','placeholder' => 'https://facebook.com/superloja']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'instagram_url','label' => 'Instagram','icon' => 'instagram','placeholder' => 'https://instagram.com/superloja']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'instagram_url','label' => 'Instagram','icon' => 'instagram','placeholder' => 'https://instagram.com/superloja']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'twitter_url','label' => 'Twitter / X','icon' => 'twitter','placeholder' => 'https://twitter.com/superloja']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'twitter_url','label' => 'Twitter / X','icon' => 'twitter','placeholder' => 'https://twitter.com/superloja']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'youtube_url','label' => 'YouTube','icon' => 'youtube','placeholder' => 'https://youtube.com/@superloja']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'youtube_url','label' => 'YouTube','icon' => 'youtube','placeholder' => 'https://youtube.com/@superloja']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'linkedin_url','label' => 'LinkedIn','icon' => 'linkedin','placeholder' => 'https://linkedin.com/company/superloja']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'linkedin_url','label' => 'LinkedIn','icon' => 'linkedin','placeholder' => 'https://linkedin.com/company/superloja']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'tiktok_url','label' => 'TikTok','icon' => 'video','placeholder' => 'https://tiktok.com/@superloja']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'tiktok_url','label' => 'TikTok','icon' => 'video','placeholder' => 'https://tiktok.com/@superloja']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                        </div>
                        
                        <div class="flex justify-end pt-4 border-t border-gray-200">
                            <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['type' => 'submit','icon' => 'save']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','icon' => 'save']); ?>
                                Salvar Alterações
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $attributes = $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $component = $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
                        </div>
                    </form>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            
            <!-- Store Settings -->
            <!--[if BLOCK]><![endif]--><?php if($activeTab === 'store'): ?>
                <div class="space-y-6">
                    <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Moeda e Formatação','icon' => 'dollar-sign']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Moeda e Formatação','icon' => 'dollar-sign']); ?>
                        <form wire:submit="saveStore" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'currency','label' => 'Símbolo da Moeda','icon' => 'dollar-sign','placeholder' => 'Kz']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'currency','label' => 'Símbolo da Moeda','icon' => 'dollar-sign','placeholder' => 'Kz']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                                
                                <?php if (isset($component)) { $__componentOriginal8ef619d218616cae7277f2a386a20785 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ef619d218616cae7277f2a386a20785 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.select','data' => ['wire:model' => 'currency_position','label' => 'Posição da Moeda']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'currency_position','label' => 'Posição da Moeda']); ?>
                                    <option value="before">Antes (Kz 100)</option>
                                    <option value="after">Depois (100 Kz)</option>
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $attributes = $__attributesOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__attributesOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $component = $__componentOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__componentOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
                                
                                <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'low_stock_threshold','type' => 'number','label' => 'Limite Estoque Baixo','icon' => 'alert-triangle','hint' => 'Alerta quando estoque ficar abaixo']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'low_stock_threshold','type' => 'number','label' => 'Limite Estoque Baixo','icon' => 'alert-triangle','hint' => 'Alerta quando estoque ficar abaixo']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
                                    <i data-lucide="toggle-left" class="w-4 h-4"></i>
                                    Funcionalidades da Loja
                                </h4>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <?php if (isset($component)) { $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.toggle','data' => ['wire:model' => 'enable_reviews','label' => 'Avaliações de Produtos','hint' => 'Permitir que clientes avaliem produtos']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'enable_reviews','label' => 'Avaliações de Produtos','hint' => 'Permitir que clientes avaliem produtos']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $attributes = $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $component = $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
                                    
                                    <?php if (isset($component)) { $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.toggle','data' => ['wire:model' => 'enable_wishlist','label' => 'Lista de Desejos','hint' => 'Permitir salvar produtos favoritos']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'enable_wishlist','label' => 'Lista de Desejos','hint' => 'Permitir salvar produtos favoritos']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $attributes = $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $component = $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
                                    
                                    <?php if (isset($component)) { $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.toggle','data' => ['wire:model' => 'enable_compare','label' => 'Comparar Produtos','hint' => 'Permitir comparação entre produtos']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'enable_compare','label' => 'Comparar Produtos','hint' => 'Permitir comparação entre produtos']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $attributes = $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $component = $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
                                    
                                    <?php if (isset($component)) { $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.toggle','data' => ['wire:model' => 'enable_quick_view','label' => 'Visualização Rápida','hint' => 'Modal de preview rápido do produto']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'enable_quick_view','label' => 'Visualização Rápida','hint' => 'Modal de preview rápido do produto']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $attributes = $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $component = $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="flex justify-end pt-4 border-t border-gray-200">
                                <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['type' => 'submit','icon' => 'save']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','icon' => 'save']); ?>
                                    Salvar Alterações
                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $attributes = $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $component = $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
                            </div>
                        </form>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
                </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            
            <!-- SMS Settings -->
            <!--[if BLOCK]><![endif]--><?php if($activeTab === 'sms'): ?>
                <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Configurações de SMS','icon' => 'message-square']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Configurações de SMS','icon' => 'message-square']); ?>
                    <form wire:submit="saveSms" class="space-y-6">
                        <div class="p-4 bg-green-50 border border-green-200 rounded-xl">
                            <p class="text-sm text-green-800">
                                <strong>📱 SMS Marketing:</strong> Configure a integração com o provedor Unimtx para enviar SMS aos clientes.
                            </p>
                        </div>
                        
                        <?php if (isset($component)) { $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.toggle','data' => ['wire:model' => 'sms_enabled','label' => 'Habilitar Envio de SMS','hint' => 'Ativar/desativar o envio de SMS']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'sms_enabled','label' => 'Habilitar Envio de SMS','hint' => 'Ativar/desativar o envio de SMS']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $attributes = $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $component = $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php if (isset($component)) { $__componentOriginal8ef619d218616cae7277f2a386a20785 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ef619d218616cae7277f2a386a20785 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.select','data' => ['wire:model' => 'sms_provider','label' => 'Provedor SMS','icon' => 'server']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'sms_provider','label' => 'Provedor SMS','icon' => 'server']); ?>
                                <option value="unimtx">Unimtx</option>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $attributes = $__attributesOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__attributesOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $component = $__componentOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__componentOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'sms_sender_name','label' => 'Nome do Remetente','icon' => 'user','placeholder' => 'SUPERLOJA','hint' => 'Nome que aparece no SMS (máx. 11 caracteres)']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'sms_sender_name','label' => 'Nome do Remetente','icon' => 'user','placeholder' => 'SUPERLOJA','hint' => 'Nome que aparece no SMS (máx. 11 caracteres)']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                        </div>
                        
                        <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'sms_access_key','label' => 'Access Key (API Key)','type' => 'password','icon' => 'key','placeholder' => 'Cole sua chave de API da Unimtx']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'sms_access_key','label' => 'Access Key (API Key)','type' => 'password','icon' => 'key','placeholder' => 'Cole sua chave de API da Unimtx']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                        
                        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl">
                            <p class="text-xs text-yellow-800">
                                <strong>⚠️ Importante:</strong> A Access Key é confidencial. Não compartilhe com terceiros.
                            </p>
                        </div>
                        
                        <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                            <a href="<?php echo e(route('admin.sms.index')); ?>" wire:navigate class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                                Ir para Templates SMS →
                            </a>
                            <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['type' => 'submit','icon' => 'save']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','icon' => 'save']); ?>
                                Salvar Alterações
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $attributes = $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $component = $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
                        </div>
                    </form>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            
            <!-- Email Settings -->
            <!--[if BLOCK]><![endif]--><?php if($activeTab === 'email'): ?>
                <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Configurações de Email (SMTP)','icon' => 'mail']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Configurações de Email (SMTP)','icon' => 'mail']); ?>
                    <form wire:submit="saveEmail" class="space-y-6">
                        <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
                            <p class="text-sm text-blue-800">
                                <strong>📧 Email Transacional:</strong> Configure o servidor SMTP para enviar emails de pedidos, confirmações, etc.
                            </p>
                        </div>
                        
                        <?php if (isset($component)) { $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.toggle','data' => ['wire:model' => 'email_enabled','label' => 'Habilitar Envio de Emails','hint' => 'Ativar/desativar o envio de emails']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.toggle'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'email_enabled','label' => 'Habilitar Envio de Emails','hint' => 'Ativar/desativar o envio de emails']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $attributes = $__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__attributesOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5)): ?>
<?php $component = $__componentOriginal277f8fea12f1dde0a332194a1c74c4b5; ?>
<?php unset($__componentOriginal277f8fea12f1dde0a332194a1c74c4b5); ?>
<?php endif; ?>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'smtp_host','label' => 'Servidor SMTP','icon' => 'server','placeholder' => 'smtp.gmail.com']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'smtp_host','label' => 'Servidor SMTP','icon' => 'server','placeholder' => 'smtp.gmail.com']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'smtp_port','label' => 'Porta','type' => 'number','icon' => 'hash','placeholder' => '587']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'smtp_port','label' => 'Porta','type' => 'number','icon' => 'hash','placeholder' => '587']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'smtp_username','label' => 'Usuário / Email','icon' => 'user','placeholder' => 'contato@superloja.vip']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'smtp_username','label' => 'Usuário / Email','icon' => 'user','placeholder' => 'contato@superloja.vip']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'smtp_password','label' => 'Senha','type' => 'password','icon' => 'lock','placeholder' => '••••••••']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'smtp_password','label' => 'Senha','type' => 'password','icon' => 'lock','placeholder' => '••••••••']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $attributes = $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__attributesOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853)): ?>
<?php $component = $__componentOriginal375f0ed4f8ee156e823aad8b1382f853; ?>
<?php unset($__componentOriginal375f0ed4f8ee156e823aad8b1382f853); ?>
<?php endif; ?>
                            
                            <?php if (isset($component)) { $__componentOriginal8ef619d218616cae7277f2a386a20785 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8ef619d218616cae7277f2a386a20785 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.select','data' => ['wire:model' => 'smtp_encryption','label' => 'Criptografia','icon' => 'shield']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'smtp_encryption','label' => 'Criptografia','icon' => 'shield']); ?>
                                <option value="tls">TLS (Recomendado)</option>
                                <option value="ssl">SSL</option>
                                <option value="">Nenhuma</option>
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $attributes = $__attributesOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__attributesOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8ef619d218616cae7277f2a386a20785)): ?>
<?php $component = $__componentOriginal8ef619d218616cae7277f2a386a20785; ?>
<?php unset($__componentOriginal8ef619d218616cae7277f2a386a20785); ?>
<?php endif; ?>
                        </div>
                        
                        <div class="p-4 bg-green-50 border border-green-200 rounded-xl">
                            <p class="text-xs text-green-800">
                                <strong>💡 Dica:</strong> Para Gmail, use smtp.gmail.com:587 com TLS e crie uma "Senha de App" nas configurações do Google.
                            </p>
                        </div>
                        
                        <div class="flex justify-end pt-4 border-t border-gray-200">
                            <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['type' => 'submit','icon' => 'save']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','icon' => 'save']); ?>
                                Salvar Alterações
                             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $attributes = $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d)): ?>
<?php $component = $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d; ?>
<?php unset($__componentOriginalf3d997ffd4903bcfaa336337e0372e3d); ?>
<?php endif; ?>
                        </div>
                    </form>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $attributes = $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0)): ?>
<?php $component = $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0; ?>
<?php unset($__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0); ?>
<?php endif; ?>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\superloja\resources\views/livewire/admin/settings/index-spa.blade.php ENDPATH**/ ?>
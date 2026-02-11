<div>
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Atualização do Sistema</h1>
            <p class="text-gray-500">Gerencie atualizações, backups e manutenção via GitHub</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1.5 bg-gray-100 rounded-lg text-sm font-mono font-bold text-gray-700"><?php echo e($currentVersion); ?></span>
            <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['href' => ''.e(route('admin.dashboard')).'','variant' => 'outline','icon' => 'arrow-left']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('admin.dashboard')).'','variant' => 'outline','icon' => 'arrow-left']); ?>
                Voltar
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
    </div>

    <!-- Tabs -->
    <div class="flex gap-1 mb-6 bg-gray-100 p-1 rounded-xl w-fit">
        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = ['update' => 'Atualização', 'backups' => 'Backups', 'maintenance' => 'Manutenção', 'history' => 'Histórico']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button wire:click="setTab('<?php echo e($tab); ?>')"
                    class="px-4 py-2 text-sm font-medium rounded-lg transition-all <?php echo e($activeTab === $tab ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-500 hover:text-gray-700'); ?>">
                <?php echo e($label); ?>

            </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">

            
            <!--[if BLOCK]><![endif]--><?php if($activeTab === 'update'): ?>

                <!-- GitHub Config -->
                <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Repositório GitHub','icon' => 'github']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Repositório GitHub','icon' => 'github']); ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <?php if (isset($component)) { $__componentOriginal375f0ed4f8ee156e823aad8b1382f853 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal375f0ed4f8ee156e823aad8b1382f853 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'githubRepo','label' => 'Repositório','placeholder' => 'usuario/repositorio','hint' => 'Ex: tiofox77/superloja']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'githubRepo','label' => 'Repositório','placeholder' => 'usuario/repositorio','hint' => 'Ex: tiofox77/superloja']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.form.input','data' => ['wire:model' => 'githubBranch','label' => 'Branch','placeholder' => 'main']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.form.input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model' => 'githubBranch','label' => 'Branch','placeholder' => 'main']); ?>
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
                    <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['wire:click' => 'saveConfig','variant' => 'primary','icon' => 'save','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'saveConfig','variant' => 'primary','icon' => 'save','size' => 'sm']); ?>
                        Salvar Configuração
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

                <!-- Prerequisites -->
                <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Pré-requisitos','icon' => 'shield-check']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Pré-requisitos','icon' => 'shield-check']); ?>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $prerequisites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex items-center gap-2 p-3 rounded-lg <?php echo e($req['status'] ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'); ?>">
                                <!--[if BLOCK]><![endif]--><?php if($req['status']): ?>
                                    <i data-lucide="check-circle-2" class="w-4 h-4 text-green-600"></i>
                                <?php else: ?>
                                    <i data-lucide="x-circle" class="w-4 h-4 text-red-600"></i>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <div>
                                    <p class="text-xs font-semibold <?php echo e($req['status'] ? 'text-green-800' : 'text-red-800'); ?>"><?php echo e($req['name']); ?></p>
                                    <p class="text-[10px] <?php echo e($req['status'] ? 'text-green-600' : 'text-red-600'); ?>"><?php echo e($req['message']); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
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

                <!-- Version Status -->
                <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Status da Atualização','icon' => 'refresh-cw']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Status da Atualização','icon' => 'refresh-cw']); ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl mb-4">
                        <div>
                            <p class="text-xs text-gray-500">Versão Atual</p>
                            <p class="text-xl font-bold font-mono text-gray-900"><?php echo e($currentVersion); ?></p>
                        </div>
                        <!--[if BLOCK]><![endif]--><?php if($latestVersion): ?>
                            <div class="text-center">
                                <i data-lucide="arrow-right" class="w-5 h-5 text-gray-400 mx-auto"></i>
                            </div>
                            <div class="text-right">
                                <p class="text-xs text-gray-500">Última Versão</p>
                                <p class="text-xl font-bold font-mono <?php echo e($hasUpdate ? 'text-green-600' : 'text-gray-900'); ?>"><?php echo e($latestVersion); ?></p>
                            </div>
                        <?php else: ?>
                            <div class="text-right">
                                <p class="text-sm text-gray-400">Clique em verificar</p>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>

                    <!--[if BLOCK]><![endif]--><?php if($hasUpdate && $updateInfo): ?>
                        <div class="p-4 bg-green-50 border border-green-200 rounded-xl mb-4">
                            <div class="flex items-start justify-between">
                                <div>
                                    <p class="font-semibold text-green-800"><?php echo e($updateInfo['name']); ?></p>
                                    <!--[if BLOCK]><![endif]--><?php if(!empty($updateInfo['published_at'])): ?>
                                        <p class="text-xs text-green-600 mt-1">Publicado em <?php echo e(\Carbon\Carbon::parse($updateInfo['published_at'])->format('d/m/Y H:i')); ?></p>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                </div>
                                <!--[if BLOCK]><![endif]--><?php if(!empty($updateInfo['html_url'])): ?>
                                    <a href="<?php echo e($updateInfo['html_url']); ?>" target="_blank" class="text-green-600 hover:text-green-800">
                                        <i data-lucide="external-link" class="w-4 h-4"></i>
                                    </a>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                            <!--[if BLOCK]><![endif]--><?php if(!empty($updateInfo['body'])): ?>
                                <button wire:click="toggleChangelog" class="mt-2 text-xs text-blue-600 hover:text-blue-800 font-semibold flex items-center gap-1">
                                    <i data-lucide="<?php echo e($showChangelog ? 'chevron-down' : 'chevron-right'); ?>" class="w-3 h-3"></i>
                                    Changelog
                                </button>
                                <!--[if BLOCK]><![endif]--><?php if($showChangelog): ?>
                                    <div class="mt-2 p-3 bg-white rounded-lg border border-green-300 text-xs text-gray-700 max-h-48 overflow-y-auto whitespace-pre-line"><?php echo e($updateInfo['body']); ?></div>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                    <!-- Action Buttons -->
                    <!--[if BLOCK]><![endif]--><?php if(!$isUpdating): ?>
                        <div class="flex flex-wrap gap-3">
                            <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['wire:click' => 'checkForUpdates','variant' => 'outline','icon' => 'search','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'checkForUpdates','variant' => 'outline','icon' => 'search','size' => 'sm']); ?>
                                Verificar Atualizações
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

                            <!--[if BLOCK]><![endif]--><?php if($hasUpdate && $canUpdate): ?>
                                <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['wire:click' => 'startUpdate','wire:confirm' => 'Iniciar atualização do sistema? Um backup será criado automaticamente.','variant' => 'primary','icon' => 'download','size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'startUpdate','wire:confirm' => 'Iniciar atualização do sistema? Um backup será criado automaticamente.','variant' => 'primary','icon' => 'download','size' => 'sm']); ?>
                                    Iniciar Atualização
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
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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

                <!-- Progress Bar (during update) -->
                <!--[if BLOCK]><![endif]--><?php if($isUpdating || $updateComplete || $hasError): ?>
                    <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Progresso','icon' => 'loader']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Progresso','icon' => 'loader']); ?>
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-sm font-medium text-gray-700"><?php echo e($currentStep ? ($steps[$currentStep] ?? $currentStep) : 'Preparando...'); ?></span>
                                <span class="text-sm font-bold <?php echo e($hasError ? 'text-red-600' : ($updateComplete ? 'text-green-600' : 'text-blue-600')); ?>"><?php echo e($progress); ?>%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">
                                <div class="h-3 rounded-full transition-all duration-700 <?php echo e($hasError ? 'bg-red-500' : ($updateComplete ? 'bg-green-500' : 'bg-gradient-to-r from-blue-500 to-purple-600')); ?>"
                                     style="width: <?php echo e($progress); ?>%"></div>
                            </div>
                        </div>

                        <!--[if BLOCK]><![endif]--><?php if($updateComplete): ?>
                            <div class="p-4 bg-green-50 border border-green-200 rounded-xl text-center">
                                <i data-lucide="check-circle-2" class="w-10 h-10 text-green-500 mx-auto mb-2"></i>
                                <h3 class="text-lg font-bold text-green-800">Atualização Concluída!</h3>
                                <p class="text-sm text-green-600 mt-1">Versão atual: <?php echo e($currentVersion); ?></p>
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                        <!--[if BLOCK]><![endif]--><?php if($hasError): ?>
                            <div class="p-4 bg-red-50 border border-red-200 rounded-xl">
                                <div class="flex items-center gap-2 mb-2">
                                    <i data-lucide="alert-triangle" class="w-5 h-5 text-red-500"></i>
                                    <h3 class="font-bold text-red-800">Atualização Falhou</h3>
                                </div>
                                <p class="text-sm text-red-600 mb-3">Verifique os logs abaixo. Você pode restaurar um backup ou reverter o código.</p>
                                <div class="flex gap-2">
                                    <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['wire:click' => 'rollbackCode','wire:confirm' => 'Reverter código para versão anterior (git reset --hard HEAD~1)?','variant' => 'outline','size' => 'sm','icon' => 'undo-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'rollbackCode','wire:confirm' => 'Reverter código para versão anterior (git reset --hard HEAD~1)?','variant' => 'outline','size' => 'sm','icon' => 'undo-2']); ?>
                                        Rollback Código
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
                            </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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

            
            <?php elseif($activeTab === 'backups'): ?>

                <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Backups (BD + Ficheiros)','icon' => 'archive']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Backups (BD + Ficheiros)','icon' => 'archive']); ?>
                    <div class="flex justify-between items-center mb-4">
                        <p class="text-sm text-gray-500">Backup completo inclui banco de dados e ficheiros do projeto. Máximo: 5 mantidos.</p>
                        <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['wire:click' => 'createManualBackup','variant' => 'primary','icon' => 'plus','size' => 'sm','wire:loading.attr' => 'disabled','wire:target' => 'createManualBackup']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'createManualBackup','variant' => 'primary','icon' => 'plus','size' => 'sm','wire:loading.attr' => 'disabled','wire:target' => 'createManualBackup']); ?>
                            <span wire:loading.remove wire:target="createManualBackup">Criar Backup</span>
                            <span wire:loading wire:target="createManualBackup">A criar...</span>
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

                    <!--[if BLOCK]><![endif]--><?php if(count($backups) > 0): ?>
                        <div class="space-y-3">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $backups; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $backup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl border border-gray-200">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg <?php echo e(($backup['type'] ?? 'bd') === 'completo' ? 'bg-purple-100' : 'bg-blue-100'); ?> flex items-center justify-center">
                                            <i data-lucide="<?php echo e(($backup['type'] ?? 'bd') === 'completo' ? 'archive' : 'database'); ?>" class="w-5 h-5 <?php echo e(($backup['type'] ?? 'bd') === 'completo' ? 'text-purple-600' : 'text-blue-600'); ?>"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-2">
                                                <p class="text-sm font-medium text-gray-900"><?php echo e($backup['filename']); ?></p>
                                                <!--[if BLOCK]><![endif]--><?php if(($backup['type'] ?? 'bd') === 'completo'): ?>
                                                    <span class="px-1.5 py-0.5 text-[10px] font-semibold bg-purple-100 text-purple-700 rounded">BD + Ficheiros</span>
                                                <?php else: ?>
                                                    <span class="px-1.5 py-0.5 text-[10px] font-semibold bg-blue-100 text-blue-700 rounded">Só BD</span>
                                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                            </div>
                                            <p class="text-xs text-gray-500"><?php echo e($backup['date']); ?> &middot; <?php echo e($backup['size']); ?></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button wire:click="restoreBackup('<?php echo e($backup['filename']); ?>')"
                                                wire:confirm="Restaurar este backup? O banco atual será sobrescrito!"
                                                class="px-3 py-1.5 text-xs font-medium text-orange-700 bg-orange-100 rounded-lg hover:bg-orange-200 transition-colors">
                                            Restaurar
                                        </button>
                                        <button wire:click="deleteBackup('<?php echo e($backup['filename']); ?>')"
                                                wire:confirm="Excluir este backup?"
                                                class="px-3 py-1.5 text-xs font-medium text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors">
                                            Excluir
                                        </button>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8 text-gray-400">
                            <i data-lucide="archive" class="w-12 h-12 mx-auto mb-3 opacity-40"></i>
                            <p class="text-sm">Nenhum backup encontrado</p>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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

                <!-- Rollback -->
                <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Rollback de Código','icon' => 'undo-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Rollback de Código','icon' => 'undo-2']); ?>
                    <p class="text-sm text-gray-500 mb-4">Reverter o código para o commit anterior via <code class="bg-gray-100 px-1.5 py-0.5 rounded text-xs">git reset --hard HEAD~1</code>.</p>
                    <?php if (isset($component)) { $__componentOriginalf3d997ffd4903bcfaa336337e0372e3d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf3d997ffd4903bcfaa336337e0372e3d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.button','data' => ['wire:click' => 'rollbackCode','wire:confirm' => 'Reverter código para versão anterior? Todas as alterações do último pull serão desfeitas!','variant' => 'outline','size' => 'sm','icon' => 'undo-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'rollbackCode','wire:confirm' => 'Reverter código para versão anterior? Todas as alterações do último pull serão desfeitas!','variant' => 'outline','size' => 'sm','icon' => 'undo-2']); ?>
                        Rollback para Commit Anterior
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

            
            <?php elseif($activeTab === 'maintenance'): ?>

                <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Ferramentas de Manutenção','icon' => 'wrench']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Ferramentas de Manutenção','icon' => 'wrench']); ?>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <button wire:click="clearAllCaches"
                                wire:loading.attr="disabled"
                                wire:target="clearAllCaches, optimizeSystem, runMigrations"
                                class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors text-left group border border-gray-200 disabled:opacity-50 disabled:cursor-wait">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i wire:loading.remove wire:target="clearAllCaches" data-lucide="trash-2" class="w-5 h-5 text-blue-600"></i>
                                <svg wire:loading wire:target="clearAllCaches" class="w-5 h-5 text-blue-600 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 text-sm">Limpar Caches</h4>
                            <p class="text-xs text-gray-500 mt-1">Config, views, rotas, app</p>
                            <span wire:loading wire:target="clearAllCaches" class="text-xs text-blue-600 font-medium mt-2 block">A executar...</span>
                        </button>

                        <button wire:click="optimizeSystem"
                                wire:loading.attr="disabled"
                                wire:target="clearAllCaches, optimizeSystem, runMigrations"
                                class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors text-left group border border-gray-200 disabled:opacity-50 disabled:cursor-wait">
                            <div class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i wire:loading.remove wire:target="optimizeSystem" data-lucide="zap" class="w-5 h-5 text-green-600"></i>
                                <svg wire:loading wire:target="optimizeSystem" class="w-5 h-5 text-green-600 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 text-sm">Otimizar</h4>
                            <p class="text-xs text-gray-500 mt-1">Cache de config e rotas</p>
                            <span wire:loading wire:target="optimizeSystem" class="text-xs text-green-600 font-medium mt-2 block">A executar...</span>
                        </button>

                        <button wire:click="runMigrations" wire:confirm="Executar todas as migrations pendentes?"
                                wire:loading.attr="disabled"
                                wire:target="clearAllCaches, optimizeSystem, runMigrations"
                                class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors text-left group border border-gray-200 disabled:opacity-50 disabled:cursor-wait">
                            <div class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform">
                                <i wire:loading.remove wire:target="runMigrations" data-lucide="database" class="w-5 h-5 text-purple-600"></i>
                                <svg wire:loading wire:target="runMigrations" class="w-5 h-5 text-purple-600 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                            <h4 class="font-semibold text-gray-900 text-sm">Migrations</h4>
                            <p class="text-xs text-gray-500 mt-1">Atualizar banco de dados</p>
                            <span wire:loading wire:target="runMigrations" class="text-xs text-purple-600 font-medium mt-2 block">A executar...</span>
                        </button>
                    </div>

                    
                    <!--[if BLOCK]><![endif]--><?php if(count($logs) > 0): ?>
                        <div class="mt-6 bg-gray-900 rounded-xl p-4 font-mono text-xs space-y-1 max-h-60 overflow-y-auto">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex gap-3 p-1.5 rounded hover:bg-gray-800 transition-colors">
                                    <span class="text-gray-500 whitespace-nowrap"><?php echo e($log['time']); ?></span>
                                    <!--[if BLOCK]><![endif]--><?php if($log['type'] === 'success'): ?>
                                        <span class="text-green-400 flex-shrink-0">&#10003;</span>
                                    <?php elseif($log['type'] === 'error'): ?>
                                        <span class="text-red-400 flex-shrink-0">&#10007;</span>
                                    <?php elseif($log['type'] === 'warning'): ?>
                                        <span class="text-yellow-400 flex-shrink-0">&#9888;</span>
                                    <?php else: ?>
                                        <span class="text-blue-400 flex-shrink-0">&#8505;</span>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <span class="<?php echo e($log['type'] === 'success' ? 'text-green-400' : ($log['type'] === 'error' ? 'text-red-400' : ($log['type'] === 'warning' ? 'text-yellow-400' : 'text-blue-400'))); ?>">
                                        <?php echo e($log['message']); ?>

                                    </span>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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

            
            <?php elseif($activeTab === 'history'): ?>

                <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Histórico de Atualizações','icon' => 'clock']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Histórico de Atualizações','icon' => 'clock']); ?>
                    <!--[if BLOCK]><![endif]--><?php if(count($updateHistory) > 0): ?>
                        <div class="space-y-3">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = array_reverse($updateHistory); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $history): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center gap-3 p-4 rounded-xl <?php echo e($history['status'] === 'success' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'); ?>">
                                    <!--[if BLOCK]><![endif]--><?php if($history['status'] === 'success'): ?>
                                        <i data-lucide="check-circle-2" class="w-5 h-5 text-green-600 flex-shrink-0"></i>
                                    <?php else: ?>
                                        <i data-lucide="x-circle" class="w-5 h-5 text-red-600 flex-shrink-0"></i>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-800">Versão <?php echo e($history['version']); ?></p>
                                        <p class="text-xs text-gray-600">
                                            <?php echo e(\Carbon\Carbon::parse($history['timestamp'])->format('d/m/Y H:i')); ?>

                                            &middot; <?php echo e($history['user'] ?? 'Sistema'); ?>

                                            &middot; <span class="font-medium <?php echo e($history['status'] === 'success' ? 'text-green-600' : 'text-red-600'); ?>"><?php echo e($history['status'] === 'success' ? 'Sucesso' : 'Falhou'); ?></span>
                                        </p>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    <?php else: ?>
                        <div class="text-center py-8 text-gray-400">
                            <i data-lucide="clock" class="w-12 h-12 mx-auto mb-3 opacity-40"></i>
                            <p class="text-sm">Nenhuma atualização registrada</p>
                        </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
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

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Console (when there are logs) -->
            <!--[if BLOCK]><![endif]--><?php if(count($logs) > 0): ?>
                <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Console','icon' => 'terminal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Console','icon' => 'terminal']); ?>
                    <div id="logs-container" class="bg-gray-900 rounded-xl p-3 font-mono text-[11px] space-y-0.5 max-h-56 overflow-y-auto">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="flex gap-2 p-1 rounded hover:bg-gray-800 transition-colors">
                                <span class="text-gray-500 whitespace-nowrap"><?php echo e($log['time']); ?></span>
                                <!--[if BLOCK]><![endif]--><?php if($log['type'] === 'success'): ?>
                                    <span class="text-green-400 flex-shrink-0">&#10003;</span>
                                <?php elseif($log['type'] === 'error'): ?>
                                    <span class="text-red-400 flex-shrink-0">&#10007;</span>
                                <?php elseif($log['type'] === 'warning'): ?>
                                    <span class="text-yellow-400 flex-shrink-0">&#9888;</span>
                                <?php else: ?>
                                    <span class="text-blue-400 flex-shrink-0">&#8505;</span>
                                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                <span class="break-all <?php echo e($log['type'] === 'success' ? 'text-green-400' : ($log['type'] === 'error' ? 'text-red-400' : ($log['type'] === 'warning' ? 'text-yellow-400' : 'text-blue-400'))); ?>">
                                    <?php echo e($log['message']); ?>

                                </span>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
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
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <!-- System Info -->
            <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Sistema','icon' => 'server']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Sistema','icon' => 'server']); ?>
                <div class="space-y-2">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $systemInfo; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex justify-between py-2 border-b border-gray-100 last:border-0">
                            <span class="text-xs text-gray-500"><?php echo e($key); ?></span>
                            <span class="text-xs font-medium text-gray-900 font-mono"><?php echo e($value); ?></span>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
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

            <!-- Quick Stats -->
            <?php if (isset($component)) { $__componentOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalfdb23fa6017278bcd751b09e9d04fdc0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.ui.card','data' => ['title' => 'Resumo','icon' => 'bar-chart-3']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.ui.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Resumo','icon' => 'bar-chart-3']); ?>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Backups</span>
                        <span class="text-sm font-bold text-gray-900"><?php echo e(count($backups)); ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Atualizações</span>
                        <span class="text-sm font-bold text-gray-900"><?php echo e(count($updateHistory)); ?></span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Status</span>
                        <!--[if BLOCK]><![endif]--><?php if($hasUpdate): ?>
                            <span class="text-xs font-medium text-orange-600 bg-orange-100 px-2 py-0.5 rounded-full">Update Disponível</span>
                        <?php else: ?>
                            <span class="text-xs font-medium text-green-600 bg-green-100 px-2 py-0.5 rounded-full">Atualizado</span>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-500">Branch</span>
                        <span class="text-xs font-mono font-medium text-gray-900 bg-gray-100 px-2 py-0.5 rounded"><?php echo e($githubBranch); ?></span>
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
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    // Auto-scroll logs container on Livewire updates
    document.addEventListener('livewire:init', () => {
        Livewire.hook('morph.updated', () => {
            const el = document.getElementById('logs-container');
            if (el) {
                setTimeout(() => { el.scrollTop = el.scrollHeight; }, 50);
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\laragon\www\superloja\resources\views/livewire/admin/system/updater-spa.blade.php ENDPATH**/ ?>
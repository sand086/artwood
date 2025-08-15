<?php $__env->startSection('title', 'Proveedores'); ?>

<?php $__env->startSection('content'); ?>
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="Proveedores">
        
        <h1 class="text-3xl font-semibold mb-6">Proveedores</h1>

        <!-- Tabla  -->
        <div class="overflow-x-auto">
            <div class="p-1.5">
                <table id="proveedoresTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="art-bg-primary art-text-background">
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        
                    </tbody>
                </table>
            </div>
        </div>
        
        <?php if (isset($component)) { $__componentOriginale6a555649da86b3de44465cdfe004aa4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale6a555649da86b3de44465cdfe004aa4 = $attributes; } ?>
<?php $component = App\View\Components\Modal::resolve(['id' => 'proveedoresModal','formId' => 'proveedoresForm','showCancelButton' => false,'showSaveButton' => false,'showClearButton' => false,'size' => 'lg'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['data-current-id' => ''.e($proveedor->proveedor_id ?? '').'']); ?>
            
             <?php $__env->slot('header', null, []); ?> 
                <h5 class="text-lg font-semibold">Formulario Proveedores</h5>
             <?php $__env->endSlot(); ?>
            
             <?php $__env->slot('body', null, []); ?> 
                <div x-data="{ tab: 'basicos', isEditing: false }" 
                @update-alpine-tabs.window="
                        if ($event.target.id === 'proveedoresModal') { // Asegura que el evento viene del modal correcto
                            console.log('Alpine received update-alpine-tabs:', $event.detail);
                            isEditing = $event.detail.isEditing;
                            tab = $event.detail.tab;
                        }
                     "
                >
                    
                    <nav class="flex mb-2 border-b border-gray-200">
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="tab === 'basicos' ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-600'"
                            @click="tab = 'basicos'">
                            Info Básica
                        </button>
                        
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'contactos' && isEditing,
                                'text-gray-600': tab !== 'contactos' || !isEditing, // Gris si no está activa o si no se está editando
                                'opacity-50 cursor-not-allowed': !isEditing       // Estilo deshabilitado si no se está editando
                            }"
                            @click="if (isEditing) tab = 'contactos'" 
                            :disabled="!isEditing">
                            Contactos
                        </button>
                        
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'servicios' && isEditing,
                                'text-gray-600': tab !== 'servicios' || !isEditing,
                                'opacity-50 cursor-not-allowed': !isEditing
                            }"
                            @click="if (isEditing) tab = 'servicios'"
                            :disabled="!isEditing">
                            Servicios
                        </button>
                        
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'productos' && isEditing,
                                'text-gray-600': tab !== 'productos' || !isEditing,
                                'opacity-50 cursor-not-allowed': !isEditing
                            }"
                            @click="if (isEditing) tab = 'productos'"
                            :disabled="!isEditing">
                            Productos
                        </button>
                        
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'materiales' && isEditing,
                                'text-gray-600': tab !== 'materiales' || !isEditing,
                                'opacity-50 cursor-not-allowed': !isEditing
                            }"
                            @click="if (isEditing) tab = 'materiales'"
                            :disabled="!isEditing">
                            Materiales
                        </button>
                        
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'equipos' && isEditing,
                                'text-gray-600': tab !== 'equipos' || !isEditing,
                                'opacity-50 cursor-not-allowed': !isEditing
                            }"
                            @click="if (isEditing) tab = 'equipos'"
                            :disabled="!isEditing">
                            Equipos
                        </button>
                    </nav>
                    <hr>
                    
                    <div>
                        <div>
                            
                            <div x-show="tab === 'basicos'" class="h-[700px] overflow-y-auto p-1">
                                <?php echo $__env->make('modules.Proveedores.basicos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>
        
                            
                            <div x-show="tab === 'contactos'" class="h-[700px] overflow-y-auto p-1">
                                <?php echo $__env->make('modules.Proveedores.contactos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>
        
                            
                            <div x-show="tab === 'servicios'" class="h-[700px] overflow-y-auto p-1">
                                <?php echo $__env->make('modules.Proveedores.servicios', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>

                            
                            <div x-show="tab === 'productos'" class="h-[700px] overflow-y-auto p-1">
                                <?php echo $__env->make('modules.Proveedores.productos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>
        
                            
                            <div x-show="tab === 'materiales'" class="h-[700px] overflow-y-auto p-1">
                                <?php echo $__env->make('modules.Proveedores.materiales', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>
        
                            
                            <div x-show="tab === 'equipos'" class="h-[700px] overflow-y-auto p-1">
                                <?php echo $__env->make('modules.Proveedores.equipos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>
                        </div>
                    </div>
                </div>
             <?php $__env->endSlot(); ?>
            
             <?php $__env->slot('footer', null, []); ?> 
             <?php $__env->endSlot(); ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale6a555649da86b3de44465cdfe004aa4)): ?>
<?php $attributes = $__attributesOriginale6a555649da86b3de44465cdfe004aa4; ?>
<?php unset($__attributesOriginale6a555649da86b3de44465cdfe004aa4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale6a555649da86b3de44465cdfe004aa4)): ?>
<?php $component = $__componentOriginale6a555649da86b3de44465cdfe004aa4; ?>
<?php unset($__componentOriginale6a555649da86b3de44465cdfe004aa4); ?>
<?php endif; ?>

        <?php if (isset($component)) { $__componentOriginal88b0e6813f5b80100a19437aa80e29ba = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal88b0e6813f5b80100a19437aa80e29ba = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.message','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('message'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal88b0e6813f5b80100a19437aa80e29ba)): ?>
<?php $attributes = $__attributesOriginal88b0e6813f5b80100a19437aa80e29ba; ?>
<?php unset($__attributesOriginal88b0e6813f5b80100a19437aa80e29ba); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal88b0e6813f5b80100a19437aa80e29ba)): ?>
<?php $component = $__componentOriginal88b0e6813f5b80100a19437aa80e29ba; ?>
<?php unset($__componentOriginal88b0e6813f5b80100a19437aa80e29ba); ?>
<?php endif; ?>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.appP', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/modules/Proveedores/index.blade.php ENDPATH**/ ?>
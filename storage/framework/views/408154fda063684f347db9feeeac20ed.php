<?php $__env->startSection('title', 'Solicitudes Cotizaciones'); ?>

<?php $__env->startSection('content'); ?>
    <div class="@container mx-auto px-4 py-8"  data-module="CotizacionesSolicitudes"> 
        <h1 class="text-3xl font-semibold mb-6">Solicitudes Cotizaciones</h1>

        <div class="overflow-x-auto"> 
            <table id="cotizacionessolicitudesTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    
                </tbody>
            </table>
        </div>

        
        <?php if (isset($component)) { $__componentOriginale6a555649da86b3de44465cdfe004aa4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale6a555649da86b3de44465cdfe004aa4 = $attributes; } ?>
<?php $component = App\View\Components\Modal::resolve(['id' => 'cotizacionessolicitudesModal','formId' => 'cotizacionessolicitudesForm','showCancelButton' => false,'showSaveButton' => false,'size' => 'lg','showClearButton' => false] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            
             <?php $__env->slot('header', null, []); ?> 
                <h5 class="text-lg font-semibold">Formulario Solicitudes Cotizaciones</h5>
             <?php $__env->endSlot(); ?>
            
             <?php $__env->slot('body', null, []); ?> 
                <div x-data="{ tab: 'solicitud', isEditing: false }" 
                @update-alpine-tabs.window="
                        if ($event.target.id === 'cotizacionessolicitudesModal') { // Asegura que el evento viene del modal correcto
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
                            :class="tab === 'solicitud' ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-600'"
                            @click="tab = 'solicitud'">
                            Solicitud
                        </button>
                        
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'responsables' && isEditing,
                                'text-gray-600': tab !== 'responsables' || !isEditing, // Gris si no está activa o si no se está editando
                                'opacity-50 cursor-not-allowed': !isEditing       // Estilo deshabilitado si no se está editando
                            }"
                            @click="if (isEditing) tab = 'responsables'" 
                            :disabled="!isEditing">
                            Responsables
                        </button>
                        
                        <button
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'documentos' && isEditing,
                                'text-gray-600': tab !== 'documentos' || !isEditing,
                                'opacity-50 cursor-not-allowed': !isEditing
                            }"
                            @click="if (isEditing) tab = 'documentos'"
                            :disabled="!isEditing">
                            Documentos
                        </button>
                    </nav>
                    <hr>
                    
                    <div>
                        <div>
                            
                            <div x-show="tab === 'solicitud'" class="h-[600px] overflow-y-auto p-1">
                                <?php echo $__env->make('modules.CotizacionesSolicitudes.solicitud', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>
        
                            
                            <div x-show="tab === 'responsables'" class="h-[600px] overflow-y-auto p-1">
                                <?php echo $__env->make('modules.CotizacionesSolicitudes.responsables', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                            </div>

                            
                            <div x-show="tab === 'documentos'" class="h-[600px] overflow-y-auto p-1">
                                <?php echo $__env->make('modules.CotizacionesSolicitudes.documentos', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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
    </div>
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.appP', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/modules/CotizacionesSolicitudes/index.blade.php ENDPATH**/ ?>
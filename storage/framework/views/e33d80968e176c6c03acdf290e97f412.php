<?php $__env->startSection('title', 'Productos'); ?>

<?php $__env->startSection('content'); ?>
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="Productos">
        <h1 class="text-3xl font-semibold mb-6">Productos</h1>

        <!-- Tabla  -->
        <div class="overflow-x-auto">
            <div class="p-1.5">
                <table id="productosTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="art-bg-primary art-text-background">
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        
                    </tbody>
                </table>
            </div>
        </div>

        
        <?php if (isset($component)) { $__componentOriginale6a555649da86b3de44465cdfe004aa4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale6a555649da86b3de44465cdfe004aa4 = $attributes; } ?>
<?php $component = App\View\Components\Modal::resolve(['id' => 'productosModal','formId' => 'productosForm'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            
             <?php $__env->slot('header', null, []); ?> 
                <h5 class="text-lg font-semibold">Formulario Productos</h5>
             <?php $__env->endSlot(); ?>
            
             <?php $__env->slot('body', null, []); ?> 
                <form id="productosForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-1 gap-1">

                        <div>
                            <label for="nombre" class="art-label-custom">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                        </div>

                        <div>
                            <label for="descripcion" class="art-label-custom">Descripcion</label>
                            <input type="text" id="descripcion" name="descripcion" class="art-input-custom" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-2 gap-1">
                            <div class="col-span-1 p-2 rounded-lg ">
                                <?php if (isset($component)) { $__componentOriginal4b64953296fad43ab18567788f55889a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b64953296fad43ab18567788f55889a = $attributes; } ?>
<?php $component = App\View\Components\FormSelect::resolve(['label' => 'Unidad Medida','name' => 'unidad_medida_id','id' => 'unidad_medida_id','table' => 'unidadesmedidas','valueField' => 'unidad_medida_id','labelField' => 'nombre','where' => ['estado' => 'A'],'orderBy' => ['nombre', 'asc'],'placeholder' => 'Seleccione una Unidad Medida'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\FormSelect::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4b64953296fad43ab18567788f55889a)): ?>
<?php $attributes = $__attributesOriginal4b64953296fad43ab18567788f55889a; ?>
<?php unset($__attributesOriginal4b64953296fad43ab18567788f55889a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4b64953296fad43ab18567788f55889a)): ?>
<?php $component = $__componentOriginal4b64953296fad43ab18567788f55889a; ?>
<?php unset($__componentOriginal4b64953296fad43ab18567788f55889a); ?>
<?php endif; ?>
                            </div>

                            <div class="col-span-1 p-2 rounded-lg ">
                                <label for="precio_unitario" class="art-label-custom">Costo Unitario</label>
                                <input type="number" id="precio_unitario" name="precio_unitario" min="0" step="0.01" class="art-input-custom text-right" required>
                            </div>
                        </div>

                    </div>
                    <?php if (isset($component)) { $__componentOriginal72d301163a8b8a01da479060e1875f4a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal72d301163a8b8a01da479060e1875f4a = $attributes; } ?>
<?php $component = App\View\Components\FormAuditoria::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-auditoria'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\FormAuditoria::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal72d301163a8b8a01da479060e1875f4a)): ?>
<?php $attributes = $__attributesOriginal72d301163a8b8a01da479060e1875f4a; ?>
<?php unset($__attributesOriginal72d301163a8b8a01da479060e1875f4a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal72d301163a8b8a01da479060e1875f4a)): ?>
<?php $component = $__componentOriginal72d301163a8b8a01da479060e1875f4a; ?>
<?php unset($__componentOriginal72d301163a8b8a01da479060e1875f4a); ?>
<?php endif; ?>
                </form>

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
<?php echo $__env->make('layouts.appP', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/modules/Productos/index.blade.php ENDPATH**/ ?>
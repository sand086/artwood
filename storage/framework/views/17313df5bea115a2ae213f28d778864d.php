<div id="tab-productos" data-module="ProveedoresProductos" 
    x-data="{ mostrarFormProducto: false }" 
    x-on:show-form-producto.window="mostrarFormProducto = true"
    x-on:hide-form-producto.window="mostrarFormProducto = false"
>

    <div x-show="mostrarFormProducto" x-transition class="mb-4">
        <form id="proveedoresproductosForm" method="POST">
            <?php echo csrf_field(); ?>
            <div class="grid grid-cols-1 gap-2">
                <div class="grid grid-cols-1 lg:grid-cols-6 gap-2">
                    <div class="col-span-3 p-1 rounded-lg ">
                        <?php if (isset($component)) { $__componentOriginal4b64953296fad43ab18567788f55889a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b64953296fad43ab18567788f55889a = $attributes; } ?>
<?php $component = App\View\Components\FormSelect::resolve(['label' => 'Producto','name' => 'producto_id','id' => 'producto_id','table' => 'productos','valueField' => 'producto_id','labelField' => 'nombre','where' => ['estado' => 'A'],'orderBy' => ['nombre', 'asc'],'placeholder' => 'Seleccione un Producto'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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

                    <div class="col-span-2 p-1 rounded-lg ">
                        <label for="boton-crear-producto" class="art-label-custom p-1">&nbsp;</label>
                        <a href="#" @click.prevent="abrirVentana('<?php echo e(route('productos.index')); ?>', '?openModal=true&windowClose=true')" class="art-btn-secondary ml-2">Crear Producto</a>
                    </div>

                    <div class="col-span-1 p-1 rounded-lg ">
                        <label for="stock" class="art-label-custom">Stock</label>
                        <input type="number" id="stock" name="stock" min="0" step="1" value="0" class="art-input-custom text-right" required>
                    </div>
                </div>
                
                <div>
                    <label for="descripcion" class="art-label-custom">Descripci&oacute;n</label>
                    <input type="text" id="descripcion" name="descripcion" class="art-input-custom" required>
                </div>
                
                <div>
                    <label for="detalle" class="art-label-custom">Detalle</label>
                    <input type="text" id="detalle" name="detalle" class="art-input-custom">
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
            </div>
        </form>

        <?php if (isset($component)) { $__componentOriginalbac5affb147c7bb0375e6eb7b7d76916 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbac5affb147c7bb0375e6eb7b7d76916 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.buttons','data' => ['formId' => 'proveedoresproductosForm','cancelEvent' => '
                mostrarFormProducto = false;
                
                
            ']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['formId' => 'proveedoresproductosForm','cancelEvent' => '
                mostrarFormProducto = false;
                
                
            ']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbac5affb147c7bb0375e6eb7b7d76916)): ?>
<?php $attributes = $__attributesOriginalbac5affb147c7bb0375e6eb7b7d76916; ?>
<?php unset($__attributesOriginalbac5affb147c7bb0375e6eb7b7d76916); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbac5affb147c7bb0375e6eb7b7d76916)): ?>
<?php $component = $__componentOriginalbac5affb147c7bb0375e6eb7b7d76916; ?>
<?php unset($__componentOriginalbac5affb147c7bb0375e6eb7b7d76916); ?>
<?php endif; ?>
    </div>

    <div x-show="!mostrarFormProducto" x-transition class="overflow-x-auto">
        <div class="overflow-x-auto"> 
            <table id="proveedoresproductosTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    
                </tbody>
            </table>
        </div>
    </div>

</div>

<?php $__env->startPush('scripts'); ?>

<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/modules/Proveedores/productos.blade.php ENDPATH**/ ?>
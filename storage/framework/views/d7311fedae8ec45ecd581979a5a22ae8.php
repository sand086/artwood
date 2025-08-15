<div id="tab-recursos" data-module="CotizacionnesRecursos" 
    x-data="{
        mostrarFormRecursos: false,
        precio_unitario: '',
        cantidad: '',
        precio_total: '',
        recalcularTotal: function() {
            const puStr = String(this.precio_unitario).trim();
            const cantStr = String(this.cantidad).trim();

            if (puStr === '' || cantStr === '') {
                this.precio_total = '';
                return;
            }

            const pu = parseFloat(puStr);
            const cant = parseFloat(cantStr);

            if (!isNaN(pu) && pu >= 0 && !isNaN(cant) && cant >= 0) {
                this.precio_total = (pu * cant).toFixed(2);
            } else {
                this.precio_total = '';
            }
        },
        // Función para leer los inputs del DOM, actualizar las variables Alpine y recalcular.
        sincronizarYRecalcular: function() {
            const puInput = document.getElementById('precio_unitario');
            const cantInput = document.getElementById('cantidad');

            if (puInput) {
                // Actualizar la variable Alpine solo si el valor del DOM es diferente
                // para evitar disparos innecesarios del watcher si ya está sincronizado.
                if (String(this.precio_unitario) !== String(puInput.value)) {
                    this.precio_unitario = puInput.value;
                }
            }
            if (cantInput) {
                if (String(this.cantidad) !== String(cantInput.value)) {
                    this.cantidad = cantInput.value;
                }
            }
            // Después de actualizar las variables (lo que podría disparar los watchers),
            // llamamos explícitamente a recalcularTotal para asegurar que el precio_total
            // refleje el estado actual, especialmente en la carga inicial o cambios programáticos.
            this.recalcularTotal();
        },
        handleRecursoChange: function() {
            // Este método se llama cuando el select de Recurso cambia.
            // Damos tiempo a la lógica de 'populateFields' del x-form-select para que actualice el DOM.
            this.$nextTick(() => {
                this.sincronizarYRecalcular();
            });
        }
    }"
    x-init="
        $watch('precio_unitario', () => recalcularTotal());
        $watch('cantidad', () => recalcularTotal());
    "
    x-on:show-form-recurso.window="
        mostrarFormRecursos = true;
        // BaseModule.js o similar podría estar poblando el formulario aquí.
        // Esperamos al siguiente ciclo de actualización del DOM para leer los valores.
        // this.$nextTick(() => {
        //    this.sincronizarYRecalcular();
        // });
    "
    x-on:hide-form-recurso.window="
        mostrarFormRecursos = false;
        precio_unitario = ''; // Limpiar variable Alpine
        cantidad = '';      // Limpiar variable Alpine
        precio_total = '';  // Limpiar variable Alpine (recalcularTotal lo haría si los otros se limpian)
        const form = document.getElementById('cotizacionesrecursosForm');
        if (form) {
            form.reset(); // Resetear el formulario HTML para limpiar todos los campos visualmente
        }
    "
>
    <div x-show="!mostrarFormRecursos" x-transition class="overflow-x-auto">
        <div class="overflow-x-auto"> 
            <table id="cotizacionesrecursosTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="mostrarFormRecursos" x-transition class="mb-4">
        <form id="cotizacionesrecursosForm" method="POST">
            <?php echo csrf_field(); ?>
            <div class="grid grid-cols-1 gap-2">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                    <div class="col-span-1 p-1 rounded-lg ">
                        <?php if (isset($component)) { $__componentOriginal4b64953296fad43ab18567788f55889a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b64953296fad43ab18567788f55889a = $attributes; } ?>
<?php $component = App\View\Components\FormSelect::resolve(['label' => 'Tipo Recurso','name' => 'tipo_recurso_id','id' => 'tipo_recurso_id','table' => 'tiposrecursos','valueField' => 'tipo_recurso_id','labelField' => 'nombre','where' => ['estado' => 'A'],'orderBy' => ['nombre', 'asc'],'placeholder' => 'Seleccione un Tipo Recurso'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
                
                    <div class="col-span-1 p-1 rounded-lg ">
                        <?php if (isset($component)) { $__componentOriginal4b64953296fad43ab18567788f55889a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b64953296fad43ab18567788f55889a = $attributes; } ?>
<?php $component = App\View\Components\FormSelect::resolve(['label' => 'Recurso','name' => 'recurso_id','id' => 'recurso_id','table' => 'vw_recursos','valueField' => 'recurso_id','labelField' => 'nombre','parentIdField' => 'tipo_recurso_id','where' => ['estado' => 'A'],'orderBy' => ['nombre', 'asc'],'placeholder' => 'Seleccione un Recurso'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\FormSelect::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['populateFields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                                ['source_key' => 'unidad_medida_id', 'target_id' => 'unidad_medida_id'],
                                ['source_key' => 'precio_unitario',  'target_id' => 'precio_unitario']
                            ]),'x-on:change' => 'handleRecursoChange()','required' => true]); ?>
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

                    <div class="col-span-1 p-1 rounded-lg ">
                        <?php if (isset($component)) { $__componentOriginal4b64953296fad43ab18567788f55889a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b64953296fad43ab18567788f55889a = $attributes; } ?>
<?php $component = App\View\Components\FormSelect::resolve(['label' => 'Proveedor','name' => 'proveedor_id','id' => 'proveedor_id','table' => 'vw_recursoproveedores','valueField' => 'proveedor_id','labelField' => 'nombre','parentIdField' => ['tipo_recurso_id', 'recurso_id'],'where' => ['estado' => 'A'],'orderBy' => ['nombre', 'asc'],'placeholder' => 'Seleccione un Proveedor'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-9 gap-2">
                    <div class="col-span-3 p-1 rounded-lg ">
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
                    
                    <div class="col-span-2 p-1 rounded-lg ">
                        <label for="precio_unitario" class="art-label-custom">Precio Unitario</label>
                        <input type="number" id="precio_unitario" name="precio_unitario" class="art-input-custom text-right" min="0" step="0.01" required x-model.lazy="precio_unitario">
                    </div>
                    
                    <div class="col-span-1 p-1 rounded-lg ">
                        <label for="cantidad" class="art-label-custom">Cantidad</label>
                        <input type="number" id="cantidad" name="cantidad" class="art-input-custom text-right" min="0" step="1" required x-model.lazy="cantidad">
                    </div>

                    <div class="col-span-2 p-1 rounded-lg ">
                        <label for="precio_total" class="art-label-custom">Precio Total</label>
                        <input type="number" id="precio_total" name="precio_total" class="art-input-custom text-right bg-gray-100" min="0" step="0.01" x-model="precio_total" readonly required>
                    </div>

                    <div class="col-span-1 p-1 rounded-lg ">
                        <label for="costo_clave" class="art-label-custom">Costo Clave</label>
                        <select id="costo_clave" name="costo_clave" class="art-input-custom" required>
                            <option value="NO" selected>NO</option>
                            <option value="SI">SI</option>
                        </select>
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
<?php $component->withAttributes(['showUser' => true]); ?>
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

        <?php if (isset($component)) { $__componentOriginalbac5affb147c7bb0375e6eb7b7d76916 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbac5affb147c7bb0375e6eb7b7d76916 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.buttons','data' => ['formId' => 'cotizacionesrecursosForm','cancelEvent' => '
                mostrarFormRecursos = false; 
                precio_unitario = \'\'; 
                cantidad = \'\'; 
                precio_total = \'\';
                const formToReset = document.getElementById(\'cotizacionesrecursosForm\');
                if (formToReset) {
                    formToReset.reset();
                }
                $dispatch(\'reset-form-fields\', { formId: \'cotizacionesrecursosForm\' }); // Para resetear x-form-selects si es necesario
            ']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['formId' => 'cotizacionesrecursosForm','cancelEvent' => '
                mostrarFormRecursos = false; 
                precio_unitario = \'\'; 
                cantidad = \'\'; 
                precio_total = \'\';
                const formToReset = document.getElementById(\'cotizacionesrecursosForm\');
                if (formToReset) {
                    formToReset.reset();
                }
                $dispatch(\'reset-form-fields\', { formId: \'cotizacionesrecursosForm\' }); // Para resetear x-form-selects si es necesario
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

</div><?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/modules/CotizacionesAnalisis/recursos.blade.php ENDPATH**/ ?>
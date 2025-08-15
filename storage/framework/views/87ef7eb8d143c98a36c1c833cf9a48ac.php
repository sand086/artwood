
            <form id="cotizacionesanalisisForm" method="POST">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 gap-2">
                    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-6 lg:grid-cols-6 gap-2">
                        <div class="col-span-3 p-2 rounded-lg ">
                            <?php if (isset($component)) { $__componentOriginal4b64953296fad43ab18567788f55889a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b64953296fad43ab18567788f55889a = $attributes; } ?>
<?php $component = App\View\Components\FormSelect::resolve(['label' => 'Solicitud','name' => 'cotizacion_solicitud_id','id' => 'cotizacion_solicitud_id','table' => 'cotizacionessolicitudes','valueField' => 'cotizacion_solicitud_id','labelField' => 'nombre_proyecto','where' => ['estado' => 'A', 'estado_id' => 2],'orderBy' => ['nombre_proyecto', 'asc'],'placeholder' => 'Seleccione una Solicitud'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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

                        <div class="col-span-2 p-2 rounded-lg ">
                            <?php if (isset($component)) { $__componentOriginal4b64953296fad43ab18567788f55889a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b64953296fad43ab18567788f55889a = $attributes; } ?>
<?php $component = App\View\Components\FormSelect::resolve(['label' => 'Tipo Proyecto','name' => 'tipo_proyecto_id','id' => 'tipo_proyecto_id','table' => 'tiposproyectos','valueField' => 'tipo_proyecto_id','labelField' => 'nombre','where' => ['estado' => 'A'],'orderBy' => ['nombre', 'asc'],'placeholder' => 'Seleccione un Tipo Proyecto'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
                            <label for="control_version" class="art-label-custom">Control Version</label>
                            <input type="number" id="control_version" name="control_version" class="art-input-custom text-right" min="1" step="1" value="1" required>
                        </div>
                    </div>
                        
                    <div>
                        <label for="descripcion_solicitud" class="art-label-custom">Descripci&oacute;n de la Solicitud</label>
                        <input type="text" id="descripcion_solicitud" name="descripcion_solicitud" class="art-input-custom">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-6 lg:grid-cols-2 gap-2">
                        <div>
                            <label for="costo_total" class="art-label-custom">Costo Total</label>
                            <input type="number" id="costo_total" name="costo_total" class="art-input-custom text-right" value="0.00" step="0.01" min="0">
                        </div>
                        
                        <div>
                            <label for="tiempo_total" class="art-label-custom">Tiempo Total</label>
                            <input type="number" id="tiempo_total" name="tiempo_total" class="art-input-custom text-right" value="0" step="1" min="0">
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.buttons','data' => ['formId' => 'cotizacionesanalisisForm','saveEvent' => '
                    const form = document.getElementById(\'cotizacionesanalisisForm\');
                    form.dispatchEvent(new Event(\'submit\'));  // sigue usando BaseModule.js
                    
                ']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['formId' => 'cotizacionesanalisisForm','saveEvent' => '
                    const form = document.getElementById(\'cotizacionesanalisisForm\');
                    form.dispatchEvent(new Event(\'submit\'));  // sigue usando BaseModule.js
                    
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
<?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/modules/CotizacionesAnalisis/analisis.blade.php ENDPATH**/ ?>
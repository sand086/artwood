
                <form id="procesosForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-1 gap-4">
                        
                            <div>
                                <label for="nombre" class="art-label-custom">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                            </div>
                            
                            <div>
                                <label for="descripcion" class="art-label-custom">Descripcion</label>
                                <input type="text" id="descripcion" name="descripcion" class="art-input-custom" required>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div class="col-span-2 p-2 rounded-lg ">
                                    <label for="presupuesto_estimado" class="art-label-custom">Presupuesto Estimado</label>
                                    <input type="number" id="presupuesto_estimado" name="presupuesto_estimado" min="0" step="0.01" class="art-input-custom text-right" required>
                                </div>
                                
                                <div class="col-span-2 p-2 rounded-lg ">
                                    <label for="fecha_estimada" class="art-label-custom">Fecha Estimada</label>
                                    <input type="date" id="fecha_estimada" name="fecha_estimada" class="art-input-custom">
                                </div>
                            </div>
                            
                            <div>
                                <label for="comentarios" class="art-label-custom">Comentarios</label>
                                <input type="text" id="comentarios" name="comentarios" class="art-input-custom">
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

                <?php if (isset($component)) { $__componentOriginalbac5affb147c7bb0375e6eb7b7d76916 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbac5affb147c7bb0375e6eb7b7d76916 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.buttons','data' => ['formId' => 'procesosForm','saveEvent' => '
                        const form = document.getElementById(\'procesosForm\');
                        form.dispatchEvent(new Event(\'submit\'));  // sigue usando BaseModule.js
                        
                    ']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['formId' => 'procesosForm','saveEvent' => '
                        const form = document.getElementById(\'procesosForm\');
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/modules/Procesos/basicos.blade.php ENDPATH**/ ?>
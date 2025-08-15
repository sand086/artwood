            <form id="proveedoresForm" method="POST">
                <?php echo csrf_field(); ?>
                <div class="grid grid-cols-1 gap-1">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-2">
                        <div class="col-span-3 p-1 rounded-lg ">
                            <label for="nombre" class="art-label-custom">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                        </div>

                        <div class="col-span-1 p-1 rounded-lg ">
                            <label for="rfc" class="art-label-custom">RFC</label>
                            <input type="text" id="rfc" name="rfc" class="art-input-custom text-center" >
                        </div>

                        <div class="col-span-1 p-1 rounded-lg ">
                            <label for="tipo" class="art-label-custom">Tipo</label>
                            
                            <select id="tipo" name="tipo" class="art-input-custom" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="PERSONA">Persona</option>
                                <option value="EMPRESA">Empresa</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-4 lg:grid-cols-10 gap-2">
                        <div class="col-span-4 p-1 rounded-lg ">
                            <label for="direccion" class="art-label-custom">Direcci&oacute;n</label>
                            <input type="text" id="direccion" name="direccion" class="art-input-custom" required>
                        </div>

                        <div class="col-span-4 p-1 rounded-lg ">
                            <label for="colonia" class="art-label-custom">Colonia</label>
                            <input type="text" id="colonia" name="colonia" class="art-input-custom">
                        </div>

                        <div class="col-span-2 p-1 rounded-lg ">
                            <label for="telefono" class="art-label-custom">Tel&eacute;fono</label>
                            <input type="text" id="telefono" name="telefono" class="art-input-custom" required>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-5 gap-2">
                        <div class="col-span-1 p-1 rounded-lg ">
                            <label for="codigo_postal" class="art-label-custom">C&oacute;digo Postal</label>
                            <input type="text" id="codigo_postal" name="codigo_postal" class="art-input-custom text-center">
                        </div>

                        <div class="col-span-2 p-1 rounded-lg ">
                            <?php if (isset($component)) { $__componentOriginal4b64953296fad43ab18567788f55889a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b64953296fad43ab18567788f55889a = $attributes; } ?>
<?php $component = App\View\Components\FormSelect::resolve(['label' => 'Estado Pais','name' => 'estado_pais_id','id' => 'estado_pais_id','table' => 'estadospaises','valueField' => 'estado_pais_id','labelField' => 'nombre','where' => ['estado' => 'A'],'orderBy' => ['nombre', 'asc'],'placeholder' => 'Seleccione un Estado Pais'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\FormSelect::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($proveedor->estado_pais_id ?? old('estado_pais_id', '')),'required' => true]); ?>
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
                            <?php if (isset($component)) { $__componentOriginal4b64953296fad43ab18567788f55889a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b64953296fad43ab18567788f55889a = $attributes; } ?>
<?php $component = App\View\Components\FormSelect::resolve(['label' => 'Municipio','name' => 'municipio_id','id' => 'municipio_id','table' => 'municipios','valueField' => 'municipio_id','labelField' => 'nombre','parentIdField' => 'estado_pais_id','where' => ['estado' => 'A'],'orderBy' => ['nombre', 'asc'],'placeholder' => 'Seleccione un Municipio'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\FormSelect::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($proveedor->municipio_id ?? old('municipio_id', '')),'required' => true]); ?>
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
                    
                    <div class="grid grid-cols-1 gap-2">
                        <div class="col-span-1 p-1 rounded-lg ">
                            <label for="sitio_web" class="art-label-custom">Sitio Web</label>
                            <input type="text" id="sitio_web" name="sitio_web" class="art-input-custom" required>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 gap-2">
                        <div class="col-span-1 p-1 rounded-lg ">
                            <label for="notas_adicionales" class="art-label-custom">Notas Adicionales</label>
                            <input type="text" id="notas_adicionales" name="notas_adicionales" class="art-input-custom" required>
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
                </div>
            </form>

            <?php if (isset($component)) { $__componentOriginalbac5affb147c7bb0375e6eb7b7d76916 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbac5affb147c7bb0375e6eb7b7d76916 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.buttons','data' => ['formId' => 'proveedoresForm','saveEvent' => '
                    const form = document.getElementById(\'proveedoresForm\');
                    form.dispatchEvent(new Event(\'submit\'));  // sigue usando BaseModule.js
                    
                ']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['formId' => 'proveedoresForm','saveEvent' => '
                    const form = document.getElementById(\'proveedoresForm\');
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
<?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/modules/Proveedores/basicos.blade.php ENDPATH**/ ?>
            <div x-data="{ 
                handleClientCreated(event) {
                    const newClient = event.detail;
                    const clienteSelect = document.getElementById('cliente_id'); // ID de tu select de clientes
                    if (clienteSelect) {
                        // Añadir la nueva opción al select
                        const option = document.createElement('option');
                        option.value = newClient.id;
                        option.text = newClient.name; // Asumiendo que 'name' es el campo de texto
                        
                        // Evitar duplicados si el cliente ya existe en el select
                        let exists = Array.from(clienteSelect.options).some(opt => opt.value == newClient.id);
                        if (!exists) {
                            // Añadir después del placeholder o como primera opción si no hay placeholder
                            clienteSelect.add(option, clienteSelect.options[1] || null); 
                        }
                        clienteSelect.value = newClient.id; // Seleccionar el nuevo cliente

                        // Importante: Disparar evento 'change' para que otros componentes (ej. TomSelect) reaccionen
                        clienteSelect.dispatchEvent(new Event('change', { bubbles: true }));
                    }
                    // El modal se cierra solo al escuchar 'quick-client-success'
                } 
            }" @quick-save-client-data.window="Artwood.CotizacionesSolicitudes.saveQuickClient($event.detail, '<?php echo e(route('quick.client.contact.store')); ?>')">
                <form id="cotizacionessolicitudesForm" method="POST" @client-created.window="handleClientCreated($event)">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-1 gap-2">
                        
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-6 lg:grid-cols-6 gap-2">
                            <div class="col-span-3 p-1 rounded-lg ">
                                <?php if (isset($component)) { $__componentOriginal4b64953296fad43ab18567788f55889a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b64953296fad43ab18567788f55889a = $attributes; } ?>
<?php $component = App\View\Components\FormSelect::resolve(['label' => 'Cliente / Prospecto','name' => 'cliente_id','id' => 'cliente_id','table' => 'clientes','valueField' => 'cliente_id','labelField' => 'nombre','where' => ['estado' => 'A'],'orderBy' => ['nombre', 'asc'],'placeholder' => 'Seleccione un Cliente'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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

                            
                            <div class="col-span-1 p-1 rounded-lg flex items-end">
                                <button type="button" @click.prevent="$dispatch('open-quick-client-modal')" class="art-btn-secondary ml-2 p-1 leading-none" title="Crear Cliente/Prospecto Rápido">+</button>
                            </div>

                            <div class="col-span-1 p-1 rounded-lg ">
                                <?php if (isset($component)) { $__componentOriginal4b64953296fad43ab18567788f55889a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b64953296fad43ab18567788f55889a = $attributes; } ?>
<?php $component = App\View\Components\FormSelect::resolve(['label' => 'Tipo Solicitud','name' => 'tipo_solicitud_id','id' => 'tipo_solicitud_id','table' => 'tipossolicitudes','valueField' => 'tipo_solicitud_id','labelField' => 'nombre','where' => ['estado' => 'A'],'orderBy' => ['nombre', 'asc'],'placeholder' => 'Seleccione un Tipo Solicitud'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
<?php $component = App\View\Components\FormSelect::resolve(['label' => 'Fuente','name' => 'fuente_id','id' => 'fuente_id','table' => 'fuentes','valueField' => 'fuente_id','labelField' => 'nombre','where' => ['estado' => 'A'],'orderBy' => ['nombre', 'asc'],'placeholder' => 'Seleccione una Fuente'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
                        
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
                            <div class="col-span-3 p-1 rounded-lg ">
                                <label for="nombre_proyecto" class="art-label-custom">Nombre Proyecto
                                    <span class="text-red-500">&nbsp;*</span>
                                </label>
                                <input type="text" id="nombre_proyecto" name="nombre_proyecto" class="art-input-custom" required>
                            </div>

                            <div class="col-span-2 p-1 rounded-lg ">
                                <label for="fecha_estimada" class="art-label-custom">Fecha Estimada
                                    <span class="text-red-500">&nbsp;*</span>
                                </label>
                                <input type="date" id="fecha_estimada" name="fecha_estimada" class="art-input-custom" required>
                            </div>

                            <div class="col-span-1 p-1 rounded-lg ">
                                <label for="control_version" class="art-label-custom">Control Versi&oacute;n 
                                    <span class="text-red-500">&nbsp;*</span>
                                </label>
                                <input type="number" id="control_version" name="control_version" min="1" step="1" class="art-input-custom text-right" value="1" required>
                            </div>
                        </div>
                        
                        <div>
                            <label for="descripcion" class="art-label-custom">Descripci&oacute;n
                                <span class="text-red-500">&nbsp;*</span>
                            </label>
                            <input type="text" id="descripcion" name="descripcion" class="art-input-custom" required>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="col-span-2 p-1 rounded-lg ">
                                <?php if (isset($component)) { $__componentOriginal4b64953296fad43ab18567788f55889a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b64953296fad43ab18567788f55889a = $attributes; } ?>
<?php $component = App\View\Components\FormSelect::resolve(['label' => 'Usuario','name' => 'usuario_id','id' => 'usuario_id','table' => 'usuarios','valueField' => 'usuario_id','labelField' => 'nombre','where' => ['estado' => 'A'],'orderBy' => ['nombre', 'asc'],'placeholder' => 'Seleccione un Usuario'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
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
                                <?php if (isset($component)) { $__componentOriginal4b64953296fad43ab18567788f55889a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b64953296fad43ab18567788f55889a = $attributes; } ?>
<?php $component = App\View\Components\FormSelect::resolve(['label' => 'Estado','name' => 'estado_id','id' => 'estado_id','table' => 'estadosgenerales','valueField' => 'estado_general_id','labelField' => 'nombre','where' => ['estado' => 'A', 'categoria' => 'SOLICITUD'],'orderBy' => ['nombre', 'asc'],'placeholder' => 'Seleccione un Estado'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\FormSelect::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => '1','required' => true]); ?>
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
<?php $component->withAttributes(['showStatus' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.buttons','data' => ['formId' => 'cotizacionessolicitudesForm','saveEvent' => '
                        const form = document.getElementById(\'cotizacionessolicitudesForm\');
                        form.dispatchEvent(new Event(\'submit\'));  // sigue usando BaseModule.js
                        
                    ']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['formId' => 'cotizacionessolicitudesForm','saveEvent' => '
                        const form = document.getElementById(\'cotizacionessolicitudesForm\');
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
                <?php if (isset($component)) { $__componentOriginala56ae225a8142798d9800550425d0815 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala56ae225a8142798d9800550425d0815 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form-create-prospecto','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-create-prospecto'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala56ae225a8142798d9800550425d0815)): ?>
<?php $attributes = $__attributesOriginala56ae225a8142798d9800550425d0815; ?>
<?php unset($__attributesOriginala56ae225a8142798d9800550425d0815); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala56ae225a8142798d9800550425d0815)): ?>
<?php $component = $__componentOriginala56ae225a8142798d9800550425d0815; ?>
<?php unset($__componentOriginala56ae225a8142798d9800550425d0815); ?>
<?php endif; ?>
            </div>
<?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/modules/CotizacionesSolicitudes/solicitud.blade.php ENDPATH**/ ?>
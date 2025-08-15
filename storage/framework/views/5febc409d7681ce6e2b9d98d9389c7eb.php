    <div id="tab-contactos" data-module="ProveedoresContactos" 
        x-data="{ mostrarFormContacto: false }" 
        x-on:show-form-contacto.window="mostrarFormContacto = true"
        x-on:hide-form-contacto.window="mostrarFormContacto = false"
    >

      <div x-show="mostrarFormContacto" x-transition class="mb-4">
        <form id="proveedorescontactosForm" method="POST">
          <?php echo csrf_field(); ?>
          <div class="grid grid-cols-1 gap-2">
                      
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                <div class="col-span-2 p-1 rounded-lg ">
                    <?php if (isset($component)) { $__componentOriginal4b64953296fad43ab18567788f55889a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b64953296fad43ab18567788f55889a = $attributes; } ?>
<?php $component = App\View\Components\FormSelect::resolve(['label' => 'Contacto','name' => 'persona_id','id' => 'persona_id','table' => 'vw_contactos','valueField' => 'persona_id','labelField' => 'nombre_completo','where' => ['estado' => 'A', 'empleado_id' => 'IS NULL'],'orderBy' => ['nombres', 'asc'],'placeholder' => 'nombre_completo un Contacto'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\FormSelect::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['populateFields' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
                            ['source_key' => 'telefono', 'target_id' => 'telefono_contacto'],
                            ['source_key' => 'correo_electronico',  'target_id' => 'correo_electronico_contacto']
                        ]),'required' => true]); ?>
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
                    <label for="boton-crear-contacto" class="art-label-custom p-1">&nbsp;</label>
                    <a href="#" @click.prevent="abrirVentana('<?php echo e(route('personas.create')); ?>', '?openModal=true&windowClose=true')" class="art-btn-secondary ml-2">Crear Contacto</a>
                </div>
            </div>
            
            <div>
                <label for="cargo" class="art-label-custom">Cargo</label>
                <input type="text" id="cargo" name="cargo" class="art-input-custom" required>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                <div class="col-span-1 p-1 rounded-lg ">
                    <label for="telefono" class="art-label-custom">Tel&eacute;fono Empresarial</label>
                    <input type="text" id="telefono_contacto" name="telefono" class="art-input-custom" required>
                </div>
                <div class="col-span-2 p-1 rounded-lg ">
                    <label for="correo_electronico" class="art-label-custom">Correo Electr&oacute;nico Empresarial</label>
                    <input type="text" id="correo_electronico_contacto" name="correo_electronico" class="art-input-custom" required>
                </div>
            </div>
            
            <div>
                <label for="observaciones" class="art-label-custom">Observaciones</label>
                <input type="text" id="observaciones" name="observaciones" class="art-input-custom">
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.buttons','data' => ['formId' => 'proveedorescontactosForm','cancelEvent' => '
                mostrarFormContacto = false;
                
                
            ','saveEvent' => '
                const form = document.getElementById(\'proveedorescontactosForm\');
                form.dispatchEvent(new Event(\'submit\'));
                mostrarFormContacto = false;  // oculta formulario
            ']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['formId' => 'proveedorescontactosForm','cancelEvent' => '
                mostrarFormContacto = false;
                
                
            ','saveEvent' => '
                const form = document.getElementById(\'proveedorescontactosForm\');
                form.dispatchEvent(new Event(\'submit\'));
                mostrarFormContacto = false;  // oculta formulario
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
      
      <div x-show="!mostrarFormContacto" x-transition class="overflow-x-auto">
        <div class="overflow-x-auto"> 
          <table id="proveedorescontactosTable" class="min-w-full divide-y divide-gray-200">
              <thead class="art-bg-primary art-text-background">
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                  
              </tbody>
          </table>
        </div>
      </div>

    </div>

<?php $__env->startPush('scripts'); ?>
    
<?php $__env->stopPush(); ?><?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/modules/Proveedores/contactos.blade.php ENDPATH**/ ?>
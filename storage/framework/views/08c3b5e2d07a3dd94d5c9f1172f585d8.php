<?php $__env->startSection('title', 'Usuarios'); ?>

<?php $__env->startSection('content'); ?>
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="Usuarios">
        <h1 class="text-3xl font-semibold mb-6">Usuarios</h1>

        <div class="overflow-x-auto">
            <div class="p-1.5">
                <table id="usuariosTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="art-bg-primary art-text-background">
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        
                    </tbody>
                </table>
            </div>
        </div>

        
        <?php if (isset($component)) { $__componentOriginale6a555649da86b3de44465cdfe004aa4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale6a555649da86b3de44465cdfe004aa4 = $attributes; } ?>
<?php $component = App\View\Components\Modal::resolve(['id' => 'usuariosModal','formId' => 'usuariosForm','showCancelButton' => true,'showSaveButton' => true,'showClearButton' => true,'size' => 'md'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Modal::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
            
             <?php $__env->slot('header', null, []); ?> 
                <h5 class="text-lg font-semibold">Formulario Usuarios</h5>
             <?php $__env->endSlot(); ?>
            
             <?php $__env->slot('body', null, []); ?> 
                <form id="usuariosForm" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="grid grid-cols-12 gap-4">
                        <!-- Foto -->
                        <div class="col-span-5">
                            <div
                                data-hs-file-upload='{
                                                                                                                                            "url": "/upload",
                                                                                                                                            "acceptedFiles": "image/*",
                                                                                                                                            "maxFiles": 1,
                                                                                                                                            "singleton": true
                                                                                                                                          }'>
                                <template data-hs-file-upload-preview="">
                                    <div class="w-20 h-20">
                                        <img class="w-full h-full object-cover rounded-full" data-dz-thumbnail="">
                                    </div>
                                </template>
                                <div class="flex flex-col items-center gap-2 mt-2">
                                    <!-- Placeholder de imagen -->
                                    <div class="group" data-hs-file-upload-previews=""
                                        data-hs-file-upload-pseudo-trigger="">
                                        <span class="file-upload-previews-span">
                                            <i class="w-8 h-8" data-lucide="circle-user-round"></i>
                                        </span>
                                    </div>
                                    <!-- Botones de acción  -->
                                    <div class="flex gap-2">
                                        <!-- Botón de upload (icono de subir) -->
                                        <button type="button" data-hs-file-upload-trigger=""
                                            class="art-button-upload-icon-user">

                                            <i class="w-6 h-6" data-lucide="upload"></i>
                                        </button>
                                        <!-- Botón de delete (X roja) -->
                                        <button type="button" data-hs-file-upload-clear=""
                                            class="art-button-trash-icon-upload-user">
                                            <i class="w-6 h-6" data-lucide="trash-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contenedor para Alias y Rol  -->
                        <div class="col-span-7 space-y-4">
                            <div>
                                <label for="nombre" class="art-label-custom">Alias (Usuario)</label>
                                <input type="text" id="nombre" name="nombre" placeholder="Ingresa alias"
                                    class="art-input-custom" required>
                            </div>

                            <div>
                                <?php if (isset($component)) { $__componentOriginal4b64953296fad43ab18567788f55889a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4b64953296fad43ab18567788f55889a = $attributes; } ?>
<?php $component = App\View\Components\FormSelect::resolve(['label' => 'Role','name' => 'role_id','id' => 'role_id','table' => 'roles','valueField' => 'role_id','labelField' => 'name','where' => ['estado' => 'A'],'orderBy' => ['role_id', 'asc'],'placeholder' => 'Seleccione un Rol'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form-select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\FormSelect::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
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

                        <!-- Nombres, Apellidos  -->

                        <div class="col-span-12 grid grid-cols-2 gap-4">
                            <div>
                                <label for="nombres" class="art-label-custom">Nombres</label>
                                <input type="text" id="nombres" name="nombres" placeholder="Ingresa nombres"
                                    class="art-input-custom" required>
                            </div>
                            <div>
                                <label for="apellidos" class="art-label-custom">Apellidos</label>
                                <input type="text" id="apellidos" name="apellidos" placeholder="Ingresa apellidos"
                                    class="art-input-custom" required>
                            </div>
                        </div>

                        <!-- Teléfono y Email -->
                        <div class="col-span-12 grid grid-cols-2 gap-4">
                            <div>
                                <label for="telefono" class="art-label-custom">Teléfono</label>
                                <input type="text" id="telefono" name="telefono" placeholder="Ingresa teléfono"
                                    class="art-input-custom" required>
                            </div>
                            <div>
                                <label for="email" class="art-label-custom">Email</label>
                                <input type="email" id="email" name="email" placeholder="Ingresa email"
                                    class="art-input-custom" required>
                            </div>
                        </div>

                        <!-- Dirección  -->
                        <div class="col-span-12 space-y-4">
                            <div>
                                <label for="direccion" class="art-label-custom">Dirección</label>
                                <input type="text" id="direccion" name="direccion" placeholder="Ingresa dirección"
                                    class="art-input-custom" required>
                            </div>
                        </div>
                        <!-- Bloque para Contraseña y Confirmación (solo en creación) -->
                        <div class="password-fields col-span-12 grid grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="art-label-custom">Contraseña</label>
                                <input type="password" id="password" name="password" placeholder="Ingresa la contraseña"
                                    class="art-input-custom" required>
                            </div>
                            <div>
                                <label for="password_confirmation" class="art-label-custom">Confirmar
                                    Contraseña</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Confirma la contraseña" class="art-input-custom" required>
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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function actualizarVisibilidadPassword() {
                const $form = $('#usuariosForm');
                const formType = $form.attr('data-type');
                // console.log('Valor de data-type:', formType);

                if (formType === 'PUT') {
                    $('.password-fields').hide();
                    // console.log('Ocultando campos de contraseña');
                } else {
                    $('.password-fields').show();
                    // console.log('Mostrando campos de contraseña');
                }
            }

            // Intentamos primero con el evento de Bootstrap
            const modalEl = document.getElementById('usuariosModal');
            if (modalEl) {
                modalEl.addEventListener('shown.bs.modal', function () {
                    actualizarVisibilidadPassword();
                });
            }

            // Fallback: llamar a la función después de un breve retraso
            setTimeout(actualizarVisibilidadPassword, 500);
        });
    </script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.appP', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/modules/Usuarios/index.blade.php ENDPATH**/ ?>

<div id="tab-documentos" data-module="CotizacionesDocumentos" 
    x-data="{
        // cotizacionSolicitudId: null, // Se deberá setear desde el JS principal al abrir/editar una solicitud
        mostrarFormDocumento: false,
        // documentos: [], // Array para almacenar los documentos cargados - BaseModule/DataTable will handle this
        // fetchDocumentos() {} // BaseModule/DataTable will handle fetching
        // handleFileUpload(event) {} // This logic will move to the JS module and BaseModule
    }"
    x-init="
        // Initialize cotizacionSolicitudId from Alpine store if available (e.g., set by parent module)
        // cotizacionSolicitudId = Alpine.store('alpineTabs')?.currentId || null;

        // Watch for changes in the Alpine store
        // $watch('$store.alpineTabs.currentId', newId => {
           // cotizacionSolicitudId = newId;
           // The CotizacionesDocumentos JS module will listen to this change (or a dedicated event)
           // to update its internal state and reload the DataTable.
        // });

        // Alternative: Listen for a custom event dispatched by the parent module
        window.addEventListener('cotizacion-solicitud-selected', (event) => {
            if (event.detail && event.detail.id) {
                cotizacionSolicitudId = event.detail.id;
            }
        });
        // La carga inicial de documentos la hará BaseModule a través de DataTables
    "
    x-on:show-form-documento.window="mostrarFormDocumento = true"
    x-on:hide-form-documento.window="mostrarFormDocumento = false"
>
    
    <div x-show="mostrarFormDocumento" x-transition class="mb-4">
        <form id="cotizacionesdocumentosForm" method="POST" enctype="multipart/form-data" class="mb-6 p-4 border rounded-lg bg-gray-50">
            <?php echo csrf_field(); ?>
            
            <h4 class="text-lg font-medium mb-3">Subir Nuevo Documento</h4>
            <div class="mb-4">
                <label for="documento_file_upload" class="art-label-custom">Seleccionar Documento</label>
                <input type="file" id="documento_file_upload" name="documento" class="art-input-custom" required>
            </div>
            <div class="mb-4">
                <label for="documento_descripcion_upload" class="art-label-custom">Descripción (Opcional)</label>
                <input type="text" id="documento_descripcion_upload" name="descripcion" class="art-input-custom" placeholder="Breve descripción del documento">

            </div>
            
        </form>
        <?php if (isset($component)) { $__componentOriginalbac5affb147c7bb0375e6eb7b7d76916 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbac5affb147c7bb0375e6eb7b7d76916 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.buttons','data' => ['formId' => 'cotizacionesdocumentosForm','cancelEvent' => 'mostrarFormDocumento = false;','saveLabel' => 'Subir Documento']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('buttons'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['formId' => 'cotizacionesdocumentosForm','cancelEvent' => 'mostrarFormDocumento = false;','saveLabel' => 'Subir Documento']); ?>
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


    
    
    
    
            

    
    <div x-show="!mostrarFormDocumento" x-transition class="overflow-x-auto">
        <div class="overflow-x-auto"> 
            <table id="cotizacionesdocumentosTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    
                </tbody>
            </table>
        </div>
    </div>
</div><?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/modules/CotizacionesSolicitudes/documentos.blade.php ENDPATH**/ ?>
{{-- resources/views/modules/CotizacionesSolicitudes/documentos.blade.php --}}
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
    {{-- Formulario para subir nuevos documentos --}}
    <div x-show="mostrarFormDocumento" x-transition class="mb-4">
        <form id="cotizacionesdocumentosForm" method="POST" enctype="multipart/form-data" class="mb-6 p-4 border rounded-lg bg-gray-50">
            @csrf
            {{-- <input type="hidden" name="cotizacion_solicitud_id" id="cotizacion_solicitud_id_upload"> JS module will populate this --}}
            <h4 class="text-lg font-medium mb-3">Subir Nuevo Documento</h4>
            <div class="mb-4">
                <label for="documento_file_upload" class="art-label-custom">Seleccionar Documento</label>
                <input type="file" id="documento_file_upload" name="documento" class="art-input-custom" required>
            </div>
            <div class="mb-4">
                <label for="documento_descripcion_upload" class="art-label-custom">Descripción (Opcional)</label>
                <input type="text" id="documento_descripcion_upload" name="descripcion" class="art-input-custom" placeholder="Breve descripción del documento">

            </div>
            {{-- <button type="submit" class="art-btn-primary">Subir Documento</button> --}}
        </form>
        <x-buttons 
            formId="cotizacionesdocumentosForm"
            cancelEvent="mostrarFormDocumento = false;"
            saveLabel="Subir Documento"
        />
    </div>


    {{-- Formulario para EDITAR metadatos de documentos (manejado por BaseModule, inicialmente oculto) --}}
    {{-- Este formulario se mostraría/ocultaría con los eventos 'show-form-documento' y 'hide-form-documento' --}}
    {{-- Deberás implementar la lógica en BaseModule o tu JS para manejar su visibilidad --}}
    {{-- <div x-data="{ showEditForm: false }" @show-form-documento.window="showEditForm = true" @hide-form-documento.window="showEditForm = false" x-show="showEditForm" x-cloak>
        <form id="cotizacionesDocumentosForm" class="mb-6 p-4 border rounded-lg bg-gray-50">
            <h4 class="text-lg font-medium mb-3">Editar Documento</h4>
            <input type="hidden" name="cotizacion_documento_id" id="cotizacion_documento_id_edit">
            <input type="hidden" name="cotizacion_solicitud_id" id="cotizacion_solicitud_id_edit_doc"> {{-- BaseModule lo llenará --
            <div class="mb-4">
                <label for="descripcion_edit" class="art-label-custom">Descripción</label>
                <input type="text" id="descripcion_edit" name="descripcion" class="art-input-custom" placeholder="Descripción del documento">
            </div>
            {{-- Podrías añadir campo para 'estado' si es editable --}}
            {{-- Los botones de guardar/cancelar para este formulario los manejaría BaseModule o tu lógica de eventos --
        </form>
    </div> --}}

    {{-- Tabla para listar documentos existentes --}}
    <div x-show="!mostrarFormDocumento" x-transition class="overflow-x-auto">
        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="cotizacionesdocumentosTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
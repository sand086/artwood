    <div id="tab-cotizacion" data-module="Cotizaciones"
        x-data="{ analisis: {} }"
        x-init="
            window.addEventListener('datos-cargados-analisis', (event) => {
                // Asignamos los datos a la variable de Alpine
                analisis = event.detail.data;
                // console.log('Datos del análisis cargados en Alpine:', analisis);
            });
        "
        x-on:datos-cargados-analisis.window="analisis = $event.detail.data"
        x-on:cotizacion-form-cancel.window="
            // Usar la API de Preline para cerrar el modal
            HSOverlay.close(document.getElementById('cotizacionesanalisisModal'));

            // Lógica para limpiar el formulario
            document.getElementById('cotizacionesForm').reset();
            analisis = {};
        "
        >
        <form id="cotizacionesForm" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-4">
                <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-10 lg:grid-cols-7 gap-2">
                    <div class="col-span-1 p-1 rounded-lg ">
                        <label for="cotizacion_cotizacion_solicitud_id" class="art-label-custom">Solicitud</label>
                        <input type="hidden" name="cotizacion_solicitud_id" id="cotizacion_cotizacion_solicitud_id" 
                        x-bind:value="analisis.cotizacion ? analisis.cotizacion.cotizacion_solicitud_id : analisis.cotizacion_solicitud_id">
                        <input type="hidden" name="cliente_id" id="cliente_id" 
                        x-bind:value="analisis.cotizacion_solicitud ? analisis.cotizacion_solicitud.cliente_id : ''">
                        <input type="hidden" name="cotizacion_id" x-bind:value="analisis.cotizacion ? analisis.cotizacion.cotizacion_id : ''">
                        <p class="text-gray-700">
                            <span class="font-semibold" x-text="analisis.cotizacion_solicitud ? analisis.cotizacion_solicitud.consecutivo : ''"></span>
                        </p>
                    </div>
                    
                    <div class="col-span-2 p-1 rounded-lg ">
                        <x-form-select
                            label="Responsable"
                            name="empleado_responsable_id"
                            id="empleado_responsable_id"
                            table="vw_empleados"
                            valueField="empleado_id"
                            labelField="nombre_completo"
                            :where="['estado' => 'A']"
                            :orderBy="['nombre_completo', 'asc']"
                            placeholder="Seleccione un Responsable"
                            {{-- x-model="analisis.cotizacion ? analisis.cotizacion.empleado_responsable_id : null" --}}
                        />
                    </div>

                    <div class="col-span-2 p-1 rounded-lg ">
                        <x-form-select
                            label="Destinatario"
                            name="cliente_contacto_id"
                            id="cliente_contacto_id"
                            table="vw_clientescontactos"
                            valueField="cliente_contacto_id"
                            labelField="contacto_nombre_completo"
                            parentIdField="cliente_id"
                            :where="['estado' => 'A']"
                            :orderBy="['contacto_nombre_completo', 'asc']"
                            placeholder="Seleccione un Destinatario"
                            {{-- x-model="analisis.cotizacion ? analisis.cotizacion.cliente_contacto_id : null" --}}
                        />
                    </div>
                    
                    <div class="col-span-2 p-1 rounded-lg ">
                        <x-form-select
                            label="Plantilla"
                            name="plantilla_id"
                            id="plantilla_id"
                            table="plantillas"
                            valueField="plantilla_id"
                            labelField="nombre"
                            :where="['estado' => 'A']"
                            :orderBy="['nombre', 'asc']"
                            placeholder="Seleccione una Plantilla"
                            {{-- x-model="analisis.cotizacion ? analisis.cotizacion.plantilla_id : null" --}}
                        />
                    </div>
                </div>
                    
                <div>
                    <label for="condiciones_comerciales" class="art-label-custom">Condiciones Comerciales</label>
                    <textarea type="text" id="condiciones_comerciales" name="condiciones_comerciales" class="art-input-custom"></textarea>
                </div>
                
                <div>
                    <label for="datos_adicionales" class="art-label-custom">Datos Adicionales</label>
                    <textarea type="text" id="datos_adicionales" name="datos_adicionales" class="art-input-custom"></textarea>
                </div>
                    
            </div>
            <x-form-auditoria/>
        </form>
        <x-buttons 
            formId="cotizacionesForm"
            cancelDispatch="cotizacion-form-cancel"
            saveEvent="
                const form = document.getElementById('cotizacionesForm');
                form.dispatchEvent(new Event('submit'));  // sigue usando BaseModule.js
            "
        />
    </div>

@push('scripts')
<script type="module">
    let cotizacionesModule = null;
    (function() {
        // Función para inicializar el módulo una vez que BaseModule esté listo
        function initializeModule() {

            const config = {
                moduleName: 'Cotizaciones',
                baseUrl: '/cotizaciones/',
                idField: 'cotizacion_id',
                formFields: ['cotizacion_analisis_id', 'cliente_contacto_id', 'empleado_responsable_id', 'plantilla_id', 'condiciones_comerciales', 'datos_adicionales'],
                moduleForm: 'cotizacionesForm',
                // moduleTable: 'cotizacionesTable',
                moduleModal: 'cotizacionesanalisisModal',
                parentIdField: 'cotizacion_analisis_id',  // ID del padre del modulo cuando es una pestaña
                closeModalOnSave: false,  // Determina si se cierra el modal al guardar
                resetFormOnSave: false,  // Determina si se reinicia el formulario al guardar
                targetTab: 'cotizacion', // Nombre de la pestaña a la que se redirige despues de un evento
                formIsInModal: false,
                columns: [
                ],
                onSaveSuccess: (response, form) => {
                    // Notificar al módulo principal que se guardó una cotización
                    window.dispatchEvent(new CustomEvent('cotizacion-guardada', {
                        detail: {
                            cotizacionId: response.cotizacione.cotizacion_id,
                            solicitudId: response.cotizacione.cotizacion_solicitud_id
                        }
                    }));
                }
            };

            cotizacionesModule = new BaseModule(config);
            cotizacionesModule.init();
        }

        // Espera a que BaseModule esté definido en el objeto global 'window'
        // Esto previene la condición de carrera
        const checkBaseModule = setInterval(() => {
            if (window.BaseModule) {
                clearInterval(checkBaseModule); // Detiene el intervalo
                initializeModule();

                window.addEventListener('datos-cargados-analisis', (event) => {
                    const cotizacionData = event.detail.data.cotizacion;
                    
                    if (cotizacionData && cotizacionData.cotizacion_id) {
                        // Si existe un cotizacion_id, activamos el modo de edición
                        cotizacionesModule.state.method = 'PUT';
                        cotizacionesModule.state.id = cotizacionData.cotizacion_id;
                        console.log(`[${cotizacionesModule.config.moduleName}] Modo de edición activado. ID: ${cotizacionesModule.state.id}`);
                    } else {
                        // Si no existe, nos aseguramos de que el método sea POST para crear un nuevo registro
                        cotizacionesModule.state.method = 'POST';
                        cotizacionesModule.state.id = '';
                        console.log(`[${cotizacionesModule.config.moduleName}] Modo de creación activado.`);
                    }
                });
            }
        }, 50); // Comprueba cada 50 milisegundos

    })();
</script>
@endpush

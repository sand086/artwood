<div id="tab-recursos" data-module="CotizacionesRecursos" 
    x-ref="cotizacionesrecursosContainer"
    x-data="{
        mostrarFormRecursos: false,
        reiniciarFormulario: false,
        precio_unitario: 0,
        porcentaje_ganancia: 0, // Se inicializa en 0. Será actualizado por el evento o al editar.
        precio_unitario_ganancia: 0,    
        cantidad: 0,
        precio_total: 0,
        // Propiedad para almacenar el porcentaje por defecto hasta que el formulario esté visible y listo.
        _pendingPorcentajeGananciaDefault: null, 

        // Función para calcular el precio_unitario_ganancia (precio_unitario + ganancia)
        calcularPrecioConGanancia: function() {
            const puStr = String(this.precio_unitario).trim();
            const pgVal = this.porcentaje_ganancia; 
            
            if (puStr === '' || pgVal === '' || pgVal === null) { 
                this.precio_unitario_ganancia = '';
                this.recalcularTotal(); 
                return;
            }

            const pu = parseFloat(puStr);
            const pg = parseFloat(pgVal);

            if (!isNaN(pu) && pu >= 0 && !isNaN(pg) && pg >= 0) {
                this.precio_unitario_ganancia = (pu * (1 + pg / 100)).toFixed(2);
            } else {
                console.warn('Valores inválidos para calcular precio_unitario_ganancia:', pu, pg);
                this.precio_unitario_ganancia = ''; 
            }
            this.recalcularTotal(); 
        },

        // Función para recalcular el precio_total (ahora basado en precio_unitario_ganancia)
        recalcularTotal: function() {
            const pgVal = String(this.precio_unitario_ganancia).trim(); 
            const cantStr = String(this.cantidad).trim();

            if (pgVal === '' || cantStr === '') {
                this.precio_total = '';
                return;
            }

            const pg = parseFloat(pgVal);
            const cant = parseFloat(cantStr);

            if (!isNaN(pg) && pg >= 0 && !isNaN(cant) && cant >= 0) {
                this.precio_total = (pg * cant).toFixed(2);
            } else {
                this.precio_total = ''; 
            }
        },

        // Función para leer los inputs del DOM y actualizar las variables Alpine.
        // Se llama cuando el formulario se muestra o cuando cambian campos que lo requieren.
        sincronizarYRecalcular: function() {
            const puInput = document.getElementById('precio_unitario');
            const pgInput = document.getElementById('porcentaje_ganancia');
            const ptInput = document.getElementById('precio_total');
            const cantInput = document.getElementById('cantidad');

            if (puInput) {
                this.precio_unitario = puInput.value; 
            }
            // Sincronizar porcentaje_ganancia:
            // Lee el valor del DOM. Si el input está vacío, this.porcentaje_ganancia será '',
            // lo cual es deseable para que la lógica de valor por defecto pueda aplicarse.
            if (pgInput) { 
                this.porcentaje_ganancia = pgInput.value;
            }
            if (cantInput) {
                this.cantidad = cantInput.value;
            }
            
            if (this.porcentaje_ganancia instanceof HTMLElement) {
                console.warn('Reiniciando porcentaje_ganancia, estaba contaminado con un input');
                this.porcentaje_ganancia = ''; // o 0, como lo tengas inicialmente
            }
            if (ptInput) {
                this.precio_total = ptInput.value; 
            }
            this.calcularPrecioConGanancia();
        },

        handleRecursoChange: function() {
            this.$nextTick(() => {
                this.sincronizarYRecalcular();
            });
        },

        // Función para limpiar y ocultar el formulario.
        resetAndHideForm: function() {
            this.mostrarFormRecursos = false;
            this.precio_unitario = '';
            this.porcentaje_ganancia = 0; // Restablecer a 0 para una nueva entrada limpia
            this.precio_unitario_ganancia = '';    
            this.cantidad = '';
            this.precio_total = '';
            const form = document.getElementById('cotizacionesrecursosForm');
            if (form) {
                form.reset(); // También limpiar los campos del formulario
            }
            this.$dispatch('reset-form-fields', { formId: 'cotizacionesrecursosForm' });
        }
    }"
    x-init="
        // Observar cambios en precio_unitario y porcentaje_ganancia para recalcular precio_unitario_ganancia
        $watch('precio_unitario', () => calcularPrecioConGanancia());
        $watch('porcentaje_ganancia', (value) => {
            if (value !== '' && value !== null) {
                calcularPrecioConGanancia();
            }
        });
        $watch('cantidad', () => recalcularTotal());

        // Sincronización inicial al cargar el componente.
        $nextTick(() => {
            sincronizarYRecalcular(); 
        });
    "
    @update-alpine-tabs.window="
        isEditing = $event.detail.isEditing; 

        if (isEditing && $event.detail.tab === 'recursos' && $event.detail.data) {
            sincronizarYRecalcular();
        }
    "
    x-on:show-form-recurso.window="
        reiniciarFormulario = true; 
        
        if (this.porcentaje_ganancia instanceof HTMLElement) {
            this.porcentaje_ganancia = 0;
        }
        
        if ($event?.detail?.isEditing !== undefined) {
            isEditing = $event.detail.isEditing;
        }
        
        $nextTick(() => {
            reiniciarFormulario = false;
            mostrarFormRecursos = true;
            
            $nextTick(() => {
                if (!isEditing && this._pendingPorcentajeGananciaDefault !== null && 
                    (porcentaje_ganancia == 0 || porcentaje_ganancia == '')) {
                    porcentaje_ganancia = this._pendingPorcentajeGananciaDefault;
                    this._pendingPorcentajeGananciaDefault = null;
                }
                calcularPrecioConGanancia();
            });
        });
    "
    x-on:hide-form-recurso.window="resetAndHideForm()"
    x-on:recurso-form-cancel.window="resetAndHideForm()"
    {{-- Solo almacena el valor por defecto. Se aplicará cuando el formulario se muestre con 'show-form-recurso.window'. --}}
    x-on:recursos-porcentaje-ganancia-default-actualizado.window="
        this._pendingPorcentajeGananciaDefault = $event.detail.defaultPorcentaje;
    "
>
    <div x-show="!mostrarFormRecursos" x-transition class="overflow-x-auto">
        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="cotizacionesrecursosTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="mostrarFormRecursos && !reiniciarFormulario" x-transition class="mb-4">
        <form id="cotizacionesrecursosForm" method="POST" >
            @csrf
            <div class="grid grid-cols-1 gap-2">
                <div class="grid grid-cols-1 lg:grid-cols-10 gap-2">
                    <div class="col-span-2 p-1 rounded-lg ">
                        <x-form-select
                            label="Tipo Recurso"
                            name="tipo_recurso_id"
                            id="tipo_recurso_id"
                            table="tiposrecursos"
                            valueField="tipo_recurso_id"
                            labelField="nombre"
                            :where="['estado' => 'A']"
                            :orderBy="['nombre', 'asc']"
                            placeholder="Seleccione un Tipo Recurso"
                            required
                        />
                    </div>
                
                    <div class="col-span-4 p-1 rounded-lg ">
                        <x-form-select
                            label="Recurso"
                            name="recurso_id"
                            id="recurso_id"
                            table="vw_recursos"
                            valueField="recurso_id"
                            labelField="nombre"
                            parentIdField="tipo_recurso_id"
                            :where="['estado' => 'A']"
                            :orderBy="['nombre', 'asc']"
                            placeholder="Seleccione un Recurso"
                            :populateFields="[
                                ['source_key' => 'unidad_medida_id', 'target_id' => 'unidad_medida_id'],
                                ['source_key' => 'precio_unitario',  'target_id' => 'precio_unitario']
                            ]"
                            x-on:change="handleRecursoChange()"
                            required
                        />
                    </div>

                    <div class="col-span-4 p-1 rounded-lg ">
                        <x-form-select
                            label="Proveedor"
                            name="proveedor_id"
                            id="proveedor_id"
                            table="vw_recursosproveedores"
                            valueField="proveedor_id"
                            labelField="proveedor_precio_nombre"
                            :parentIdField="['tipo_recurso_id', 'recurso_id']"
                            :where="['estado' => 'A']"
                            :orderBy="['nombre', 'asc']"
                            placeholder="Seleccione un Proveedor"
                            :populateFields="[
                                ['source_key' => 'precio_recurso_proveedor',  'target_id' => 'precio_unitario']
                            ]"
                            x-on:change="handleRecursoChange()"
                        />
                    </div>
                </div>
                {{-- fila 2 --}}
                <div class="grid grid-cols-1 lg:grid-cols-6 gap-2">
                    <div class="col-span-2 p-1 rounded-lg ">
                        <x-form-select
                            label="Unidad Medida"
                            name="unidad_medida_id"
                            id="unidad_medida_id"
                            table="unidadesmedidas"
                            valueField="unidad_medida_id"
                            labelField="nombre"
                            :where="['estado' => 'A']"
                            :orderBy="['nombre', 'asc']"
                            placeholder="Seleccione una Unidad Medida"
                            required
                        />
                    </div>
                    
                    <div class="col-span-2 p-1 rounded-lg ">
                        <label for="precio_unitario" class="art-label-custom">Precio Unitario</label>
                        <div class="flex mt-1">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-700 bg-gray-300 text-green-900 text-md">$</span>
                            <input type="number" id="precio_unitario" name="precio_unitario" class="art-input-custom rounded-l-none text-right" min="0" step="0.01" required x-model="precio_unitario">
                        </div>
                    </div>

                    <div class="col-span-1 p-1 rounded-lg ">
                        <label for="porcentaje_ganancia" class="art-label-custom">% Ganancia</label>
                        <div class="flex mt-1">
                            <input type="number" id="porcentaje_ganancia" name="porcentaje_ganancia" 
                                x-model="porcentaje_ganancia" class="art-input-custom rounded-r-none text-right" 
                                min="0" max="100" step="0.01" required >
                            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-700 bg-gray-300 text-gray-900 text-md">%</span>
                        </div>
                    </div>

                    <div class="col-span-1 p-1 rounded-lg ">
                        <label for="tiempo_entrega" class="art-label-custom">Tiempo Entrega</label>
                        <div class="flex mt-1">
                            <input type="number" id="tiempo_entrega" name="tiempo_entrega" class="art-input-custom rounded-r-none text-right" min="0" step="1" value="0" required x-model="tiempo_entrega">
                            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-700 bg-gray-300 text-gray-900 text-md">d&iacute;as</span>
                        </div>
                    </div>
                </div>
                {{-- fila 3 --}}
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-2">
                    <div class="col-span-2 p-1 rounded-lg ">
                        <label for="precio_unitario_ganancia" class="art-label-custom">Precio + Ganancia</label>
                        <div class="flex mt-1">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-700 bg-gray-300 text-green-900 text-md">$</span>
                            <input type="number" id="precio_unitario_ganancia" name="precio_unitario_ganancia" class="art-input-custom rounded-l-none text-right" min="0" step="0.01" required x-model.lazy="precio_unitario_ganancia" readonly x-model="precio_unitario_ganancia">
                        </div>
                    </div>

                    <div class="col-span-1 p-1 rounded-lg ">
                        <label for="cantidad" class="art-label-custom">Cantidad</label>
                        <div class="flex mt-1">
                            <input type="number" id="cantidad" name="cantidad" class="art-input-custom rounded-r-none text-right" min="0" step="1" required x-model="cantidad">
                            <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-700 bg-gray-300 text-gray-900 text-md">#</span>
                        </div>
                    </div>

                    <div class="col-span-2 p-1 rounded-lg ">
                        <label for="precio_total" class="art-label-custom">Precio Total</label>
                        <div class="flex mt-1">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-700 bg-gray-300 text-green-900 text-md">$</span>
                            <input type="number" id="precio_total" name="precio_total" class="art-input-custom rounded-l-none text-right bg-gray-100" min="0" step="0.01" x-model="precio_total" readonly required>
                        </div>
                    </div>
                </div>
            </div>
            {{-- fila auditoria --}}
            <x-form-auditoria :showUser="true" />
        </form>

        <x-buttons 
            formId="cotizacionesrecursosForm"
            cancelDispatch="recurso-form-cancel"
        />
    </div>

</div>

<x-info-modal size="md" />
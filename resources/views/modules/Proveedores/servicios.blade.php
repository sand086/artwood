<div id="tab-servicios" data-module="ProveedoresServicios" 
    x-data="{ mostrarFormServicio: false }" 
    x-on:show-form-servicio.window="mostrarFormServicio = true"
    x-on:hide-form-servicio.window="mostrarFormServicio = false"
>

    <div x-show="mostrarFormServicio" x-transition class="mb-4">
        <form id="proveedoresserviciosForm" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-2">
                {{-- fila 1 --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                    <div class="col-span-2 p-1 rounded-lg ">
                        <x-form-select
                            label="Servicio"
                            name="servicio_id"
                            id="servicio_id"
                            table="servicios"
                            valueField="servicio_id"
                            labelField="nombre"
                            :where="['estado' => 'A']"
                            :orderBy="['nombre', 'asc']"
                            placeholder="Seleccione un Servicio"
                            :populateFields="[
                                ['source_key' => 'tiempo', 'target_id' => 'tiempo_servicio'],
                                ['source_key' => 'unidad_medida_id', 'target_id' => 'unidad_medida_id_servicio'],
                                ['source_key' => 'precio',  'target_id' => 'precio_unitario_servicio'],
                                ['source_key' => 'descripcion',  'target_id' => 'descripcion_servicio']
                            ]"
                            required
                        />
                    </div>

                    {{-- <div class="col-span-1 p-1 rounded-lg ">
                        <label for="boton-crear-contacto" class="art-label-custom p-1">&nbsp;</label>
                        <a href="#" @click.prevent="abrirVentana('{{ route('servicios.index') }}', '?openModal=true&windowClose=true')" class="art-btn-secondary ml-2">Crear Servicio</a>
                    </div> --}}
                    <div 
                        class="col-span-1 p-1 rounded-lg"
                        x-data="{ creatingServicio: false }"
                        @popup-closed-without-save.window="if ($event.detail.targetSelectId === 'servicio_id') creatingServicio = false"
                    >
                        <label for="boton-crear-servicio" class="art-label-custom">&nbsp;</label>
                        <a
                            href="{{ route('servicios.index') }}" 
                            data-target-select-id="servicio_id"
                            class="btn-open-popup-creator art-btn-secondary ml-2"
                            @click="creatingServicio = true"
                            :disabled="creatingServicio"
                            :class="{ 'opacity-50 cursor-not-allowed': creatingServicio }"
                        >
                            <span x-show="!creatingServicio">Crear Servicio</span>
                            <span x-show="creatingServicio">Abriendo...</span>
                        </a>
                    </div>
                </div>
                {{-- fila 2 --}}
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                    <div class="col-span-1 p-2 rounded-lg ">
                        <label for="tiempo" class="art-label-custom">Tiempo</label>
                        <input type="number" id="tiempo_servicio" name="tiempo" min="0" step="1" class="art-input-custom text-right" required>
                    </div>

                    <div class="col-span-1 p-2 rounded-lg ">
                        <x-form-select 
                            label="Unidad Medida" 
                            name="unidad_medida_id" 
                            id="unidad_medida_id_servicio"
                            table="unidadesmedidas" 
                            valueField="unidad_medida_id" 
                            labelField="nombre"
                            :where="['estado' => 'A']" 
                            :orderBy="['nombre', 'asc']"
                            placeholder="Seleccione una Unidad Medida" 
                            required
                        />
                    </div>

                    <div class="col-span-1 p-2 rounded-lg ">
                        <label for="precio_unitario" class="art-label-custom">Costo Unitario</label>
                        <div class="flex mt-1">
                            <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-700 bg-gray-300 text-green-900 text-md">$</span>
                            <input type="number" id="precio_unitario_servicio" name="precio_unitario" min="0" step="0.01" class="art-input-custom text-right" required>
                        </div>
                    </div>
                </div>
                {{-- fila 3 --}}
                <div>
                    <label for="descripcion" class="art-label-custom">Descripci&oacute;n</label>
                    <input type="text" id="descripcion_servicio" name="descripcion" class="art-input-custom" required>
                </div>
                {{-- fila 4 --}}
                <div>
                    <label for="detalle" class="art-label-custom">Detalle</label>
                    <input type="text" id="detalle" name="detalle" class="art-input-custom">
                </div>
                {{-- fila auditoria --}}
                <x-form-auditoria/>
            </div>
        </form>

        <x-buttons 
            formId="proveedoresserviciosForm"
            {{-- :showClearButton="true" --}}
            {{-- cancelEvent="mostrarFormServicio = false" --}}
            {{-- cancelEvent="tab = 'servicios'" --}}
            cancelEvent="
                mostrarFormServicio = false;
                {{-- window.Helpers.toggleModal('proveedoresModal'); --}}
                {{-- tab = 'basicos'; --}}
            "
            {{-- saveEvent="
                const form = document.getElementById('proveedoresserviciosForm');
                form.dispatchEvent(new Event('submit'));  // sigue usando BaseModule.js

                // Ahora manejas cómo cierras manualmente la modal/pestaña:
                {{-- mostrarFormServicio = false;  // oculta formulario --}
                // si también deseas cerrar modal, adicionalmente haz:
                {{-- window.Helpers.toggleModal('proveedoresModal'); --}
            " --}}
        />
    </div>

    <div x-show="!mostrarFormServicio" x-transition class="overflow-x-auto">
        <table id="proveedoresserviciosTable" class="min-w-full divide-y divide-gray-200">
            <thead class="art-bg-primary art-text-background">
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                {{-- Datos de la tabla se llenarán con JavaScript --}}
            </tbody>
        </table>
    </div>

</div>

@push('scripts')

@endpush
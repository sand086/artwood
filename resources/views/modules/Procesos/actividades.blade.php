        <div id="tab-actividades" data-module="ProcesosActividades" 
                x-data="{ mostrarFormActividad: false }" 
                x-on:show-form-actividad.window="mostrarFormActividad = true"
                x-on:hide-form-actividad.window="mostrarFormActividad = false"
            >

            <div x-show="mostrarFormActividad" x-transition class="mb-4">
                <form id="procesosactividadesForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        
                            <div>
                                <label for="nombre" class="art-label-custom">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                            </div>
                            
                            <div>
                                <label for="descripcion" class="art-label-custom">Descripcion</label>
                                <input type="text" id="descripcion" name="descripcion" class="art-input-custom" required>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2">
                                <div class="col-span-2 p-2 rounded-lg ">
                                    <x-form-select
                                        label="Area Responsable"
                                        name="area_id"
                                        id="area_id"
                                        table="areas"
                                        valueField="area_id"
                                        labelField="nombre"
                                        :where="['estado' => 'A']"
                                        :orderBy="['nombre', 'asc']"
                                        placeholder="Seleccione un Area"
                                    />
                                </div>
                                                            
                                <div class="col-span-2 p-2 rounded-lg ">
                                    <x-form-select
                                        label="Unidad de Tiempo"
                                        name="unidad_medida_id"
                                        id="unidad_medida_id"
                                        table="unidadesmedidas"
                                        valueField="unidad_medida_id"
                                        labelField="nombre"
                                        :where="['estado' => 'A', 'categoria' => 'TIEMPO']"
                                        :orderBy="['nombre', 'asc']"
                                        placeholder="Seleccione un Unidad de Tiempo"
                                    />
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2">
                                <div class="col-span-2 p-2 rounded-lg ">
                                    <label for="tiempo_estimado" class="art-label-custom">Tiempo Estimado</label>
                                    <input type="number" id="tiempo_estimado" name="tiempo_estimado" min="1" step="1" class="art-input-custom text-right" required>
                                </div>
                                
                                <div class="col-span-2 p-2 rounded-lg ">
                                    <label for="costo_estimado" class="art-label-custom">Costo Estimado</label>
                                    <input type="number" id="costo_estimado" name="costo_estimado" min="0" step="0.01" class="art-input-custom text-right" required>
                                </div>
                            </div>
                            
                            <div>
                                <label for="riesgos" class="art-label-custom">Riesgos</label>
                                <input type="text" id="riesgos" name="riesgos" class="art-input-custom">
                            </div>
                            
                            <div>
                                <label for="observaciones" class="art-label-custom">Observaciones</label>
                                <input type="text" id="observaciones" name="observaciones" class="art-input-custom">
                            </div>
                            
                    </div>
                    <x-form-auditoria/>
                </form>
                <x-buttons 
                    formId="procesosactividadesForm"
                    {{-- :showClearButton="true" --}}
                    {{-- cancelEvent="mostrarFormActividad = false" --}}
                    {{-- cancelEvent="tab = 'productos'" --}}
                    cancelEvent="
                        mostrarFormActividad = false;
                        {{-- window.Helpers.toggleModal('procesosModal'); --}}
                        {{-- tab = 'basicos'; --}}
                    "
                    {{-- saveEvent="
                        const form = document.getElementById('procesosactividadesForm');
                        form.dispatchEvent(new Event('submit'));  // sigue usando BaseModule.js

                        // Ahora manejas cómo cierras manualmente la modal/pestaña:
                        mostrarFormActividad = false;  // oculta formulario
                        // si también deseas cerrar modal, adicionalmente haz:
                        {{-- window.Helpers.toggleModal('procesosModal'); --}
                    " --}}
                    />
            </div>

            <div x-show="!mostrarFormActividad" x-transition class="overflow-x-auto">
                <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
                    <table id="procesosactividadesTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="art-bg-primary art-text-background">
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            {{-- Datos de la tabla se llenarán con JavaScript --}}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

@push('scripts')

@endpush

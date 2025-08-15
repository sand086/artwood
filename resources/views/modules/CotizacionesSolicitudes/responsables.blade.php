        <div id="tab-responsables" data-module="CotizacionesResponsables" 
                x-data="{ mostrarFormResponsable: false }" 
                x-on:show-form-responsable.window="mostrarFormResponsable = true"
                x-on:hide-form-responsable.window="mostrarFormResponsable = false"
            >
            <div x-show="mostrarFormResponsable" x-transition class="mb-4">
                <form id="cotizacionesresponsablesForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <x-form-select
                                label="Empleado"
                                name="empleado_id"
                                id="empleado_id"
                                table="vw_empleados"
                                valueField="empleado_id"
                                labelField="nombre_completo"
                                :where="['estado' => 'A']"
                                :orderBy="['nombre_completo', 'asc']"
                                placeholder="Seleccione un Empleado"
                                required
                            />
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="col-span-2 p-2 rounded-lg ">
                                <x-form-select
                                    label="Area"
                                    name="area_id"
                                    id="area_id"
                                    table="areas"
                                    valueField="area_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Area"
                                    required
                                />
                            </div>
                            
                            <div class="col-span-2 p-2 rounded-lg ">
                                <label for="responsabilidad" class="art-label-custom">Responsabilidad</label>
                                <select id="responsabilidad" name="responsabilidad" class="art-input-custom" required>
                                    <option value="ACTIVIDAD">ACTIVIDAD</option>
                                    <option value="PROCESO">PROCESO</option>
                                    <option value="PROYECTO">PROYECTO</option>
                                </select>
                            </div>
                        </div>
                            
                    </div>
                    <x-form-auditoria :showEstado="true"/>
                </form>
                <x-buttons 
                    formId="cotizacionesresponsablesForm"
                    {{-- :showClearButton="true" --}}
                    {{-- cancelEvent="mostrarFormResponsable = false" --}}
                    {{-- cancelEvent="tab = 'productos'" --}}
                    cancelEvent="
                        mostrarFormResponsable = false;
                        {{-- window.Helpers.toggleModal('procesosModal'); --}}
                        {{-- tab = 'basicos'; --}}
                    "
                    {{-- saveEvent="
                        const form = document.getElementById('procesosactividadesForm');
                        form.dispatchEvent(new Event('submit'));  // sigue usando BaseModule.js

                        // Ahora manejas cómo cierras manualmente la modal/pestaña:
                        mostrarFormResponsable = false;  // oculta formulario
                        // si también deseas cerrar modal, adicionalmente haz:
                        {{-- window.Helpers.toggleModal('procesosModal'); --}
                    " --}}
                />
            </div>

            <div x-show="!mostrarFormResponsable" x-transition class="overflow-x-auto">
                <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
                    <table id="cotizacionesresponsablesTable" class="min-w-full divide-y divide-gray-200">
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

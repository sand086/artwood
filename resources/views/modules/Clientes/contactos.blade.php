        <div id="tab-contactos" data-module="ClientesContactos" 
                x-data="{ mostrarFormContacto: false }" 
                x-on:show-form-contacto.window="mostrarFormContacto = true"
                x-on:hide-form-contacto.window="mostrarFormContacto = false"
            >

            <div x-show="mostrarFormContacto" x-transition class="mb-4">
                <form id="clientescontactosForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-2">
                        {{-- fila 1 --}}
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                            <div class="col-span-2 p-2 rounded-lg ">
                                <x-form-select
                                    label="Contacto"
                                    name="persona_id"
                                    id="persona_id"
                                    table="vw_contactos"
                                    valueField="persona_id"
                                    labelField="nombre_completo"
                                    :where="['estado' => 'A', 'empleado_id' => 'IS NULL']"
                                    :orderBy="['nombre_completo', 'asc']"
                                    placeholder="Seleccione un Contacto"
                                    :populateFields="[
                                        ['source_key' => 'telefono', 'target_id' => 'telefono_empresarial'],
                                        ['source_key' => 'correo_electronico',  'target_id' => 'correo_electronico_empresarial']
                                    ]"
                                    required
                                />
                            </div>

                            <div class="col-span-1 p-2 rounded-lg "
                                x-data="{ creatingContacto: false }"
                                @popup-closed-without-save.window="if ($event.detail.targetSelectId === 'persona_id') creatingContacto = false"
                            >
                                <label for="boton-crear-contacto" class="art-label-custom">&nbsp;</label>
                                <a 
                                    {{-- href="#" @click.prevent="abrirVentana('{{ route('personas.create') }}', '?openModal=true&windowClose=true')" class="art-btn-secondary ml-2" --}}
                                    href="{{ route('personas.create') }}" 
                                    data-target-select-id="persona_id"
                                    class="btn-open-popup-creator art-btn-secondary ml-2"
                                    @click="creatingContacto = true"
                                    :disabled="creatingContacto"
                                    :class="{ 'opacity-50 cursor-not-allowed': creatingContacto }"
                                >
                                    <span x-show="!creatingContacto">Crear Contacto</span>
                                    <span x-show="creatingContacto">Abriendo...</span>
                                </a>
                            </div>
                        </div>
                        {{-- fila 2 --}}
                        <div>
                            <label for="cargo" class="art-label-custom">Cargo</label>
                            <input type="text" id="cargo" name="cargo" class="art-input-custom" >
                        </div>
                        {{-- fila 3 --}}
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                            <div class="col-span-1 p-1 rounded-lg ">
                                <label for="telefono" class="art-label-custom">Telefono Empresarial</label>
                                <input type="text" id="telefono_empresarial" name="telefono" class="art-input-custom" required>
                            </div>
                            
                            <div class="col-span-2 p-1 rounded-lg ">
                                <label for="correo_electronico" class="art-label-custom">Correo Electronico Empresarial</label>
                                <input type="text" id="correo_electronico_empresarial" name="correo_electronico" class="art-input-custom" required>
                            </div>
                        </div>
                        {{-- fila 4 --}}
                        <div>
                            <label for="observaciones" class="art-label-custom">Observaciones</label>
                            <input type="text" id="observaciones" name="observaciones" class="art-input-custom">
                        </div>
                        <x-form-auditoria/>
                    </div>
                </form>

                <x-buttons 
                    formId="clientescontactosForm"
                    {{-- :showClearButton="true" --}}
                    {{-- cancelEvent="mostrarFormContacto = false" --}}
                    {{-- cancelEvent="tab = 'productos'" --}}
                    cancelEvent="
                        mostrarFormContacto = false;
                        {{-- window.Helpers.toggleModal('clientesModal'); --}}
                        {{-- tab = 'basicos'; --}}
                    "
                    saveEvent="
                        const form = document.getElementById('clientescontactosForm');
                        form.dispatchEvent(new Event('submit'));  // sigue usando BaseModule.js
                        mostrarFormContacto = false;
                    "
                    {{-- saveDataAction="clientescontactos.store" --}}
                    {{-- saveEvent="window.Helpers.saveForm('clientescontactosForm', 'clientescontactosTable'); mostrarFormContacto = false;" --}}
                    {{-- saveEvent="
                        const form = document.getElementById('clientescontactosForm');
                        form.dispatchEvent(new Event('submit'));  // sigue usando BaseModule.js

                        // Ahora manejas cómo cierras manualmente la modal/pestaña:
                        mostrarFormContacto = false;  // oculta formulario
                        // si también deseas cerrar modal, adicionalmente haz:
                        {{-- window.Helpers.toggleModal('clientesModal'); --}
                    " --}}
                />
            </div>

            <div x-show="!mostrarFormContacto" x-transition class="overflow-x-auto">
                <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
                    <table id="clientescontactosTable" class="min-w-full divide-y divide-gray-200">
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

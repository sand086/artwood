            <div 
                x-data="{ 
                    handleClientCreated(event) {
                        const newClient = event.detail;
                        const clienteSelect = document.getElementById('cliente_id'); // ID de tu select de clientes
                        if (clienteSelect) {
                            // Añadir la nueva opción al select
                            const option = document.createElement('option');
                            option.value = newClient.id;
                            option.text = newClient.name; // Asumiendo que 'name' es el campo de texto
                            
                            // Evitar duplicados si el cliente ya existe en el select
                            let exists = Array.from(clienteSelect.options).some(opt => opt.value == newClient.id);
                            if (!exists) {
                                // Añadir después del placeholder o como primera opción si no hay placeholder
                                clienteSelect.add(option, clienteSelect.options[1] || null); 
                            }
                            clienteSelect.value = newClient.id; // Seleccionar el nuevo cliente

                            // Importante: Disparar evento 'change' para que otros componentes (ej. TomSelect) reaccionen
                            clienteSelect.dispatchEvent(new Event('change', { bubbles: true }));
                        }
                        // El modal se cierra solo al escuchar 'quick-client-success'
                    } 
                }"
                @quick-save-client-data.window="Artwood.CotizacionesSolicitudes.saveQuickClient($event.detail, '{{ route('quick.client.contact.store') }}')"
            >
                <form id="cotizacionessolicitudesForm" method="POST" @client-created.window="handleClientCreated($event)">
                    @csrf
                    <div class="grid grid-cols-1 gap-2">
                        {{-- fila 1 --}}
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-10 lg:grid-cols-10 gap-2">
                            <div class="col-span-4 p-1 rounded-lg ">
                                <x-form-select
                                    label="Cliente / Prospecto"
                                    name="cliente_id"
                                    id="cliente_id"
                                    table="clientes"
                                    valueField="cliente_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Cliente"
                                    elemGroupType="button"
                                    elemGroupContent='<i data-lucide="plus" class="w-4 h-4"></i>'
                                    elemGroupEvent="$dispatch('open-quick-client-modal')"
                                    elemGroupTitle="Crear Cliente/Prospecto Rápido"
                                    required
                                />
                            </div>
                            {{-- <div class="col-span-1 p-1 rounded-lg flex items-end">
                                <button type="button" @click.prevent="$dispatch('open-quick-client-modal')" class="art-btn-secondary ml-2 p-1 leading-none" title="Crear Cliente/Prospecto Rápido">+</button>
                            </div> --}}
                            <div class="col-span-2 p-1 rounded-lg ">
                                <label for="consecutivo" class="art-label-custom">Consecutivo</label>
                                <input type="text" name="consecutivo" id="consecutivo" 
                                    class="art-input-custom text-right h-10 bg-gray-200"
                                {{-- x-bind:value="analisis.cotizacion ? analisis.cotizacion.cotizacion_solicitud_id : analisis.cotizacion_solicitud_id" --}}
                                    readonly>
                                {{-- <p class="text-gray-700">
                                    <span class="font-semibold" x-text="analisis.cotizacion_solicitud ? analisis.cotizacion_solicitud.nombre_proyecto : ''"></span>
                                </p> --}}
                            </div>

                            <div class="col-span-2 p-1 rounded-lg ">
                                <x-form-select
                                    label="Tipo Solicitud"
                                    name="tipo_solicitud_id"
                                    id="tipo_solicitud_id"
                                    table="tipossolicitudes"
                                    valueField="tipo_solicitud_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Tipo Solicitud"
                                    required
                                />
                            </div>

                            <div class="col-span-2 p-1 rounded-lg ">
                                <label for="control_version" class="art-label-custom">Control Versi&oacute;n 
                                    <span class="text-red-500">&nbsp;*</span>
                                </label>
                                <input type="number" id="control_version" name="control_version" min="1" step="1" class="art-input-custom text-right h-10" value="1" required>
                            </div>
                        </div>
                        {{-- fila 2 --}}
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-7 lg:grid-cols-7 gap-4">
                            <div class="col-span-3 p-1 rounded-lg ">
                                <label for="nombre_proyecto" class="art-label-custom">Nombre Proyecto
                                    <span class="text-red-500">&nbsp;*</span>
                                </label>
                                <input type="text" id="nombre_proyecto" name="nombre_proyecto" class="art-input-custom" required>
                            </div>

                            <div class="col-span-2 p-1 rounded-lg ">
                                <label for="fecha_estimada" class="art-label-custom">Fecha Estimada
                                    <span class="text-red-500">&nbsp;*</span>
                                </label>
                                <input type="date" id="fecha_estimada" name="fecha_estimada" class="art-input-custom" required>
                            </div>

                            <div class="col-span-2 p-1 rounded-lg ">
                                <x-form-select
                                    label="Fuente"
                                    name="fuente_id"
                                    id="fuente_id"
                                    table="fuentes"
                                    valueField="fuente_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione una Fuente"
                                    required
                                />
                            </div>
                        </div>
                        {{-- fila 3 --}}
                        <div>
                            <label for="descripcion" class="art-label-custom">Descripci&oacute;n
                                <span class="text-red-500">&nbsp;*</span>
                            </label>
                            <input type="text" id="descripcion" name="descripcion" class="art-input-custom" required>
                        </div>
                        {{-- fila 4 --}}
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="col-span-2 p-1 rounded-lg ">
                                <x-form-select
                                    label="Usuario"
                                    name="usuario_id"
                                    id="usuario_id"
                                    table="usuarios"
                                    valueField="usuario_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Usuario"
                                    required
                                />
                            </div>
                            
                            <div class="col-span-2 p-1 rounded-lg ">
                                <x-form-select
                                    label="Estado"
                                    name="estado_id"
                                    id="estado_id"
                                    table="estadosgenerales"
                                    valueField="estado_general_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A', 'categoria' => 'SOLICITUD']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Estado"
                                    value="1" {{-- Estado por defecto --}}
                                    required
                                />
                            </div>
                        </div>
                                                        
                    </div>
                    <x-form-auditoria :showStatus="false" />
                </form>
                <x-buttons 
                    formId="cotizacionessolicitudesForm" 
                    saveEvent="
                        const form = document.getElementById('cotizacionessolicitudesForm');
                        form.dispatchEvent(new Event('submit'));  // sigue usando BaseModule.js
                        {{-- tab = 'actividades'; --}}
                    "
                />
                <x-form-create-prospecto />
            </div>

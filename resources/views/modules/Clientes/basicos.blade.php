                <form id="clientesForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-2">
                        {{-- fila 1 --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-1">
                            <div class="col-span-2 p-1 rounded-lg ">
                                <label for="nombre" class="art-label-custom">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                            </div>

                            <div class="col-span-1 p-1 rounded-lg ">
                                <label for="rfc" class="art-label-custom">RFC</label>
                                <input type="text" id="rfc" name="rfc" class="art-input-custom text-center" >
                            </div>
                            
                            <div class="col-span-1 p-1 rounded-lg ">
                                <x-form-select
                                    label="Tipo"
                                    name="tipo_cliente_id"
                                    id="tipo_cliente_id"
                                    table="tiposclientes"
                                    valueField="tipo_cliente_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Tipo"
                                    :value="$cliente->tipo_cliente_id ?? old('tipo_cliente_id', '')"
                                    required
                                />
                            </div>
                            <div class="col-span-1 p-1 rounded-lg ">
                                <label for="clase" class="art-label-custom">Clase</label>
                                <select id="clase" name="clase" class="art-input-custom" required>
                                    <option value="CLIENTE" selected>CLIENTE</option>
                                    <option value="PROSPECTO">PROSPECTO</option>
                                </select>
                            </div>
                        </div>
                        {{-- fila 2 --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-1">
                            <div class="col-span-2 p-2 rounded-lg ">
                                <label for="direccion" class="art-label-custom">Direccion</label>
                                <input type="text" id="direccion" name="direccion" class="art-input-custom" required>
                            </div>
                            <div class="col-span-2 p-2 rounded-lg ">
                                <label for="colonia" class="art-label-custom">Colonia</label>
                                <input type="text" id="colonia" name="colonia" class="art-input-custom">
                            </div>
                        </div>
                        {{-- fila 3 --}}
                        <div class="grid grid-cols-1 lg:grid-cols-6 gap-2">
                            <div class="col-span-1 p-2 rounded-lg ">
                                <label for="telefono" class="art-label-custom">Telefono</label>
                                <input type="text" id="telefono" name="telefono" class="art-input-custom" required>
                            </div>

                            <div class="col-span-1 p-2 rounded-lg ">
                                <label for="codigo_postal" class="art-label-custom">C&oacute;digo Postal</label>
                                <input type="text" id="codigo_postal" name="codigo_postal" class="art-input-custom text-center">
                            </div>

                            <div class="col-span-2 p-2 rounded-lg ">
                                <x-form-select
                                    label="Estado Pais"
                                    name="estado_pais_id"
                                    id="estado_pais_id"
                                    table="estadospaises"
                                    valueField="estado_pais_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Estado Pais"
                                    :value="$cliente->estado_pais_id ?? old('estado_pais_id', '')"
                                    required
                                />
                            </div>

                            <div class="col-span-2 p-2 rounded-lg ">
                                <x-form-select
                                    label="Municipio"
                                    name="municipio_id"
                                    id="municipio_id"
                                    table="municipios"
                                    valueField="municipio_id"
                                    labelField="nombre"
                                    parentIdField="estado_pais_id"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Municipio"
                                    :value="$cliente->municipio_id ?? old('municipio_id', '')"
                                    required
                                />
                            </div>
                        </div>
                        {{-- fila 4 --}}
                        <div class="grid grid-cols-1 gap-2">
                            <label for="sitio_web" class="art-label-custom">Sitio Web</label>
                            <input type="text" id="sitio_web" name="sitio_web" class="art-input-custom" required>
                        </div>
                        {{-- fila 5 --}}
                        <div class="grid grid-cols-1 gap-2">
                            <label for="notas_adicionales" class="art-label-custom">Notas Adicionales</label>
                            <input type="text" id="notas_adicionales" name="notas_adicionales" class="art-input-custom" required>
                        </div>
                        {{-- fila 6 - datos auditoria --}}
                        <x-form-auditoria :showUser="true" />
                    </div>
                </form>

                <x-buttons 
                    formId="clientesForm" 
                    saveEvent="
                        const form = document.getElementById('clientesForm');
                        form.dispatchEvent(new Event('submit'));  // sigue usando BaseModule.js
                    "
                />

            <form id="proveedoresForm" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-1">
                    {{-- fila 1 --}}
                    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-2">
                        <div class="col-span-3 p-1 rounded-lg ">
                            <label for="nombre" class="art-label-custom">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                        </div>

                        <div class="col-span-1 p-1 rounded-lg ">
                            <label for="rfc" class="art-label-custom">RFC</label>
                            <input type="text" id="rfc" name="rfc" class="art-input-custom text-center" >
                        </div>

                        <div class="col-span-1 p-1 rounded-lg ">
                            <label for="tipo" class="art-label-custom">Tipo</label>
                            {{-- <input type="text" id="tipo" name="tipo" class="art-input-custom" required> --}}
                            <select id="tipo" name="tipo" class="art-input-custom" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="PERSONA">Persona</option>
                                <option value="EMPRESA">Empresa</option>
                            </select>
                        </div>
                    </div>
                    {{-- fila 2 --}}
                    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-4 lg:grid-cols-10 gap-2">
                        <div class="col-span-4 p-1 rounded-lg ">
                            <label for="direccion" class="art-label-custom">Direcci&oacute;n</label>
                            <input type="text" id="direccion" name="direccion" class="art-input-custom" required>
                        </div>

                        <div class="col-span-4 p-1 rounded-lg ">
                            <label for="colonia" class="art-label-custom">Colonia</label>
                            <input type="text" id="colonia" name="colonia" class="art-input-custom">
                        </div>

                        <div class="col-span-2 p-1 rounded-lg ">
                            <label for="telefono" class="art-label-custom">Tel&eacute;fono</label>
                            <input type="text" id="telefono" name="telefono" class="art-input-custom" required>
                        </div>
                    </div>
                    {{-- fila 3 --}}
                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-5 gap-2">
                        <div class="col-span-1 p-1 rounded-lg ">
                            <label for="codigo_postal" class="art-label-custom">C&oacute;digo Postal</label>
                            <input type="text" id="codigo_postal" name="codigo_postal" class="art-input-custom text-center">
                        </div>

                        <div class="col-span-2 p-1 rounded-lg ">
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
                                :value="$proveedor->estado_pais_id ?? old('estado_pais_id', '')"
                                required
                            />
                        </div>

                        <div class="col-span-2 p-1 rounded-lg ">
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
                                :value="$proveedor->municipio_id ?? old('municipio_id', '')"
                                required
                            />
                        </div>

                        {{-- <div>
                            <x-form-select
                                label="Colonia"
                                name="colonia_id"
                                id="colonia_id"
                                table="colonias"
                                valueField="colonia_id"
                                labelField="nombre"
                                parentIdField="municipio_id"
                                :where="['estado' => 'A']"
                                :orderBy="['nombre', 'asc']"
                                placeholder="Seleccione una Colonia"
                                :value="$proveedor->colonia_id ?? old('colonia_id', '')"
                            />
                        </div> --}}
                        {{-- <div class="bg-gray-100 p-4 rounded-lg shadow">Columna 4</div> --}}
                    </div>
                    {{-- fila 4 --}}
                    <div class="grid grid-cols-1 gap-2">
                        <div class="col-span-1 p-1 rounded-lg ">
                            <label for="sitio_web" class="art-label-custom">Sitio Web</label>
                            <input type="text" id="sitio_web" name="sitio_web" class="art-input-custom" required>
                        </div>
                    </div>
                    {{-- fila 5 --}}
                    <div class="grid grid-cols-1 gap-2">
                        <div class="col-span-1 p-1 rounded-lg ">
                            <label for="notas_adicionales" class="art-label-custom">Notas Adicionales</label>
                            <input type="text" id="notas_adicionales" name="notas_adicionales" class="art-input-custom" required>
                        </div>
                    </div>
                    {{-- fila auditoria --}}
                    <x-form-auditoria :showUser="true" />
                </div>
            </form>

            <x-buttons 
                formId="proveedoresForm" 
                saveEvent="
                    const form = document.getElementById('proveedoresForm');
                    form.dispatchEvent(new Event('submit'));  // sigue usando BaseModule.js
                    {{-- tab = 'contactos'; --}}
                "
            />

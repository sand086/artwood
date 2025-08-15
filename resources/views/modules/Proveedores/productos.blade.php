<div id="tab-productos" data-module="ProveedoresProductos" 
    x-data="{ mostrarFormProducto: false }" 
    x-on:show-form-producto.window="mostrarFormProducto = true"
    x-on:hide-form-producto.window="mostrarFormProducto = false"
>

    <div x-show="mostrarFormProducto" x-transition class="mb-4">
        <form id="proveedoresproductosForm" method="POST">
            @csrf
            <div class="grid grid-cols-1 gap-2">
                <div class="grid grid-cols-1 lg:grid-cols-6 gap-2">
                    <div class="col-span-3 p-1 rounded-lg ">
                        <x-form-select
                            label="Producto"
                            name="producto_id"
                            id="producto_id"
                            table="productos"
                            valueField="producto_id"
                            labelField="nombre"
                            :where="['estado' => 'A']"
                            :orderBy="['nombre', 'asc']"
                            placeholder="Seleccione un Producto"
                            :populateFields="[
                                ['source_key' => 'unidad_medida_id', 'target_id' => 'unidad_medida_id_producto'],
                                ['source_key' => 'precio_unitario',  'target_id' => 'precio_unitario_producto'],
                                ['source_key' => 'descripcion',  'target_id' => 'descripcion_producto']
                            ]"
                            required
                        />
                    </div>

                    <div 
                        class="col-span-2 p-1 rounded-lg"
                        x-data="{ creatingProducto: false }"
                        @popup-closed-without-save.window="if ($event.detail.targetSelectId === 'producto_id') creatingProducto = false"
                    >
                        <label for="boton-crear-producto" class="art-label-custom">&nbsp;</label>
                        <a
                            href="{{ route('productos.index') }}" 
                            data-target-select-id="producto_id"
                            class="btn-open-popup-creator art-btn-secondary ml-2"
                            @click="creatingProducto = true"
                            :disabled="creatingProducto"
                            :class="{ 'opacity-50 cursor-not-allowed': creatingProducto }"
                        >
                            <span x-show="!creatingProducto">Crear Producto</span>
                            <span x-show="creatingProducto">Abriendo...</span>
                        </a>
                    </div>

                    <div class="col-span-1 p-1 rounded-lg ">
                        <label for="stock" class="art-label-custom">Stock</label>
                        <input type="number" id="stock" name="stock" min="0" step="1" value="0" class="art-input-custom text-right" required>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">
                    <div class="col-span-1 p-2 rounded-lg ">
                        <x-form-select 
                            label="Unidad Medida" 
                            name="unidad_medida_id" 
                            id="unidad_medida_id_producto"
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
                            <input type="number" id="precio_unitario_producto" name="precio_unitario" min="0" step="0.01" class="art-input-custom rounded-l-none text-right" required>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label for="descripcion" class="art-label-custom">Descripci&oacute;n</label>
                    <input type="text" id="descripcion_producto" name="descripcion" class="art-input-custom" required>
                </div>
                
                <div>
                    <label for="detalle" class="art-label-custom">Detalle</label>
                    <input type="text" id="detalle" name="detalle" class="art-input-custom">
                </div>
                {{-- fila auditoria --}}
                <x-form-auditoria/>
            </div>
        </form>

        <x-buttons 
            formId="proveedoresproductosForm"
            {{-- :showClearButton="true" --}}
            {{-- cancelEvent="mostrarFormProducto = false" --}}
            {{-- cancelEvent="tab = 'productos'" --}}
            cancelEvent="
                mostrarFormProducto = false;
                {{-- window.Helpers.toggleModal('proveedoresModal'); --}}
                {{-- tab = 'basicos'; --}}
            "
            {{-- saveEvent="
                const form = document.getElementById('proveedoresproductosForm');
                form.dispatchEvent(new Event('submit'));  // sigue usando BaseModule.js

                // Ahora manejas cómo cierras manualmente la modal/pestaña:
                {{-- mostrarFormProducto = false;  // oculta formulario --}
                // si también deseas cerrar modal, adicionalmente haz:
                {{-- window.Helpers.toggleModal('proveedoresModal'); --}
            " --}}
        />
    </div>

    <div x-show="!mostrarFormProducto" x-transition class="overflow-x-auto">
        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="proveedoresproductosTable" class="min-w-full divide-y divide-gray-200">
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
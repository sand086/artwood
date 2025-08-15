
        <div id="analisisContainer" x-show="mostrarFormAnalisis" x-transition
            x-data="{
                mostrarFormAnalisis: true,
                tiempoTotalAnalisis: 0,
                costoTotalAnalisis: 0,
                _costo_subtotal_raw: 0.00,
                costo_subtotal: 0.00,
                impuesto_iva: 0.00,
                costo_total: 0.00,
                _pendingImpuestoIvaDefault: null,

                calcularCostoTotal() {
                    const iva = parseFloat(this.impuesto_iva) || 0.00;
                    const subtotal = parseFloat(this.costo_subtotal) || 0.00;
                    this.costo_total = (subtotal + (subtotal * iva / 100)).toFixed(2);
                }

            }"
            @analisis-tiempo-total-actualizado.window="tiempoTotalAnalisis = $event.detail.tiempoTotal"
            @analisis-costo-total-actualizado.window="
                costo_subtotal = $event.detail.costoSubtotal;
                costo_total = $event.detail.costoTotal;
                
                if (!Alpine.store('tabPendingData')) {
                    Alpine.store('tabPendingData', {});
                }
                
                $store.tabPendingData = {
                    costoSubtotal: $event.detail.costoSubtotal,
                    costoTotal: $event.detail.costoTotal
                };
            " 
            {{-- class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto my-8" --}}
            @update-alpine-tabs.window="
                isEditing = $event.detail.isEditing;

                if ($event.detail.tab === 'analisis') {
                    const data = Alpine.store('tabPendingData');
                    if (data) {
                        costo_subtotal = data.costoSubtotal;
                        costo_total = data.costoTotal;

                        // Limpia para que no se vuelva a aplicar
                        Alpine.store('tabPendingData').analisis = null;
                    }
                }
            "
            x-on:show-form-analisis.window="
                {{-- reiniciarFormulario = false; --}}
                mostrarFormAnalisis = true;
                
                $nextTick(() => {
                    if (!isEditing && this._pendingImpuestoIvaDefault !== null && (impuesto_iva == '0.00' || impuesto_iva == '')) {
                        impuesto_iva = this._pendingImpuestoIvaDefault;
                        {{-- this._pendingImpuestoIvaDefault = null; --}}
                        {{-- calcularPrecioConGanancia(); --}}
                    } else {
                        impuesto_iva = $event.detail.impuesto_iva || 0.00;
                        costo_subtotal = $event.detail.costo_subtotal || 0.00;
                    }
                });
            "
            x-on:analisis-impuesto-iva-default-actualizado.window="
                this._pendingImpuestoIvaDefault = $event.detail.defaultIva;
                impuesto_iva = this._pendingImpuestoIvaDefault;
            "
            >
            <form id="cotizacionesanalisisForm" method="POST">
                @csrf
                <div class="grid grid-cols-1 gap-2">
                    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-6 lg:grid-cols-6 gap-2">
                        <div class="col-span-3 p-2 rounded-lg ">
                            <x-form-select
                                label="Solicitud"
                                name="cotizacion_solicitud_id"
                                id="cotizacion_solicitud_id"
                                table="cotizacionessolicitudes"
                                valueField="cotizacion_solicitud_id"
                                labelField="consecutivo"
                                :where="['estado' => 'A', 'estado_id' => 2]"
                                :orderBy="['consecutivo', 'asc']"
                                placeholder="Seleccione una Solicitud"
                                required
                            />
                        </div>

                        <div class="col-span-2 p-2 rounded-lg ">
                            <x-form-select
                                label="Tipo Proyecto"
                                name="tipo_proyecto_id"
                                id="tipo_proyecto_id"
                                table="tiposproyectos"
                                valueField="tipo_proyecto_id"
                                labelField="nombre"
                                :where="['estado' => 'A']"
                                :orderBy="['nombre', 'asc']"
                                placeholder="Seleccione un Tipo Proyecto"
                                required
                            />
                        </div>

                        <div class="col-span-1 p-2 rounded-lg ">
                            <label for="control_version" class="art-label-custom">Control Version</label>
                            <input type="number" id="control_version" name="control_version" class="art-input-custom text-right" min="1" step="1" value="1" required>
                        </div>
                    </div>
                        
                    <div>
                        <label for="descripcion_solicitud" class="art-label-custom">Descripci&oacute;n de la Solicitud</label>
                        <input type="text" id="descripcion_solicitud" name="descripcion_solicitud" class="art-input-custom">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-4 lg:grid-cols-10 gap-2">                        
                        <div class="col-span-2 p-1 rounded-lg ">
                            <label for="tiempo_total" class="art-label-custom">Tiempo Entrega</label>
                            <div class="flex mt-1">
                                <input type="number" id="tiempo_total" name="tiempo_total" 
                                    x-model="tiempoTotalAnalisis"
                                    class="art-input-custom rounded-r-none text-right" 
                                    value="0" step="1" min="0">
                                <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-700 bg-gray-300 text-gray-900 text-md">dias</span>
                            </div>
                        </div>

                        <div class="col-span-3 p-1 rounded-lg ">
                            <label for="costo_subtotal" class="art-label-custom">Costo SubTotal</label>
                            <div class="flex mt-1">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-700 bg-gray-300 text-green-900 text-md">$</span>
                                <input type="number" id="costo_subtotal" name="costo_subtotal" 
                                    x-model="costo_subtotal" 
                                    @input="calcularCostoTotal()"
                                    class="art-input-custom rounded-l-none text-right" 
                                    value="0.00" step="0.01" min="0">
                            </div>
                        </div>

                        <div class="col-span-2 p-1 rounded-lg ">
                            <label for="impuesto_iva" class="art-label-custom">Impuesto IVA</label>
                            <div class="flex mt-1">
                                <input type="number" id="impuesto_iva" name="impuesto_iva" 
                                    class="art-input-custom rounded-r-none text-right" 
                                    x-model="impuesto_iva"
                                    @input="calcularCostoTotal()"
                                    value="0.00" step="0.01" min="0">
                                <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-700 bg-gray-300 text-gray-900 text-md">%</span>
                            </div>
                        </div>

                        <div class="col-span-3 p-1 rounded-lg ">
                            <label for="costo_total" class="art-label-custom">Costo Total</label>
                            <div class="flex mt-1">
                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-700 bg-gray-300 text-green-900 text-md">$</span>
                                <input type="text" id="costo_total" name="costo_total" 
                                    x-model="costo_total" class="art-input-custom rounded-l-none text-right" readonly>
                            </div>
                        </div>

                    </div>

                </div>
                <x-form-auditoria :showUser="true" />
            </form>
            <x-buttons 
                formId="cotizacionesanalisisForm" 
                saveEvent="
                    const form = document.getElementById('cotizacionesanalisisForm');
                    form.dispatchEvent(new Event('submit'));  // sigue usando BaseModule.js
                    {{-- tab = 'contactos'; --}}
                "
            />
        </div>

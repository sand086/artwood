
                <form id="procesosForm" method="POST">
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
                            
                            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div class="col-span-2 p-2 rounded-lg ">
                                    <label for="presupuesto_estimado" class="art-label-custom">Presupuesto Estimado</label>
                                    <input type="number" id="presupuesto_estimado" name="presupuesto_estimado" min="0" step="0.01" class="art-input-custom text-right" required>
                                </div>
                                
                                <div class="col-span-2 p-2 rounded-lg ">
                                    <label for="fecha_estimada" class="art-label-custom">Fecha Estimada</label>
                                    <input type="date" id="fecha_estimada" name="fecha_estimada" class="art-input-custom">
                                </div>
                            </div>
                            
                            <div>
                                <label for="comentarios" class="art-label-custom">Comentarios</label>
                                <input type="text" id="comentarios" name="comentarios" class="art-input-custom">
                            </div>
                            
                    </div>
                    <x-form-auditoria/>
                </form>

                <x-buttons 
                    formId="procesosForm" 
                    saveEvent="
                        const form = document.getElementById('procesosForm');
                        form.dispatchEvent(new Event('submit'));  // sigue usando BaseModule.js
                        {{-- tab = 'actividades'; --}}
                    "
                />
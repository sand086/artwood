@extends('layouts.appP')

@section('title', 'Procesos Actividades')

@section('content')
    <div class="@container mx-auto px-4 py-8"  data-module="ProcesosActividades"> {{-- Margen y padding con Tailwind --}}
        <h1 class="text-3xl font-semibold mb-6">Procesos Actividades</h1>

        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="procesosactividadesTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="procesosactividadesModal" formId="procesosactividadesForm" :showCancelButton="true" :showSaveButton="true" :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Procesos Actividades</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
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
                            
                            <div>
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
                                />
                            </div>
                                                        
                            <div>
                                <label for="id_unidad_medida_tiempo" class="art-label-custom">Unidad Medida Tiempo</label>
                                <input type="text" id="id_unidad_medida_tiempo" name="id_unidad_medida_tiempo" class="art-input-custom" required>
                            </div>
                            
                            <div>
                                <label for="tiempo_estimado" class="art-label-custom">Tiempo Estimado</label>
                                <input type="text" id="tiempo_estimado" name="tiempo_estimado" class="art-input-custom" required>
                            </div>
                            
                            <div>
                                <label for="costo_estimado" class="art-label-custom">Costo Estimado</label>
                                <input type="text" id="costo_estimado" name="costo_estimado" class="art-input-custom" required>
                            </div>
                            
                            {{-- <div>
                                <label for="riesgos" class="art-label-custom">Riesgos</label>
                                <input type="text" id="riesgos" name="riesgos" class="art-input-custom" required>
                            </div>
                            
                            <div>
                                <label for="observaciones" class="art-label-custom">Observaciones</label>
                                <input type="text" id="observaciones" name="observaciones" class="art-input-custom" required>
                            </div> --}}
                            
                    </div>
                    <x-form-auditoria/>
                </form>
            </x-slot>
            {{-- Seccion FOODER del modal --}}
            <x-slot name="footer">
            </x-slot>
        </x-modal>
    </div>
    <x-message />
@endsection

@push('scripts')

@endpush

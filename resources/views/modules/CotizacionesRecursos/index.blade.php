@extends('layouts.appP')

@section('title', 'Cotizaciones Recursos')

@section('content')
    <div class="@container mx-auto px-4 py-8"  data-module="CotizacionesRecursos"> {{-- Margen y padding con Tailwind --}}
        <h1 class="text-3xl font-semibold mb-6">Cotizaciones Recursos</h1>

        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="cotizacionesrecursosTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="cotizacionesrecursosModal" formId="cotizacionesrecursosForm" :showCancelButton="true" :showSaveButton="true" :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Cotizaciones Recursos</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="cotizacionesrecursosForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        
                            <div>
                                <x-form-select
                                    label="Cotizacion Analisis"
                                    name="cotizacion_analisis_id"
                                    id="cotizacion_analisis_id"
                                    table="cotizacions_analises"
                                    valueField="cotizacion_analisis_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Cotizacion Analisis"
                                />
                            </div>
                            
                            <div>
                                <x-form-select
                                    label="Tipo Recurso"
                                    name="tipo_recurso_id"
                                    id="tipo_recurso_id"
                                    table="tipos_recursos"
                                    valueField="tipo_recurso_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Tipo Recurso"
                                />
                            </div>
                            
                            <div>
                                <x-form-select
                                    label="Recurso"
                                    name="recurso_id"
                                    id="recurso_id"
                                    table="recursos"
                                    valueField="recurso_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Recurso"
                                />
                            </div>
                            
                            <div>
                                <x-form-select
                                    label="Unidad Medida"
                                    name="unidad_medida_id"
                                    id="unidad_medida_id"
                                    table="unidads_medidas"
                                    valueField="unidad_medida_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Unidad Medida"
                                />
                            </div>
                            
                            <div>
                                <label for="precio_unitario" class="art-label-custom">Precio Unitario</label>
                                <input type="text" id="precio_unitario" name="precio_unitario" class="art-input-custom" required>
                            </div>
                            
                            <div>
                                <label for="cantidad" class="art-label-custom">Cantidad</label>
                                <input type="text" id="cantidad" name="cantidad" class="art-input-custom" required>
                            </div>
                            
                            <div>
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
                                />
                            </div>
                            
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

@extends('layouts.appP')

@section('title', 'Cotizaciones Documentos')

@section('content')
    <div class="@container mx-auto px-4 py-8"  data-module="CotizacionesDocumentos"> {{-- Margen y padding con Tailwind --}}
        <h1 class="text-3xl font-semibold mb-6">Cotizaciones Documentos</h1>

        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="cotizacionesdocumentosTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="cotizacionesdocumentosModal" formId="cotizacionesdocumentosForm" :showCancelButton="true" :showSaveButton="true" :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Cotizaciones Documentos</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="cotizacionesdocumentosForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        
                            <div>
                                <x-form-select
                                    label="Cotizacion Solicitud"
                                    name="cotizacion_solicitud_id"
                                    id="cotizacion_solicitud_id"
                                    table="cotizacions_solicituds"
                                    valueField="cotizacion_solicitud_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Cotizacion Solicitud"
                                />
                            </div>
                            
                            <div>
                                <label for="nombre_documento_original" class="art-label-custom">Nombre Documento Original</label>
                                <input type="text" id="nombre_documento_original" name="nombre_documento_original" class="art-input-custom" required>
                            </div>
                            
                            <div>
                                <label for="nombre_documento_sistema" class="art-label-custom">Nombre Documento Sistema</label>
                                <input type="text" id="nombre_documento_sistema" name="nombre_documento_sistema" class="art-input-custom" required>
                            </div>
                            
                            <div>
                                <label for="descripcion" class="art-label-custom">Descripcion</label>
                                <input type="text" id="descripcion" name="descripcion" class="art-input-custom" required>
                            </div>
                            
                            <div>
                                <label for="ruta_almacenamiento" class="art-label-custom">Ruta Almacenamiento</label>
                                <input type="text" id="ruta_almacenamiento" name="ruta_almacenamiento" class="art-input-custom" required>
                            </div>
                            
                            <div>
                                <label for="tipo_mime" class="art-label-custom">Tipo Mime</label>
                                <input type="text" id="tipo_mime" name="tipo_mime" class="art-input-custom" required>
                            </div>
                            
                            <div>
                                <label for="tamano_bytes" class="art-label-custom">Tamano Bytes</label>
                                <input type="text" id="tamano_bytes" name="tamano_bytes" class="art-input-custom" required>
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

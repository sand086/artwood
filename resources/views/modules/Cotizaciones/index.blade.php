@extends('layouts.appP')

@section('title', 'Cotizaciones')

@section('content')
    <div class="@container mx-auto px-4 py-8"  data-module="Cotizaciones"> {{-- Margen y padding con Tailwind --}}
        <h1 class="text-3xl font-semibold mb-6">Cotizaciones</h1>

        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="cotizacionesTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="cotizacionesModal" formId="cotizacionesForm" :showCancelButton="true" :showSaveButton="true" :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Cotizaciones</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="cotizacionesForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                            {{-- <div class="col-span-1 p-1 rounded-lg ">
                                <x-form-select
                                    label="Solicitud"
                                    name="cotizacion_analisis_id"
                                    id="cotizacion_analisis_id"
                                    table="cotizacions_analises"
                                    valueField="cotizacion_analisis_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Cotizacion Analisis"
                                />
                            </div> --}}
                            <label for="cotizacion_cotizacion_solicitud_id" class="art-label-custom">Solicitud</label>
                            <input type="hidden" name="cotizacion_solicitud_id" id="cotizacion_cotizacion_solicitud_id" 
                            x-bind:value="analisis.cotizacion ? analisis.cotizacion.cotizacion_solicitud_id : analisis.cotizacion_solicitud_id">
                            <input type="hidden" name="cliente_id" id="cliente_id" 
                            x-bind:value="analisis.cotizacion_solicitud ? analisis.cotizacion_solicitud.cliente_id : ''">
                            <input type="hidden" name="cotizacion_id" x-bind:value="analisis.cotizacion ? analisis.cotizacion.cotizacion_id : ''">
                            <p class="text-gray-700">
                                <span class="font-semibold" x-text="analisis.cotizacion_solicitud ? analisis.cotizacion_solicitud.consecutivo : ''"></span>
                            </p>
                            
                            <div class="col-span-1 p-1 rounded-lg ">
                                <x-form-select
                                    label="Destinatario"
                                    name="cliente_contacto_id"
                                    id="cliente_contacto_id"
                                    table="vw_clientescontactos"
                                    valueField="cliente_contacto_id"
                                    labelField="contacto_nombre_completo"
                                    parentIdField="cliente_id"
                                    :where="['estado' => 'A']"
                                    :orderBy="['contacto_nombre_completo', 'asc']"
                                    placeholder="Seleccione un Destinatario"
                                    {{-- x-model="analisis.cotizacion ? analisis.cotizacion.cliente_contacto_id : null" --}}
                                />
                            </div>
                            
                            <div class="col-span-1 p-1 rounded-lg ">
                                <x-form-select
                                    label="Plantilla"
                                    name="plantilla_id"
                                    id="plantilla_id"
                                    table="plantillas"
                                    valueField="plantilla_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Plantilla"
                                />
                            </div>
                        </div>
                            
                        <div>
                            <label for="condiciones_comerciales" class="art-label-custom">Condiciones Comerciales</label>
                            <textarea type="text" id="condiciones_comerciales" name="condiciones_comerciales" class="art-input-custom" required></textarea>
                        </div>
                        
                        <div>
                            <label for="datos_adicionales" class="art-label-custom">Datos Adicionales</label>
                            <textarea type="text" id="datos_adicionales" name="datos_adicionales" class="art-input-custom" required></textarea>
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

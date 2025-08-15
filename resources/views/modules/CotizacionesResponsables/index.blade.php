@extends('layouts.appP')

@section('title', 'Cotizaciones Responsables')

@section('content')
    <div class="@container mx-auto px-4 py-8"  data-module="CotizacionesResponsables"> {{-- Margen y padding con Tailwind --}}
        <h1 class="text-3xl font-semibold mb-6">Cotizaciones Responsables</h1>

        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="cotizacionesresponsablesTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="cotizacionesresponsablesModal" formId="cotizacionesresponsablesForm" :showCancelButton="true" :showSaveButton="true" :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Cotizaciones Responsables</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="cotizacionesresponsablesForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        
                        {{-- <div>
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
                        </div> --}}
                        
                        <div>
                            <x-form-select
                                label="Persona"
                                name="persona_id"
                                id="persona_id"
                                table="personas"
                                valueField="persona_id"
                                labelField="nombres"
                                :where="['estado' => 'A']"
                                :orderBy="['nombres', 'asc']"
                                placeholder="Seleccione una Persona"
                                required
                            />
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="col-span-2 p-2 rounded-lg ">
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
                                    required
                                />
                            </div>
                            
                            <div class="col-span-2 p-2 rounded-lg ">
                                <label for="responsabilidad" class="art-label-custom">Responsabilidad</label>
                                <select id="responsabilidad" name="responsabilidad" class="art-input-custom" required>
                                    <option value="ACTIVIDAD">ACTIVIDAD</option>
                                    <option value="PROCESO">PROCESO</option>
                                    <option value="PROYECTO">PROYECTO</option>
                                </select>
                            </div>
                        </div>
                            
                    </div>
                    <x-form-auditoria :showEstado="true"/>
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

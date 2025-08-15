@extends('layouts.appP')

@section('title', 'Municipios')

@section('content')
    <div class="@container mx-auto px-4 py-8" data-module="Municipios"> {{-- Margen y padding con Tailwind --}}
        <h1 class="text-3xl font-semibold mb-6">Municipios</h1>

        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="municipiosTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="municipiosModal" formId="municipiosForm" :showCancelButton="true" :showSaveButton="true" :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Municipios</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="municipiosForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">

                            <div>
                                <label for="nombre" class="art-label-custom">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                            </div>

                            <div>
                                <label for="codigo_postal" class="art-label-custom">Codigo Postal</label>
                                <input type="text" id="codigo_postal" name="codigo_postal" class="art-input-custom" required>
                            </div>

                            <div>
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
                                />
                            </div>

                    </div>
                    <x-form-auditoria/>
                </form>
                {{-- <x-buttons formId="municipiosForm" /> --}}
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

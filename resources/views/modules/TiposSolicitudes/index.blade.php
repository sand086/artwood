@extends('layouts.appP')

@section('title', 'Tipos Solicitudes')

@section('content')
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="TiposSolicitudes">
        <h1 class="text-3xl font-semibold mb-6">Tipos Solicitudes</h1>

        <!-- Tabla  -->
        <div class="overflow-x-auto">
            <div class="p-1.5">
                <table id="tipossolicitudesTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="art-bg-primary art-text-background">
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- Datos de la tabla se llenarán con JavaScript --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="tipossolicitudesModal" formId="tipossolicitudesForm" :showCancelButton="true" :showSaveButton="true"
            :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Tipos Solicitudes</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="tipossolicitudesForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">

                        <div>
                            <label for="nombre" class="art-label-custom">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                        </div>

                        <div>
                            <label for="descripcion" class="art-label-custom">Descripción</label>
                            <input type="text" id="descripcion" name="descripcion" class="art-input-custom">
                        </div>

                    </div>
                    {{-- <x-form-auditoria/> --}}
                    <x-form-auditoria :estado="$tipossolicitude->estado ?? 'A'"
                        :fechaRegistro="$tipossolicitude->fecha_registro ?? null"
                        :fechaActualizacion="$tipossolicitude->fecha_actualizacion ?? null" />
                </form>
                {{-- <x-buttons formId="tipossolicitudesForm" /> --}}
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
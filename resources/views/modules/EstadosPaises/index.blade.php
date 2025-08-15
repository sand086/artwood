@extends('layouts.appP')

@section('title', 'Estados Paises')

@section('content')


    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="EstadosPaises">
        <h1 class="text-3xl font-semibold mb-6">Estados Paises</h1>

        <!-- Tabla  -->
        <div class="overflow-x-auto">
            <div class="p-1.5">
                <table id="estadospaisesTable" class="min-w-full bg-white divide-y divide-gray-200">
                    <thead class="art-bg-primary art-text-background">
                        {{-- Encabezados de la tabla --}}
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- Datos de la tabla  --}}
                    </tbody>
                </table>
            </div>
        </div>


        {{-- Modal para el formulario del módulo --}}
        <x-modal id="estadospaisesModal" formId="estadospaisesForm" :showCancelButton="true" :showSaveButton="true"
            :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Estados Paises</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="estadospaisesForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">

                        <div>
                            <label for="nombre" class="art-label-custom">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                        </div>

                        <div>
                            <x-form-select label="Pais" name="pais_id" id="pais_id" table="paises" valueField="pais_id"
                                labelField="nombre" :where="['estado' => 'A']" :orderBy="['nombre', 'asc']"
                                placeholder="Seleccione un Pais" />
                        </div>

                    </div>
                    <x-form-auditoria />
                    {{-- <x-buttons formId="estadospaisesForm" /> --}}
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
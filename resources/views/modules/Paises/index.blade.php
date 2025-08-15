@extends('layouts.appP')

@section('title', 'Paises')

@section('content')
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="Paises">
        <h1 class="text-3xl font-semibold mb-6">Paises</h1>

        <!-- Tabla  -->
        <div class="overflow-x-auto">
            <div class="p-1.5">
                <table id="paisesTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="art-bg-primary art-text-background">
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- Datos de la tabla se llenarán con JavaScript --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="paisesModal" formId="paisesForm" :showCancelButton="true" :showSaveButton="true"
            :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Paises</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="paisesForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">

                        <div>
                            <label for="nombre" class="art-label-custom">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                        </div>

                        <div>
                            <label for="codigo_iso" class="art-label-custom">Codigo Iso</label>
                            <input type="text" id="codigo_iso" name="codigo_iso" class="art-input-custom" required>
                        </div>

                    </div>
                    <x-form-auditoria />
                </form>
                {{-- <x-buttons formId="paisesForm" /> --}}
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
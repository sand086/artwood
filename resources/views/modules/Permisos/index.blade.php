@extends('layouts.appP')

@section('title', 'Permisos')

@section('content')
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="Permisos">
        <h1 class="text-3xl font-semibold mb-6">Permisos</h1>

        <!-- Tabla  -->
        <div class="overflow-x-auto">
            <div class="p-1.5">
                <table id="permisosTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="art-bg-primary art-text-background">
                        {{-- Aquí se generan las cabeceras dinámicamente --}}
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- Datos de la tabla se llenarán con JavaScript --}}
                    </tbody>
                </table>
            </div>
        </div>
        {{-- Modal para el formulario del módulo --}}
        <x-modal id="permisosModal" formId="permisosForm" :showCancelButton="true" :showSaveButton="true"
            :showClearButton="true">
            {{-- Sección HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Permisos</h5>
            </x-slot>
            {{-- Sección BODY del modal --}}
            <x-slot name="body">
                <form id="permisosForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="name" class="art-label-custom">Nombre</label>
                            <input type="text" id="name" name="name" class="art-input-custom" required>
                        </div>
                        <div>
                            <label for="guard_name" class="art-label-custom">Guard Name</label>
                            <input type="text" id="guard_name" name="guard_name" class="art-input-custom" required>
                        </div>
                        <div>
                            <label for="descripcion" class="art-label-custom">Descripción</label>
                            <input type="text" id="descripcion" name="descripcion" class="art-input-custom" required>
                        </div>
                    </div>
                    <x-form-auditoria />
                </form>
            </x-slot>
            {{-- Sección FOOTER del modal --}}
            <x-slot name="footer">
                {{-- Puedes agregar botones adicionales si lo requieres --}}
            </x-slot>
        </x-modal>
    </div>
    <x-message />
@endsection

@push('scripts')
    {{-- Scripts adicionales, si es necesario --}}
@endpush
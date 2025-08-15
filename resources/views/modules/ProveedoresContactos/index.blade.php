@extends('layouts.appP')

@section('title', 'Proveedores Contactos')

@section('content')
    <div class="container mx-auto px-4 py-8"> {{-- Margen y padding con Tailwind --}}
        <h1 class="text-3xl font-semibold mb-6">Proveedores Contactos</h1>

        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="proveedorescontactosTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="proveedorescontactosModal" formId="proveedorescontactosForm" :showCancelButton="true" :showSaveButton="true" :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Proveedores Contactos</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="proveedorescontactosForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">

                            <div>
                                <x-form-select
                                    label="Proveedor"
                                    name="proveedor_id"
                                    id="proveedor_id"
                                    table="proveedorescontactos"
                                    valueField="proveedor_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Proveedor"
                                />
                            </div>

                            <div>
                                <x-form-select
                                    label="Persona"
                                    name="persona_id"
                                    id="persona_id"
                                    table="proveedorescontactos"
                                    valueField="persona_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Persona"
                                />
                            </div>

                            <div>
                                <label for="cargo" class="art-label-custom">Cargo</label>
                                <input type="text" id="cargo" name="cargo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>

                            <div>
                                <label for="telefono" class="art-label-custom">Telefono</label>
                                <input type="text" id="telefono" name="telefono" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>

                            <div>
                                <label for="correo_electronico" class="art-label-custom">Correo Electronico</label>
                                <input type="text" id="correo_electronico" name="correo_electronico" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                            </div>

                            <div>
                                <label for="observaciones" class="art-label-custom">Observaciones</label>
                                <input type="text" id="observaciones" name="observaciones" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
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

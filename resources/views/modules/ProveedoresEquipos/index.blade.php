@extends('layouts.appP')

@section('title', 'Proveedores Equipos')

@section('content')
    <div class="@container mx-auto px-4 py-8"  data-module="ProveedoresEquipos"> {{-- Margen y padding con Tailwind --}}
        <h1 class="text-3xl font-semibold mb-6">Proveedores Equipos</h1>

        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="proveedoresequiposTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="proveedoresequiposModal" formId="proveedoresequiposForm" :showCancelButton="true" :showSaveButton="true" :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Proveedores Equipos</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="proveedoresequiposForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        
                            <div>
                                <x-form-select
                                    label="Proveedor"
                                    name="proveedor_id"
                                    id="proveedor_id"
                                    table="proveedors"
                                    valueField="proveedor_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Proveedor"
                                />
                            </div>
                            
                            <div>
                                <x-form-select
                                    label="Equipo"
                                    name="equipo_id"
                                    id="equipo_id"
                                    table="equipos"
                                    valueField="equipo_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Equipo"
                                />
                            </div>
                            
                            <div>
                                <label for="descripcion" class="art-label-custom">Descripcion</label>
                                <input type="text" id="descripcion" name="descripcion" class="art-input-custom" required>
                            </div>
                            
                            <div>
                                <label for="detalle" class="art-label-custom">Detalle</label>
                                <input type="text" id="detalle" name="detalle" class="art-input-custom" required>
                            </div>
                            
                            <div>
                                <label for="stock" class="art-label-custom">Stock</label>
                                <input type="text" id="stock" name="stock" class="art-input-custom" required>
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

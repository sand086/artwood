@extends('layouts.appP')

@section('title', 'Productos')

@section('content')
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="Productos">
        <h1 class="text-3xl font-semibold mb-6">Productos</h1>

        <!-- Tabla  -->
        <div class="overflow-x-auto">
            <div class="p-1.5">
                <table id="productosTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="art-bg-primary art-text-background">
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- Datos de la tabla se llenarán con JavaScript --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="productosModal" formId="productosForm" >
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Productos</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="productosForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-1">

                        <div>
                            <label for="nombre" class="art-label-custom">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                        </div>

                        <div>
                            <label for="descripcion" class="art-label-custom">Descripcion</label>
                            <input type="text" id="descripcion" name="descripcion" class="art-input-custom" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-2 gap-1">
                            <div class="col-span-1 p-2 rounded-lg ">
                                <x-form-select 
                                    label="Unidad Medida" 
                                    name="unidad_medida_id" 
                                    id="unidad_medida_id"
                                    table="unidadesmedidas" 
                                    valueField="unidad_medida_id" 
                                    labelField="nombre"
                                    :where="['estado' => 'A']" 
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione una Unidad Medida" 
                                    required
                                />
                            </div>

                            <div class="col-span-1 p-2 rounded-lg ">
                                <label for="precio_unitario" class="art-label-custom">Costo Unitario</label>
                                <div class="flex mt-1">
                                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-700 bg-gray-300 text-green-900 text-md">$</span>
                                    <input type="number" id="precio_unitario" name="precio_unitario" min="0" step="0.01" class="art-input-custom rounded-l-none text-right" required>
                                </div>
                            </div>
                        </div>

                    </div>
                    <x-form-auditoria />
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
@extends('layouts.appP')

@section('title', 'Gastos')

@section('content')
    <div class="@container mx-auto px-4 py-8"  data-module="Gastos"> {{-- Margen y padding con Tailwind --}}
        <h1 class="text-3xl font-semibold mb-6">Gastos</h1>

        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="gastosTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="gastosModal" formId="gastosForm" :showCancelButton="true" :showSaveButton="true" :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Gastos</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="gastosForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="col-span-3 p-2 rounded-lg ">
                                <label for="nombre" class="art-label-custom">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                            </div>
                            
                            <div class="col-span-1 p-2 rounded-lg ">
                                <x-form-select
                                    label="Tipo Gasto"
                                    name="tipo_gasto_id"
                                    id="tipo_gasto_id"
                                    table="tiposgastos"
                                    valueField="tipo_gasto_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Tipo Gasto"
                                    required
                                />
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="col-span-2 p-2 rounded-lg ">
                                <x-form-select
                                    label="Unidad Medida"
                                    name="unidad_medida_id"
                                    id="unidad_medida_id"
                                    table="unidadesmedidas"
                                    valueField="unidad_medida_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A', 'categoria' => 'TIEMPO']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione una Unidad Medida"
                                    required
                                />
                            </div>
                            
                            <div class="col-span-2 p-2 rounded-lg ">
                                <label for="valor_unidad" class="art-label-custom">Valor Unidad</label>
                                <input type="number" id="valor_unidad" name="valor_unidad" min="0" step="0.01" class="art-input-custom text-right" required>
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="col-span-2 p-2 rounded-lg ">
                                <label for="cantidad" class="art-label-custom">Cantidad</label>
                                <input type="number" id="cantidad" name="cantidad" min="1" step="1" class="art-input-custom text-right" required>
                            </div>
                            
                            <div class="col-span-2 p-2 rounded-lg ">
                                <label for="valor_total" class="art-label-custom">Valor Total</label>
                                <input type="number" id="valor_total" name="valor_total" min="0" step="0.01" class="art-input-custom text-right" required>
                            </div>
                        </div>
                    </div>
                    <x-form-auditoria :showUser="true"  />
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

@extends('layouts.appP')

@section('title', 'Equipos')

@section('content')
    <div class="@container mx-auto px-4 py-8" data-module="Equipos"> {{-- Margen y padding con Tailwind --}}
        <h1 class="text-3xl font-semibold mb-6">Equipos</h1>

        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="equiposTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="equiposModal" formId="equiposForm" :showCancelButton="true" :showSaveButton="true"
            :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Equipos</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="equiposForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 2xl:grid-cols-2 gap-6">

                        {{-- Nombre --}}
                        <div class="col-span-1 px-4 bg-white rounded-lg shadow-sm">
                            <label for="nombre" class="art-label-custom">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="art-input-custom w-full"
                                placeholder="Ingrese nombre del equipo" required>
                        </div>

                        {{-- Descripción --}}
                        <div class="col-span-1 px-4 bg-white rounded-lg shadow-sm">
                            <label for="descripcion" class="art-label-custom">Descripción</label>
                            <input type="text" id="descripcion" name="descripcion" class="art-input-custom w-full"
                                placeholder="Ingrese descripción breve" required>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-3">

                        {{-- Unidad de Medida --}}
                        <div class="px-4 bg-white rounded-lg shadow-sm">
                            {{-- <label for="unidad_medida_id" class="art-label-custom">Unidad de Medida</label> --}}
                            <x-form-select name="unidad_medida_id" id="unidad_medida_id" label="Unidad Medida"
                                table="unidadesmedidas" value-field="unidad_medida_id" label-field="nombre"
                                :where="['estado' => 'A']" :order-by="['nombre','asc']" placeholder="Seleccione una unidad"
                                class="art-select-custom w-full" />
                        </div>

                        {{-- Costo Unitario --}}
                        <div class="px-4 bg-white rounded-lg shadow-sm">
                            <label for="precio_unitario" class="art-label-custom">Costo Unitario</label>
                            <div class="mt-1 relative">
                                <div
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                    <span class="text-sm">$</span>
                                </div>
                                <input type="number" id="precio_unitario" name="precio_unitario" min="0" step="0.01"
                                    placeholder="0.00" class="art-input-custom w-full pl-10 pr-4 text-right" required>
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
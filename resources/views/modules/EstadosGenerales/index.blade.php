@extends('layouts.appP')

@section('title', 'Estados Generales')

@section('content')


    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="EstadosGenerales">
        <h1 class="text-3xl font-semibold mb-6">Estados Generales</h1>

        <!-- Tabla  -->
        <div class="overflow-x-auto">
            <div class="p-1.5">
                <table id="estadosgeneralesTable" class="min-w-full bg-white divide-y divide-gray-200">
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
        <x-modal id="estadosgeneralesModal" formId="estadosgeneralesForm" :showCancelButton="true" :showSaveButton="true"
            :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Estados Generales</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="estadosgeneralesForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">

                        <div>
                            <label for="nombre" class="art-label-custom">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                        </div>

                        <div>
                            {{-- <label for="categoria_estado" class="art-label-custom">Categoria
                                Estado</label>
                            <input type="text" id="categoria_estado" name="categoria_estado" class="art-input-custom"
                                required> --}}
                            <label for="categoria" class="art-label-custom">Categoria</label>
                            <select id="categoria" name="categoria" class="art-input-custom" required>
                                <option value="">Seleccione un categoria</option>
                                <option value="COTIZACION">COTIZACION</option>
                                <option value="PRESUPUESTO">PRESUPUESTO</option>
                                <option value="SOLICITUD">SOLICITUD</option>
                            </select>
                        </div>

                    </div>
                    <x-form-auditoria />
                </form>
                {{-- <x-buttons formId="estadosgeneralesForm" /> --}}
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
@extends('layouts.appP')

@section('title', 'Tipos Gastos')

@section('content')
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="TiposGastos">
        <h1 class="text-3xl font-semibold mb-6">Tipos Gastos</h1>


        <div class="flex flex-col">
            <div class="-m-1.5 overflow-x-auto">
                <div class="p-1.5 min-w-full inline-block align-middle">

                    <div class="overflow-hidden">

                        <table id="tiposgastosTable" class="min-w-full bg-white divide-y divide-gray-200">
                            <thead class="art-bg-primary art-text-background">
                                {{-- Encabezados de la tabla --}}
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                {{-- Datos de la tabla  --}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="tiposgastosModal" formId="tiposgastosForm" :showCancelButton="true" :showSaveButton="true"
            :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                Formulario Tipos Gastos
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="tiposgastosForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4 mb-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label for="nombre" class="art-label-custom">
                                    Nombre
                                </label>
                                <input type="text" id="nombre" name="nombre" class="art-input-custom"
                                    placeholder="Nombre tipo del gasto" required>
                            </div>


                            <div>
                                <label for="prioridad" class="art-label-custom">
                                    Prioridad
                                </label>
                                <input type="number" id="prioridad" name="prioridad" class="art-input-custom"
                                    placeholder="Parametro de prioridad" required>
                            </div>
                        </div>
                    </div>
                    <x-form-auditoria />
                </form>
                {{-- <x-buttons formId="tiposgastosForm" /> --}}
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
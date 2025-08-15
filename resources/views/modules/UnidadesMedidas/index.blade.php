@extends('layouts.appP')

@section('title', 'Unidades Medidas')

@section('content')
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="UnidadesMedidas">
        <h1 class="text-3xl font-semibold mb-6">Unidades Medidas</h1>

        <!-- Tabla  -->
        <div class="overflow-x-auto">
            <div class="p-1.5">
                <table id="unidadesmedidasTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="art-bg-primary art-text-background">
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- Datos de la tabla se llenarán con JavaScript --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="unidadesmedidasModal" formId="unidadesmedidasForm" :showCancelButton="true" :showSaveButton="true" :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Unidades Medidas</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="unidadesmedidasForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">

                        <div>
                            <label for="nombre" class="art-label-custom">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                        </div>

                        <div class="col-span-1 p-2 rounded-lg ">
                            <label for="categoria" class="art-label-custom">Categoria</label>
                            <select id="categoria" name="categoria" class="art-input-custom" required>
                                <option value="">Seleccione una categoria</option>
                                <option value="CANTIDAD">CANTIDAD</option>
                                <option value="LONGITUD">LONGITUD</option>
                                <option value="MASA">MASA</option>
                                <option value="SUPERFICIE">SUPERFICIE</option>
                                <option value="TIEMPO">TIEMPO</option>
                                <option value="VOLUMEN">VOLUMEN</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="simbolo" class="art-label-custom">Simbolo</label>
                            <input type="text" id="simbolo" name="simbolo" class="art-input-custom" required>
                        </div>

                    </div>
                    <x-form-auditoria />
                </form>
                {{-- <x-buttons formId="unidadesmedidasForm" /> --}}
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
@extends('layouts.appP')

@section('title', 'Tipos Recursos')

@section('content')
    <div class="@container mx-auto px-4 py-8"  data-module="TiposRecursos"> {{-- Margen y padding con Tailwind --}}
        <h1 class="text-3xl font-semibold mb-6">Tipos Recursos</h1>

        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="tiposrecursosTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="tiposrecursosModal" formId="tiposrecursosForm" :showCancelButton="true" :showSaveButton="true" :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Tipos Recursos</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="tiposrecursosForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        
                        <div>
                            <label for="nombre" class="art-label-custom">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                        </div>

                        <div>
                            <label for="tabla_referencia" class="art-label-custom">Tabla Referencia</label>
                            <input type="text" id="tabla_referencia" name="tabla_referencia" class="art-input-custom" required>
                        </div>
                        
                        <div>
                            <label for="descripcion" class="art-label-custom">Descripcion</label>
                            <input type="text" id="descripcion" name="descripcion" class="art-input-custom" required>
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

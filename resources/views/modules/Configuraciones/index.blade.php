@extends('layouts.appP')

@section('title', 'Configuraciones')

@section('content')
    <div class="@container mx-auto px-4 py-8"  data-module="Configuraciones"> {{-- Margen y padding con Tailwind --}}
        <h1 class="text-3xl font-semibold mb-6">Configuraciones</h1>

        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="configuracionesTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="configuracionesModal" formId="configuracionesForm" :showCancelButton="true" :showSaveButton="true" :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Configuraciones</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="configuracionesForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        {{-- fila 1 --}}
                        <div>
                            <label for="nombre" class="art-label-custom">Nombre</label>
                            <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                        </div>
                        {{-- fila 2 --}}
                        <div>
                            <label for="clave" class="art-label-custom">Clave</label>
                            <input type="text" id="clave" name="clave" class="art-input-custom" required>
                        </div>
                        {{-- fila 3 --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-1">
                            <div>
                                <label for="valor" class="art-label-custom">Valor</label>
                                <input type="text" id="valor" name="valor" class="art-input-custom" required>
                            </div>
                            
                            <div>
                                <label for="tipo_dato" class="art-label-custom">Tipo Dato</label>
                                {{-- <input type="text" id="tipo_dato" name="tipo_dato" class="art-input-custom" required> --}}
                                <select id="tipo_dato" name="tipo_dato" class="art-input-custom" required>
                                    <option value="string">Cadena</option>
                                    <option value="text">Texto</option>
                                    <option value="integer">Entero</option>
                                    <option value="decimal">Decimal</option>
                                    <option value="date">Fecha</option>
                                </select>
                            </div>
                        </div>
                        {{-- fila 4 --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-1">
                            <div>
                                <label for="fecha_inicio_vigencia" class="art-label-custom">Fecha Inicio Vigencia</label>
                                <input type="date" id="fecha_inicio_vigencia" name="fecha_inicio_vigencia" class="art-input-custom" required>
                            </div>
                            
                            <div>
                                <label for="fecha_fin_vigencia" class="art-label-custom">Fecha Fin Vigencia</label>
                                <input type="date" id="fecha_fin_vigencia" name="fecha_fin_vigencia" class="art-input-custom" >
                            </div>
                        </div>
                        {{-- fila 5 --}}
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

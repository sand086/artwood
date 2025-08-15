@extends('layouts.appP')

@section('title', 'Procesos')

@section('content')
    <div class="@container mx-auto px-4 py-8"  data-module="Procesos"> {{-- Margen y padding con Tailwind --}}
        {{-- Header --}}
        <h1 class="text-3xl font-semibold mb-6">Procesos</h1>
        
        {{-- Tabla --}}
        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="procesosTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        <x-modal id="procesosModal" formId="procesosForm" :showCancelButton="false" :showSaveButton="false" :showClearButton="false" size="lg" data-current-id="{{ $proceso->proceso_id ?? '' }}">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Procesos</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <div x-data="{ tab: 'basicos', isEditing: false }" {{-- Estado activo 
                de pestañas --}}
                @update-alpine-tabs.window="
                        if ($event.target.id === 'procesosModal') { // Asegura que el evento viene del modal correcto
                            console.log('Alpine received update-alpine-tabs:', $event.detail);
                            isEditing = $event.detail.isEditing;
                            tab = $event.detail.tab;
                        }
                     "
                >
                    {{-- Navegación Tabs --}}
                    <nav class="flex mb-2 border-b border-gray-200">
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="tab === 'basicos' ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-600'"
                            @click="tab = 'basicos'">
                            Info Básica
                        </button>
                        {{-- Pestaña Contactos (Habilitada solo si isEditing es true) --}}
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'actividades' && isEditing,
                                'text-gray-600': tab !== 'actividades' || !isEditing, // Gris si no está activa o si no se está editando
                                'opacity-50 cursor-not-allowed': !isEditing       // Estilo deshabilitado si no se está editando
                            }"
                            @click="if (isEditing) tab = 'actividades'" {{-- Solo cambia la pestaña si se está editando --}}
                            :disabled="!isEditing">
                            Actividades
                        </button>
                    </nav>
                    <hr>
                    {{-- Tabs --}}
                    <div>
                        <div>
                            {{-- Info Básica --}}
                            <div x-show="tab === 'basicos'" class="h-[750px] overflow-y-auto p-1">
                                @include('modules.Procesos.basicos')
                            </div>
        
                            {{-- Actividades --}}
                            <div x-show="tab === 'actividades'" class="h-[750px] overflow-y-auto p-1">
                                @include('modules.Procesos.actividades')
                            </div>
                        </div>
                    </div>
                </div>
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

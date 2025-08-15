@extends('layouts.appP')

@section('title', 'Analisis de Cotizaci&oacute;n')

@section('content')
    <div class="@container mx-auto px-4 py-8"  data-module="CotizacionesAnalisis"> {{-- Margen y padding con Tailwind --}}
        <h1 class="text-3xl font-semibold mb-6">Analisis de Cotizaci&oacute;n</h1>

        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="cotizacionesanalisisTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="cotizacionesanalisisModal" formId="cotizacionesanalisisForm" :showCancelButton="false" :showSaveButton="false" size="xl" :showClearButton="false">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Analisis de Cotizaci&oacute;n</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <div x-data="{ tab: 'analisis', isEditing: false }" {{-- Estado activo 
                de pestañas --}}
                    @update-alpine-tabs.window="
                        if ($event.target.id === 'cotizacionesanalisisModal') { // Asegura que el evento viene del modal correcto
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
                            :class="tab === 'analisis' ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-600'"
                            @click="tab = 'analisis'">
                            Resumen
                        </button>
                        {{-- Pestaña Recursos (Habilitada solo si isEditing es true) --}}
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'recursos' && isEditing,
                                'text-gray-600': tab !== 'recursos' || !isEditing, // Gris si no está activa o si no se está editando
                                'opacity-50 cursor-not-allowed': !isEditing       // Estilo deshabilitado si no se está editando
                            }"
                            @click="if (isEditing) tab = 'recursos'" {{-- Solo cambia la pestaña si se está editando --}}
                            :disabled="!isEditing">
                            Recursos
                        </button>
                        {{-- Pestaña Cotizacion (Habilitada solo si isEditing es true) --}}
                        <button
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'cotizacion' && isEditing,
                                'text-gray-600': tab !== 'cotizacion' || !isEditing,
                                'opacity-50 cursor-not-allowed': !isEditing
                            }"
                            @click="if (isEditing) tab = 'cotizacion'"
                            :disabled="!isEditing">
                            Cotizacion
                        </button>
                    </nav>
                    <hr>
                    {{-- Tabs --}}
                    <div>
                        <div>
                            {{-- Resumen --}}
                            <div x-show="tab === 'analisis'" class="h-[600px] overflow-y-auto p-1">
                                @include('modules.CotizacionesAnalisis.analisis')
                            </div>
        
                            {{-- Recursos --}}
                            <div x-show="tab === 'recursos'" class="h-[600px] overflow-y-auto p-1">
                                @include('modules.CotizacionesAnalisis.recursos')
                            </div>

                            {{-- Cotizacion --}}
                            <div x-show="tab === 'cotizacion'" class="h-[600px] overflow-y-auto p-1">
                                @include('modules.Cotizaciones.cotizacion')
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

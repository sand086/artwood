@extends('layouts.appP')

@section('title', 'Solicitudes Cotizaciones')

@section('content')
    <div class="@container mx-auto px-4 py-8"  data-module="CotizacionesSolicitudes"> {{-- Margen y padding con Tailwind --}}
        <h1 class="text-3xl font-semibold mb-6">Solicitudes Cotizaciones</h1>

        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="cotizacionessolicitudesTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="cotizacionessolicitudesModal" formId="cotizacionessolicitudesForm" :showCancelButton="false" :showSaveButton="false" size="lg" :showClearButton="false">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Solicitudes Cotizaciones</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <div x-data="{ tab: 'solicitud', isEditing: false }" {{-- Estado activo 
                de pestañas --}}
                @update-alpine-tabs.window="
                        if ($event.target.id === 'cotizacionessolicitudesModal') { // Asegura que el evento viene del modal correcto
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
                            :class="tab === 'solicitud' ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-600'"
                            @click="tab = 'solicitud'">
                            Solicitud
                        </button>
                        {{-- Pestaña Contactos (Habilitada solo si isEditing es true) --}}
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'responsables' && isEditing,
                                'text-gray-600': tab !== 'responsables' || !isEditing, // Gris si no está activa o si no se está editando
                                'opacity-50 cursor-not-allowed': !isEditing       // Estilo deshabilitado si no se está editando
                            }"
                            @click="if (isEditing) tab = 'responsables'" {{-- Solo cambia la pestaña si se está editando --}}
                            :disabled="!isEditing">
                            Responsables
                        </button>
                        {{-- Pestaña Documentos (Habilitada solo si isEditing es true) --}}
                        <button
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'documentos' && isEditing,
                                'text-gray-600': tab !== 'documentos' || !isEditing,
                                'opacity-50 cursor-not-allowed': !isEditing
                            }"
                            @click="if (isEditing) tab = 'documentos'"
                            :disabled="!isEditing">
                            Documentos
                        </button>
                    </nav>
                    <hr>
                    {{-- Tabs --}}
                    <div>
                        <div>
                            {{-- Info Básica --}}
                            <div x-show="tab === 'solicitud'" class="h-[600px] overflow-y-auto p-1">
                                @include('modules.CotizacionesSolicitudes.solicitud')
                            </div>
        
                            {{-- Responsables --}}
                            <div x-show="tab === 'responsables'" class="h-[600px] overflow-y-auto p-1">
                                @include('modules.CotizacionesSolicitudes.responsables')
                            </div>

                            {{-- Documentos --}}
                            <div x-show="tab === 'documentos'" class="h-[600px] overflow-y-auto p-1">
                                @include('modules.CotizacionesSolicitudes.documentos')
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

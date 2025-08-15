@extends('layouts.appP')

@section('title', 'Proveedores')

@section('content')
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="Proveedores">
        {{-- Header --}}
        <h1 class="text-3xl font-semibold mb-6">Proveedores</h1>

        <!-- Tabla  -->
        <div class="overflow-x-auto">
            <div class="p-1.5">
                <table id="proveedoresTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="art-bg-primary art-text-background">
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- Datos de la tabla se llenarán con JavaScript --}}
                    </tbody>
                </table>
            </div>
        </div>
        
        <x-modal id="proveedoresModal" formId="proveedoresForm" :showCancelButton="false" :showSaveButton="false" :showClearButton="false" size="lg" data-current-id="{{ $proveedor->proveedor_id ?? '' }}">
            {{-- Header --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Proveedores</h5>
            </x-slot>
            {{-- Body con pestañas --}}
            <x-slot name="body">
                <div x-data="{ tab: 'basicos', isEditing: false }" {{-- Estado activo 
                de pestañas --}}
                @update-alpine-tabs.window="
                        if ($event.target.id === 'proveedoresModal') { // Asegura que el evento viene del modal correcto
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
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'contactos' && isEditing,
                                'text-gray-600': tab !== 'contactos' || !isEditing, // Gris si no está activa o si no se está editando
                                'opacity-50 cursor-not-allowed': !isEditing       // Estilo deshabilitado si no se está editando
                            }"
                            @click="if (isEditing) tab = 'contactos'" {{-- Solo cambia la pestaña si se está editando --}}
                            :disabled="!isEditing">
                            Contactos
                        </button>
                        {{-- Pestaña Servicios (Habilitada solo si isEditing es true) --}}
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'servicios' && isEditing,
                                'text-gray-600': tab !== 'servicios' || !isEditing,
                                'opacity-50 cursor-not-allowed': !isEditing
                            }"
                            @click="if (isEditing) tab = 'servicios'"
                            :disabled="!isEditing">
                            Servicios
                        </button>
                        {{-- Pestaña Productos (Habilitada solo si isEditing es true) --}}
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'productos' && isEditing,
                                'text-gray-600': tab !== 'productos' || !isEditing,
                                'opacity-50 cursor-not-allowed': !isEditing
                            }"
                            @click="if (isEditing) tab = 'productos'"
                            :disabled="!isEditing">
                            Productos
                        </button>
                        {{-- Pestaña Materiales (Habilitada solo si isEditing es true) --}}
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'materiales' && isEditing,
                                'text-gray-600': tab !== 'materiales' || !isEditing,
                                'opacity-50 cursor-not-allowed': !isEditing
                            }"
                            @click="if (isEditing) tab = 'materiales'"
                            :disabled="!isEditing">
                            Materiales
                        </button>
                        {{-- Pestaña Equipos (Habilitada solo si isEditing es true) --}}
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'equipos' && isEditing,
                                'text-gray-600': tab !== 'equipos' || !isEditing,
                                'opacity-50 cursor-not-allowed': !isEditing
                            }"
                            @click="if (isEditing) tab = 'equipos'"
                            :disabled="!isEditing">
                            Equipos
                        </button>
                    </nav>
                    <hr>
                    {{-- Tabs --}}
                    <div>
                        <div>
                            {{-- Info Básica --}}
                            <div x-show="tab === 'basicos'" class="h-[700px] overflow-y-auto p-1">
                                @include('modules.Proveedores.basicos')
                            </div>
        
                            {{-- Contactos --}}
                            <div x-show="tab === 'contactos'" class="h-[700px] overflow-y-auto p-1">
                                @include('modules.Proveedores.contactos')
                            </div>
        
                            {{-- Servicios --}}
                            <div x-show="tab === 'servicios'" class="h-[700px] overflow-y-auto p-1">
                                @include('modules.Proveedores.servicios')
                            </div>

                            {{-- Productos --}}
                            <div x-show="tab === 'productos'" class="h-[700px] overflow-y-auto p-1">
                                @include('modules.Proveedores.productos')
                            </div>
        
                            {{-- Materiales --}}
                            <div x-show="tab === 'materiales'" class="h-[700px] overflow-y-auto p-1">
                                @include('modules.Proveedores.materiales')
                            </div>
        
                            {{-- Equipos --}}
                            <div x-show="tab === 'equipos'" class="h-[700px] overflow-y-auto p-1">
                                @include('modules.Proveedores.equipos')
                            </div>
                        </div>
                    </div>
                </div>
            </x-slot>
            {{-- Seccion FOODER del modal --}}
            <x-slot name="footer">
            </x-slot>
        </x-modal>

        <x-message />
    </div>
@endsection

@push('scripts')
    {{-- @vite(['resources/js/modules/ProveedoresContactos/index.js']); --}}
@endpush
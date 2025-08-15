@extends('layouts.appP')

@section('title', 'Clientes')

@section('content')
    <div class="@container mx-auto px-4 py-8" data-module="Clientes">
        <h1 class="text-3xl font-semibold mb-6">Clientes</h1>

        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="clientesTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="clientesModal" formId="clientesForm" :showCancelButton="false" :showSaveButton="false" :showClearButton="false" size="lg" data-current-id="{{ $cliente->cliente_id ?? '' }}">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Clientes</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <div x-data="{ tab: 'basicos', isEditing: false }" {{-- Estado activo de pestañas --}}
                    @update-alpine-tabs.window="
                        if ($event.target.id === 'clientesModal') { // Asegura que el evento viene del modal correcto
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
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'historico' && isEditing,
                                'text-gray-600': tab !== 'historico' || !isEditing, // Gris si no está activa o si no se está editando
                                'opacity-50 cursor-not-allowed': !isEditing       // Estilo deshabilitado si no se está editando
                            }"
                            @click="if (isEditing) tab = 'historico'" {{-- Solo cambia la pestaña si se está editando --}}
                            :disabled="!isEditing">
                            Historico
                        </button>
                    </nav>
                    <hr>
                    {{-- Tabs --}}
                    <div>
                        <div>
                            {{-- Info Básica --}}
                            <div x-show="tab === 'basicos'" class="h-[720px] overflow-y-auto p-1">
                                @include('modules.Clientes.basicos')
                            </div>
        
                            {{-- Contactos --}}
                            <div x-show="tab === 'contactos'" class="h-[720px] overflow-y-auto p-1">
                                @include('modules.Clientes.contactos')
                            </div>
                            
                            {{-- Historico --}}
                            <div x-show="tab === 'historico'" class="h-[720px] overflow-y-auto p-1">
                                {{-- @include('modules.Clientes.historico') --}}
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

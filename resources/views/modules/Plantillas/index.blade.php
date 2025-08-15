@extends('layouts.appP')

@section('title', 'Plantillas')

@section('content')
    <div class="@container mx-auto px-4 py-8"  data-module="Plantillas"> {{-- Margen y padding con Tailwind --}}
        <h1 class="text-3xl font-semibold mb-6">Plantillas</h1>

        <div class="overflow-x-auto"> {{-- Para la tabla responsive --}}
            <table id="plantillasTable" class="min-w-full divide-y divide-gray-200">
                <thead class="art-bg-primary art-text-background">
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    {{-- Datos de la tabla se llenarán con JavaScript --}}
                </tbody>
            </table>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="plantillasModal" formId="plantillasForm" 
                :showCancelButton="true" 
                :showSaveButton="true" 
                :showClearButton="true"
                size="xl"
                x-data="{
                    initialized: false,
                    initWatcher() {
                        const modal = document.getElementById('plantillasModal');
                        if (!modal) return;
                        const observer = new MutationObserver((mutations) => {
                            for (let mutation of mutations) {
                                if (mutation.attributeName === 'class' &&
                                    modal.classList.contains('open') &&
                                    !this.initialized) {
                                    this.initialized = true;
                                    console.log('Modal visible');
                                    this.$nextTick(() => {
                                        if (window.initEditor) {
                                            setTimeout(() => window.initEditor(), 50); // Delay pequeño para asegurar DOM listo
                                        }
                                    });
                                }
                            }
                        });
                        observer.observe(modal, { attributes: true });
                    }
                }"
                x-init="initWatcher()"
        >
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Plantillas</h5>
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="plantillasForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        {{-- fila 1 --}}
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                            <div class="col-span-2 p-1 rounded-lg ">
                                <label for="nombre" class="art-label-custom">Nombre</label>
                                <input type="text" id="nombre" name="nombre" class="art-input-custom" required>
                            </div>
                            <div class="col-span-1 p-1 rounded-lg ">
                                <label for="modulo" class="art-label-custom">Modulo</label>
                                <input type="text" id="modulo" name="modulo" class="art-input-custom">
                            </div>
                        </div>

                        {{-- fila 2 --}}
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                            <div class="col-span-2">
                                <label for="html" class="art-label-custom">Plantilla Html</label>
                                <textarea id="html" name="html" class="art-input-custom h-full" rows="4" required></textarea>
                            </div>
                            <div class="col-span-1 grid grid-cols-1 gap-2">
                                <div class="p-1 rounded-lg">
                                    <label for="clave" class="art-label-custom">Clave</label>
                                    <input type="text" id="clave" name="clave" class="art-input-custom" required>
                                </div>
                                <div class="p-1 rounded-lg">
                                    <label for="origen_datos" class="art-label-custom">Origen Datos</label>
                                    <select id="origen_datos" name="origen_datos" class="art-input-custom" required>
                                        <option value="TABLA">TABLA</option>
                                        <option value="CONSULTA">CONSULTA</option>
                                        <option value="FUNCION">FUNCION</option>
                                    </select>
                                </div>
                                <div class="p-1 rounded-lg">
                                    <label for="fuente_datos" class="art-label-custom">Fuente Datos</label>
                                    <input type="text" id="fuente_datos" name="fuente_datos" class="art-input-custom" required>
                                </div>
                                <div class="p-1 rounded-lg">
                                    <label for="tipo" class="art-label-custom">Tipo</label>
                                    <select id="tipo" name="tipo" class="art-input-custom" required>
                                        <option value="PDF">PDF</option>
                                        <option value="EMAIL">EMAIL</option>
                                    </select>
                                </div>
                                <div class="p-1 rounded-lg">
                                    <label for="formato" class="art-label-custom">Formato</label>
                                    <select id="formato" name="formato" class="art-input-custom" required>
                                        <option value="PDF">PDF</option>
                                        <option value="EXCEL">EXCEL</option>
                                        <option value="WORD">WORD</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <x-form-auditoria/>
                    </div>
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

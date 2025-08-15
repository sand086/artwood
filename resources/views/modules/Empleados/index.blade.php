@extends('layouts.appP')

@section('title', 'Empleados')

@section('content')



    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="Empleados">
        <h1 class="text-3xl font-semibold mb-6">Empleados</h1>

        <!-- Tabla  -->
        <div class="overflow-x-auto">
            <div class="p-1.5">
                <table id="empleadosTable" class="min-w-full bg-white divide-y divide-gray-200">
                    <thead class="art-bg-primary art-text-background">
                        {{-- Encabezados de la tabla --}}
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- Datos de la tabla  --}}
                    </tbody>
                </table>
            </div>
        </div>


        {{-- Modal para el formulario del módulo --}}
        <x-modal id="empleadosModal" formId="empleadosForm" :showCancelButton="true" :showSaveButton="true" :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                Formulario Empleados
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                <form id="empleadosForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 gap-4">
                        {{-- fila 1 --}}
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-2">
                            <div class="col-span-2 p-2 rounded-lg ">
                                <x-form-select
                                    label="Persona"
                                    name="persona_id"
                                    id="persona_id"
                                    table="vw_contactos"
                                    valueField="persona_id"
                                    labelField="nombre_completo"
                                    :where="['estado' => 'A', 'empleado_id' => 'IS NULL', 'relaciones' => 'IS NULL']"
                                    :orderBy="['nombres', 'asc']"
                                    placeholder="Seleccione una Persona"
                                    required
                                />
                            </div>

                            <div 
                                class="col-span-1 p-2 rounded-lg"
                                x-data="{ creatingPersona: false }"
                                @popup-closed-without-save.window="if ($event.detail.targetSelectId === 'persona_id') creatingPersona = false"
                            >
                                <label for="boton-crear-persona" class="art-label-custom">&nbsp;</label>
                                <a
                                    href="{{ route('personas.create') }}" 
                                    data-target-select-id="persona_id"
                                    class="btn-open-popup-creator art-btn-secondary ml-2"
                                    @click="creatingPersona = true"
                                    :disabled="creatingPersona"
                                    :class="{ 'opacity-50 cursor-not-allowed': creatingPersona }"
                                >
                                    <span x-show="!creatingPersona">Crear Persona</span>
                                    <span x-show="creatingPersona">Abriendo...</span>
                                </a>
                            </div>
                        </div>
                        {{-- fila 2 --}}
                            <div>
                                <label for="cargo" class="art-label-custom">Cargo</label>
                                <input type="text" id="cargo" name="cargo" class="art-input-custom" required>
                            </div>

                            <div>
                                <x-form-select
                                    label="Usuario"
                                    name="usuario_id"
                                    id="usuario_id"
                                    table="usuarios"
                                    valueField="usuario_id"
                                    labelField="nombre"
                                    :where="['estado' => 'A']"
                                    :orderBy="['nombre', 'asc']"
                                    placeholder="Seleccione un Usuario"
                                />
                            </div>

                    </div>
                    <x-form-auditoria/>
                </form>

                {{-- <x-buttons formId="empleadosForm" /> --}}
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

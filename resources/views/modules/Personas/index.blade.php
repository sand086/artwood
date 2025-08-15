@extends('layouts.appP')

@section('title', 'Personas')

@section('content')
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="Personas">
        <h1 class="text-3xl font-semibold mb-6">Personas</h1>

        <!-- Tabla  -->
        <div class="overflow-x-auto">
            <div class="p-1.5">
                <table id="personasTable" class="min-w-full bg-white divide-y divide-gray-200">
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
        <x-modal id="personasModal" formId="personasForm" size="lg" :showCancelButton="true" :showSaveButton="true"
            :showClearButton="true">
            {{-- Seccion HEADER del modal --}}
            <x-slot name="header">
                Formulario Personas
            </x-slot>
            {{-- Seccion BODY del modal --}}
            <x-slot name="body">
                {{-- <div x-data="{ tab: 'basicos', isEditing: false }" {{-- Estado activo de pestañas --}}
                    {{-- @update-alpine-tabs.window="
                        if ($event.target.id === 'personasModal') { // Asegura que el evento viene del modal correcto
                            isEditing = $event.detail.isEditing;
                            tab = $event.detail.tab;
                        }
                    " --}}
                {{-- > --}
                    {-- Navegación Tabs --}
                    <nav class="flex mb-2 border-b border-gray-200">
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="tab === 'basicos' ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-600'"
                            @click="tab = 'basicos'">
                            Info Básica
                        </button>
                        {{-- Pestaña Asociaciones (Habilitada solo si isEditing es true) --}
                        <button 
                            type="button"
                            class="px-4 py-2 -mb-px font-semibold"
                            :class="{
                                'border-b-2 border-indigo-500 text-indigo-600': tab === 'asociaciones' && isEditing,
                                'text-gray-600': tab !== 'asociaciones' || !isEditing, // Gris si no está activa o si no se está editando
                                'opacity-50 cursor-not-allowed': !isEditing       // Estilo deshabilitado si no se está editando
                            }"
                            @click="if (isEditing) tab = 'asociaciones'" {{-- Solo cambia la pestaña si se está editando --}
                            :disabled="!isEditing">
                            Asociaciones
                        </button>
                    </nav>
                    <hr>
                    {{-- Tabs --}
                    <div>
                        <div>
                            {{-- Info Básica --}
                            <div x-show="tab === 'basicos'" class="h-[550px] overflow-y-auto p-1"> --}}
                                <form id="personasForm" method="POST">
                                    @csrf
                                    <div class="grid grid-cols-1 gap-2">
                                        {{-- fila 1 --}}
                                        <div class="grid grid-cols-1 md:grid-cols-10 lg:grid-cols-10 gap-1">
                                            <div class="col-span-4 p-1 rounded-lg ">
                                                <label for="nombres" class="art-label-custom">
                                                    Nombres
                                                </label>
                                                <input type="text" id="nombres" name="nombres" class="art-input-custom"
                                                    placeholder="Nombre completo" required>
                                            </div>

                                            <div class="col-span-4 p-1 rounded-lg ">
                                                <label for="apellidos" class="art-label-custom">
                                                    Apellidos
                                                </label>
                                                <input type="text" id="apellidos" name="apellidos" class="art-input-custom"
                                                    placeholder="Apellido paterno" required>
                                            </div>

                                            <div class="col-span-2 p-1 rounded-lg ">
                                                <x-form-select
                                                    label="Tipo Identificación"
                                                    name="tipo_identificacion_id"
                                                    id="tipo_identificacion_id"
                                                    table="tiposidentificaciones"
                                                    valueField="tipo_identificacion_id"
                                                    labelField="nombre"
                                                    :where="['estado' => 'A']"
                                                    :orderBy="['nombre', 'asc']"
                                                    placeholder="Seleccione un Tipo Identificación"
                                                    :value="$proveedor->estado_pais_id ?? old('tipo_identificacion_id', '')"
                                                    required
                                                />
                                            </div>
                                        </div>
                                        {{-- fila 2 --}}
                                        <div class="grid grid-cols-1 md:grid-cols-10 lg:grid-cols-10 gap-1">
                                            <div class="col-span-4 p-1 rounded-lg ">
                                                <label for="direccion" class="art-label-custom">
                                                    Direcci&oacute;n
                                                </label>
                                                <input type="text" id="direccion" name="direccion" class="art-input-custom"
                                                    placeholder="Dirección completa" required>
                                            </div>

                                            <div class="col-span-4 p-1 rounded-lg ">
                                                <label for="colonia" class="art-label-custom">
                                                    Colonia
                                                </label>
                                                <input type="text" id="colonia" name="colonia" class="art-input-custom"
                                                    placeholder="Colonia">
                                            </div>

                                            <div class="col-span-2 p-1 rounded-lg ">
                                                <label for="identificador" class="art-label-custom">
                                                    identificador
                                                </label>
                                                <input type="text" id="identificador" name="identificador" class="art-input-custom"
                                                    placeholder="identificador">
                                            </div>
                                        </div>
                                        {{-- fila 3 --}}
                                        <div class="grid grid-cols-1 md:grid-cols-10 lg:grid-cols-10 gap-1">
                                            <div class="col-span-2 p-1 rounded-lg ">
                                                <x-form-select
                                                    label="Estado Pais"
                                                    name="estado_pais_id"
                                                    id="estado_pais_id"
                                                    table="estadospaises"
                                                    valueField="estado_pais_id"
                                                    labelField="nombre"
                                                    :where="['estado' => 'A']"
                                                    :orderBy="['nombre', 'asc']"
                                                    placeholder="Seleccione un Estado Pais"
                                                    :value="$proveedor->estado_pais_id ?? old('estado_pais_id', '')"
                                                />
                                            </div>

                                            <div class="col-span-2 p-1 rounded-lg ">
                                                <x-form-select
                                                    label="Municipio"
                                                    name="municipio_id"
                                                    id="municipio_id"
                                                    table="municipios"
                                                    valueField="municipio_id"
                                                    labelField="nombre"
                                                    parentIdField="estado_pais_id"
                                                    :where="['estado' => 'A']"
                                                    :orderBy="['nombre', 'asc']"
                                                    placeholder="Seleccione un Municipio"
                                                    :value="$proveedor->municipio_id ?? old('municipio_id', '')"
                                                />
                                            </div>

                                            <div class="col-span-2 p-1 rounded-lg ">
                                                <label for="telefono" class="art-label-custom">
                                                    Tel&eacute;fono
                                                </label>
                                                <input type="text" id="telefono" name="telefono" class="art-input-custom" placeholder="Teléfono fijo o móvil" required>
                                            </div>

                                            <div class="col-span-4 p-1 rounded-lg ">
                                                <label for="correo_electronico" class="art-label-custom">
                                                    Correo Electr&oacute;nico
                                                </label>
                                                <input type="email" id="correo_electronico" name="correo_electronico" placeholder="Correo electrónico" class="art-input-custom" required>
                                            </div>
                                        </div>
                                        <!-- Componente de auditoría (si aplica) -->
                                        <x-form-auditoria />
                                    </div>
                                </form>
                            {{-- </div>
        
                            {{-- Asociaciones --}
                            <div x-show="tab === 'asociaciones'" class="h-[550px] overflow-y-auto p-1">
                                {{-- @include('modules.Clientes.contactos') --}
                            </div>                            
                    </div>
                </div> --}}
            </x-slot>
            {{-- Seccion FOODER del modal --}}
            <x-slot name="footer">
            </x-slot>
        </x-modal>
    </div>
    <x-message />
@endsection

@push('scripts')
    {{-- Scripts personalizados --}}
@endpush
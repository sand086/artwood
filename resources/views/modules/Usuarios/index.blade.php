@extends('layouts.appP')

@section('title', 'Usuarios')

@section('content')
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="Usuarios">
        <h1 class="text-3xl font-semibold mb-6">Usuarios</h1>

        <div class="overflow-x-auto">
            <div class="p-1.5">
                <table id="usuariosTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="art-bg-primary art-text-background">
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        {{-- Datos de la tabla se llenarán con JavaScript --}}
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Modal para el formulario del módulo --}}
        <x-modal id="usuariosModal" formId="usuariosForm" :showCancelButton="true" :showSaveButton="true"
            :showClearButton="true" size="md">
            {{-- Sección HEADER del modal --}}
            <x-slot name="header">
                <h5 class="text-lg font-semibold">Formulario Usuarios</h5>
            </x-slot>
            {{-- Sección BODY del modal --}}
            <x-slot name="body">
                <form id="usuariosForm" method="POST">
                    @csrf
                    <div class="grid grid-cols-12 gap-4">
                        <!-- Foto -->
                        <div class="col-span-5">
                            <div
                                data-hs-file-upload='{
                                                                                                                                            "url": "/upload",
                                                                                                                                            "acceptedFiles": "image/*",
                                                                                                                                            "maxFiles": 1,
                                                                                                                                            "singleton": true
                                                                                                                                          }'>
                                <template data-hs-file-upload-preview="">
                                    <div class="w-20 h-20">
                                        <img class="w-full h-full object-cover rounded-full" data-dz-thumbnail="">
                                    </div>
                                </template>
                                <div class="flex flex-col items-center gap-2 mt-2">
                                    <!-- Placeholder de imagen -->
                                    <div class="group" data-hs-file-upload-previews=""
                                        data-hs-file-upload-pseudo-trigger="">
                                        <span class="file-upload-previews-span">
                                            <i class="w-8 h-8" data-lucide="circle-user-round"></i>
                                        </span>
                                    </div>
                                    <!-- Botones de acción  -->
                                    <div class="flex gap-2">
                                        <!-- Botón de upload (icono de subir) -->
                                        <button type="button" data-hs-file-upload-trigger=""
                                            class="art-button-upload-icon-user">

                                            <i class="w-6 h-6" data-lucide="upload"></i>
                                        </button>
                                        <!-- Botón de delete (X roja) -->
                                        <button type="button" data-hs-file-upload-clear=""
                                            class="art-button-trash-icon-upload-user">
                                            <i class="w-6 h-6" data-lucide="trash-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contenedor para Alias y Rol  -->
                        <div class="col-span-7 space-y-4">
                            <div>
                                <label for="nombre" class="art-label-custom">Alias (Usuario)</label>
                                <input type="text" id="nombre" name="nombre" placeholder="Ingresa alias"
                                    class="art-input-custom" required>
                            </div>

                            <div>
                                <x-form-select label="Role" name="role_id" id="role_id" table="roles" valueField="role_id"
                                    labelField="name" :where="['estado' => 'A']" :orderBy="['role_id', 'asc']"
                                    placeholder="Seleccione un Rol" />
                            </div>

                        </div>

                        <!-- Nombres, Apellidos  -->

                        <div class="col-span-12 grid grid-cols-2 gap-4">
                            <div>
                                <label for="nombres" class="art-label-custom">Nombres</label>
                                <input type="text" id="nombres" name="nombres" placeholder="Ingresa nombres"
                                    class="art-input-custom" required>
                            </div>
                            <div>
                                <label for="apellidos" class="art-label-custom">Apellidos</label>
                                <input type="text" id="apellidos" name="apellidos" placeholder="Ingresa apellidos"
                                    class="art-input-custom" required>
                            </div>
                        </div>

                        <!-- Teléfono y Email -->
                        <div class="col-span-12 grid grid-cols-2 gap-4">
                            <div>
                                <label for="telefono" class="art-label-custom">Teléfono</label>
                                <input type="text" id="telefono" name="telefono" placeholder="Ingresa teléfono"
                                    class="art-input-custom" required>
                            </div>
                            <div>
                                <label for="email" class="art-label-custom">Email</label>
                                <input type="email" id="email" name="email" placeholder="Ingresa email"
                                    class="art-input-custom" required>
                            </div>
                        </div>

                        <!-- Dirección  -->
                        <div class="col-span-12 space-y-4">
                            <div>
                                <label for="direccion" class="art-label-custom">Dirección</label>
                                <input type="text" id="direccion" name="direccion" placeholder="Ingresa dirección"
                                    class="art-input-custom" required>
                            </div>
                        </div>
                        <!-- Bloque para Contraseña y Confirmación (solo en creación) -->
                        <div class="password-fields col-span-12 grid grid-cols-2 gap-4">
                            <div>
                                <label for="password" class="art-label-custom">Contraseña</label>
                                <input type="password" id="password" name="password" placeholder="Ingresa la contraseña"
                                    class="art-input-custom" required>
                            </div>
                            <div>
                                <label for="password_confirmation" class="art-label-custom">Confirmar
                                    Contraseña</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    placeholder="Confirma la contraseña" class="art-input-custom" required>
                            </div>
                        </div>




                    </div>


                    {{-- Sección FOOTER del modal, por ejemplo para auditoría --}}
                    <x-form-auditoria />
                </form>
            </x-slot>
            {{-- Sección FOOTER del modal --}}
            <x-slot name="footer">
                {{-- Puedes incluir botones adicionales si es necesario --}}
            </x-slot>
        </x-modal>
    </div>
    <x-message />
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function actualizarVisibilidadPassword() {
                const $form = $('#usuariosForm');
                const formType = $form.attr('data-type');
                // console.log('Valor de data-type:', formType);

                if (formType === 'PUT') {
                    $('.password-fields').hide();
                    // console.log('Ocultando campos de contraseña');
                } else {
                    $('.password-fields').show();
                    // console.log('Mostrando campos de contraseña');
                }
            }

            // Intentamos primero con el evento de Bootstrap
            const modalEl = document.getElementById('usuariosModal');
            if (modalEl) {
                modalEl.addEventListener('shown.bs.modal', function () {
                    actualizarVisibilidadPassword();
                });
            }

            // Fallback: llamar a la función después de un breve retraso
            setTimeout(actualizarVisibilidadPassword, 500);
        });
    </script>

@endpush
@extends('layouts.appP')

@section('title', 'Ajustes')

@section('content')
    <div class="@container m-8 px-4 sm:px-6 lg:px-8" data-module="Ajustes">
        <h1 class="text-3xl font-semibold mb-6">Ajustes</h1>

        <div class="overflow-x-auto">
            <div class="p-1.5">
                <form id="ajustesForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="grid grid-cols-12 gap-4">
                        <!-- Configuración general -->

                        <div class="col-span-12 mt-6">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="timezone" class="block text-sm font-medium text-gray-700">Zona
                                        horaria</label>
                                    <select id="timezone" name="timezone" class="art-input-custom">
                                        <option value="America/Mexico_City">Ciudad de México</option>
                                        <option value="America/New_York">Nueva York</option>
                                        <option value="Europe/Madrid">Madrid</option>
                                    </select>
                                </div>
                                {{--                                 <div>
                                            <label for="language" class="block text-sm font-medium text-gray-700">Idioma</label>
                                            <select id="language" name="language" class="art-input-custom">
                                                <option value="es">Español</option>
                                                <option value="en">Inglés</option>
                                            </select>
                                        </div> --}}
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="art-button-primary flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" data-lucide="save"></svg>
                            Guardar ajustes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Inicializa validaciones o plugins adicionales que requieras en ajustes
        });
    </script>
@endpush
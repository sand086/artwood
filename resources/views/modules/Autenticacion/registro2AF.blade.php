@extends('layouts.app')

@section('title', 'Registro con Doble Factor')

@section('content')
    <div class="min-h-screen flex items-center justify-center container mx-auto px-4">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-lg">
            <div class="flex justify-center mb-6">
                <img class="object-cover transition-transform duration-500 ease-in-out rounded-t-xl"
                    src="{{ asset('images/icons/artwood-logo.svg') }}" alt="artwood" width="250">
            </div>
            <div class="p-4 md:p-5">
                <h1 class="font-poppins text-2xl font-semibold text-gray-800 text-center mb-4">
                    Autenticación de Doble Factor (2FA)
                </h1>

                <!-- Paso 1 -->
                <div class="mb-6 grid grid-cols-1">
                    <h3 class="text-lg font-semibold text-gray-700">
                        Paso 1: Usa una aplicación MFA en un dispositivo de confianza
                    </h3>
                    <p class="text-sm text-gray-600">
                        Abre la aplicación y selecciona la opción para agregar una nueva cuenta.
                    </p>
                </div>

                <!-- Paso 2 -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 items-center">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Paso 2: Escanea el código QR</h3>
                        <p class="text-sm text-gray-600">
                            Usa la cámara de tu teléfono o ingresa la siguiente clave manualmente:
                        </p>
                        <p id="clave2AF" class="mt-2 font-bold text-blue-600">Cargando...</p>
                    </div>

                    <!-- Spinner y Código QR -->
                    <div class="flex flex-col items-center">
                        <div id="spinner"
                            class="animate-spin w-10 h-10 border-4 border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500">
                            <span class="sr-only">Cargando...</span>
                        </div>

                        <img id="clave2AFQr" class="mx-auto w-40 h-40 border rounded-lg mt-4 hidden"
                            alt="Código QR para 2FA">
                    </div>
                </div>

                <!-- Paso 3 -->
                <div class="mb-6">
                    <div class="my-4 text-center">
                        <h3 class="text-lg font-semibold text-gray-700">Paso 3: Ingresa tu código</h3>
                        <p class="text-sm text-gray-600">Introduce el código de verificación de 6 dígitos generado por la
                            app.</p>
                    </div>

                    <!-- Input de Código 2FA -->
                    <div class="flex gap-x-3 justify-center">
                        <div class="flex gap-x-3" data-hs-pin-input="">
                            <input type="text"
                                class="block w-12 h-12 art-input text-center art-border-gray-400 rounded-md sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                data-hs-pin-input-item="" autofocus="">
                            <input type="text"
                                class="block w-12 h-12 art-input text-center art-gray-600 rounded-md sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                data-hs-pin-input-item="">
                            <input type="text"
                                class="block w-12 h-12 art-input text-center border-gray-200 rounded-md sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                data-hs-pin-input-item="">
                            <input type="text"
                                class="block w-12 h-12 art-input text-center border-gray-200 rounded-md sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                data-hs-pin-input-item="">
                            <input type="text"
                                class="block w-12 h-12 art-input text-center border-gray-200 rounded-md sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                data-hs-pin-input-item="">
                            <input type="text"
                                class="block w-12 h-12 art-input text-center border-gray-200 rounded-md sm:text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                data-hs-pin-input-item="">
                        </div>
                    </div>

                    <!-- Botones de acción -->
                    <div class="flex justify-between items-center text-sm text-gray-600 mb-6 mt-5">
                        <a href="{{ route('login') }}"
                            class="px-4 py-2 bg-gray-300 art-btn-tertiary text-gray-700 rounded-lg hover:bg-gray-400 transition flex items-center">
                            <i data-lucide="arrow-left" class="mr-2" aria-hidden="true"></i> Volver al inicio de sesión
                        </a>

                        <button type="button" id="verificar_2af_registro"
                            class="px-4 py-2 art-btn-primary text-white rounded-lg hover:art-bg-primary-700 transition flex items-center">
                            Verificar <i data-lucide="check-check" class="ml-2" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@vite('resources/js/modules/Autenticacion/registro2AF.js')

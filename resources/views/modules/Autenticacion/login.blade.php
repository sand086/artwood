{{-- resources/views/auth/login.blade.php --}}
@extends('layouts.app')

@section('title', 'Iniciar Sesión')

{{-- 1) Inyectamos la clave pública de reCAPTCHA en un meta tag --}}
@section('meta')
    <meta name="recaptcha-key" content="{{ env('GOOGLE_RECAPTCHA_KEY') }}">
@endsection


@section('content')

    <div>
        <div class="min-h-screen flex items-center justify-center">
            <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">

                <div class="relative rounded-t-xl overflow-hidden flex justify-center mb-6">
                    <img class="size-full top-0 left-0 object-cover group-hover:scale-105 group-focus:scale-80 transition-transform duration-500 ease-in-out rounded-t-xl"
                        src="{{ asset('images/icons/artwood-logo.svg') }}" alt="Logo" width="200">
                </div>
                <div class="p-4 md:p-5">
                    <h2 class="font-poppins text-3xl font-semibold text-gray-800 text-center mb-2">Bienvenido</h2>
                    <p class="text-center text-gray-600 mb-6">Panel de Control</p>
                    <!-- Formulario de Login -->

                    <form class="space-y-4" id="loginForm" novalidate>
                        @csrf

                        <div class="mt-1 text-gray-500">
                            <div class="max-w-sm space-y-3">
                                <div class="relative">
                                    <input type="text" name="usuario" aria-describedby="hs-validation-usuario-error-helper"
                                        id="usuario"
                                        class="peer py-3  pl-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm art-input focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Correo electrónico">
                                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none pl-4">
                                        <i class="shrink-0 w-4 h-4 text-gray-500" data-lucide="circle-user"></i>
                                    </div>
                                    <div
                                        class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3 invisible error-icon ">
                                        <i class="shrink-0 size-4 text-red-500" data-lucide="info"></i>

                                    </div>

                                </div>
                                <span class="text-sm text-red-600 mt-2 invisible error-message"
                                    id="hs-validation-usuario-error-helper"></span>
                                <div class="relative">
                                    <input name="contrasena" type="password" id="contrasena"
                                        aria-describedby="hs-validation-contrasena-error-helper"
                                        class="peer py-3 pl-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm art-input focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Contraseña" value="">
                                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none pl-4">
                                        <i data-lucide="key-round" class="w-4 h-4 text-gray-500"></i>
                                    </div>
                                    <div
                                        class="absolute inset-y-0 end-6 flex items-center pointer-events-none pe-3 invisible error-icon">
                                        <i class="shrink-0 size-4 text-red-500" data-lucide="info"></i>

                                    </div>

                                    <button type="button" data-hs-toggle-password='{"target": "#contrasena"}'
                                        class="absolute inset-y-0 end-0 flex items-center z-20 px-3 cursor-pointer text-gray-400 rounded-e-md focus:outline-none focus:text-blue-600 dark:text-neutral-600 dark:focus:text-blue-500">
                                        <!-- Icono cuando la contraseña está oculta: eye-off -->
                                        <i data-lucide="eye-off"
                                            class="hs-password-active:hidden w-4 h-4 text-gray-500"></i>
                                        <!-- Icono cuando se muestra la contraseña: eye -->
                                        <i data-lucide="eye"
                                            class="hidden hs-password-active:block w-4 h-4 text-gray-500"></i>
                                    </button>

                                </div>
                                <span class="text-sm text-red-600 mt-2 invisible error-message"
                                    id="hs-validation-contrasena-error-helper"></span>

                                <div class="flex justify-between items-center">
                                    <div class="flex items-center">
                                        <input type="checkbox"
                                            class="shrink-0 mt-0.5 border-gray-200 rounded art-input focus:ring-dark-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-dark-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                            id="recordar-usuario-checkbox">
                                        <label for="recordar-usuario-checkbox"
                                            class="text-sm text-gray-500 ms-3 dark:text-neutral-400">Recuerdame</label>
                                    </div>
                                    <a href="{{ route('recoveryContrasena') }}"
                                        class="text-sm text-blue-500 hover:text-blue-600 dark:text-neutral-500 dark:hover:text-neutral-600">
                                        Olvidé mi contraseña
                                    </a>
                                </div>
                                <div class="relative">
                                    <input type="password" name="codigo_2fa" id="codigo_2fa"
                                        aria-describedby="hs-validation-codigo_2fa-error-helper"
                                        class="peer py-3  pl-11 block w-full bg-gray-100 border-transparent rounded-lg art-input  text-sm focus:border-blue-500 focus:ring-blue-500"
                                        placeholder="Doble factor">
                                    <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none pl-4">
                                        <i class="shrink-0 w-4 h-4 text-gray-500" data-lucide="fingerprint"></i>
                                    </div>
                                    <div
                                        class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3 invisible error-icon">

                                        <i class="shrink-0 size-4 text-red-500" data-lucide="info"></i>
                                    </div>
                                </div>
                                <span class="text-sm text-red-600 mt-3 invisible error-message"
                                    id="hs-validation-codigo_2fa-error-helper"></span>

                            </div>
                        </div>
                        <div class="pt-4">

                            <button type="submit" id="btnLogin"
                                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent art-btn-secondary  focus:outline-none  disabled:opacity-50 disabled:pointer-events-none">
                                Iniciar Sesión <i class="shrink-0 size-4" data-lucide="log-in"></i>
                            </button>

                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- 1) Carga el script de Google reCAPTCHA v3 con tu site key --}}
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('GOOGLE_RECAPTCHA_KEY') }}" async defer></script>

    {{-- 2) Tu lógica de login (login.js) --}}
    @vite('resources/js/modules/Autenticacion/login.js')
@endpush
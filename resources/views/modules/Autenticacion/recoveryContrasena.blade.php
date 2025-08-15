@extends('layouts.app')

@section('title', 'Recuperar Contraseña')

@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
            <!-- Logo -->
            <div class="relative rounded-t-xl overflow-hidden flex justify-center mb-6">
                <img class="w-32" src="{{ asset('images/icons/artwood-logo.svg') }}" alt="Logo">
            </div>
            <div class="p-4 md:p-5">
                <h2 class="font-poppins text-2xl font-semibold text-gray-800 text-center mb-2">¿Olvidaste tu contraseña?
                </h2>
                <p class="text-center text-gray-600 mb-6">
                    ¿Recuerdas tu contraseña?
                    <a href="{{ route('login') }}"
                        class="text-blue-600 decoration-2 hover:underline focus:outline-none font-medium">
                        Inicia sesión aquí
                    </a>
                </p>
                <!-- Formulario -->
                <form method="POST" action="#" class="space-y-4">
                    @csrf
                    <!-- Campo de correo electrónico -->
                    <div>
                        <label for="email" class="block text-sm mb-2">Correo electrónico</label>
                        <div class="relative">
                            <input type="email" name="email" required
                                class="peer py-3  pl-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Escribe tu correo electrónico">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none pl-4">
                                <i class="shrink-0 w-4 h-4 text-gray-500" data-lucide="circle-user"></i>
                            </div>
                        </div>
                    </div>
                    <!-- Botón para restablecer contraseña -->
                    <a href="{{ route('correoEnviadoRecoveryContrasena') }}"
                        class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent art-btn-secondary text-white  focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                        Restablecer contraseña
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection
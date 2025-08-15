@extends('layouts.app')

@section('title', 'Correo Enviado')

@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
            <!-- Logo -->
            <div class="relative rounded-t-xl overflow-hidden flex justify-center mb-6">
                <img class="w-32" src="{{ asset('images/icons/artwood-logo.svg') }}" alt="Logo">
            </div>
            <div class="p-4 md:p-5 text-center">
                <h2 class="font-poppins text-2xl font-semibold text-gray-800 mb-2">Correo Enviado</h2>
                <p class="text-gray-600 mb-6">
                    Si el correo que ingresaste está registrado, hemos enviado un enlace para restablecer tu contraseña. Por
                    favor, revisa tu bandeja de entrada (y la carpeta de spam) y sigue las instrucciones del correo.
                </p>
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">
                    Volver a Iniciar Sesión
                </a>
            </div>
        </div>
    </div>
@endsection
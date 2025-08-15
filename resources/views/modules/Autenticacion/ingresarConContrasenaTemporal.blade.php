@extends('layouts.app')

@section('title', 'Verificar Código Temporal')

@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
            <!-- Logo -->
            <div class="flex justify-center mb-6">
                <img class="w-32" src="{{ asset('images/icons/artwood-logo.svg') }}" alt="Logo">
            </div>
            <div class="p-4 md:p-5">
                <h2 class="font-poppins text-2xl font-semibold text-gray-800 text-center mb-2">
                    Ingresa tu contraseña temporal
                </h2>
                <p class="text-center text-gray-600 mb-4">
                    Revisa tu correo para obtener el código (6 dígitos alfanuméricos). Este código es válido por 5 minutos.
                </p>
                <!-- Temporizador -->
                <div class="text-center mb-4">
                    <span id="countdown" class="text-lg font-bold text-blue-600">05:00</span>
                </div>
                <!-- Formulario para verificar el código -->
                <form method="POST" action="#" class="space-y-4">
                    @csrf
                    <div>
                        <label for="token" class="block text-sm mb-2">Código Temporal</label>
                        <div class="relative">
                            <input type="text" name="token" id="token" required maxlength="6"
                                class="py-3 pl-11 block w-full bg-gray-100 border-transparent rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500"
                                placeholder="Ingresa el código">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none pl-4">
                                <i class="w-4 h-4 text-gray-500" data-lucide="qr-code"></i>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-between items-center">

                        <!-- Botón para reenviar el código -->
                        <a id="resend-btn" href="#"
                            class="py-2 px-1 inline-flex justify-center items-center gap-x-2 text-sm font-medium art-text-primary cursor-not-allowed opacity-50">
                            <strong> Reenviar Código</strong>
                        </a>
                        <!-- Botón para verificar el código -->
                        <button type="submit"
                            class="py-2 px-2 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent art-btn-secondary focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            <i data-lucide="check-check"></i> Verificar Código
                        </button>

                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Duración del token: 5 minutos = 300 segundos
        let timeLeft = 3;
        const countdownElement = document.getElementById('countdown');
        const resendBtn = document.getElementById('resend-btn');

        const timer = setInterval(() => {
            timeLeft--;
            const minutes = Math.floor(timeLeft / 60).toString().padStart(2, '0');
            const seconds = (timeLeft % 60).toString().padStart(2, '0');
            countdownElement.textContent = `${minutes}:${seconds}`;

            if (timeLeft <= 0) {
                clearInterval(timer);
                countdownElement.textContent = "00:00";
                // Habilitar el botón para reenviar el código
                resendBtn.classList.remove('cursor-not-allowed', 'opacity-50');
                resendBtn.classList.add('cursor-pointer');
            }
        }, 1000);
    </script>
@endsection
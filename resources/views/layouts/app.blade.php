<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'ARTWOOD')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta name="recaptcha-key" content="{{ env('GOOGLE_RECAPTCHA_KEY') }}"> --}}

    @yield('meta') <!--  meta tags dinámicamente en otras vistas -->

    <link rel="icon" href="{{ asset('images/icons/Favicon.svg') }}" type="image/png">

    <!-- Vite: CSS -->
    @vite('resources/css/app.css')

    <!-- Stack para estilos adicionales -->
    @stack('styles')

</head>

<body class="art-bg-primary">

    @yield('content')



    <!-- Stack para scripts antes de cerrar <body> -->
    @stack('scripts')

    <!-- Vite: JS -->
    @vite('resources/js/app.js')

    <!--  Preline desde public/js/ -->
    <script src="{{ asset('js/preline.js') }}" defer></script>

</body>

</html>
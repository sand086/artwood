<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link rel="icon" href="<?php echo e(asset('images/icons/Favicon.svg')); ?>" type="image/png">


    <!-- Espacio para CSS adicionales en vistas -->
    <?php echo $__env->yieldPushContent('styles'); ?>


    <!-- Cargar DataTables CSS desde public/css/datatables -->
    <link rel="stylesheet" href="<?php echo e(asset('css/datatables/datatables.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/datatables/datatables-responsive.css')); ?>">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Ocultar contenido hasta validar autenticación -->
    <script>
        document.documentElement.style.visibility = 'hidden';
    </script>

</head>

<body class="bg-gray-100" x-data="{ sidebarOpen: true, loading: true }"
    x-init="window.addEventListener('load', () => loading = false)">
    <!-- Overlay de carga -->
    <div x-show="loading" class="fixed inset-0 bg-white flex items-center justify-center z-50">
        <img src="<?php echo e(asset('images/icons/CargandoArtwood.gif')); ?>" alt="Cargando..." class="h-40 w-40" />
    </div>
    <!-- Contenedor Principal -->
    <div class="flex h-screen overflow-hidden" x-cloak>

        <!-- SIDEBAR -->
        <?php echo $__env->make('partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- FIN SIDEBAR -->

        <!-- CONTENEDOR DERECHA: NAVBAR ARRIBA + CONTENIDO -->
        <div class="flex-1 flex flex-col">
            <!-- NAVBAR SUPERIOR -->
            <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <!-- FIN NAVBAR -->
            <main class="flex-1 overflow-y-auto">
                <!-- CONTENIDO PRINCIPAL -->
                <?php echo $__env->yieldContent('content'); ?>
            </main>

        </div>


    </div>

    <!-- Espacio para scripts adicionales en vistas -->
    <?php echo $__env->yieldPushContent('scripts'); ?>

    <!-- Cargar Preline desde public/js/ -->
    <script src="<?php echo e(asset('js/preline.js')); ?>"></script>


    <!-- Cargar JS CSS con Vite -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>





</body>

</html><?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/layouts/appP.blade.php ENDPATH**/ ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'ARTWOOD'); ?></title>

    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    

    <?php echo $__env->yieldContent('meta'); ?> <!--  meta tags dinámicamente en otras vistas -->

    <link rel="icon" href="<?php echo e(asset('images/icons/Favicon.svg')); ?>" type="image/png">

    <!-- Vite: CSS -->
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>

    <!-- Stack para estilos adicionales -->
    <?php echo $__env->yieldPushContent('styles'); ?>

</head>

<body class="art-bg-primary">

    <?php echo $__env->yieldContent('content'); ?>



    <!-- Stack para scripts antes de cerrar <body> -->
    <?php echo $__env->yieldPushContent('scripts'); ?>

    <!-- Vite: JS -->
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/app.js'); ?>

    <!--  Preline desde public/js/ -->
    <script src="<?php echo e(asset('js/preline.js')); ?>" defer></script>

</body>

</html><?php /**PATH C:\xampp\htdocs\github\artwoort\resources\views/layouts/app.blade.php ENDPATH**/ ?>
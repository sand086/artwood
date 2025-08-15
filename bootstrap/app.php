<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

use App\Http\Middleware\CheckJwtToken;
use App\Http\Middleware\JwtSessionMiddleware;



return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->alias([
            //'auth'     => \Illuminate\Auth\Middleware\Authenticate::class,
            'jwt.auth' => CheckJwtToken::class,
            'jwt.session'  => JwtSessionMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {})->create();

$app->singleton(
    App\Console\Commands\GenerarModulo::class,
    function ($app) {
        return new App\Console\Commands\GenerarModulo();
    }
);

$app->singleton(
    App\Console\Commands\GenerarModuloRolesYPermisos::class,
    function ($app) {
        return new App\Console\Commands\GenerarModuloRolesYPermisos();
    }
);

$app->bind(
    App\Console\Kernel::class,
    function ($app) {
        return new App\Console\Kernel($app);
    }
);

// ...

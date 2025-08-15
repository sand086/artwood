<?php

namespace App\Providers;
use App\Models\CotizacionesRecursos;
use App\Observers\CotizacionesRecursosObserver;

use Illuminate\Support\ServiceProvider;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            // Toma el token desde la cookie
            $token = request()->cookie('token');
            $user  = null;
            if ($token) {
                try {
                    $user = JWTAuth::setToken($token)->authenticate();
                    // opcional: Auth::login($user);
                } catch (\Exception $e) {
                    $user = null;
                }
            }
            $view->with('user', $user);
        });

        // Registrar el observer para el modelo CotizacionRecurso
        CotizacionesRecursos::observe(CotizacionesRecursosObserver::class);
    }
}

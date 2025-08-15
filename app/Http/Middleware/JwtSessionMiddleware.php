<?php
// app/Http/Middleware/JwtSessionMiddleware.php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtSessionMiddleware
{
    public function handle($request, Closure $next)
    {
        // Si no hay usuario en el guard web aún:
        if (! Auth::check()) {
            // Toma el token de la cookie 'token'
            $token = $request->cookie('token');
            if ($token) {
                try {
                    // Valida y obtiene el user
                    $user = JWTAuth::setToken($token)->authenticate();
                    // Lo “loguea” en el guard web
                    Auth::login($user);
                } catch (\Exception $e) {
                    // token inválido, no hacemos nada
                }
            }
        }

        return $next($request);
    }
}

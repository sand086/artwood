<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Auth;


use App\Models\TokenUsuario;

class CheckJwtToken
{
    /**
     * Middleware para validar el token en cada solicitud protegida.
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            // Obtener token desde el encabezado de autorización
            $token = $request->bearerToken();


            if (!$token) {
                return response()->json(['error' => 'No autenticado - No token'], 401);
            }

            // Intentar autenticar con JWT
            $user = JWTAuth::setToken($token)->authenticate();
            Auth::login($user);
            //$user = JWTAuth::setToken($request->bearerToken())->authenticate();
            if (!$user) {
                return response()->json(['error' => 'Usuario no encontrado'], 401);
            }

            // Verificar si el token sigue siendo el más reciente en la base de datos
            if (!$this->esTokenValido($user->usuario_id, $token)) {
                return response()->json(['error' => 'Token inválido o reemplazado'], 401);
            }

            // Auth::login($user);
            // Agregar usuario autenticado al request
            $request->merge(['auth_user' => $user]);

            return $next($request);
        } catch (TokenExpiredException $e) {
            return response()->json(['error' => 'Token expirado'], 401);
        } catch (TokenInvalidException $e) {
            return response()->json(['error' => 'Token inválido'], 401);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Error en el token'], 401);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No autenticado', 'detalle' => $e->getMessage()], 401);
        }
    }

    /**
     * Verifica si el token en la solicitud es el más reciente en la base de datos.
     */
    private function esTokenValido($usuarioId, $token)
    {
        // Obtener el token activo más reciente del usuario
        $tokenEnDB = TokenUsuario::where('usuario_id', $usuarioId)
            ->where('estado', 'A')
            ->orderBy('fecha_registro', 'desc')
            ->first();

        return $tokenEnDB && $tokenEnDB->token === $token;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Http\Requests\AutenticacionRequest;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use PragmaRX\Google2FA\Google2FA;
use App\Models\Usuarios;
use App\Models\TokenUsuario;


class AutenticacionController extends Controller
{
    /**
     * Iniciar sesión y generar un token JWT.
     */
    public function login(AutenticacionRequest $request)
    {
        try {

            // validar google reCAPTCHA
            $this->validarRecaptcha($request);

            $usuario = Usuarios::where('nombre', $request->usuario)->first();

            if (!$usuario || !Hash::check($request->contrasena, $usuario->contrasena)) {
                return $this->respuestaJson(false, 'Credenciales incorrectas', 401);
            }
            if ($usuario->no_intentos >= 5) {
                return $this->respuestaJson(false, 'Usuario bloqueado por múltiples intentos fallidos.', 403);
            }

            $custom = [
                'nombre'   => $usuario->nombre,
                'foto_url' => $usuario->foto_url,
            ];

            if (!$token = JWTAuth::claims($custom)->attempt(['nombre' => $usuario->nombre, 'password' => $request->contrasena])) {
                return $this->respuestaJson(false, 'Credenciales inválidas', 401);
            }

            // Guardar el token
            TokenUsuario::create([
                'usuario_id' => $usuario->usuario_id,
                'token' => $token,
                'estado' => 'A',
                'fecha_registro' => now(),
                'fecha_actualizacion' => now(),
            ]);

            // Cargar roles y permisos
            $usuario->load('roles', 'permissions'); // Opcional pero recomendado
            $roles = $usuario->getRoleNames(); // Devuelve una colección (puedes convertirla a array si lo deseas)
            $permisos = $usuario->getAllPermissions()->pluck('name'); // Devuelve una colección

            // Configurar 2FA si no está configurado
            if (!$usuario->doble_factor) {
                $datos_clave2FA = $this->generarClave2FA($usuario);
                $clave2FA = $datos_clave2FA->getData();

                return $this->respuestaJson(true, 'Se requiere configuración de 2FA', 200, [
                    'clave_2fa'    => $clave2FA->secret,
                    'clave_2fa_url' => $clave2FA->qr_url,
                    'usuario'      => $usuario->nombre,
                    'token'        => $token,
                    'tipo_token'   => 'Bearer',
                    'roles'        => $roles,      // Retorna roles asignados
                    'permisos'     => $permisos,   // Retorna permisos asignados
                    'redirect'     => url('/registro-2fa')
                ]);
            }

            // Validar 2FA
            if (!$this->validarCodigo2FA($usuario, $request->codigo_2fa)) {
                $usuario->increment('no_intentos');
                $intentosRestantes = 5 - $usuario->no_intentos;

                if ($usuario->no_intentos >= 5) {
                    return $this->respuestaJson(false, 'Cuenta bloqueada por múltiples intentos fallidos.', 403);
                }

                return $this->respuestaJson(false, 'Código 2FA incorrecto', 422, [
                    'errors' => ['codigo_2fa' => ["Código 2FA incorrecto. Intentos restantes: {$intentosRestantes}"]]
                ]);
            }

            // Restablecer intentos y actualizar fecha
            $usuario->update(['no_intentos' => 0, 'fecha_ultimo_acceso' => now()]);

            return $this->respuestaJson(true, 'Inicio de sesión exitoso', 200, [
                'usuario' => $usuario->nombre,
                'token' => $token,
                'tipo_token' => 'Bearer',
                'roles' => $roles,
                'permisos' => $permisos,
                'redirect' => url('/home')
            ]);
        } catch (HttpResponseException $e) {
            // Si validarRecaptcha abortó con JSON 422, devolvemos exactamente esa respuesta
            return $e->getResponse();
        } catch (\Throwable $e) {
            // Errores "reales" de servidor
            Log::error('Error en login(): ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            $data = ['error' => $e->getMessage()];
            if (config('app.debug')) {
                $data['trace'] = $e->getTraceAsString();
            }

            return $this->respuestaJson(
                false,
                'Error en el servidor: ' . ($e->getMessage() ?: get_class($e)),
                500,
                $data
            );
        }
    }

    private function validarRecaptcha(Request $request)
    {

        try {
            $token = $request->input('recaptcha');

            if (!$token) {
                Log::warning('Token reCAPTCHA no recibido en la solicitud.');
                abort(response()->json([
                    'resultado' => false,
                    'message' => 'Token de reCAPTCHA no enviado',
                    'errors' => ['recaptcha' => ['Por favor, intenta nuevamente.']]
                ], 422));
            }

            $client = new \GuzzleHttp\Client([
                'verify' => config('app.env') === 'local' ? false : true,
            ]);
            $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
                'form_params' => [
                    'secret' => env('GOOGLE_RECAPTCHA_SECRET'),
                    'response' => $token,
                ],
            ]);

            $body = json_decode((string) $response->getBody(), true);

            //Log::info('Respuesta reCAPTCHA:', $body); // Log de ayuda

            //var_dump($body);

            if (!isset($body['success']) || !$body['success']) {
                abort(response()->json([
                    'resultado' => false,
                    'message' => 'Error al validar el reCAPTCHA',
                    'errors' => ['recaptcha' => ['La verificación de reCAPTCHA falló.']]
                ], 422));
            }

            // Si está presente el score y es bajo, también podemos rechazar
            if (isset($body['score']) && $body['score'] < 0.5) {
                abort(response()->json([
                    'resultado' => false,
                    'message' => 'Actividad sospechosa detectada por reCAPTCHA',
                    'errors' => ['recaptcha' => ['Tu comportamiento fue considerado sospechoso.']]
                ], 422));
            }
        } catch (\Exception $e) {
            Log::error('Error al validar reCAPTCHA: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            abort(response()->json([
                'resultado' => false,
                'message' => 'Error interno al validar reCAPTCHA',
                'errors' => ['recaptcha' => [$e->getMessage()]]
            ], 500));
        }
    }




    public function loginWeb(AutenticacionRequest $request)
    {
        try {
            // Buscar al usuario por su "nombre"
            $usuario = Usuarios::where('nombre', $request->usuario)->first();

            if (!$usuario || !Hash::check($request->contrasena, $usuario->contrasena)) {
                return response()->json([
                    'resultado' => false,
                    'message'   => 'Credenciales incorrectas'
                ], 401);
            }

            // Si el usuario está bloqueado, denegar acceso
            if ($usuario->no_intentos >= 5) {
                return response()->json([
                    'resultado' => false,
                    'message'   => 'Usuario bloqueado por múltiples intentos fallidos.'
                ], 403);
            }

            // Si el usuario no tiene 2FA configurado, generarlo y enviar la información necesaria
            if (!$usuario->doble_factor) {
                $datos_clave2FA = $this->generarClave2FA($usuario);
                $clave2FA = $datos_clave2FA->getData();

                return response()->json([
                    'resultado'      => true,
                    'message'        => 'Se requiere configuración de 2FA',
                    'clave_2fa'      => $clave2FA->secret,
                    'clave_2fa_url'  => $clave2FA->qr_url,
                    'usuario'        => $usuario->nombre,
                    'redirect'       => url('/registro-2fa')
                ], 200);
            }

            // Si el usuario ya tiene 2FA, se espera que el formulario envíe el código
            if (empty($request->codigo_2fa) || !$this->validarCodigo2FA($usuario, $request->codigo_2fa)) {
                $usuario->increment('no_intentos');
                $intentosRestantes = 5 - $usuario->no_intentos;

                return response()->json([
                    'resultado' => false,
                    'errors'    => ['codigo_2fa' => ["Código 2FA incorrecto. Intentos restantes: {$intentosRestantes}"]],
                    'message'   => "Código 2FA incorrecto. Intentos restantes: {$intentosRestantes}",

                ], 422);
            }

            // Si la validación 2FA es correcta, restablecer intentos y actualizar la fecha de último acceso
            $usuario->update([
                'no_intentos'         => 0,
                'fecha_ultimo_acceso' => now()
            ]);

            // Autenticar al usuario en el guard "web" (esto crea la sesión)
            Auth::login($usuario);
            $request->session()->regenerate();

            return response()->json([
                'resultado' => true,
                'message'   => 'Inicio de sesión exitoso',
                'usuario'   => $usuario->nombre,
                'redirect'  => url('/home')
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error en loginWeb', ['error' => $e->getMessage()]);
            return response()->json([
                'resultado' => false,
                'message'   => 'Error en el servidor',
                'error'     => $e->getMessage()
            ], 500);
        }
    }





    /**
     * Generar código QR y clave secreta para 2FA.
     */
    public function generarClave2FA(Usuarios $usuario)
    {
        if ($usuario->doble_factor) {
            return $this->respuestaJson(false, '2FA ya está activado', 400);
        }

        $google2fa = new Google2FA();
        $secretKey = $google2fa->generateSecretKey();

        $usuario->doble_factor = $secretKey;
        $usuario->save();

        $qrUrl = "otpauth://totp/Artwood:{$usuario->nombre}?secret={$secretKey}&issuer=Artwood";
        $qrPath = "qrcodes/{$usuario->usuario_id}_2fa.png";
        Storage::disk('public')->put($qrPath, QrCode::format('png')->size(300)->generate($qrUrl));

        return $this->respuestaJson(true, '2FA generado correctamente', 200, [
            'secret' => $secretKey,
            'qr_url' => asset("storage/$qrPath"),
        ]);
    }

    /**
     * Verificar código 2FA.
     */
    public function verificar2FA(Request $request)
    {
        try {
            $usuario = JWTAuth::parseToken()->authenticate();
            $roles = $usuario->getRoleNames();

            if (!$usuario || !$usuario->doble_factor) {
                return $this->respuestaJson(false, 'Usuario no autenticado o sin 2FA', 401);
            }

            if (!$this->validarCodigo2FA($usuario, $request->codigo_2fa)) {
                $codigoEstado = $request->has('error_input') && !empty($request->error_input) ? $request->error_input : 422;

                return $this->respuestaJson(false, 'Código 2FA incorrecto', $codigoEstado, [
                    'errors' => ['codigo_2fa' => ['Código incorrecto o inválido']]
                ]);
            }

            return $this->respuestaJson(
                true,
                '2FA verificado correctamente',
                200
            );
        } catch (TokenExpiredException | TokenInvalidException $e) {
            return $this->respuestaJson(false, 'Token inválido o expirado', 401);
        } catch (\Exception $e) {
            return $this->respuestaJson(false, 'Error en el servidor', 500, ['error' => $e->getMessage()]);
        }
    }

    /**
     * Cerrar sesión e invalidar token.
     */
    public function logout()
    {
        try {
            if (!$token = JWTAuth::getToken()) {
                return $this->respuestaJson(false, 'No se encontró un token válido', 400);
            }

            TokenUsuario::where('token', $token)->update(['estado' => 'I']);

            JWTAuth::invalidate($token);

            Auth::logout();

            return $this->respuestaJson(true, 'Sesión cerrada correctamente');
        } catch (\Exception $e) {
            return $this->respuestaJson(false, 'Error en el servidor', 500, ['error' => $e->getMessage()]);
        }
    }



    /**
     * Obtener la sesión actual del usuario autenticado.
     */
    public function obtenerSesionActualUsuario()
    {

        //var_dump(JWTAuth::getToken());
        if (!JWTAuth::getToken()) {
            return $this->respuestaJson(false, 'No se encontró un token válido', 400);
        }

        try {
            if (! $usuario = JWTAuth::parseToken()->authenticate()) {
                return $this->respuestaJson(false, 'No autenticado', 401);
            }

            return $this->respuestaJson(true, 'Usuario autenticado correctamente', 200, ['usuario' => $usuario]);
        } catch (\Exception $e) {
            return $this->respuestaJson(false, 'Error en la autenticación', 500, ['error' => $e->getMessage()]);
        }
    }


    /**
     * Devuelve el usuario actualmente autenticado vía JWT.
     */
    public function obtenerUsuarioLogueado(Request $request)
    {
        // auth()->user() ya viene “logueado” por tu middleware
        $user = $request->user();
        if (! $user) {
            return $this->respuestaJson(false, 'No autenticado', 401);
        }

        return $this->respuestaJson(
            true,
            'Usuario obtenido correctamente',
            200,
            ['usuario' => $user]
        );
    }


    /**
     * Validar código 2FA.
     */
    private function validarCodigo2FA(Usuarios $usuario, $codigo2FA)
    {
        return !empty($usuario->doble_factor) && !empty($codigo2FA) &&
            (new Google2FA())->verifyKey($usuario->doble_factor, $codigo2FA);
    }

    public function refreshToken()
    {
        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());
            // re-autentica con el nuevo token
            $usuario = JWTAuth::setToken($newToken)->authenticate();

            return response()->json([
                'resultado' => true,
                'mensaje'   => 'Token refrescado correctamente',
                'token'     => $newToken,
                'usuario'   => $usuario,
            ], 200);
        } catch (TokenExpiredException $e) {
            return response()->json(['resultado' => false, 'mensaje' => 'No se puede refrescar un token expirado'], 401);
        } catch (JWTException $e) {
            return response()->json(['resultado' => false, 'mensaje' => 'No se pudo refrescar el token'], 500);
        }
    }



    /**
     * Función para responder JSON de manera estándar.
     */
    private function respuestaJson(bool $resultado, string $message = '', int $status = 200, array $data = [])
    {
        return response()->json(array_merge([
            'resultado' => $resultado,
            'message' => $message ?: ($resultado ? 'Operación exitosa' : 'Error en la operación'),
        ], $data), $status);
    }
}

<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Driver de Sesión
    |--------------------------------------------------------------------------
    |
    | Define cómo Laravel almacenará las sesiones. Se pueden usar varias opciones,
    | como archivos, base de datos, Redis, etc. Para mayor rendimiento y escalabilidad,
    | la base de datos es una buena opción.
    |
    | Opciones soportadas: "file", "cookie", "database", "apc",
    |                      "memcached", "redis", "dynamodb", "array"
    |
    */

    // 'driver' => env('SESSION_DRIVER', 'database'),
    'driver' => env('SESSION_DRIVER', 'file'),


    /*
    |--------------------------------------------------------------------------
    | Duración de la Sesión (en minutos)
    |--------------------------------------------------------------------------
    |
    | Indica cuántos minutos puede estar inactiva una sesión antes de expirar.
    | Se puede modificar según las necesidades de seguridad y usabilidad.
    |
    */

    'lifetime' => env('SESSION_LIFETIME', 120), // 120 minutos por defecto

    /*
    |--------------------------------------------------------------------------
    | Expirar sesión al cerrar el navegador
    |--------------------------------------------------------------------------
    |
    | Si es `true`, la sesión expirará cuando el usuario cierre el navegador.
    | Si es `false`, la sesión durará hasta que se cumpla el tiempo de `lifetime`.
    |
    */

    'expire_on_close' => false,

    /*
    |--------------------------------------------------------------------------
    | Encriptación de la Sesión
    |--------------------------------------------------------------------------
    |
    | Si se habilita, todos los datos de sesión se almacenarán de manera encriptada.
    | Útil para mayor seguridad, pero puede afectar el rendimiento.
    |
    */

    'encrypt' => false,

    /*
    |--------------------------------------------------------------------------
    | Nombre de la Cookie de Sesión
    |--------------------------------------------------------------------------
    |
    | Define el nombre de la cookie de sesión que Laravel usará para almacenar
    | la sesión del usuario en el navegador.
    |
    */

    'cookie' => env('SESSION_COOKIE', Str::slug(env('APP_NAME', 'artwood'), '_') . '_session'),


    /*
    |--------------------------------------------------------------------------
    | Ruta de la Cookie
    |--------------------------------------------------------------------------
    |
    | Especifica la ruta en la que la cookie será accesible.
    | Normalmente, se mantiene en `/` para que sea accesible en toda la aplicación.
    |
    */

    'path' => '/',

    /*
    |--------------------------------------------------------------------------
    | Dominio de la Cookie
    |--------------------------------------------------------------------------
    |
    | Especifica el dominio al que pertenece la cookie.
    | Si se deja como `null`, usará el dominio de la aplicación automáticamente.
    |
    */

    'domain' => env('SESSION_DOMAIN', null),

    /*
    |--------------------------------------------------------------------------
    | Cookies Seguras (Solo HTTPS)
    |--------------------------------------------------------------------------
    |
    | Si es `true`, Laravel solo enviará cookies a través de HTTPS.
    | Esto debe estar en `true` en producción para mayor seguridad.
    |
    */

    'secure' => env('APP_ENV') === 'production', // Solo usa Secure en producción

    /*
    |--------------------------------------------------------------------------
    | Cookies Solo Accesibles por HTTP
    |--------------------------------------------------------------------------
    |
    | Si es `true`, la cookie no podrá ser accedida por JavaScript (document.cookie).
    | Es importante para prevenir ataques XSS (Cross-Site Scripting).
    |
    */

    'http_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Política de "SameSite" para Cookies
    |--------------------------------------------------------------------------
    |
    | Define la política "SameSite" de la cookie:
    | - "lax" (por defecto) → Permite la mayoría de las solicitudes cruzadas.
    | - "strict" → La cookie solo se enviará en navegación desde el mismo sitio.
    | - "none" → Permite el uso en CORS, pero requiere `Secure: true`.
    |
    */

    'same_site' => 'lax',

    /*
    |--------------------------------------------------------------------------
    | Cookies Particionadas (Solo en Browsers Recientes)
    |--------------------------------------------------------------------------
    |
    | Permite que las cookies sean accesibles solo en el sitio de nivel superior.
    | Requiere `Secure: true` y `SameSite: none`. Solo útil en entornos con CORS.
    |
    */

    'partitioned' => false,
];

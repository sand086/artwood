<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * Las cookies que NO deben ser encriptadas.
     *
     * @var array
     */
    protected $except = [
        //
    ];
}

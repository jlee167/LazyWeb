<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //'http://www.lazyweb.com/*',
        'http://10.0.2.2/*',
        'http://127.0.0.1:3001/*'
        //
    ];
}

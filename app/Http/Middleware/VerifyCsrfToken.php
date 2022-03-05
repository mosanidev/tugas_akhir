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
        'http://c904-103-121-18-9.ngrok.io/order/webhook',
        'http://c904-103-121-18-9.ngrok.io/order/initpayment'
    ];
}

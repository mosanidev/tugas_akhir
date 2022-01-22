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
        'http://5e17-103-121-18-37.ngrok.io/order/webhook',
        'http://5e17-103-121-18-37.ngrok.io/order/initpayment'
    ];
}

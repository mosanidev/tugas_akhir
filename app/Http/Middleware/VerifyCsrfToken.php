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
        'http://5c8b-103-121-18-52.ngrok.io/order/webhook',
        'http://5c8b-103-121-18-52.ngrok.io/order/initpayment'
    ];
}

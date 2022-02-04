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
        'http://edea-103-121-18-11.ngrok.io/order/webhook',
        'http://edea-103-121-18-11.ngrok.io/order/initpayment'
    ];
}

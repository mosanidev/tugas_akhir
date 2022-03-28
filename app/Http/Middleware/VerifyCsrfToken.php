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
        'http://604a-103-121-18-0.ngrok.io/order/webhook',
        'http://604a-103-121-18-0.ngrok.io/order/initpayment'
    ];
}

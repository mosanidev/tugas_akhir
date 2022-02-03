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
        'http://2d1c-180-253-165-66.ngrok.io/order/webhook',
        'http://2d1c-180-253-165-66.ngrok.io/order/initpayment'
    ];
}

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
        'http://3c7a-182-253-116-210.ngrok.io/order/webhook',
        'http://3c7a-182-253-116-210.ngrok.io/order/initpayment'
    ];
}

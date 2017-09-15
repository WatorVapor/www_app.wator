<?php

namespace Wator\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
        '/wai/text/train/crawler',
        '/wai/text/train/ostrich/*',
        '/wai/text/train/parrot/*',
        '/wai/text/train/phoenix/*',
    ];
}

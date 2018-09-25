<?php

namespace Wator\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * Indicates whether the XSRF-TOKEN cookie should be set on the response.
     *
     * @var bool
     */
    protected $addHttpCookie = true;

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
        '/wai/text/participle/sns',
    ];
}

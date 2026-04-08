<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
    
    /**
     * Handle unauthenticated CSRF token expiration.
     */
    protected function addCookieToResponse($request, $response)
    {
        $response->headers->setCookie(
            cookie('XSRF-TOKEN', 
                $request->session()->token(), 
                60, // 60 minutes
                null, 
                null, 
                false, // httpOnly
                true, // secure (if using HTTPS)
                false, // sameSite (lax for mobile compatibility)
                'strict'
            )
        );

        return parent::addCookieToResponse($request, $response);
    }
}

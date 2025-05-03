<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HandleProxies
{
    public function handle(Request $request, Closure $next): Response
    {
        $request->setTrustedProxies(
            ['127.0.0.1', '172.18.0.0/16'], // Docker network
            Request::HEADER_X_FORWARDED_FOR |
            Request::HEADER_X_FORWARDED_HOST |
            Request::HEADER_X_FORWARDED_PORT |
            Request::HEADER_X_FORWARDED_PROTO |
            Request::HEADER_X_FORWARDED_PREFIX
        );
        
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BlockRobots
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // Esta cabecera es la clave:
        $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive');

        return $response;
    }
}

<?php

namespace App\Http\Middleware;

use Closure;

class CheckHmac
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Invalid request
        if (!$request->query('hmac')) {
            return abort(403);
        }

        // Check hmac
        if (!\App\Helpers\Shopify::verifyHmac($request->query())) {
            return abort(403, 'Failed to verify request');
        }

        return $next($request);
    }
}

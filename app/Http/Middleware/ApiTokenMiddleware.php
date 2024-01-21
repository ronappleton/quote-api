<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (
            !$request->query->has('api_token') ||
            $request->query->get('api_token') !== config('auth.api_token')
        ) {
            abort(401, 'Unauthorized');
        }

        $token = $request->query->get('api_token');

        return $next($request);
    }
}

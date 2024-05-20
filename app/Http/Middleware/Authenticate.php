<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

use App\Exceptions\Unauthorized;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    // public function handle($request, Closure $next, $guard = null)
    // {
    //     if ($this->auth->guard($guard)->guest()) {
    //         throw new Unauthorized();
    //     }

    //     return $next($request);
    // }
}

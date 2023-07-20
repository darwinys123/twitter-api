<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */

    //To receive an abort message whenever the user is trying to use an endpoint with sanctum middleware
    protected function redirectTo(Request $request)
    {
        if (!$request->expectsJson()) {
            abort(response()->json([
                'message' => 'Unauthenticated'
            ], 401));
        }
    }


    //To automatically add the cookie into the request header

    public function handle($request, Closure $next, ...$guards)
    {
        if ($jwt = $request->cookie('jwt')) {
            $request->headers->set('Authorization', 'Bearer ' . $jwt);
        }

        $this->authenticate($request, $guards);

        return $next($request);
    }
}

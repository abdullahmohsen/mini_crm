<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class Authenticate
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            return $request->expectsJson()
                ? response('Unauthorized.', 401)
                : redirect()->guest('login');
        }

        return $next($request);
    }
}

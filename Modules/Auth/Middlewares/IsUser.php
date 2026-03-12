<?php

namespace Modules\Auth\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Modules\Core\Utilities\Response as UtilitiesResponse;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->is_user) {
            return $next($request);
        }

        return (new UtilitiesResponse())->error(message: 'أنت لست زبوناً.');
    }
}

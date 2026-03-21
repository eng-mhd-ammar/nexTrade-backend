<?php

namespace Modules\Auth\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Utilities\Response as UtilitiesResponse;
use Symfony\Component\HttpFoundation\Response;

class IsDelivery
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('user')->check() && Auth::user()->is_delivery) {
            return $next($request);
        }
        return (new UtilitiesResponse())->error(message: 'Sorry you are not a delivery.');
    }
}

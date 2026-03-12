<?php

namespace Modules\Auth\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Utilities\Response;

class OptionalAuth
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if ($token) {
            $user = Auth::guard('sanctum')->user();

            if (!$user) {
                return (new Response())->error(message: "Invalid or expired token.", code:Response::HTTP_UNAUTHORIZED);
            }

            Auth::setUser($user);
        }

        return $next($request);
    }
}

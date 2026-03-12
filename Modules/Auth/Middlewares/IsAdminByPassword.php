<?php

namespace Modules\Auth\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Modules\Auth\Exceptions\AuthException;
use Symfony\Component\HttpFoundation\Response;

class IsAdminByPassword
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $password = $request->header('Admin-Password');
        if (!$password) {
            abort(401, 'Password Wrong.');
        }
        $user = Auth::user();
        if (!$user) {
            abort(401, 'Unauthenticated');
        }
        if (!Hash::check($password, $user->password)) {
            AuthException::invalidCredentials();
        }
        return $next($request);
    }
}

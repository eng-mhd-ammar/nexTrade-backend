<?php

namespace Modules\Auth\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Core\Exceptions\AuthException;
use Symfony\Component\HttpFoundation\Response;

class AdminOrOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $modelClass, string $column = 'user_id'): Response
    {
        $user = Auth::user();

        if (! $user) {
            throw AuthException::notAnAdmin();
        }

        if (!class_exists($modelClass)) {
            abort(500, "Model class {$modelClass} not found.");
        }

        $model = new $modelClass();
        $ownsRecord = $model::query()->where($column, $user->id)->exists();

        if (! $user->is_admin && ! $ownsRecord) {
            throw AuthException::notAnAdmin();
        }

        return $next($request);
    }
}

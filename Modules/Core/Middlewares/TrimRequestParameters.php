<?php

namespace Modules\Core\Middlewares;

use Closure;
use Illuminate\Http\Request;

class TrimRequestParameters
{
    public function handle(Request $request, Closure $next)
    {
        $request->merge(
            collect($request->all())->mapWithKeys(function ($value, $key) {
                if (is_string($value)) {
                    return [$key => trim($value)];
                }
                return [$key => $value];
            })->all()
        );
        return $next($request);
    }
}

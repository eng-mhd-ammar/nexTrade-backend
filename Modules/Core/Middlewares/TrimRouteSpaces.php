<?php

namespace Modules\Core\Middlewares;

use Closure;
use Illuminate\Http\Request;

class TrimRouteSpaces
{
    public function handle(Request $request, Closure $next)
    {
        $uri = $request->getRequestUri();

        $parts = explode('?', $uri, 2);
        $path = $parts[0];
        $query = $parts[1] ?? null;

        $cleanPath = str_replace('%20', '', $path);

        $request->server->set(
            'REQUEST_URI',
            $cleanPath . ($query ? '?' . $query : '')
        );
        $request->server->set('PATH_INFO', $cleanPath);
        $request->server->set('ORIG_PATH_INFO', $cleanPath);

        return $next($request);
    }
}

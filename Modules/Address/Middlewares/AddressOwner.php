<?php

namespace Modules\Address\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Address\Models\Address;
use Modules\Core\Utilities\Response as UtilitiesResponse;
use Symfony\Component\HttpFoundation\Response;

class AddressOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->is_admin || Address::query()->withTrashed()->findOrFail($request->route('modelId'))->user_id == auth()->id())) {
            return $next($request);
        }

        return (new UtilitiesResponse())->error(message: 'The address is not yours.');
    }
}

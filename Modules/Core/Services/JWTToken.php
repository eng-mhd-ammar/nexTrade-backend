<?php

namespace Modules\Core\Services;

use Modules\Core\Enums\GuardType;
use Modules\Core\Enums\TokenType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Context;
use Modules\Core\Enums\StaticKeys;

class JWTToken
{
    /**
     * Generate access token where utt => user token type is access
     */
    public static function accessTokenById(string $userId, string $guard = 'user')
    {
        return auth($guard)->setTTL((int) env('JWT_TTL_ACCESS_TOKEN'))->claims(['utt' => TokenType::REFRESH->value, 'guard' => $guard, 'tenant' => config('database.connections.tenant.database')])->tokenById($userId);
    }


    /**
     * Generate refresh token where utt => user token type is refresh
     */
    public static function refreshTokenById(string $userId, string $guard = 'user')
    {
        return auth($guard)->setTTL((int) env('JWT_TTL_REFRESH_TOKEN'))->claims(['utt' => TokenType::REFRESH->value, 'guard' => $guard, 'tenant' => config('database.connections.tenant.database')])->tokenById($userId);
    }

    /**
     * Generate refresh token where utt => user token type is refresh
     */
    public static function resetPasswordTokenById(string $userId, string $guard = 'user')
    {
        return auth($guard)->setTTL((int) env('JWT_TTL_RESET_TOKEN'))->claims(['utt' => TokenType::RESET->value, 'guard' => $guard, 'tenant' => config('database.connections.tenant.database')])->tokenById($userId);
    }

    public static function tokens(string $userId, $guard = 'user', $is_admin = false): array
    {
        return [
            'access_token'  => self::accessTokenById($userId, $guard),
            'refresh_token' => self::refreshTokenById($userId, $guard),
            'is_admin' => $is_admin,
            // 'subdomain' => Context::get(StaticKeys::REQUESTED_TENANT->value)?->subdomain,
        ];
    }
    public static function resetToken(string $userId, $guard = 'user'): array
    {
        return [
            'reset_token'  => self::resetPasswordTokenById($userId, $guard),
        ];
    }

    public static function payloadFromToken(string $token)
    {
        $tokenParts = explode('.', $token);
        if (count($tokenParts) == 3) {
            return (array)json_decode(base64_decode($tokenParts[1]));
        } else {
            return false;
        }
    }
    public static function guard()
    {
        $payload = self::payloadFromToken(request()->header('Authorization', ''));
        if ($payload) {
            return $payload['guard'];
        } else {
            return false;
        }
    }

    public static function isCustomer()
    {
        return Auth::user()->is_customer;
        return self::guard() == GuardType::CUSTOMER->value;
    }
    public static function isAdmin()
    {
        return Auth::user()->is_admin;
        return self::guard() == GuardType::ADMIN->value;
    }
    public static function isDelivery()
    {
        return Auth::user()->is_delivery;
        return self::guard() == GuardType::DELIVERY->value;
    }
    public static function isSupport()
    {
        return Auth::user()->is_support;
        return self::guard() == GuardType::SUPPORT->value;
    }
    public static function isGuest()
    {
        return !in_array(self::guard(), GuardType::guards());
    }
}

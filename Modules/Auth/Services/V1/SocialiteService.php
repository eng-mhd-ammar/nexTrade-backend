<?php

namespace Modules\Auth\Services\V1;

use Modules\Auth\Models\User;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Modules\Auth\Interfaces\V1\Socialite\SocialiteServiceInterface;

class SocialiteService implements SocialiteServiceInterface
{
    protected string $model = User::class;
    protected array $columns = ['email'];

    public function googleLogin($token)
    {
        $googleUser = Socialite::driver('google')->userFromToken($token);
        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {
            $new_user = [
                'first_name' => $googleUser->user['given_name'],
                'photo' => $googleUser->avatar,
                'email' => $googleUser->email,
                'password' => Str::random(16),
                'email_verified_at' => \Carbon\Carbon::now(),
            ];
            if (array_key_exists('family_name', $googleUser->user)) {
                $new_user['last_name'] = $googleUser->user['family_name'];
            }
            $user = $this->model::create($new_user);
        }

        $data['token'] = $user->createToken('apiToken', ['user'], now()->addWeek())->plainTextToken;

        return $data;
    }
}

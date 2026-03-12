<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\UserType;
use App\Traits\ApiTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;

class LoginController extends Controller
{
    use ApiTrait;
    // use SendEmailTrait;

    public function login(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email|min:5|max:100',
                'password' => 'required|min:8'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $user = User::where('email', $request->email)->first();
            if (!$user)  return $this->returnError('User Not Found');
            if (!$user->email_verified_at) return $this->returnError('Email Not Verified');
            if (!Hash::check($request->password, $user->password)) return $this->returnError('Wrong Password');
            $user->user_type = UserType::find($user->user_type_id)->type;
            $token = $user->createToken('apiToken', [$user->user_type])->plainTextToken;
            return $this->returnData('data', ['user' => $user, 'token' => $token]);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function logout()
    {
        try {
            auth()->user()->currentAccessToken()->delete();
            return $this->returnSuccessMessage('Logout Success');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function checkEmail(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email|min:5|max:100',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $user = User::where('email', $request->email)->first();
            if (!$user)  return $this->returnError('User Not Found');
            $numbers = range(0, 9);
            shuffle($numbers);
            $verificationCode = implode(array_slice($numbers, 0, 5));
            $user->verification_code = $verificationCode;
            $user->save();
            // $this->sendVerificationEmail($request->email, $user->name, $verificationCode);
            return $this->returnSuccessMessage('Mail Sent');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email|min:5|max:100',
                'password' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $user = User::where('email', $request->email)->first();
            if (!$user)  return $this->returnError('User Not Found');
            $user->password = Hash::make($request->password);
            $user->save();
            return $this->returnSuccessMessage('Password Reset');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function verifyCodeForgetPassword(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email|min:5|max:100',
                'verification_code' => 'required|max:5|min:5',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $user = User::where('email', $request->email)->first();
            if (!$user) return $this->returnError('User Not Found');
            if ($request->verification_code != $user->verification_code) return $this->returnError('Verification Code Not Match');
            $user->email_verified_at = Carbon::now();
            $user->save();
            return $this->returnSuccessMessage('Email Verified');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
}

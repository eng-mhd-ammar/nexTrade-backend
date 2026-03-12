<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class SignUpController extends Controller
{
    use ApiTrait;
    // use SendEmailTrait;

    public function signUp(Request $request)
    {
        try {
            $rules = [
                'name' => 'required|string|max:30',
                'email' => 'required|email|unique:users,email|min:5|max:100',
                'password' => 'required|min:8|max:20',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $user = User::where('email', $request->email)->first();
            if ($user) return $this->returnError('User Was Already Exist');
            $numbers = range(0, 9);
            shuffle($numbers);
            $verificationCode = implode(array_slice($numbers, 0, 5));
            $data  = [
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'verification_code' => $verificationCode,
            ];
            User::create($data);
            // $this->sendVerificationEmail($request->email, $request->name, $verificationCode);
            return $this->returnSuccessMessage('Mail Sent');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function verifyCodeSignUp(Request $request)
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

    public function resendVerificationCode(Request $request)
    {
        try {
            $rules = [
                'email' => 'required|email|min:5|max:100',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $user = User::where('email', $request->email)->first();
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
}

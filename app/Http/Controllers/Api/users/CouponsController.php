<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Traits\ApiTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CouponsController extends Controller
{

    use ApiTrait;

    public function check(Request $request)
    {
        try {
            $rules = [
                'code' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $code = Coupon::firstWhere('code', $request->code);
            if (!$code) return $this->returnError('Coupon Not Found');
            if ($code->expired_date < Carbon::now()) return $this->returnError('Coupon Was Expired');
            if ($code->count <= 0) return $this->returnError('Coupon Was Ended');
            return $this->returnData('data', $code);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
}

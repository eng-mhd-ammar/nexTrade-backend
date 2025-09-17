<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Traits\ApiTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressesController extends Controller
{
    
    use ApiTrait;

    public function get()
    {
        try {
            $user = auth()->user();
            $data = Address::where('user_id', $user->id)->get();
            return $this->returnData('data', $data);
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    
    public function create(Request $request)
    {
        try {
            $rules = [
                'name' => 'required',
                'city' => 'required',
                'street' => 'required',
                'phone' => 'required',
                'location_lat' => 'required',
                'location_long' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $user = auth()->user();
            $data = [
                'user_id' => $user->id,
                'name' => $request->name,
                'city' => $request->city,
                'street' => $request->street,
                'phone' => $request->phone,
                'location_lat' => $request->location_lat,
                'location_long' => $request->location_long,
            ];
            Address::create($data);
            return $this->returnSuccessMessage('Address Added');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $rules = [
                'address_id' => 'required',
                'name' => 'required',
                'city' => 'required',
                'street' => 'required',
                'phone' => 'required',
                'location_lat' => 'required',
                'location_long' => 'required',
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $address = Address::find($request->address_id);
            if (!$address) return $this->returnError('Address Not Found In Cart');
            $data = [
                'name' => $request->name,
                'city' => $request->city,
                'street' => $request->street,
                'phone' => $request->phone,
                'location_lat' => $request->location_lat,
                'location_long' => $request->location_long,
            ];
            $address->update($data);
            return $this->returnSuccessMessage('Address Updated');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    
    public function delete(Request $request)
    {
        try {
            $rules = ['address_id' => 'required'];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) return $this->returnValidationError($validator);
            $address = Address::find($request->address_id);
            if (!$address) return $this->returnError('Address Not Found In Cart');
            $address->delete();
            return $this->returnSuccessMessage('Address Deleted');
        } catch (Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
}

<?php

namespace App\Traits;

trait ApiTrait
{
    public function getCurrentLang()
    {
        return app()->getLocale();
    }

    public function returnError($msg)
    {
        return response()->json([
            'status' => false,
            'msg' => $msg
        ]);
    }

    public function returnSuccessMessage($msg)
    {
        return ['status' => true, 'msg' => $msg];
    }

    public function returnData($key, $value)
    {
        return response()->json([
            'status' => true,
            $key => $value
        ]);
    }

    public function returnCodeAccordingToInput($validator)
    {
        $inputs = array_keys($validator->errors()->toArray());
        $code = $this->getErrorCode($inputs[0]);
        return $code;
    }

    public function returnValidationError($validator)
    {
        return $this->returnError($validator->errors()->first());
    }
}

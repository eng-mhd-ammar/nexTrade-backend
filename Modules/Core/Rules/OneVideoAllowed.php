<?php

namespace Modules\Core\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\UploadedFile;

class OneVideoAllowed implements ValidationRule
{
    public function __construct(protected array|string $mimes = [])
    {
        $this->mimes = is_array($mimes)
            ? $mimes
            : explode(',', str_replace(' ', '', $mimes));
    }


    public function validate($attribute, $value, $fail): void
    {
        $videosCount = 0;

        foreach ($value as $file) {
            $extension = null;

            if ($file instanceof UploadedFile) {
                $extension = $file->getClientOriginalExtension();
            } elseif (is_string($file)) {
                $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            }

            if ($extension && in_array(strtolower($extension), $this->mimes)) {
                $videosCount++;
            }
        }

        if ($videosCount > 1) {
            $fail('Only one video is allowed.');
        }
    }
}

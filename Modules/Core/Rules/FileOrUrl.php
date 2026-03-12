<?php

namespace Modules\Core\Rules;

use Illuminate\Http\UploadedFile;
use Illuminate\Contracts\Validation\ValidationRule;
use Closure;

class FileOrUrl implements ValidationRule
{
    protected array $mimes;
    protected array $mimeTypes;

    public function __construct(array|string $mimes = [])
    {
        $this->mimes = is_array($mimes)
            ? $mimes
            : explode(',', str_replace(' ', '', $mimes));

        $this->mimeTypes = [
            'jpg'  => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'webp' => 'image/webp',
        ];
    }

public function validate(string $attribute, mixed $value, Closure $fail): void
{
    if (is_null($value)) {
        return;
    }

    if ($value instanceof UploadedFile) {
        $extension = strtolower($value->getClientOriginalExtension());

        if (!in_array($extension, $this->mimes)) {
            $fail("The {$attribute} must be a file of type: " . implode(', ', $this->mimes) . '.');
            return;
        }

        $mime = $value->getMimeType();
        $expected = $this->mimeTypes[$extension] ?? null;

        if ($expected && $mime !== $expected) {
            $fail("Invalid file type uploaded.");
            return;
        }

        return;
    }

    if (is_string($value) && filter_var($value, FILTER_VALIDATE_URL)) {
        $path = parse_url($value, PHP_URL_PATH);

        if (!$path) {
            $fail("Invalid URL format.");
            return;
        }

        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        if (!in_array($extension, $this->mimes)) {
            $fail("The {$attribute} URL must end with one of: " . implode(', ', $this->mimes) . '.');
            return;
        }

        return;
    }

    $fail("The {$attribute} must be a valid file or URL.");
}

}

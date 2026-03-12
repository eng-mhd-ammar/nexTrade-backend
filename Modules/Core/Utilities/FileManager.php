<?php

namespace Modules\Core\Utilities;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileManager
{
    public static function __callStatic($name, $arguments)
    {
        return (new self())->$name(...$arguments);
    }

    public function store(UploadedFile $file, string $path, array|string $options = []): string|false
    {
        return $file->store($path, $options);
    }
    public function storePublicly(UploadedFile $file, string $path, array|string $options = []): string|false
    {
        return $file->storePublicly($path, $options);
    }
    public function storeAs(UploadedFile $file, string $path, string $name = null, array|string $options = []): string|false
    {
        return $file->storeAs($path, $name, $options);
    }
    public function storePubliclyAS(UploadedFile $file, string $path, string $name = null, array|string $options = []): string|false
    {
        return $file->storePubliclyAs($path, $name, $options);
    }
    public function exists(string $path, $disk = 'locale'): bool
    {
        return Storage::disk($disk)->exists($path);
    }
    public function delete(string $path, $disk = 'locale'): bool
    {
        return Storage::disk($disk)->delete($path);
    }
    public function deleteIfExists(string $path, $disk = 'locale'): bool
    {
        if ($this->exists($path, $disk)) {
            return $this->delete($path, $disk);
        }
        return false;
    }
    public function new()
    {

    }
}

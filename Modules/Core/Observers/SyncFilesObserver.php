<?php

namespace Modules\Core\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SyncFilesObserver
{
    public function updating(Model $model): void
    {
        if (!property_exists($model, 'FilesFields') || !is_array($model->FilesFields) || empty($model->FilesFields)) {
            return;
        }

        foreach ($model->FilesFields as $field) {
            $oldValue = $model->getOriginal($field);
            $newValue = $model->{$field};

            if (
                (is_string($oldValue) && Str::startsWith($oldValue, ['http://', 'https://'])) ||
                (is_string($newValue) && Str::startsWith($newValue, ['http://', 'https://']))
            ) {
                continue;
            }

            if (is_string($oldValue) || is_string($newValue)) {
                if ($oldValue && $oldValue !== $newValue) {
                    $path = ltrim(str_replace('storage/', '', $oldValue), '/');
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                        Log::info("🗑️ Deleted single file: {$path}");
                    } else {
                        Log::warning("⚠️ File not found for deletion: {$path}");
                    }
                }
                continue;
            }

            if (is_array($oldValue) || is_array($newValue)) {
                $oldImages = is_array($oldValue) ? $oldValue : json_decode($oldValue ?? '[]', true);
                $newImages = is_array($newValue) ? $newValue : json_decode($newValue ?? '[]', true);

                $oldImagesSet = collect($oldImages)
                    ->reject(fn ($img) => Str::startsWith($img, ['http://', 'https://']))
                    ->map(fn ($img) => ltrim(str_replace('storage/', '', $img), '/'));

                $newImagesSet = collect($newImages)
                    ->reject(fn ($img) => Str::startsWith($img, ['http://', 'https://']))
                    ->map(fn ($img) => ltrim(str_replace('storage/', '', $img), '/'));

                $imagesToDelete = $oldImagesSet->diff($newImagesSet);

                foreach ($imagesToDelete as $image) {
                    if (Storage::disk('public')->exists($image)) {
                        Storage::disk('public')->delete($image);
                        Log::info("🗑️ Deleted image from array: {$image}");
                    } else {
                        Log::warning("⚠️ Image from array not found for deletion: {$image}");
                    }
                }
            }
        }
    }

    public function forceDeleting(Model $model): void
    {
        if (!property_exists($model, 'FilesFields') || !is_array($model->FilesFields) || empty($model->FilesFields)) {
            return;
        }

        foreach ($model->FilesFields as $field) {
            $value = $model->{$field};

            if (is_string($value) && Str::startsWith($value, ['http://', 'https://'])) {
                continue;
            }

            if (is_string($value) && $value) {
                $path = ltrim(str_replace('storage/', '', $value), '/');
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                    Log::info("🗑️ Deleted single file on model deletion: {$path}");
                }
            }

            if (is_array($value)) {
                foreach ($value as $image) {
                    if (Str::startsWith($image, ['http://', 'https://'])) {
                        continue;
                    }

                    $path = ltrim(str_replace('storage/', '', $image), '/');
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                        Log::info("🗑️ Deleted image from array on model deletion: {$path}");
                    }
                }
            }
        }
    }
}

<?php

namespace Modules\Core\DTO;

use Illuminate\Http\UploadedFile;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as ImageDriver;
use FFMpeg\FFMpeg;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BaseDTO
{
    public function toArray(): array
    {
        $array = (array) $this;
        if (array_key_exists('id', $array)) {
            unset($array['id']);
        }

        return $array;
    }

    public function filterNull(array $skip = []): self
    {
        $attributesArray = (array)$this;

        foreach ($attributesArray as $attribute => $value) {
            if (is_null($value) && (!in_array($attribute, $skip))) {
                unset($this->{$attribute});
            }
        }

        return $this;
    }

    public function filter(array $attributes = [], array $values = [], array $skip = []): self
    {
        $attributesArray = (array)$this;

        $valuesIsSet = count($values);
        $attributesIsSet = count($attributes);

        if ($attributesIsSet || $valuesIsSet) {

            foreach ($attributesArray as $attribute => $value) {

                if ((in_array($value, $values) || in_array($attribute, $attributes) && (!in_array($attribute, $skip)))) {
                    unset($this->{$attribute});
                }
            }
        }

        return $this;
    }

    public static function handleFileStoring(UploadedFile|string|null $file, string $path, ?string $name = null, string $disk = 'public'): ?string
    {
        if (is_null($file)) {
            return null;
        }

        if (is_string($file)) {
            return $file;
        }

        $mimeType = $file->getMimeType();

        $originalName = $name ?? pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $baseName = Str::slug($originalName);

        $extension = str_starts_with($mimeType, 'image/') ? 'webp'
                    : (str_starts_with($mimeType, 'video/') ? 'webm'
                    : $file->getClientOriginalExtension());

        $finalName = self::generateUniqueFilename($disk, $path, $baseName, $extension);

        $tempPath = sys_get_temp_dir() . '/' . $finalName;

        try {
            if (str_starts_with($mimeType, 'image/')) {
                $manager = new ImageManager(new ImageDriver());
                $image = $manager->read($file->getRealPath())->toWebp();
                $image->save($tempPath);
            } elseif (str_starts_with($mimeType, 'video/')) {
                $ffmpeg = FFMpeg::create();
                $video = $ffmpeg->open($file->getRealPath());
                $format = new \FFMpeg\Format\Video\WebM();
                $video->save($format, $tempPath);
            } else {
                $fullPath = $file->storePubliclyAs($path, $finalName, $disk);
                return 'storage/' . $fullPath;
            }

            $fullPath = Storage::disk($disk)->putFileAs($path, new \Illuminate\Http\File($tempPath), $finalName);
            unlink($tempPath);

        } catch (\Throwable $e) {
            $fullPath = $file->storePubliclyAs($path, $finalName, $disk);
        }

        return 'storage/' . $fullPath;
    }

    private static function generateUniqueFilename(string $disk, string $path, string $baseName, string $extension): string
    {
        $filename = "{$baseName}.{$extension}";
        $counter = 1;

        while (Storage::disk($disk)->exists("$path/$filename")) {
            $filename = "{$baseName}-{$counter}.{$extension}";
            $counter++;
        }

        return $filename;
    }

    public static function prepareRequestArray(?array $data): null|array
    {
        if (!is_array($data)) {
            return null;
        }
        if (empty($data) || $data[0] == -1) {
            return [];
        }

        return $data;
    }
}

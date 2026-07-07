<?php

namespace App\Services;

use App\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaService
{
    /** Longest edge stored; larger uploads are downscaled to keep pages fast. */
    protected const MAX_DIMENSION = 2560;

    /**
     * Store an uploaded image on the public disk and register it
     * in the media library. Returns the Media record.
     */
    public function store(UploadedFile $file, string $folder = 'general', ?string $alt = null): Media
    {
        $folder = $this->sanitizeFolder($folder);
        $safeName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'jpg';
        $fileName = $safeName.'-'.Str::random(8).'.'.$extension;
        $path = "media/{$folder}/{$fileName}";

        Storage::disk('public')->putFileAs("media/{$folder}", $file, $fileName);

        [$width, $height] = $this->optimize(Storage::disk('public')->path($path), $extension);

        return Media::create([
            'name' => $safeName,
            'file_name' => $fileName,
            'path' => $path,
            'mime_type' => $file->getMimeType() ?? 'application/octet-stream',
            'size' => Storage::disk('public')->size($path),
            'folder' => $folder,
            'alt' => $alt,
            'width' => $width,
            'height' => $height,
        ]);
    }

    public function delete(Media $media): void
    {
        Storage::disk('public')->delete($media->path);
        $media->delete();
    }

    public function replace(Media $media, UploadedFile $file): Media
    {
        Storage::disk('public')->delete($media->path);

        $extension = strtolower($file->getClientOriginalExtension()) ?: 'jpg';
        $fileName = pathinfo($media->file_name, PATHINFO_FILENAME).'.'.$extension;
        $path = "media/{$media->folder}/{$fileName}";

        Storage::disk('public')->putFileAs("media/{$media->folder}", $file, $fileName);
        [$width, $height] = $this->optimize(Storage::disk('public')->path($path), $extension);

        $media->update([
            'file_name' => $fileName,
            'path' => $path,
            'mime_type' => $file->getMimeType() ?? $media->mime_type,
            'size' => Storage::disk('public')->size($path),
            'width' => $width,
            'height' => $height,
        ]);

        return $media;
    }

    protected function sanitizeFolder(string $folder): string
    {
        $folder = Str::slug($folder) ?: 'general';

        return substr($folder, 0, 80);
    }

    /**
     * Downscale oversized raster images in place using GD.
     * Returns [width, height] of the stored file.
     *
     * @return array{0: ?int, 1: ?int}
     */
    protected function optimize(string $absolutePath, string $extension): array
    {
        if ($extension === 'svg') {
            return [null, null];
        }

        $info = @getimagesize($absolutePath);
        if ($info === false) {
            return [null, null];
        }

        [$width, $height] = $info;
        if (max($width, $height) <= self::MAX_DIMENSION || ! function_exists('imagecreatetruecolor')) {
            return [$width, $height];
        }

        $scale = self::MAX_DIMENSION / max($width, $height);
        $newWidth = (int) round($width * $scale);
        $newHeight = (int) round($height * $scale);

        $source = match ($info[2]) {
            IMAGETYPE_JPEG => @imagecreatefromjpeg($absolutePath),
            IMAGETYPE_PNG => @imagecreatefrompng($absolutePath),
            IMAGETYPE_WEBP => @imagecreatefromwebp($absolutePath),
            default => null,
        };

        if (! $source) {
            return [$width, $height];
        }

        $resized = imagecreatetruecolor($newWidth, $newHeight);
        imagealphablending($resized, false);
        imagesavealpha($resized, true);
        imagecopyresampled($resized, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        match ($info[2]) {
            IMAGETYPE_JPEG => imagejpeg($resized, $absolutePath, 85),
            IMAGETYPE_PNG => imagepng($resized, $absolutePath, 8),
            IMAGETYPE_WEBP => imagewebp($resized, $absolutePath, 85),
            default => null,
        };

        imagedestroy($source);
        imagedestroy($resized);

        return [$newWidth, $newHeight];
    }
}

<?php

use Illuminate\Support\Facades\Storage;

if (! function_exists('media_url')) {
    /**
     * Resolve a stored media path to a browser URL.
     * Absolute URLs and public paths pass through; everything else
     * is treated as a file on the "public" storage disk.
     */
    function media_url(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://') || str_starts_with($path, '/')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}

if (! function_exists('setting')) {
    function setting(string $key, ?string $default = null): ?string
    {
        return \App\Services\Settings::get($key, $default);
    }
}

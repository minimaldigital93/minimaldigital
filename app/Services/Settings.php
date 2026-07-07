<?php

namespace App\Services;

use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Cache;

class Settings
{
    protected const CACHE_KEY = 'website_settings.all';

    /**
     * All settings as a key => value array, cached until changed.
     *
     * @return array<string, string|null>
     */
    public static function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return WebsiteSetting::query()->pluck('value', 'key')->all();
        });
    }

    public static function get(string $key, ?string $default = null): ?string
    {
        return self::all()[$key] ?? $default;
    }

    public static function set(string $key, ?string $value, string $group = 'general'): void
    {
        WebsiteSetting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
        self::flush();
    }

    public static function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}

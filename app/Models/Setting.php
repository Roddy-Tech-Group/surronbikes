<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    /**
     * Get a setting value by key.
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        $settings = Cache::rememberForever('settings', function () {
            return self::pluck('value', 'key')->toArray();
        });

        return $settings[$key] ?? $default;
    }

    /**
     * Set a setting value by key.
     */
    public static function set(string $key, mixed $value): void
    {
        self::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );

        Cache::forget('settings');
    }
}

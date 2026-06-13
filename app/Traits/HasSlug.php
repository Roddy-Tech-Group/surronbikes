<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug(Str::slug($model->name));
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('name') && !$model->isDirty('slug')) {
                $model->slug = static::generateUniqueSlug(Str::slug($model->name), $model->id);
            }
        });
    }

    /**
     * Generate a unique slug, appending -2, -3, etc. if needed.
     */
    public static function generateUniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = $baseSlug;
        $counter = 2;

        while (static::slugExists($slug, $ignoreId)) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Check if a slug already exists in the table.
     */
    protected static function slugExists(string $slug, ?int $ignoreId = null): bool
    {
        $query = static::where('slug', $slug);

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        return $query->exists();
    }
}

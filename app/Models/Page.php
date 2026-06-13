<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'slug',
        'title',
        'content',
    ];

    public static function findBySlug(string $slug): ?self
    {
        return self::where('slug', $slug)->first();
    }
}

<?php

namespace App\Models;

use App\Traits\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasSlug;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
        'description',
        'specifications',
        'video_url',
        'featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'specifications' => 'array',
            'featured' => 'boolean',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function getFormattedPriceAttribute(): string
    {
        return '$' . number_format($this->price, 2);
    }
}

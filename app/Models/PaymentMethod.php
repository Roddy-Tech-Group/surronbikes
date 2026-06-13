<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    const TYPE_BANK = 'bank';
    const TYPE_CRYPTO = 'crypto';
    const TYPE_ZELLE = 'zelle';
    const TYPE_CASHAPP = 'cashapp';
    const TYPE_PAYPAL = 'paypal';
    const TYPE_MOBILE_MONEY = 'mobile_money';

    const TYPES = [
        self::TYPE_BANK => 'Bank Transfer',
        self::TYPE_CRYPTO => 'Cryptocurrency',
        self::TYPE_ZELLE => 'Zelle',
        self::TYPE_CASHAPP => 'CashApp',
        self::TYPE_PAYPAL => 'PayPal',
        self::TYPE_MOBILE_MONEY => 'Mobile Money',
    ];

    protected $fillable = [
        'name',
        'type',
        'details',
        'instructions',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'details' => 'array',
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
    
    public function getTypeLabelAttribute(): string
    {
        return self::TYPES[$this->type] ?? ucfirst($this->type);
    }
}

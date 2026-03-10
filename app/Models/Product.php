<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name', 'category', 'description', 'price',
        'unit', 'tag', 'image', 'available', 'sort_order',
    ];

    protected $casts = [
        'available' => 'boolean',
        'price'     => 'decimal:2',
    ];

    public function getImageUrlAttribute(): string
    {
        if ($this->image && file_exists(storage_path('app/public/' . $this->image))) {
            return asset('storage/' . $this->image);
        }
        return ''; // empty = use emoji fallback in blade
    }

    public static function categories(): array
    {
        return [
            'cookies'      => 'Cookies',
            'brownies'     => 'Brownies',
            'cookie-cakes' => 'Cookie Cakes',
            'boxes'        => 'Gift Boxes',
        ];
    }
}

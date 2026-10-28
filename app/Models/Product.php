<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'category',
        'image',
        'second_image',
        'description',
    ];

    protected static function booted(): void
    {
        static::saving(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        if (Str::startsWith($this->image, 'images/')) {
            return asset($this->image);
        }
        return asset('images/' . $this->image);
    }

    public function getSecondImageUrlAttribute(): ?string
    {
        if (!$this->second_image) {
            return $this->image_url;
        }
        if (Str::startsWith($this->second_image, ['http://', 'https://'])) {
            return $this->second_image;
        }
        if (Str::startsWith($this->second_image, 'images/')) {
            return asset($this->second_image);
        }
        return asset('images/' . $this->second_image);
    }
}


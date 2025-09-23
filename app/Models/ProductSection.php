<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ProductSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'image',
        'category'
    ];

    protected $casts = [
        'name' => 'array',
        'description' => 'array',
        'category' => 'array',
    ];

    // Generate slug automatically
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = $product->generateSlug($product->name['en'] ?? 'product');
            }
        });

        static::updating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = $product->generateSlug($product->name['en'] ?? 'product');
            }
        });
    }

    private function generateSlug($name)
    {
        $slug = Str::slug($name);
        $count = static::whereRaw("slug RLIKE '^{$slug}(-[0-9]+)?$'")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }
}
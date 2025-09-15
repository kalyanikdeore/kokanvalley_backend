<?php

// app/Models/AmenityGallery.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class AmenityGallery extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'order_column',
        'is_active'
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'is_active' => 'boolean'
    ];

    public function images(): HasMany
    {
        return $this->hasMany(AmenityGalleryImage::class)->orderBy('order_column');
    }

    // Register media collections
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('gallery_images');
    }
}
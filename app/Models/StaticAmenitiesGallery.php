<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class StaticAmenitiesGallery extends Model
{
    use HasFactory;

    protected $table = 'static_amenities_galleries';
    protected $fillable = [
        'title',
        'description',
        'images',
        'sort_order',
        'is_active'
    ];
    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'images' => 'array',
        'is_active' => 'boolean'
    ];

    // Accessor to get full image URLs
    public function getImageUrlsAttribute()
    {
        if (empty($this->images)) {
            return [];
        }
        
        return array_map(function ($image) {
            return Storage::disk('static_amenities')->url($image);
        }, $this->images);
    }
}
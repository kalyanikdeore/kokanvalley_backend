<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'gallery_images',
        'amenities_highlights',
        'guest_experiences',
    ];

    protected $casts = [
        'gallery_images' => 'array',
        'amenities_highlights' => 'array',
        'guest_experiences' => 'array',
    ];
}
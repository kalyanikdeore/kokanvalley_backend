<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmenitiesSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_en',
        'title_mr',
        'description_en',
        'description_mr',
        'icon',
        'images',
    ];

    protected $casts = [
        'images' => 'array', // ✅ Multiple images as array
    ];
}

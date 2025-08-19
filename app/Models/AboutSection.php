<?php


// app/Models/AboutSection.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSection extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title_en',
        'title_mr',
        'subtitle_en',
        'subtitle_mr',
        'description_en',
        'description_mr',
        'stats',
        'image_labels',
        'image_beach',
        'image_hills',
        'image_cuisine',
        'image_villages',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'stats' => 'array',
        'image_labels' => 'array',
    ];
}
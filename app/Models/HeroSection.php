<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_url',
        'title_en',
        'title_mr',
        'description_en',
        'description_mr',
        'youtube_link',
        'cta_highlight_en',
        'cta_highlight_mr',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
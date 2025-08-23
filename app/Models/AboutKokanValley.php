<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutKokanValley extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image1_url',
        'image2_url',
        'story',
        'video_url',
        'watch_story_text', // Changed from 'watch_story'
        'overlap_image_alt',
        'founder_image_url',
        'founder_name',
        'founder_position',
        'is_active'
    ];

    protected $casts = [
        'title' => 'array',
        'story' => 'array',
        'watch_story_text' => 'array', // Changed from 'watch_story'
        'overlap_image_alt' => 'array',
    ];
}
<?php
// app/Models/AboutKonkan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutKonkan extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'story',
        'image1_url',
        'image2_url',
        'video_url',
        'watch_story_text',
        'overlap_image_alt',
        'founder_image_url',
        'founder_name',
        'founder_position',
        'is_active'
    ];

    protected $casts = [
        'title' => 'array',
        'story' => 'array',
        'watch_story_text' => 'array',
        'overlap_image_alt' => 'array',
        'founder_name' => 'array',
        'founder_position' => 'array',
        'is_active' => 'boolean'
    ];
}
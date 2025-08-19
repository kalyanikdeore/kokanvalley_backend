<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'is_active',
        'video_url',
        'title',
        'description',
        'youtube_link',
        'cta_highlight',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'cta_highlight' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
}
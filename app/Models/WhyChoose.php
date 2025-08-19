<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WhyChoose extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'title',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'is_active' => 'boolean',
    ];

    // Helper methods to get localized content
    public function getLocalizedTitle($language = 'en')
    {
        return $this->title[$language] ?? $this->title['en'] ?? '';
    }

    public function getLocalizedDescription($language = 'en')
    {
        return $this->description[$language] ?? $this->description['en'] ?? '';
    }
}
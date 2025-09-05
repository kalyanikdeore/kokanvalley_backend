<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientTestimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'role',
        'location',
        'content',
        'rating',
        'project_id',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'name' => 'array',
        'role' => 'array',
        'location' => 'array',
        'content' => 'array',
        'is_active' => 'boolean'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectLocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'lat',
        'lng',
        'address_en',
        'address_mr',
        'embed_url',
        'zoom_level',
        'map_type'
    ];

    protected $attributes = [
        'zoom_level' => 15,
        'map_type' => 'roadmap'
    ];

    protected $casts = [
        'lat' => 'decimal:8',
        'lng' => 'decimal:8',
        'zoom_level' => 'integer',
    ];

 
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
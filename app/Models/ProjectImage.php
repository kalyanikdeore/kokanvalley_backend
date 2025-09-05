<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'image_path',
        'order'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    
    // Add an accessor to make it easier to reference the path
    public function getPathAttribute()
    {
        return $this->image_path;
    }
}
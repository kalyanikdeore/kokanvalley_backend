<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'video_path',
        'thumbnail_path',
        'order'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
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

    protected $appends = ['video_url', 'thumbnail_url'];

    public function getVideoUrlAttribute()
    {
        return $this->video_path ? asset('storage/' . $this->video_path) : null;
    }

    public function getThumbnailUrlAttribute()
    {
        return $this->thumbnail_path ? asset('storage/' . $this->thumbnail_path) : null;
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
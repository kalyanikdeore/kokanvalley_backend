<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectHighlight extends Model
{
    use HasFactory;

    protected $table = 'project_highlights';

    protected $fillable = [
        'project_id',
        'highlight_en',
        'highlight_mr',
        'order'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
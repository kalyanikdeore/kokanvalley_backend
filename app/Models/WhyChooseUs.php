<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhyChooseUs extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title_en',
        'title_mr',
        'description_en',
        'description_mr',
        'icon',
        'order'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
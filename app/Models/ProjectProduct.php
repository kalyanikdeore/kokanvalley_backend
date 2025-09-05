<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProjectProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'title_en',
        'title_mr',
        'description_en',
        'description_mr',
        'date',
        'order'
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Get all media for the project product
     */
    public function media(): HasMany
    {
        return $this->hasMany(ProductMedia::class, 'product_id');
    }
}
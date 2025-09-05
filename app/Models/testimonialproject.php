<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Testimonialproject extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'location_en',
        'location_mr',
        'quote_en',
        'quote_mr',
        'rating',
        'avatar_path',
        'order'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
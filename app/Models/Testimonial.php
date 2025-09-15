<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'content',      // single field for quotes
        'project_id',
        'rating',
        'avatar_path',  // add avatar_path if uploading image
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}

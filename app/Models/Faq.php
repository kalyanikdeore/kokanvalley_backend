<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'question_en',
        'question_mr',
        'answer_en',
        'answer_mr',
        'order'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
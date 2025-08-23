<?php

// app/Models/Resort.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resort extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'category'
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
    ];
}
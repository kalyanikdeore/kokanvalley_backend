<?php

// app/Models/CoreValue.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreValue extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'title',
        'description',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'is_active' => 'boolean'
    ];
}
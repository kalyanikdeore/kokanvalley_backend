<?php

// app/Models/GuestExperience.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'image'
    ];
}
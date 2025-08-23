<?php
// app/Models/Amenity.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'icon',
        'images'
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'images' => 'array'
    ];
}
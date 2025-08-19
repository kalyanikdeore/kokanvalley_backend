<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image',
        'category',
        'description',
        'price',
        'is_active'
    ];

    protected $casts = [
        'name' => 'array',
        'category' => 'array',
        'description' => 'array',
        'price' => 'array',
        'is_active' => 'boolean'
    ];
}
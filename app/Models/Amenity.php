<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Amenity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'images',
        'sort_order',
        'is_active'
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'images' => 'array',
        'is_active' => 'boolean'
    ];

    public function getTitleAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = json_encode($value);
    }

    public function getDescriptionAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = json_encode($value);
    }

    public function getImagesAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setImagesAttribute($value)
    {
        $this->attributes['images'] = json_encode($value);
    }
}
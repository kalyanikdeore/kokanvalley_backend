<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonkanGalleryCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name_en', 'name_mr', 'slug', 'sort_order', 'is_active'];

    public function images()
    {
        return $this->hasMany(KonkanGalleryImage::class, 'category_id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'icon', 
        'lat',
        'lng',
        'is_active',
        'image',
        'name', 
        'description',
        'address_en',
        'address_mr',
        'embed_url'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'lat' => 'decimal:8',
        'lng' => 'decimal:8',
        'name' => 'array',
        'description' => 'array'
    ];

    /**
     * Get all highlights for the project
     */
    public function highlights(): HasMany
    {
        return $this->hasMany(ProjectHighlight::class);
    }

        public function location(): HasMany
    {
        return $this->hasMany(ProjectLocation::class);
    }

    /**
     * Get all images for the project
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class);
    }

    /**
     * Get all videos for the project
     */
    public function videos(): HasMany
    {
        return $this->hasMany(ProjectVideo::class);
    }

    /**
     * Get all products for the project
     */
    public function products(): HasMany
    {
        return $this->hasMany(ProjectProduct::class);
    }

    /**
     * Get all why choose us items for the project
     */
    public function whyChooseUs(): HasMany
    {
        return $this->hasMany(WhyChooseUs::class);
    }

    /**
     * Get all testimonials for the project
     */
    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }
}
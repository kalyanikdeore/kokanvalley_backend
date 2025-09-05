<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductMedia extends Model
{
    protected $table = 'product_media'; // Changed from 'project_product_media'
    
    protected $fillable = [
        'product_id',
        'type',
        'media_path',
        'order'
    ];
    
    public function product(): BelongsTo
    {
        return $this->belongsTo(ProjectProduct::class, 'product_id');
    }
}
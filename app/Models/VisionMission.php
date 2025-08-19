<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisionMission extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'vision_title',
        'vision_content',
        'mission_title',
        'mission_content'
    ];

    protected $casts = [
        'title' => 'array',
        'vision_title' => 'array',
        'vision_content' => 'array',
        'mission_title' => 'array',
        'mission_content' => 'array',
    ];

    // Helper method to get the first record (since we'll only have one)
    public static function getContent()
    {
        return self::first() ?? new self();
    }
}
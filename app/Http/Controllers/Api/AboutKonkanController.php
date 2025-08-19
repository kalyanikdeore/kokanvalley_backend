<?php
// app/Http/Controllers/AboutKonkanController.php

namespace App\Http\Controllers;

use App\Models\AboutKonkan;
use Illuminate\Http\Request;

class AboutKonkanController extends Controller
{
    public function index()
    {
        $aboutKonkan = AboutKonkan::where('is_active', true)->first();
        
        if (!$aboutKonkan) {
            // Return default data if no active record exists
            return response()->json([
                'title' => ['en' => 'About Konkan Valley', 'mr' => 'कोकण व्हॅली बद्दल'],
                'story' => ['en' => 'Default story...', 'mr' => 'डीफॉल्ट कहाणी...'],
                'image1_url' => 'default-image1.jpg',
                'image2_url' => 'default-image2.jpg',
                'video_url' => null,
                'watch_story_text' => ['en' => 'Watch our Story', 'mr' => 'आमची कहाणी पहा'],
                'overlap_image_alt' => ['en' => 'Leela Farmhouse', 'mr' => 'लीला फार्महाऊस'],
                'founder_image_url' => null,
                'founder_name' => null,
                'founder_position' => null,
            ]);
        }
        
        return response()->json($aboutKonkan);
    }
}
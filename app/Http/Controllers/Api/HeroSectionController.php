<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;

class HeroSectionController extends Controller
{
    public function index()
    {
        try {
            $heroSections = HeroSection::where('is_active', true)
                ->orderBy('order', 'asc')
                ->get()
                ->map(function ($item) {
                    // Add full URL for video files
                    if ($item->video_url) {
                        $item->video_url = asset('storage/' . $item->video_url);
                    }
                    return $item;
                });
                
            return response()->json($heroSections);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch hero sections',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    public function show($id)
    {
        try {
            $heroSection = HeroSection::findOrFail($id);
            
            // Add full URL for video file
            if ($heroSection->video_url) {
                $heroSection->video_url = asset('storage/' . $heroSection->video_url);
            }
            
            return response()->json($heroSection);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Hero section not found',
                'message' => $e->getMessage()
            ], 404);
        }
    }
}
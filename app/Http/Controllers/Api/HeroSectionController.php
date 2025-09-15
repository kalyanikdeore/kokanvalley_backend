<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSectionController extends Controller
{
    public function index()
    {
        try {
            $heroSections = HeroSection::where('is_active', true)
                ->orderBy('order', 'asc')
                ->get()
                ->map(function ($item) {
                    // Return only the relative path for video files
                    // The frontend will construct the full URL using a utility function
                    return [
                        'id' => $item->id,
                        'video_url' => $item->video_url, // This is the relative path
                        'title_en' => $item->title_en,
                        'title_mr' => $item->title_mr,
                        'description_en' => $item->description_en,
                        'description_mr' => $item->description_mr,
                        'youtube_link' => $item->youtube_link,
                        'cta_highlight_en' => $item->cta_highlight_en,
                        'cta_highlight_mr' => $item->cta_highlight_mr,
                        'order' => $item->order,
                        'is_active' => $item->is_active,
                        'created_at' => $item->created_at,
                        'updated_at' => $item->updated_at,
                    ];
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
            
            // Return only the relative path for the video file
            $response = [
                'id' => $heroSection->id,
                'video_url' => $heroSection->video_url, // This is the relative path
                'title_en' => $heroSection->title_en,
                'title_mr' => $heroSection->title_mr,
                'description_en' => $heroSection->description_en,
                'description_mr' => $heroSection->description_mr,
                'youtube_link' => $heroSection->youtube_link,
                'cta_highlight_en' => $heroSection->cta_highlight_en,
                'cta_highlight_mr' => $heroSection->cta_highlight_mr,
                'order' => $heroSection->order,
                'is_active' => $heroSection->is_active,
                'created_at' => $heroSection->created_at,
                'updated_at' => $heroSection->updated_at,
            ];
            
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Hero section not found',
                'message' => $e->getMessage()
            ], 404);
        }
    }
    
    /**
     * Optional: If you need an endpoint that returns full URLs
     */
    public function indexWithUrls()
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
    
    /**
     * Optional: If you need an endpoint that returns a single item with full URL
     */
    public function showWithUrl($id)
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
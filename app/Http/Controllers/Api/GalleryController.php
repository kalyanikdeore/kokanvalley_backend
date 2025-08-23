<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $gallery = Gallery::latest()->first();
        
        if (!$gallery) {
            return response()->json([
                'message' => 'No gallery content found'
            ], 404);
        }

        // Process gallery images to include full URLs
        $galleryImages = collect($gallery->gallery_images)->map(function($image) {
            return [
                'id' => $image['id'] ?? uniqid(),
                'url' => asset('storage/' . $image['url']),
                'category' => $image['category']
            ];
        });

        // Process amenities highlights
        $amenitiesHighlights = collect($gallery->amenities_highlights)->map(function($amenity) {
            $amenity['images'] = collect($amenity['images'])->map(function($image) {
                return asset('storage/' . $image);
            })->toArray();
            
            return $amenity;
        });

        // Process guest experiences
        $guestExperiences = collect($gallery->guest_experiences)->map(function($experience) {
            return [
                'url' => asset('storage/' . $experience['url']),
                'position' => $experience['position']
            ];
        });

        return response()->json([
            'title' => $gallery->title,
            'description' => $gallery->description,
            'gallery_images' => $galleryImages,
            'amenities_highlights' => $amenitiesHighlights,
            'guest_experiences' => $guestExperiences,
        ]);
    }
}
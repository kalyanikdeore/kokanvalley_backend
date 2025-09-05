<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProjectAmenity;
use Illuminate\Http\Request;

class ProjectAmenityController extends Controller
{
    public function index(Request $request)
    {
        $language = $request->get('language', 'en');
        
        $amenities = ProjectAmenity::where('is_active', true)
            ->orderBy('sort_order', 'asc')
            ->get()
            ->map(function ($amenity) use ($language) {
                return [
                    'id' => $amenity->id,
                    'title' => $amenity->title[$language] ?? $amenity->title['en'],
                    'description' => $amenity->description[$language] ?? $amenity->description['en'],
                    'images' => array_map(function ($image) {
                        return asset('storage/' . $image);
                    }, $amenity->images)
                ];
            });
        
        return response()->json($amenities);
    }
}
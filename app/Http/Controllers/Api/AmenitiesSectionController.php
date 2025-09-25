<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AmenitiesSection;
use Illuminate\Http\Request;

class AmenitiesSectionController extends Controller
{
    // GET all amenities
    public function index()
    {
        return response()->json(AmenitiesSection::all());
    }

    // Store new amenity with multiple images
    public function store(Request $request)
    {
        $data = $request->validate([
            'title_en' => 'required|string',
            'title_mr' => 'required|string',
            'description_en' => 'nullable|string',
            'description_mr' => 'nullable|string',
            'icon' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            // Create nested directory if it doesn't exist
            $directory = public_path('amenities-images');
            if (!file_exists($directory)) {
                mkdir($directory, 0755, true);
            }
            
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
                $image->move($directory, $filename);
                // Store only filename, not full path
                $imagePaths[] = $filename;
            }
        }

        $data['images'] = $imagePaths;

        $amenity = AmenitiesSection::create($data);

        return response()->json($amenity, 201);
    }

    // Delete amenity
    public function destroy($id)
    {
        $amenity = AmenitiesSection::findOrFail($id);
        
        // Delete associated images from storage
        if (!empty($amenity->images)) {
            foreach ($amenity->images as $image) {
                $imagePath = public_path('amenities-images/' . $image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
        }
        
        $amenity->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
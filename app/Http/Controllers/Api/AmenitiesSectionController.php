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
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads'), $filename);
                $imagePaths[] = $filename;
            }
        }

        $data['images'] = $imagePaths;

        $amenity = AmenitiesSection::create($data);

        return response()->json($amenity, 201);
    }

    // Show single amenity
    public function show($id)
    {
        return response()->json(AmenitiesSection::findOrFail($id));
    }

    // Update amenity
    public function update(Request $request, $id)
    {
        $amenity = AmenitiesSection::findOrFail($id);

        $data = $request->validate([
            'title_en' => 'sometimes|string',
            'title_mr' => 'sometimes|string',
            'description_en' => 'nullable|string',
            'description_mr' => 'nullable|string',
            'icon' => 'nullable|string',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePaths = $amenity->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('uploads'), $filename);
                $imagePaths[] = $filename;
            }
        }

        $data['images'] = $imagePaths;

        $amenity->update($data);

        return response()->json($amenity);
    }

    // Delete amenity
    public function destroy($id)
    {
        $amenity = AmenitiesSection::findOrFail($id);
        $amenity->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}

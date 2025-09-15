<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\StaticAmenitiesGallery;
use Illuminate\Http\Request;


class StaticAmenitiesGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $amenities = StaticAmenitiesGallery::where('is_active', true)
            ->orderBy('sort_order')
            ->get();
        
        return response()->json($amenities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title.en' => 'required|string|max:255',
            'title.mr' => 'required|string|max:255',
            'description.en' => 'required|string',
            'description.mr' => 'required|string',
            'images' => 'required|array',
            'images.*' => 'string',
            'sort_order' => 'integer',
            'is_active' => 'boolean'
        ]);

        $amenity = StaticAmenitiesGallery::create($validated);

        return response()->json($amenity, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $amenity = StaticAmenitiesGallery::findOrFail($id);
        
        return response()->json($amenity);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $amenity = StaticAmenitiesGallery::findOrFail($id);

        $validated = $request->validate([
            'title.en' => 'sometimes|required|string|max:255',
            'title.mr' => 'sometimes|required|string|max:255',
            'description.en' => 'sometimes|required|string',
            'description.mr' => 'sometimes|required|string',
            'images' => 'sometimes|required|array',
            'images.*' => 'string',
            'sort_order' => 'sometimes|integer',
            'is_active' => 'sometimes|boolean'
        ]);

        $amenity->update($validated);

        return response()->json($amenity);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $amenity = StaticAmenitiesGallery::findOrFail($id);
        $amenity->delete();

        return response()->json(['message' => 'Amenity deleted successfully']);
    }
}
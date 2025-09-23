<?php

namespace App\Http\Controllers\Api;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function index()
    {
        try {
            $locations = Location::where('is_active', true)->get();
            return response()->json($locations);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch locations',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $location = Location::findOrFail($id);
            return response()->json($location);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Location not found',
                'message' => $e->getMessage()
            ], 404);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name_en' => 'required|string|max:255',
                'name_mr' => 'nullable|string|max:255',
                'address_en' => 'nullable|string',
                'address_mr' => 'nullable|string',
                'embed_url' => 'nullable|url',
                'map_type' => 'nullable|in:roadmap,satellite,hybrid,terrain',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
                'is_active' => 'boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('locations', 'public');
                $validated['image'] = $imagePath;
            }

            $location = Location::create($validated);
            return response()->json($location, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create location',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $location = Location::findOrFail($id);
            
            $validated = $request->validate([
                'name_en' => 'sometimes|required|string|max:255',
                'name_mr' => 'nullable|string|max:255',
                'address_en' => 'nullable|string',
                'address_mr' => 'nullable|string',
                'embed_url' => 'nullable|url',
                'map_type' => 'nullable|in:roadmap,satellite,hybrid,terrain',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
                'is_active' => 'boolean',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($location->image && Storage::disk('public')->exists($location->image)) {
                    Storage::disk('public')->delete($location->image);
                }
                
                $imagePath = $request->file('image')->store('locations', 'public');
                $validated['image'] = $imagePath;
            }

            $location->update($validated);
            return response()->json($location);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to update location',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $location = Location::findOrFail($id);
            
            // Delete associated image
            if ($location->image && Storage::disk('public')->exists($location->image)) {
                Storage::disk('public')->delete($location->image);
            }
            
            $location->delete();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to delete location',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
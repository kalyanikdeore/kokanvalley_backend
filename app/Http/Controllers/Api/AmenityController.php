<?php
// app/Http/Controllers/Api/AmenityController.php

namespace App\Http\Controllers\Api;

use App\Models\Amenity;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class AmenityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $amenities = Amenity::all()->map(function ($amenity) {
                // Prepend storage path to images
                $amenity->images = array_map(function ($image) {
                    return Storage::url($image);
                }, $amenity->images);
                
                return $amenity;
            });
            
            return response()->json([
                'success' => true,
                'data' => $amenities
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch amenities',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'title.en' => 'required|string',
                'title.mr' => 'required|string',
                'description.en' => 'required|string',
                'description.mr' => 'required|string',
                'icon' => 'required|in:pool,bed,utensils,tree',
                'images' => 'required|array',
                'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Store uploaded images
            $imagePaths = [];
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('amenities', 'public');
                    $imagePaths[] = $path;
                }
            }
            
            $validated['images'] = $imagePaths;
            
            $amenity = Amenity::create($validated);

            return response()->json([
                'success' => true,
                'data' => $amenity,
                'message' => 'Amenity created successfully'
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create amenity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        try {
            $amenity = Amenity::findOrFail($id);
            
            // Prepend storage path to images
            $amenity->images = array_map(function ($image) {
                return Storage::url($image);
            }, $amenity->images);
            
            return response()->json([
                'success' => true,
                'data' => $amenity
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch amenity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $amenity = Amenity::findOrFail($id);
            
            $validated = $request->validate([
                'title.en' => 'sometimes|required|string',
                'title.mr' => 'sometimes|required|string',
                'description.en' => 'sometimes|required|string',
                'description.mr' => 'sometimes|required|string',
                'icon' => 'sometimes|required|in:pool,bed,utensils,tree',
                'images' => 'sometimes|array',
                'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Handle image updates if provided
            if ($request->hasFile('images')) {
                // Delete old images
                foreach ($amenity->images as $oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
                
                // Store new images
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('amenities', 'public');
                    $imagePaths[] = $path;
                }
                
                $validated['images'] = $imagePaths;
            }
            
            $amenity->update($validated);

            return response()->json([
                'success' => true,
                'data' => $amenity,
                'message' => 'Amenity updated successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update amenity',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $amenity = Amenity::findOrFail($id);
            
            // Delete associated images
            foreach ($amenity->images as $image) {
                Storage::disk('public')->delete($image);
            }
            
            $amenity->delete();

            return response()->json([
                'success' => true,
                'message' => 'Amenity deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete amenity',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
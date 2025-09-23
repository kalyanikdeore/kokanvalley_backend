<?php
// app/Http/Controllers/Api/GuestExperienceController.php

namespace App\Http\Controllers\Api;

use App\Models\GuestExperience;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class GuestExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $experiences = GuestExperience::all()->map(function ($experience) {
                // Return full URL for the image using the public disk
                $experience->image_url = asset('uploads/' . $experience->image);
                return $experience;
            });
            
            return response()->json([
                'success' => true,
                'data' => $experiences
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch guest experiences',
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
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            // Store the image in the public disk (which now points to uploads)
            $imagePath = $request->file('image')->store('guest-experiences', 'public');

            $experience = GuestExperience::create([
                'image' => $imagePath,
            ]);

            return response()->json([
                'success' => true,
                'data' => $experience,
                'message' => 'Guest experience created successfully'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create guest experience',
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
            $experience = GuestExperience::findOrFail($id);
            $experience->image_url = asset('uploads/' . $experience->image);
            
            return response()->json([
                'success' => true,
                'data' => $experience
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Guest experience not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $experience = GuestExperience::findOrFail($id);
            
            // Delete the image file from public disk (uploads directory)
            if (\Storage::disk('public')->exists($experience->image)) {
                \Storage::disk('public')->delete($experience->image);
            }
            
            $experience->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Guest experience deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete guest experience',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
<?php
// app/Http/Controllers/Api/GuestExperienceController.php

namespace App\Http\Controllers\Api;

use App\Models\GuestExperience;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller; // Added this line

class GuestExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $experiences = GuestExperience::all()->map(function ($experience) {
                // Return full URL for the image
                $experience->image_url = asset('storage/' . $experience->image);
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

    // Other methods remain the same as in your original code
    // ...
}
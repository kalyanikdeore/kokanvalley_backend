<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resort;
use Illuminate\Http\JsonResponse;

class ResortController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        try {
            $resorts = Resort::all()->map(function ($resort) {
                // Add full URL to the image
                $resort->image_url = asset('storage/' . $resort->image);
                return $resort;
            });
            
            return response()->json([
                'success' => true,
                'data' => $resorts
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch resorts',
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
                'image' => 'required|string',
                'category' => 'required|in:property,rooms,pool'
            ]);

            $resort = Resort::create($validated);

            return response()->json([
                'success' => true,
                'data' => $resort,
                'message' => 'Resort created successfully'
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
                'message' => 'Failed to create resort',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Resort $resort): JsonResponse
    {
        try {
            // Add full URL to the image
            $resort->image_url = asset('storage/' . $resort->image);
            
            return response()->json([
                'success' => true,
                'data' => $resort
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch resort',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resort $resort): JsonResponse
    {
        try {
            $validated = $request->validate([
                'title.en' => 'sometimes|required|string',
                'title.mr' => 'sometimes|required|string',
                'description.en' => 'sometimes|required|string',
                'description.mr' => 'sometimes|required|string',
                'image' => 'sometimes|required|string',
                'category' => 'sometimes|required|in:property,rooms,pool'
            ]);

            $resort->update($validated);

            return response()->json([
                'success' => true,
                'data' => $resort,
                'message' => 'Resort updated successfully'
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
                'message' => 'Failed to update resort',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resort $resort): JsonResponse
    {
        try {
            $resort->delete();

            return response()->json([
                'success' => true,
                'message' => 'Resort deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete resort',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
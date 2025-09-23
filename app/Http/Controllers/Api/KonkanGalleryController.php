<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\KonkanGalleryCategory;
use App\Models\KonkanGalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class KonkanGalleryController extends Controller
{
    /**
     * Display a listing of the gallery data.
     */
    public function index()
    {
        return $this->getGalleryData();
    }

    /**
     * Get gallery data for API response.
     */
    public function getGalleryData()
    {
        try {
            // Verify database connection first
            DB::connection()->getPdo();
            
            $categories = KonkanGalleryCategory::where('is_active', true)
                ->with(['images' => function($query) {
                    $query->where('is_active', true)->orderBy('sort_order');
                }])
                ->orderBy('sort_order')
                ->get();

            // Format the data to match your frontend structure
            $formattedCategories = [];
            $allImages = [];

            foreach ($categories as $category) {
                $formattedCategories[] = [
                    'id' => $category->slug,
                    'name' => [
                        'en' => $category->name_en,
                        'mr' => $category->name_mr
                    ]
                ];

                foreach ($category->images as $image) {
                    // Generate URL for uploaded images in public/uploads
                    $imageUrl = url('uploads/' . $image->image_path);
                    
                    $allImages[] = [
                        'id' => $image->id,
                        'url' => $imageUrl,
                        'category' => $category->slug
                    ];
                }
            }

            // Add "All" category
            array_unshift($formattedCategories, [
                'id' => 'all',
                'name' => [
                    'en' => 'All',
                    'mr' => 'सर्व'
                ]
            ]);

            return response()->json([
                'success' => true,
                'categories' => $formattedCategories,
                'images' => $allImages
            ]);

        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Gallery API Error: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => env('APP_DEBUG') ? $e->getMessage() : 'Please check server logs'
            ], 500);
        }
    }
}
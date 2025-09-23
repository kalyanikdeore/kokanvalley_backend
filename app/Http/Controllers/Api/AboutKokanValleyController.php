<?php
// app/Http/Controllers/Api/AboutKokanValleyController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutKokanValley;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AboutKokanValleyController extends Controller
{
    public function index()
    {
        try {
            $aboutKokanValley = AboutKokanValley::where('is_active', true)->first();
            
            if (!$aboutKokanValley) {
                // Return default data if no active record exists
                return response()->json([
                    'title' => ['en' => 'About Konkan Valley', 'mr' => 'कोकण व्हॅली बद्दल'],
                    'story' => [
                        'en' => 'At Konkan valley agro farms, we are the fearless trailblazers...', 
                        'mr' => 'कोकण व्हॅली अ‍ॅग्रो फार्म्स मध्ये, आम्ही निधड्या मार्गक्रमक आहोत...'
                    ],
                    'image1_url' => '/uploads/default-images/kokan4.jpg',
                    'image2_url' => '/uploads/default-images/kokan14.jpg',
                    'video_url' => 'https://www.youtube.com/@KonkanVallyAgroFarms',
                    'watch_story_text' => ['en' => 'Watch our Story', 'mr' => 'आमची कहाणी पहा'],
                    'overlap_image_alt' => ['en' => 'Leela Farmhouse garden view', 'mr' => 'लीला फार्महाऊस बाग दृश्य'],
                    'founder_image_url' => null,
                    'founder_name' => null,
                    'founder_position' => null,
                ]);
            }
            
            // Convert stored paths to full URLs
            $aboutKokanValley->image1_url = $aboutKokanValley->image1_url ? $aboutKokanValley->image1_url : null;
            $aboutKokanValley->image2_url = $aboutKokanValley->image2_url ? $aboutKokanValley->image2_url : null;
            $aboutKokanValley->founder_image_url = $aboutKokanValley->founder_image_url ? $aboutKokanValley->founder_image_url : null;
            
            return response()->json([
                'id' => $aboutKokanValley->id,
                'title' => $aboutKokanValley->title,
                'story' => $aboutKokanValley->story,
                'image1_url' => $aboutKokanValley->image1_url,
                'image2_url' => $aboutKokanValley->image2_url,
                'video_url' => $aboutKokanValley->video_url,
                'watch_story_text' => $aboutKokanValley->watch_story_text,
                'overlap_image_alt' => $aboutKokanValley->overlap_image_alt,
                'founder_image_url' => $aboutKokanValley->founder_image_url,
                'founder_name' => $aboutKokanValley->founder_name,
                'founder_position' => $aboutKokanValley->founder_position,
                'is_active' => $aboutKokanValley->is_active,
            ]);
            
        } catch (\Exception $e) {
            Log::error('AboutKokanValleyController index error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Failed to fetch about data',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title.en' => 'required|string',
                'title.mr' => 'required|string',
                'story.en' => 'required|string',
                'story.mr' => 'required|string',
                'image1' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'image2' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'video_url' => 'nullable|url',
                'watch_story_text.en' => 'nullable|string',
                'watch_story_text.mr' => 'nullable|string',
                'overlap_image_alt.en' => 'nullable|string',
                'overlap_image_alt.mr' => 'nullable|string',
                'founder_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'founder_name' => 'nullable|string',
                'founder_position' => 'nullable|string',
                'is_active' => 'boolean',
            ]);

            // Handle file uploads
            $image1Path = $request->file('image1')->store('about-kokan-valley', 'public');
            $image2Path = $request->file('image2')->store('about-kokan-valley', 'public');
            
            $founderImagePath = null;
            if ($request->hasFile('founder_image')) {
                $founderImagePath = $request->file('founder_image')->store('about-kokan-valley/founder', 'public');
            }

            // Deactivate any currently active records if this one is being set to active
            if ($request->get('is_active', true)) {
                AboutKokanValley::where('is_active', true)->update(['is_active' => false]);
            }

            $aboutKokanValley = AboutKokanValley::create([
                'title' => $validated['title'],
                'story' => $validated['story'],
                'image1_url' => $image1Path,
                'image2_url' => $image2Path,
                'video_url' => $validated['video_url'] ?? null,
                'watch_story_text' => $validated['watch_story_text'] ?? ['en' => 'Watch our Story', 'mr' => 'आमची कहाणी पहा'],
                'overlap_image_alt' => $validated['overlap_image_alt'] ?? ['en' => 'Leela Farmhouse garden view', 'mr' => 'लीला फार्महाऊस बाग दृश्य'],
                'founder_image_url' => $founderImagePath,
                'founder_name' => $validated['founder_name'] ?? null,
                'founder_position' => $validated['founder_position'] ?? null,
                'is_active' => $request->get('is_active', true),
            ]);

            return response()->json([
                'message' => 'About Kokan Valley content created successfully',
                'data' => $aboutKokanValley
            ], 201);

        } catch (\Exception $e) {
            Log::error('AboutKokanValleyController store error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Failed to create about content',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show(AboutKokanValley $aboutKokanValley)
    {
        try {
            // Return paths as stored (relative to uploads directory)
            return response()->json([
                'id' => $aboutKokanValley->id,
                'title' => $aboutKokanValley->title,
                'story' => $aboutKokanValley->story,
                'image1_url' => $aboutKokanValley->image1_url,
                'image2_url' => $aboutKokanValley->image2_url,
                'video_url' => $aboutKokanValley->video_url,
                'watch_story_text' => $aboutKokanValley->watch_story_text,
                'overlap_image_alt' => $aboutKokanValley->overlap_image_alt,
                'founder_image_url' => $aboutKokanValley->founder_image_url,
                'founder_name' => $aboutKokanValley->founder_name,
                'founder_position' => $aboutKokanValley->founder_position,
                'is_active' => $aboutKokanValley->is_active,
                'created_at' => $aboutKokanValley->created_at,
                'updated_at' => $aboutKokanValley->updated_at,
            ]);
            
        } catch (\Exception $e) {
            Log::error('AboutKokanValleyController show error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Failed to fetch about content',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, AboutKokanValley $aboutKokanValley)
    {
        try {
            $validated = $request->validate([
                'title.en' => 'sometimes|required|string',
                'title.mr' => 'sometimes|required|string',
                'story.en' => 'sometimes|required|string',
                'story.mr' => 'sometimes|required|string',
                'image1' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
                'image2' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
                'video_url' => 'nullable|url',
                'watch_story_text.en' => 'nullable|string',
                'watch_story_text.mr' => 'nullable|string',
                'overlap_image_alt.en' => 'nullable|string',
                'overlap_image_alt.mr' => 'nullable|string',
                'founder_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'founder_name' => 'nullable|string',
                'founder_position' => 'nullable|string',
                'is_active' => 'boolean',
            ]);

            // Handle file uploads if provided
            if ($request->hasFile('image1')) {
                // Delete old image
                if ($aboutKokanValley->image1_url) {
                    Storage::disk('public')->delete($aboutKokanValley->image1_url);
                }
                $image1Path = $request->file('image1')->store('about-kokan-valley', 'public');
                $aboutKokanValley->image1_url = $image1Path;
            }
            
            if ($request->hasFile('image2')) {
                // Delete old image
                if ($aboutKokanValley->image2_url) {
                    Storage::disk('public')->delete($aboutKokanValley->image2_url);
                }
                $image2Path = $request->file('image2')->store('about-kokan-valley', 'public');
                $aboutKokanValley->image2_url = $image2Path;
            }
            
            if ($request->hasFile('founder_image')) {
                // Delete old image
                if ($aboutKokanValley->founder_image_url) {
                    Storage::disk('public')->delete($aboutKokanValley->founder_image_url);
                }
                $founderImagePath = $request->file('founder_image')->store('about-kokan-valley/founder', 'public');
                $aboutKokanValley->founder_image_url = $founderImagePath;
            }

            // If activating this record, deactivate any others
            if ($request->has('is_active') && $request->get('is_active')) {
                AboutKokanValley::where('is_active', true)
                    ->where('id', '!=', $aboutKokanValley->id)
                    ->update(['is_active' => false]);
            }

            // Update other fields
            $aboutKokanValley->title = $validated['title'] ?? $aboutKokanValley->title;
            $aboutKokanValley->story = $validated['story'] ?? $aboutKokanValley->story;
            $aboutKokanValley->video_url = $validated['video_url'] ?? $aboutKokanValley->video_url;
            $aboutKokanValley->watch_story_text = $validated['watch_story_text'] ?? $aboutKokanValley->watch_story_text;
            $aboutKokanValley->overlap_image_alt = $validated['overlap_image_alt'] ?? $aboutKokanValley->overlap_image_alt;
            $aboutKokanValley->founder_name = $validated['founder_name'] ?? $aboutKokanValley->founder_name;
            $aboutKokanValley->founder_position = $validated['founder_position'] ?? $aboutKokanValley->founder_position;
            $aboutKokanValley->is_active = $request->has('is_active') ? $request->get('is_active') : $aboutKokanValley->is_active;
            
            $aboutKokanValley->save();

            return response()->json([
                'message' => 'About Kokan Valley content updated successfully',
                'data' => $aboutKokanValley
            ]);

        } catch (\Exception $e) {
            Log::error('AboutKokanValleyController update error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Failed to update about content',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(AboutKokanValley $aboutKokanValley)
    {
        try {
            // Delete associated images
            if ($aboutKokanValley->image1_url) {
                Storage::disk('public')->delete($aboutKokanValley->image1_url);
            }
            if ($aboutKokanValley->image2_url) {
                Storage::disk('public')->delete($aboutKokanValley->image2_url);
            }
            if ($aboutKokanValley->founder_image_url) {
                Storage::disk('public')->delete($aboutKokanValley->founder_image_url);
            }
            
            $aboutKokanValley->delete();

            return response()->json([
                'message' => 'About Kokan Valley content deleted successfully'
            ], 204);

        } catch (\Exception $e) {
            Log::error('AboutKokanValleyController destroy error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Failed to delete about content',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function listAll()
    {
        try {
            $aboutKokanValleys = AboutKokanValley::orderBy('is_active', 'desc')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'title' => $item->title,
                        'is_active' => $item->is_active,
                        'created_at' => $item->created_at->format('Y-m-d H:i:s'),
                        'updated_at' => $item->updated_at->format('Y-m-d H:i:s'),
                    ];
                });

            return response()->json($aboutKokanValleys);
            
        } catch (\Exception $e) {
            Log::error('AboutKokanValleyController listAll error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Failed to fetch about content list',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
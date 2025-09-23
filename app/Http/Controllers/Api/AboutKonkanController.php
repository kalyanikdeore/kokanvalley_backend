<?php
// app/Http/Controllers/Api/AboutKonkanController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutKonkan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AboutKonkanController extends Controller
{
    public function index()
    {
        try {
            $aboutKonkan = AboutKonkan::where('is_active', true)->first();
            
            if (!$aboutKonkan) {
                // Return default data if no active record exists
                return response()->json([
                    'title' => ['en' => 'About Konkan Valley', 'mr' => 'कोकण व्हॅली बद्दल'],
                    'story' => [
                        'en' => 'At Konkan valley agro farms, we are the fearless trailblazers...', 
                        'mr' => 'कोकण व्हॅली अ‍ॅग्रो फार्म्स मध्ये, आम्ही निधड्या मार्गक्रमक आहोत...'
                    ],
                    'image1_url' => asset('uploads/default-images/kokan4.jpg'),
                    'image2_url' => asset('uploads/default-images/kokan14.jpg'),
                    'video_url' => 'https://www.youtube.com/@KonkanVallyAgroFarms',
                    'watch_story_text' => ['en' => 'Watch our Story', 'mr' => 'आमची कहाणी पहा'],
                    'overlap_image_alt' => ['en' => 'Leela Farmhouse garden view', 'mr' => 'लीला फार्महाऊस बाग दृश्य'],
                    'founder_image_url' => null,
                    'founder_name' => null,
                    'founder_position' => null,
                ]);
            }
            
            // Convert stored paths to full URLs using asset()
            $aboutKonkan->image1_url = $aboutKonkan->image1_url ? asset('uploads/' . $aboutKonkan->image1_url) : null;
            $aboutKonkan->image2_url = $aboutKonkan->image2_url ? asset('uploads/' . $aboutKonkan->image2_url) : null;
            $aboutKonkan->founder_image_url = $aboutKonkan->founder_image_url ? asset('uploads/' . $aboutKonkan->founder_image_url) : null;
            
            return response()->json([
                'id' => $aboutKonkan->id,
                'title' => $aboutKonkan->title,
                'story' => $aboutKonkan->story,
                'image1_url' => $aboutKonkan->image1_url,
                'image2_url' => $aboutKonkan->image2_url,
                'video_url' => $aboutKonkan->video_url,
                'watch_story_text' => $aboutKonkan->watch_story_text,
                'overlap_image_alt' => $aboutKonkan->overlap_image_alt,
                'founder_image_url' => $aboutKonkan->founder_image_url,
                'founder_name' => $aboutKonkan->founder_name,
                'founder_position' => $aboutKonkan->founder_position,
                'is_active' => $aboutKonkan->is_active,
            ]);
            
        } catch (\Exception $e) {
            Log::error('AboutKonkanController index error: ' . $e->getMessage());
            
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
                'founder_name.en' => 'nullable|string',
                'founder_name.mr' => 'nullable|string',
                'founder_position.en' => 'nullable|string',
                'founder_position.mr' => 'nullable|string',
                'is_active' => 'boolean',
            ]);

            // Handle file uploads to public disk
            $image1Path = $request->file('image1')->store('about-konkan', 'public');
            $image2Path = $request->file('image2')->store('about-konkan', 'public');
            
            $founderImagePath = null;
            if ($request->hasFile('founder_image')) {
                $founderImagePath = $request->file('founder_image')->store('about-konkan/founder', 'public');
            }

            // Deactivate any currently active records if this one is being set to active
            if ($request->get('is_active', true)) {
                AboutKonkan::where('is_active', true)->update(['is_active' => false]);
            }

            $aboutKonkan = AboutKonkan::create([
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
                'message' => 'About Konkan content created successfully',
                'data' => $aboutKonkan
            ], 201);

        } catch (\Exception $e) {
            Log::error('AboutKonkanController store error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Failed to create about content',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function show(AboutKonkan $aboutKonkan)
    {
        try {
            // Convert stored paths to full URLs using asset()
            $aboutKonkan->image1_url = $aboutKonkan->image1_url ? asset('uploads/' . $aboutKonkan->image1_url) : null;
            $aboutKonkan->image2_url = $aboutKonkan->image2_url ? asset('uploads/' . $aboutKonkan->image2_url) : null;
            $aboutKonkan->founder_image_url = $aboutKonkan->founder_image_url ? asset('uploads/' . $aboutKonkan->founder_image_url) : null;
            
            return response()->json([
                'id' => $aboutKonkan->id,
                'title' => $aboutKonkan->title,
                'story' => $aboutKonkan->story,
                'image1_url' => $aboutKonkan->image1_url,
                'image2_url' => $aboutKonkan->image2_url,
                'video_url' => $aboutKonkan->video_url,
                'watch_story_text' => $aboutKonkan->watch_story_text,
                'overlap_image_alt' => $aboutKonkan->overlap_image_alt,
                'founder_image_url' => $aboutKonkan->founder_image_url,
                'founder_name' => $aboutKonkan->founder_name,
                'founder_position' => $aboutKonkan->founder_position,
                'is_active' => $aboutKonkan->is_active,
                'created_at' => $aboutKonkan->created_at,
                'updated_at' => $aboutKonkan->updated_at,
            ]);
            
        } catch (\Exception $e) {
            Log::error('AboutKonkanController show error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Failed to fetch about content',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, AboutKonkan $aboutKonkan)
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
                'founder_name.en' => 'nullable|string',
                'founder_name.mr' => 'nullable|string',
                'founder_position.en' => 'nullable|string',
                'founder_position.mr' => 'nullable|string',
                'is_active' => 'boolean',
            ]);

            // Handle file uploads if provided
            if ($request->hasFile('image1')) {
                // Delete old image
                if ($aboutKonkan->image1_url) {
                    Storage::disk('public')->delete($aboutKonkan->image1_url);
                }
                $image1Path = $request->file('image1')->store('about-konkan', 'public');
                $aboutKonkan->image1_url = $image1Path;
            }
            
            if ($request->hasFile('image2')) {
                // Delete old image
                if ($aboutKonkan->image2_url) {
                    Storage::disk('public')->delete($aboutKonkan->image2_url);
                }
                $image2Path = $request->file('image2')->store('about-konkan', 'public');
                $aboutKonkan->image2_url = $image2Path;
            }
            
            if ($request->hasFile('founder_image')) {
                // Delete old image
                if ($aboutKonkan->founder_image_url) {
                    Storage::disk('public')->delete($aboutKonkan->founder_image_url);
                }
                $founderImagePath = $request->file('founder_image')->store('about-konkan/founder', 'public');
                $aboutKonkan->founder_image_url = $founderImagePath;
            }

            // If activating this record, deactivate any others
            if ($request->has('is_active') && $request->get('is_active')) {
                AboutKonkan::where('is_active', true)
                    ->where('id', '!=', $aboutKonkan->id)
                    ->update(['is_active' => false]);
            }

            // Update other fields
            $aboutKonkan->title = $validated['title'] ?? $aboutKonkan->title;
            $aboutKonkan->story = $validated['story'] ?? $aboutKonkan->story;
            $aboutKonkan->video_url = $validated['video_url'] ?? $aboutKonkan->video_url;
            $aboutKonkan->watch_story_text = $validated['watch_story_text'] ?? $aboutKonkan->watch_story_text;
            $aboutKonkan->overlap_image_alt = $validated['overlap_image_alt'] ?? $aboutKonkan->overlap_image_alt;
            $aboutKonkan->founder_name = $validated['founder_name'] ?? $aboutKonkan->founder_name;
            $aboutKonkan->founder_position = $validated['founder_position'] ?? $aboutKonkan->founder_position;
            $aboutKonkan->is_active = $request->has('is_active') ? $request->get('is_active') : $aboutKonkan->is_active;
            
            $aboutKonkan->save();

            return response()->json([
                'message' => 'About Konkan content updated successfully',
                'data' => $aboutKonkan
            ]);

        } catch (\Exception $e) {
            Log::error('AboutKonkanController update error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Failed to update about content',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(AboutKonkan $aboutKonkan)
    {
        try {
            // Delete associated images
            if ($aboutKonkan->image1_url) {
                Storage::disk('public')->delete($aboutKonkan->image1_url);
            }
            if ($aboutKonkan->image2_url) {
                Storage::disk('public')->delete($aboutKonkan->image2_url);
            }
            if ($aboutKonkan->founder_image_url) {
                Storage::disk('public')->delete($aboutKonkan->founder_image_url);
            }
            
            $aboutKonkan->delete();

            return response()->json([
                'message' => 'About Konkan content deleted successfully'
            ], 204);

        } catch (\Exception $e) {
            Log::error('AboutKonkanController destroy error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Failed to delete about content',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function listAll()
    {
        try {
            $aboutKonkans = AboutKonkan::orderBy('is_active', 'desc')
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

            return response()->json($aboutKonkans);
            
        } catch (\Exception $e) {
            Log::error('AboutKonkanController listAll error: ' . $e->getMessage());
            
            return response()->json([
                'error' => 'Failed to fetch about content list',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
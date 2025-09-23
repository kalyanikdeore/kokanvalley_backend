<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectDetailController extends Controller
{
    public function show($slug)
    {
        // Decode URL-encoded slug
        $decodedSlug = urldecode($slug);
        
        $project = Project::with([
            'highlights', 
            'whyChooseUs',
            'images', 
            'videos',
            'products.media',
            'testimonials',
            'location' // Correct relationship name
        ])->where('slug', $decodedSlug)->first();

        if (!$project) {
            return response()->json([
                'error' => 'Project not found'
            ], 404);
        }

        // Ensure proper data structure for highlights
        $highlights = [];
        if ($project->highlights) {
            foreach ($project->highlights as $highlight) {
                $highlights[] = [
                    'en' => $highlight->highlight_en ?? '',
                    'mr' => $highlight->highlight_mr ?? '',
                ];
            }
        }

        // Handle location data - check if location relationship exists and is not empty
        $locationData = [
            'lat' => null,
            'lng' => null,
            'address' => [
                'en' => '',
                'mr' => '',
            ],
            'embedUrl' => '',
            'googleMapsLink' => '',
            'zoomLevel' => 15,
            'mapType' => 'roadmap'
        ];

        // Check if location relationship exists and has data
        if ($project->location && $project->location->isNotEmpty()) {
            // Get the first location (assuming one-to-one relationship)
            $location = $project->location->first();
            
            // Generate Google Maps link
            $googleMapsLink = '';
            if ($location->lat && $location->lng) {
                $googleMapsLink = "https://www.google.com/maps?q={$location->lat},{$location->lng}&z={$location->zoom_level}&t={$location->map_type}";
            } elseif ($location->address_en) {
                $encodedAddress = urlencode($location->address_en);
                $googleMapsLink = "https://www.google.com/maps/search/?api=1&query={$encodedAddress}";
            }

            $locationData = [
                'lat' => $location->lat,
                'lng' => $location->lng,
                'address' => [
                    'en' => $location->address_en ?? '',
                    'mr' => $location->address_mr ?? '',
                ],
                'embedUrl' => $location->embed_url ?? '',
                'googleMapsLink' => $googleMapsLink,
                'zoomLevel' => $location->zoom_level ?? 15,
                'mapType' => $location->map_type ?? 'roadmap'
            ];
        }

        return response()->json([
            'id' => $project->id,
            'name' => [
                'en' => $project->name['en'] ?? '',
                'mr' => $project->name['mr'] ?? '',
            ],
            'slug' => $project->slug,
            'description' => [
                'en' => $project->description['en'] ?? '',
                'mr' => $project->description['mr'] ?? '',
            ],
            'highlights' => $highlights,
            'images' => $project->images->map(function ($image) {
                return ['url' => asset('uploads/' . $image->path)];
            }),
            'videos' => $project->videos->map(function ($video) {
                // Check if video exists in storage
                $videoExists = Storage::disk('public')->exists($video->video_path);
                $thumbnailExists = $video->thumbnail_path ? Storage::disk('public')->exists($video->thumbnail_path) : false;
                
                return [
                    'id' => $video->id,
                    'video_url' => $videoExists ? asset('uploads/' . $video->video_path) : null,
                    'thumbnail_url' => $thumbnailExists ? asset('uploads/' . $video->thumbnail_path) : null,
                    'order' => $video->order,
                    'exists' => $videoExists
                ];
            }),
            'whyChooseUs' => $project->whyChooseUs->map(function ($item) {
                return [
                    'title' => [
                        'en' => $item->title_en ?? '',
                        'mr' => $item->title_mr ?? '',
                    ],
                    'description' => [
                        'en' => $item->description_en ?? '',
                        'mr' => $item->description_mr ?? '',
                    ],
                    'icon' => $item->icon,
                ];
            }),
            'location' => $locationData, // Use the location data we prepared
            'products' => $project->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'title' => [
                        'en' => $product->title_en ?? '',
                        'mr' => $product->title_mr ?? '',
                    ],
                    'description' => [
                        'en' => $product->description_en ?? '',
                        'mr' => $product->description_mr ?? '',
                    ],
                    'date' => $product->date,
                    'media' => $product->media->map(function ($media) {
                        return [
                            'type' => $media->type,
                            'url' => asset('uploads/' . $media->media_path),
                        ];
                    }),
                ];
            }),
            'testimonials' => $project->testimonials->map(function ($testimonial) {
                return [
                    'name' => $testimonial->client_name,
                    'quote' => [
                        'en' => $testimonial->content['en'] ?? '',
                        'mr' => $testimonial->content['mr'] ?? '',
                    ],
                    'rating' => $testimonial->rating,
                ];
            }),
        ]);
    }
}
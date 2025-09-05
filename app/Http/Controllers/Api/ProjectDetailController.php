<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

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
            'testimonials'
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
                return ['url' => asset('storage/' . $image->path)];
            }),
            'videos' => $project->videos->map(function ($video) {
                return ['url' => asset('storage/' . $video->path)];
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
            'location' => [
                'lat' => $project->lat,
                'lng' => $project->lng,
                'address' => [
                    'en' => $project->address_en ?? '',
                    'mr' => $project->address_mr ?? '',
                ],
                'embedUrl' => $project->embed_url ?? '',
            ],
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
                            'url' => asset('storage/' . $media->media_path), // Changed from path to media_path
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
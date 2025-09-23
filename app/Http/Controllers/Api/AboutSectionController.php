<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutSection;
use Illuminate\Http\Request;

class AboutSectionController extends Controller
{
    public function index()
    {
        $aboutSection = AboutSection::first();
        
        if (!$aboutSection) {
            return response()->json(['message' => 'About section not found'], 404);
        }

        return response()->json([
            'title' => [
                'en' => $aboutSection->title_en,
                'mr' => $aboutSection->title_mr,
            ],
            'subtitle' => [
                'en' => $aboutSection->subtitle_en,
                'mr' => $aboutSection->subtitle_mr,
            ],
            'description' => [
                'en' => $aboutSection->description_en,
                'mr' => $aboutSection->description_mr,
            ],
            'stats' => [
                'coastline' => [
                    'value' => $aboutSection->stats[0]['value'] ?? '300+ km',
                    'label' => [
                        'en' => $aboutSection->stats[0]['label_en'] ?? 'Coastline',
                        'mr' => $aboutSection->stats[0]['label_mr'] ?? 'किनारपट्टी',
                    ],
                ],
                'beaches' => [
                    'value' => $aboutSection->stats[1]['value'] ?? '50+',
                    'label' => [
                        'en' => $aboutSection->stats[1]['label_en'] ?? 'Beaches',
                        'mr' => $aboutSection->stats[1]['label_mr'] ?? 'वाळवंट',
                    ],
                ],
                'history' => [
                    'value' => $aboutSection->stats[2]['value'] ?? '1000+',
                    'label' => [
                        'en' => $aboutSection->stats[2]['label_en'] ?? 'Years of History',
                        'mr' => $aboutSection->stats[2]['label_mr'] ?? 'इतिहासाचे वर्ष',
                    ],
                ],
                'forts' => [
                    'value' => $aboutSection->stats[3]['value'] ?? '12+',
                    'label' => [
                        'en' => $aboutSection->stats[3]['label_en'] ?? 'Ancient Fortresses',
                        'mr' => $aboutSection->stats[3]['label_mr'] ?? 'प्राचीन किल्ले',
                    ],
                ],
            ],
            'imageLabels' => [
                'beaches' => [
                    'en' => $aboutSection->image_labels[0]['en'] ?? 'Golden Beaches',
                    'mr' => $aboutSection->image_labels[0]['mr'] ?? 'सोनेरी वाळवंट',
                ],
                'hills' => [
                    'en' => $aboutSection->image_labels[1]['en'] ?? 'Lush Hills',
                    'mr' => $aboutSection->image_labels[1]['mr'] ?? 'हिरवेगार डोंगर',
                ],
                'cuisine' => [
                    'en' => $aboutSection->image_labels[2]['en'] ?? 'Local Cuisine',
                    'mr' => $aboutSection->image_labels[2]['mr'] ?? 'स्थानिक पाककृती',
                ],
                'villages' => [
                    'en' => $aboutSection->image_labels[3]['en'] ?? 'Coastal Villages',
                    'mr' => $aboutSection->image_labels[3]['mr'] ?? 'किनारी गावे',
                ],
            ],
            'images' => [
                'beach' => $aboutSection->image_beach ? asset('uploads/' . $aboutSection->image_beach) : null,
                'hills' => $aboutSection->image_hills ? asset('uploads/' . $aboutSection->image_hills) : null,
                'cuisine' => $aboutSection->image_cuisine ? asset('uploads/' . $aboutSection->image_cuisine) : null,
                'villages' => $aboutSection->image_villages ? asset('uploads/' . $aboutSection->image_villages) : null,
            ]
        ]);
    }
}
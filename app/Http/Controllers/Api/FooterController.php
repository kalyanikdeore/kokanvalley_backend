<?php
// app/Http/Controllers/Api/FooterController.php

namespace App\Http\Controllers\Api;

use App\Models\FooterSetting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    public function index()
    {
        $settings = FooterSetting::getSettings();
        
        return response()->json([
            'data' => [
                'brand_name' => $settings->brand_name ?? ['en' => '', 'mr' => ''],
                'brand_description' => $settings->brand_description ?? ['en' => '', 'mr' => ''],
                'address' => $settings->address ?? ['en' => [], 'mr' => []],
                'phone' => $settings->phone ?? '',
                'email' => $settings->email ?? '',
                'social_links' => $settings->social_links ?? [
                    'facebook' => '',
                    'instagram' => '',
                    'linkedin' => '',
                    'youtube' => ''
                ],
                
                'newsletter_text' => $settings->newsletter_text ?? ['en' => '', 'mr' => ''],
            ]
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand_name.en' => 'sometimes|string',
            'brand_name.mr' => 'sometimes|string',
            'brand_description.en' => 'sometimes|string',
            'brand_description.mr' => 'sometimes|string',
            'address.en' => 'sometimes|array',
            'address.mr' => 'sometimes|array',
            'phone' => 'sometimes|string',
            'email' => 'sometimes|email',
            'social_links.facebook' => 'sometimes|url',
            'social_links.instagram' => 'sometimes|url',
            'social_links.linkedin' => 'sometimes|url',
            'social_links.youtube' => 'sometimes|url',
        ]);

        $settings = FooterSetting::firstOrNew();
        $settings->fill($validated);
        $settings->save();

        return response()->json(['message' => 'Footer settings updated successfully', 'data' => $settings]);
    }
}
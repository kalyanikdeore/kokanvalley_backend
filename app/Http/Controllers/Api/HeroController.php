<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HeroItem;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    public function index()
    {
        $heroItems = HeroItem::active()
            ->ordered()
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'video_url' => $item->video_url,
                    'title' => $item->title,
                    'description' => $item->description,
                    'youtubeLink' => $item->youtube_link,
                    'ctaHighlight' => $item->cta_highlight,
                ];
            });

        return response()->json($heroItems);
    }
}
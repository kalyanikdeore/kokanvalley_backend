<?php

// app/Http/Controllers/Api/CoreValueController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CoreValue;
use Illuminate\Http\Request;

class CoreValueController extends Controller
{
    public function index()
    {
        $values = CoreValue::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($value) {
                return [
                    'icon' => $value->icon,
                    'title' => $value->title,
                    'description' => $value->description,
                ];
            });

        return response()->json([
            'title' => [
                'en' => 'Our Core Values',
                'mr' => 'आमची मूलभूत मूल्ये'
            ],
            'values' => $values
        ]);
    }
}
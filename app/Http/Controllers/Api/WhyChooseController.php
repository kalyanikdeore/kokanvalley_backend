<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller; // Add this import
use App\Models\WhyChoose;
use App\Models\WhyChooseSectionTitle;
use Illuminate\Http\Request;

class WhyChooseController extends Controller
{
    /**
     * Get all active Why Choose items
     */
    public function index()
    {
        $features = WhyChoose::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($item) {
                return [
                    'icon' => $item->icon,
                    'title' => $item->title,
                    'description' => $item->description,
                ];
            });

        return response()->json($features);
    }

    /**
     * Get section titles
     */
    public function getTitles()
    {
        $titles = WhyChooseSectionTitle::first();
        
        return response()->json([
            'main_title' => $titles->main_title ?? ['en' => 'Why Choose', 'mr' => 'का निवडा'],
            'highlight_text' => $titles->highlight_text ?? ['en' => 'Kokan Valley', 'mr' => 'कोकण व्हॅली'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'icon' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'title.mr' => 'required|string|max:255',
            'description.en' => 'required|string',
            'description.mr' => 'required|string',
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ]);

        $feature = WhyChoose::create($validated);

        return response()->json($feature, 201);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WhyChoose $whyChoose)
    {
        $validated = $request->validate([
            'icon' => 'sometimes|string|max:255',
            'title.en' => 'sometimes|string|max:255',
            'title.mr' => 'sometimes|string|max:255',
            'description.en' => 'sometimes|string',
            'description.mr' => 'sometimes|string',
            'sort_order' => 'sometimes|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $whyChoose->update($validated);

        return response()->json($whyChoose);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WhyChoose $whyChoose)
    {
        $whyChoose->delete();

        return response()->json(null, 204);
    }

    /**
     * Update section titles
     */
    public function updateTitles(Request $request)
    {
        $validated = $request->validate([
            'main_title.en' => 'required|string|max:255',
            'main_title.mr' => 'required|string|max:255',
            'highlight_text.en' => 'required|string|max:255',
            'highlight_text.mr' => 'required|string|max:255',
        ]);

        $titles = WhyChooseSectionTitle::firstOrNew();
        $titles->fill($validated);
        $titles->save();

        return response()->json($titles);
    }
}
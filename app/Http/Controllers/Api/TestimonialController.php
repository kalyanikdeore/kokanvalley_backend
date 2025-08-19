<?php
// app/Http/Controllers/Api/TestimonialController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::active()
            ->ordered()
            ->get()
            ->map(function ($testimonial) {
                return [
                    'id' => $testimonial->id,
                    'name' => $testimonial->name,
                    'role' => $testimonial->role,
                    'location' => $testimonial->location,
                    'content' => $testimonial->content,
                    'rating' => $testimonial->rating,
                    'projectId' => $testimonial->project_id,
                ];
            });

        return response()->json($testimonials);
    }

    public function store(Request $request)
    {
        // This would typically be handled by Filament, but adding for completeness
        $validated = $request->validate([
            'name.en' => 'required|string',
            'name.mr' => 'required|string',
            'role.en' => 'required|string',
            'role.mr' => 'required|string',
            'location.en' => 'required|string',
            'location.mr' => 'required|string',
            'content.en' => 'required|string',
            'content.mr' => 'required|string',
            'rating' => 'required|integer|between:1,5',
            'project_id' => 'required|integer',
        ]);

        $testimonial = Testimonial::create($validated);

        return response()->json($testimonial, 201);
    }

    public function show(Testimonial $testimonial)
    {
        return response()->json([
            'id' => $testimonial->id,
            'name' => $testimonial->name,
            'role' => $testimonial->role,
            'location' => $testimonial->location,
            'content' => $testimonial->content,
            'rating' => $testimonial->rating,
            'projectId' => $testimonial->project_id,
        ]);
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        // This would typically be handled by Filament, but adding for completeness
        $validated = $request->validate([
            'name.en' => 'sometimes|required|string',
            'name.mr' => 'sometimes|required|string',
            'role.en' => 'sometimes|required|string',
            'role.mr' => 'sometimes|required|string',
            'location.en' => 'sometimes|required|string',
            'location.mr' => 'sometimes|required|string',
            'content.en' => 'sometimes|required|string',
            'content.mr' => 'sometimes|required|string',
            'rating' => 'sometimes|required|integer|between:1,5',
            'project_id' => 'sometimes|required|integer',
        ]);

        $testimonial->update($validated);

        return response()->json($testimonial);
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return response()->json(null, 204);
    }
}
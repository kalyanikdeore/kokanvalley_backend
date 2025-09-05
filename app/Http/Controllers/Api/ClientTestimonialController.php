<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ClientTestimonial;
use Illuminate\Http\Request;

class ClientTestimonialController extends Controller
{
    public function index()
    {
        $testimonials = ClientTestimonial::active()
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
}
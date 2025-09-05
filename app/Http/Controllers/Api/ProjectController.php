<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('is_active', true)
            ->get()
            ->map(function ($project) {
                return [
                    'id' => $project->id,
                    'name' => $project->name ?? ['en' => '', 'mr' => ''],
                    'description' => $project->description ?? ['en' => '', 'mr' => ''],
                    'image' => $project->image ? asset('storage/' . $project->image) : null,
                    'category_id' => $project->id,
                    'slug' => $project->slug,
                ];
            });

        return response()->json($projects);
    }
}
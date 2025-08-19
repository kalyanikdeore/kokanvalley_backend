<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VisionMission;
use Illuminate\Http\Request;

class VisionMissionController extends Controller
{
    /**
     * Display the vision and mission content.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $content = VisionMission::getContent();
            
            return response()->json([
                'success' => true,
                'data' => $content
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch vision and mission content',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Not needed for this use case (using Filament for CRUD)
        return response()->json(['message' => 'Method not allowed'], 405);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Not needed for this use case
        return response()->json(['message' => 'Method not allowed'], 405);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Not needed for this use case (using Filament for CRUD)
        return response()->json(['message' => 'Method not allowed'], 405);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Not needed for this use case
        return response()->json(['message' => 'Method not allowed'], 405);
    }
}
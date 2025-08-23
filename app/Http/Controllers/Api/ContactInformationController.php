<?php

namespace App\Http\Controllers\Api;
use App\Models\ContactInformation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class ContactInformationController extends Controller
{
    /**
     * Display the contact information.
     */
    public function index()
    {
        try {
            $contactInfo = ContactInformation::first();
            
            if (!$contactInfo) {
                return response()->json([
                    'error' => 'Contact information not found'
                ], 404);
            }
            
            return response()->json($contactInfo);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch contact information',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // This could be used if you want to allow API creation
        // For now, we'll keep it simple and only allow reading
        return response()->json(['error' => 'Method not allowed'], 405);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // If you want to show a specific contact info by ID
        try {
            $contactInfo = ContactInformation::find($id);
            
            if (!$contactInfo) {
                return response()->json([
                    'error' => 'Contact information not found'
                ], 404);
            }
            
            return response()->json($contactInfo);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to fetch contact information',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // This would be protected by authentication in a real scenario
        return response()->json(['error' => 'Method not allowed'], 405);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // This would be protected by authentication in a real scenario
        return response()->json(['error' => 'Method not allowed'], 405);
    }
}
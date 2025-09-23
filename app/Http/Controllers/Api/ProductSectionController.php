<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ProductSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductSectionController extends Controller
{
public function index(Request $request)
{
    // Get language from request or default to English
    $language = $request->get('lang', 'en');
    
    // Get all products
    $products = ProductSection::all();
    
    // Transform products to include language-specific text
    $transformedProducts = $products->map(function ($product) use ($language) {
        return [
            'name' => $product->name[$language] ?? $product->name['en'],
            'image' => $product->image ? asset('uploads/' . $product->image) : null,
            'category' => $product->category[$language] ?? $product->category['en'],
            'description' => $product->description[$language] ?? $product->description['en'],
            'slug' => $product->slug
        ];
    });
    
    // Extract unique categories
    $categories = $transformedProducts->pluck('category')->unique()->values()->all();
    
    return response()->json([
        'products' => $transformedProducts,
        'categories' => $categories
    ]);
}

    public function show($slug, Request $request)
    {
        // Get language from request or default to English
        $language = $request->get('lang', 'en');
        
        $product = ProductSection::where('slug', $slug)->firstOrFail();
        
        $transformedProduct = [
            'name' => $product->name[$language] ?? $product->name['en'],
            'image' => $product->image ? asset('uploads/' . $product->image) : null,
            'category' => $product->category[$language] ?? $product->category['en'],
            'description' => $product->description[$language] ?? $product->description['en'],
            'slug' => $product->slug
        ];
        
        return response()->json($transformedProduct);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name.en' => 'required|string',
            'name.mr' => 'required|string',
            'description.en' => 'nullable|string',
            'description.mr' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category.en' => 'required|string',
            'category.mr' => 'required|string',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            // Store image in public/uploads directory
            $imagePath = $image->move(public_path('uploads'), $imageName);
            $validated['image'] = $imageName;
        }

        $product = ProductSection::create($validated);

        return response()->json($product, 201);
    }

    public function update(Request $request, $id)
    {
        $product = ProductSection::findOrFail($id);
        
        $validated = $request->validate([
            'name.en' => 'sometimes|string',
            'name.mr' => 'sometimes|string',
            'description.en' => 'nullable|string',
            'description.mr' => 'nullable|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category.en' => 'sometimes|string',
            'category.mr' => 'sometimes|string',
        ]);

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image && file_exists(public_path('uploads/' . $product->image))) {
                unlink(public_path('uploads/' . $product->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            
            // Store new image in public/uploads directory
            $imagePath = $image->move(public_path('uploads'), $imageName);
            $validated['image'] = $imageName;
        }

        $product->update($validated);

        return response()->json($product);
    }

    public function destroy($id)
    {
        $product = ProductSection::findOrFail($id);
        
        // Delete associated image
        if ($product->image && file_exists(public_path('uploads/' . $product->image))) {
            unlink(public_path('uploads/' . $product->image));
        }
        
        $product->delete();

        return response()->json(null, 204);
    }
}
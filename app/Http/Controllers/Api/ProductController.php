<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::where('is_active', true)->get();
        
        return response()->json([
            'products' => $products,
            'categories' => [
                [
                    'en' => 'All',
                    'mr' => 'सर्व'
                ],
                [
                    'en' => 'Organic Alphonso Mangoes',
                    'mr' => 'ऑर्गेनिक अल्फांसो मनुके'
                ],
                [
                    'en' => 'Authentic Konkan Cashews',
                    'mr' => 'खरे कोंकणी काजू'
                ],
                [
                    'en' => 'Jamun & Avocado',
                    'mr' => 'जांभूळ आणि एव्होकॅडो'
                ],
                [
                    'en' => 'Natural Fruit-processed Products- Mango ,Pulp',
                    'mr' => 'नैसर्गिक फळ-प्रक्रिया उत्पादने - आंबा पल्प'
                ],
                [
                    'en' => 'Spices, Pickles, Sweet Preserves',
                    'mr' => 'मसाले, लोणचे, गोड पदार्थ'
                ]
            ]
        ]);
    }
}
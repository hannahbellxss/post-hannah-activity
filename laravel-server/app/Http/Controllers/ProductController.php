<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // INDEX PUU
    public function index()
    {
        $products = Product::all()->map(function ($product) {
            return [
                'id' => (int) $product->id,
                'name' => $this->formatProductName($product->name),
                'slug' => $product->slug,
                'category' => $product->category,
                'price' => number_format((float) $product->price, 2, '.', ''),
                'quantity' => (int) $product->quantity,
                'status' => $product->status,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Products retrieved successfully.',
            'data' => $products,
        ], 200);
    }

    // SHOW GAMIT SLUG
    public function show(string $slug)
    {
        $product = Product::where('slug', $slug)->first();

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Product retrieved successfully.',
            'data' => [
                'id' => $product->id,
                'name' => $this->formatProductName($product->name),
                'slug' => $product->slug,
                'category' => $product->category,
                'price' => $product->price,
                'quantity' => $product->quantity,
                'status' => $product->status,
            ]
        ], 200);
    }

    private function formatProductName($name)
    {
        return ucwords(
            strtolower(
                trim($name)
            )
        );
    }

    
}
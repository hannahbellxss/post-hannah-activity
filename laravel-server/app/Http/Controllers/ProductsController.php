<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\V1\ProductResource;
use App\Traits\ApiResponses;

class ProductsController extends Controller
{
    use ApiResponses;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->paginate(10);

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $products1)
    {
        $products1->load('category');

        return new ProductResource($products1);
    }

    /**
     * Queries and calculations.
     */
    public function queries()
    {
        // 1. Select only name and price
        $products = Product::select('name', 'price')->get();

        // 2. Load category
        $withCategory = Product::with('category')->get();

        // 3. Select id, name and order by price ascending
        $ordered = Product::select('id', 'name')
            ->orderBy('price', 'asc')
            ->get();

        // 4. Get first 5 products
        $limited = Product::limit(5)->get();

        // 5. Products with price >= 3
        $priceFilter = Product::where('price', '>=', 3)->get();

        // 6. Products under Electronics category
        $electronics = Product::whereHas('category', function ($query) {
            $query->where('name', 'Electronics');
        })->get();

        // 7. Price calculations
        $sum = Product::sum('price');
        $average = Product::avg('price');
        $max = Product::max('price');
        $min = Product::min('price');

        // 8. Statistics per category
        $categoryStats = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name',
                DB::raw('COUNT(products.id) as total_products'),
                DB::raw('AVG(products.price) as average_price'),
                DB::raw('MIN(products.price) as minimum_price')
            )
            ->groupBy('categories.id', 'categories.name')
            ->get();

        // 9. Average price per category
        $averagePerCategory = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name',
                DB::raw('AVG(products.price) as average_price')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('average_price', 'asc')
            ->get();

        // 10. Average price for Electronics and Books
        $selectedCategoryAverage = DB::table('products')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select(
                'categories.name',
                DB::raw('AVG(products.price) as average_price')
            )
            ->whereIn('categories.name', ['Electronics', 'Books'])
            ->groupBy('categories.id', 'categories.name')
            ->get();

        return $this->ok('Queries retrieved successfully', [
            'select' => $products,
            'with_category' => $withCategory,
            'ordered' => $ordered,
            'limited' => $limited,
            'price_filter' => $priceFilter,
            'electronics' => $electronics,
            'sum' => $sum,
            'average' => $average,
            'max' => $max,
            'min' => $min,
            'category_stats' => $categoryStats,
            'average_per_category' => $averagePerCategory,
            'selected_category_average' => $selectedCategoryAverage,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $products1)
    {
        $products1->update($request->all());

        return response()->json($products1);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $products1)
    {
        $products1->delete();

        return response()->json(null, 204);
    }
}
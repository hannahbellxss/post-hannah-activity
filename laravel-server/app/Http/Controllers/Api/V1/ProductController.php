<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\V1\ProductResource;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    use ApiResponses;

    public function index(Request $request)
    {
        $products = Product::with('category')->paginate(10);
        return $this->ok('Products retrieved successfully', ProductResource::collection($products));
    }

    public function show(Product $product)
    {
        $product->load('category');
        return $this->ok('Product retrieved successfully', new ProductResource($product));
    }

    public function queries()
    {
        // A. querying
        $nameAndPrice = Product::select('name', 'price')->get();
        $productsWithCategory = Product::with('category')->get();
        $productsOrderedByPrice = Product::select('id','name')->orderBy('price','asc')->get();
        $firstFiveProducts = Product::limit(5)->get();

        // B. filtering
        $priceGreaterThanOrEqual = Product::where('price','>=',3)->get();
        $electronics = Product::whereHas('category', function($q){ $q->where('name','Electronics'); })->get();

        // C. aggregating
        $totalPrice = Product::sum('price');
        $averagePrice = Product::avg('price');
        $highestPrice = Product::max('price');
        $lowestPrice = Product::min('price');

        // D. grouping examples
        $totalPricePerCategory = Product::join('categories','products.category_id','=','categories.id')
            ->select('categories.name', DB::raw('SUM(products.price) as total_price'))
            ->groupBy('categories.name')
            ->get();

        $queryResults = [
            'name_and_price' => $nameAndPrice,
            'products_with_category' => $productsWithCategory,
            'products_ordered_by_price' => $productsOrderedByPrice,
            'first_five' => $firstFiveProducts,
            'price_gte_3' => $priceGreaterThanOrEqual,
            'electronics' => $electronics,
            'total_price' => $totalPrice,
            'average_price' => $averagePrice,
            'total_price_per_category' => $totalPricePerCategory,
        ];

        return $this->success('Query results retrieved successfully', $queryResults);
    }
}
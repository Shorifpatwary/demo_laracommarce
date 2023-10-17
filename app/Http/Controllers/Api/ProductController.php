<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Cache::remember('products', now()->addMinute(), function () {
            return Product::all();
        });

        return ProductResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->load('category', 'category.products', 'category.products.brand', 'user', 'review', 'review.customer', 'brand');
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * search the specified resource from storage.
     */
    public function search(Request $request)
    {
        $text = $request->input('text');
        $category = $request->input('category');
        $brand = $request->input('brand');
        // Get the filters parameter from the request
        $filters = $request->input('product_status');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $ratings = $request->input('ratings');

        $orderBy = $request->input('order_by', 'created_at');
        $orderDirection = $request->input('order_direction', 'asc');

        // Perform the search based on text and category.
        $results = $this->performSearch($text, $category, $brand, $minPrice, $maxPrice, $ratings,  $filters, $orderBy, $orderDirection)->with('category', 'brand', 'review')->paginate(12);

        return ProductResource::collection($results);
    }
    private function performSearch($text, $category, $brand, $minPrice, $maxPrice, $ratings, $filters,  $orderBy = 'created_at', $orderDirection = 'asc')
    {
        $query = Product::query();

        // Apply text search if provided.
        if ($text) {
            $query->where('name', 'like', '%' . $text . '%');
        }

        // Apply category filter if provided.
        if (!empty($category)) {
            $categoryIds = explode(',', $category);
            $query->whereIn('category_id', $categoryIds);
        }
        if (!empty($brand)) {
            $brandIds = explode(',', $brand);
            $query->whereIn('brand_id', $brandIds);
        }

        // Apply price range filter if provided.
        if ($minPrice !== null && $maxPrice !== null) {
            $query->whereBetween('selling_price', [$minPrice, $maxPrice]);
        }

        if (!empty($filters)) {
            // Apply product status filters
            $filterValues = explode(',', $filters);
            foreach ($filterValues as $filter) {
                // Apply the filter to the query
                $query->where($filter, true); // Modify this as per your database schema
            }
        }
        // Apply filtering based on selected ratings
        if (!empty($ratings)) {
            // $ratingsArray = explode(',', $ratings);
            $query->whereHas('review', function ($subquery) use ($ratings) {
                $subquery->whereIn('rating', explode(',', $ratings));
            });
        }

        // Apply ordering based on the provided parameters.
        $query->orderBy($orderBy, $orderDirection);

        // Apply pagination.
        return $query;
    }

    // Home page 
    public function todayDeal()
    {
        $results = Product::where('today_deal', 1)->with('brand')->paginate(10);

        return ProductResource::collection($results);
    }
    public function newArrival()
    {
        $results = Product::orderBy('created_at', 'asc')->with('brand')->paginate(10);

        return ProductResource::collection($results);
    }
    public function bestDiscount()
    {
        $results = Product::orderBy('discount_price', 'asc')->with('brand')->paginate(10);

        return ProductResource::collection($results);
    }
    public function trendingItem()
    {
        $results = Product::where('trendy', 1)->with('brand')->paginate(10);

        return ProductResource::collection($results);
    }
}
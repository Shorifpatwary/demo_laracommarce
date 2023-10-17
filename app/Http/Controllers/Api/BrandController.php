<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $categories = Cache::remember('categories_with_descendant', now()->addMinutes(1), function () {
        //     return Brand::with('descendants')->get();
        // });
        // return $categories;
        // return BrandResource::collection($categories);

        $categories = Cache::remember('brands', now()->addHours(2), function () {
            return Brand::all();
        });

        return BrandResource::collection($categories);
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
    public function show(Brand $brand)
    {
        $brand->load('product', 'product.category');
        return new BrandResource($brand);
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
}

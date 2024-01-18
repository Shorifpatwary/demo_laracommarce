<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerAddressResource;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class CustomerAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $customer = Auth::guard('api')->user();
        // Get the current page from the request or default to 1
        $page = $request->input('page', 1);

        // Define a unique cache key for each page
        $cacheKey = "customer_addresses_{$customer->id}_page_{$page}";
        $addresses = Cache::remember($cacheKey, now()->addMinutes(1), function () use ($customer) {
            return $customer->addresses()->paginate(5);
        });

        return CustomerAddressResource::collection($addresses);
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
    public function show(string $id)
    {
        //
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
    public function destroy(Request $request, CustomerAddress $customerAddress)
    {
        $customerAddress->delete();
        // return response()->json(['message' => 'Address deleted successfully']);
        // $this->deleteCache();
        // $customer = Auth::guard('api')->user();
        // Cache::forget("customer_addresses_{$customer->id}_page_*");
        return  $this->index($request);
    }

    // public function deleteCache($customer =  Auth::guard('api')->user())
    // {
    //     // $customer = Auth::guard('api')->user();
    //     // Clear all pages' cache associated with the user
    //     Cache::forget("customer_addresses_{$customer->id}_page_*");
    // }
}
// update the cache 
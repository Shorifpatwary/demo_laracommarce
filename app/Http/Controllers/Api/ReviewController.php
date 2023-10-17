<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $reviews = Cache::remember('reviews', now()->addSeconds(30), function () {
            return Review::latest()->with('customer')->get();
        });

        return ReviewResource::collection($reviews);
    }
    public function store(Request $request)
    {
        $user = Auth::guard('api')->user();
        $validatedData = $request->validate([
            'body' => 'string|required|between:5,5000',
            'rating' => 'numeric|required|between:1,5',
            'approved' => "boolean",
            'featured' => "boolean",
            'product_id' => [
                'required',
                function ($attribute, $value, $fail) use ($user) {
                    // Check if a review by the same user for the same product already exists
                    $existingReview = Review::where('customer_id', $user->id)
                        ->where('product_id', $value)
                        ->first();

                    if ($existingReview) {
                        $fail("You have already reviewed this product.");
                    }
                },
            ],
        ]);

        // User Id
        $validatedData['customer_id'] = $user->id;
        // Attempt to create a new record in the database
        try {
            $data = Review::create($validatedData);

            return response()->json(['message' => 'Review subscription created', 'data' => $data], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 400);
        }
    }
}
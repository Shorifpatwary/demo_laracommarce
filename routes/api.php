<?php

use App\Http\Controllers\Api\CustomerAddressController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Admin\NewsLetterController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\CustomerController;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('web',)->get('/csrf-endpoint', function () {
    return response()->json(['csrf_token' => csrf_token()]);
});
Route::middleware('api.authentication',)->post('/check-token', function () {
    return response()->json(['message' => 'Token is valid'], 200);
});

Route::middleware('auth:sanctum',)->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['guest']], function () {

    Route::post('/register', [CustomerController::class, 'register'])->name('register.api');

    Route::post('/login', [CustomerController::class, 'Login'])->name('login.api');
    // category
    Route::apiResource('category', CategoryController::class);

    // brand
    Route::apiResource('brand', BrandController::class);

    // product
    Route::apiResource('product', ProductController::class);

    // order
    Route::apiResource('order', OrderController::class);

    // customer address
    Route::apiResource('customer-address', CustomerAddressController::class);

    // product search
    Route::get('/search', [ProductController::class, 'search']);
    // home page 
    Route::get('/today_deal', [ProductController::class, 'todayDeal']);
    Route::get('/new_arrival', [ProductController::class, 'newArrival']);
    Route::get('/best_discount', [ProductController::class, 'bestDiscount']);
    Route::get('/trending', [ProductController::class, 'trendingItem']);
    // news letter 
    Route::post('/create_news_letter', [NewsLetterController::class, 'create']);
    // all reviews
    Route::get('/review', [ReviewController::class, 'index'])->name('review.index');
    // Route::apiResource('review', ReviewController::class);
});

// Protected routes api 
Route::group(['middleware' => ['api.authentication']], function () {

    Route::post('/logout', [CustomerController::class, 'logout'])->name('logout.api');

    // profile
    Route::get('/customer/profile', [CustomerController::class, 'show']);
    // profile edit data 
    Route::get('/customer/edit', [CustomerController::class, 'edit']);
    // profile update 
    Route::put('/customer/update', [CustomerController::class, 'update']);
    // review create 
    Route::post('/review', [ReviewController::class, 'store'])->name('review.store');
});

Route::middleware('auth:api')->get('/test', function () {
    return 'Authentication worked!';
});

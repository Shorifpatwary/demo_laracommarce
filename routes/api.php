<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\CustomerController;
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
    Route::apiResource('categories', CategoryController::class);
});

// Protected routes api 
Route::group(['middleware' => ['api.authentication']], function () {


    Route::post('/logout', [CustomerController::class, 'logout'])->name('logout.api');

    Route::post('/logout', [CustomerController::class, 'logout'])->name('logout.api');
    // profile
    Route::get('/customer/profile', [CustomerController::class, 'show']);
    // profile edit data 
    Route::get('/customer/edit', [CustomerController::class, 'edit']);
    // profile update 
    Route::put('/customer/update', [CustomerController::class, 'update']);
});

Route::middleware('auth:api')->get('/test', function () {
    return 'Authentication worked!';
});

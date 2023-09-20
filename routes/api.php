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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => ['guest']], function () {

    Route::post('/register', [CustomerController::class, 'register'])->name('register.api');

    Route::post('/login', [CustomerController::class, 'Login'])->name('login.api');
    // category
    Route::apiResource('category', CategoryController::class);
});

// Protected routes api 
Route::group(['middleware' => ['auth:api']], function () {

    Route::post('/logout', [CustomerController::class, 'logout'])->name('logout.api');
});

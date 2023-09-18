<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\PickupPointController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
	return view('welcome');
});

Route::get('/dashboard', function () {
	return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth.basic')->group(function () {
	Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
	Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// admin 
Route::middleware(['web', 'auth'])->group(function () {
	// category routes 
	Route::resource('category', CategoryController::class);

	Route::resource('sub-category', SubcategoryController::class);
	// brand routes
	Route::resource('brand', BrandController::class);
	// brand routes
	Route::resource('attribute', AttributeController::class);
	// page routes
	Route::resource('warehouse', WarehouseController::class);

	// page routes
	Route::resource('page', PageController::class);

	// coupons routess
	Route::resource('coupon', CouponController::class);

	// pickup point routes
	Route::resource('pickup-point', PickupPointController::class);

	// product routes
	Route::resource('product', ProductController::class);
});

// settings 
Route::middleware(['web', 'auth'])->group(function () {
	// website settings 
	Route::group(['prefix' => 'setting'], function () {
		//seo setting
		Route::group(['prefix' => 'seo'], function () {
			Route::get('/', [SettingController::class, 'seo'])->name('seo.setting');
			Route::post('/update/{id}', [SettingController::class, 'seoUpdate'])->name('seo.setting.update');
		});
		//smtp setting
		Route::group(['prefix' => 'smtp'], function () {
			Route::get('/',  [SettingController::class, 'smtp'])->name('smtp.setting');
			Route::post('/update', [SettingController::class, 'smtpUpdate'])->name('smtp.setting.update');
		});
		// website setting 
		Route::get('/', [SettingController::class, 'website'])->name('website.setting');

		Route::post('/update/{id}', [SettingController::class, 'WebsiteUpdate'])->name('website.setting.update');
	});
});


// other routes
//global route
Route::get('/get-child-category/{id}', [CategoryController::class, 'getChildCategory'])->middleware('api');
require __DIR__ . '/auth.php';

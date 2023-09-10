<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\PickupPoint;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Image;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('shop.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // category 
        $category = category::where('parent_id', null)->get();;
        // brand 
        $brand = Brand::all();
        // pickup point
        $pickup_point = PickupPoint::all();
        // warehouse
        $warehouse = Warehouse::all();

        return view('shop.product.create', compact('category', 'brand', 'pickup_point', 'warehouse'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|between:5,100|unique:warehouses',
            'code' => 'required|string|between:2,200',
            'subcategory_id' => 'required|string|exists:categories,id',
            'childcategory_id' => 'required|string|exists:categories,id',
            'brand_id' => 'required|string|exists:brands,id',
            'pickup_point_id' => 'string|exists:pickup_points,id',
            'unit' => 'required|string|between:2,200',
            'tags' => 'string|between:2,200',
            'purchase_price' => 'string|between:2,200',
            'selling_price' => 'required|string|between:2,200',
            'discount_price' => 'string|between:2,200',
            'warehouse_id' => 'required|string|exists:warehouses,id',
            'stock_quantity' => 'string|between:2,200',
            'color' => 'string|between:2,200',
            'size' => 'string|between:2,200',
            'description' => 'required|string|min:50',
            'video' => 'url|between:5,200',
            'featured' => 'boolean',
            'today_deal' => 'boolean',
            'product_slider' => 'boolean',
            'status' => 'boolean',
            'trendy' => 'boolean',
            'thumbnail' => 'required|file',
        ]);
        // Create a slug from the name field
        $validatedData['slug'] = Str::slug($validatedData['name'], '-');
        // category ID
        if ($validatedData['childcategory_id']) {
            $validatedData['category_id'] = $validatedData['childcategory_id'];
        } else {
            $validatedData['category_id'] = $validatedData['subcategory_id'];
        }
        // User Id
        $validatedData['user_id'] = Auth::id();

        // dd($validatedData);

        if ($request->thumbnail) {
            $thumbnail = $request->thumbnail;
            $photoname = $validatedData['slug'] . hexdec(uniqid()) . '.' . $thumbnail->getClientOriginalExtension();
            Image::make($thumbnail)->resize(600, 600)->save('files/product/' . $photoname);
            $validatedData['thumbnail'] = $photoname;   // files/product/plus-point.jpg
        }
        //multiple images
        $images = array();
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $key => $image) {
                $imageName = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                Image::make($image)->resize(600, 600)->save('files/product/' . $imageName);
                array_push($images, $imageName);
            }
            $validatedData['images'] = json_encode($images);
        }
        // insert data 
        Product::create($validatedData);
        $notification = ['notification' => 'Product Created!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}

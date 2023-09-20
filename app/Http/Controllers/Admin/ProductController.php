<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\PickupPoint;
use App\Models\Product;
use App\Models\Warehouse;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Image;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $data = Product::all();
        $data = Product::with('user', 'category')->get();

        if ($request->ajax()) {
            // $imgurl = asset('') . 'public/files/product';
            return DataTables::of($data)
                ->addIndexColumn()
                // ->editColumn('thumbnail', function ($row) use ($imgurl) {
                //     return '<img src="' . $imgurl . '/' . $row->thumbnail . '"  height="30" width="30" >';
                // })
                ->addColumn('action', function ($row) {
                    $actionbtn = '<div class="d-inline-flex gap-1">
                    <a href="' . route('product.edit', [$row->id]) . '" class="btn btn-info btn-sm edit"><i class="fas fa-edit"></i></a>
                    <form id="delete" action="' . route('product.destroy', [$row->id]) . '" method="post">'
                        . csrf_field()  .
                        method_field('DELETE') .
                        '<button type="submit" href="' . route('product.destroy', [$row->id]) . '" class="btn btn-danger btn-sm" id="delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    </div>';
                    return $actionbtn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('shop.product.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // category 
        $category = category::where('parent_id', null)->get();
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
            'color' => 'string|between:2,200',
            'size' => 'string|between:2,200',
            'purchase_price' => 'string|between:2,200',
            'selling_price' => 'required|string|between:2,200',
            'discount_price' => 'string|between:2,200',
            'warehouse_id' => 'required|string|exists:warehouses,id',
            'stock_quantity' => 'string|between:2,200',
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
        return redirect()->route('product.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('shop.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        // Load necessary data for dropdowns
        $category = Category::where('parent_id', null)->get();
        $brand = Brand::all();
        $pickup_point = PickupPoint::all();
        $warehouse = Warehouse::all();

        // Pass the retrieved product and other data to the edit view
        return view('shop.product.edit', compact('product', 'category', 'brand', 'pickup_point', 'warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // dd($request);
        $validatedData = $request->validate([
            'name' => 'required|string|between:5,100',
            'code' => 'required|string|between:2,200',
            'subcategory_id' => 'required|string|string|exists:categories,id',
            'childcategory_id' => 'required|string|string|exists:categories,id',
            'brand_id' => 'required|string|exists:brands,id',
            'pickup_point_id' => 'string|exists:pickup_points,id',
            'unit' => 'required|string|between:2,200',
            'tags' => 'string|between:2,200',
            'color' => 'string|between:2,200',
            'size' => 'string|between:2,200',
            'purchase_price' => 'string|between:2,200',
            'selling_price' => 'required|string|between:2,200',
            'discount_price' => 'string|between:2,200',
            'warehouse_id' => 'required|string|exists:warehouses,id',
            'stock_quantity' => 'string|between:2,200',
            'description' => 'required|string|min:50',
            'video' => 'url|between:5,200',
            'featured' => 'boolean',
            'today_deal' => 'boolean',
            'product_slider' => 'boolean',
            'status' => 'boolean',
            'trendy' => 'boolean',
            'thumbnail' => 'file',
        ]);

        $existingImages = $request->input('existing_images', []);
        // Handle thumbnail update
        if ($request->hasFile('thumbnail')) {
            // Delete the old thumbnail

            if (File::exists('files/product/' . $product->thumbnail)) {
                File::delete('files/product/' . $product->thumbnail);
            }
            // Upload and save the new thumbnail
            $thumbnail = $request->file('thumbnail');
            $photoname = Str::slug($product->name, '-') . '-' . hexdec(uniqid()) . '.' . $thumbnail->getClientOriginalExtension();
            Image::make($thumbnail)->resize(600, 600)->save('files/product/' . $photoname);
            $validatedData['thumbnail'] = $photoname;
        }

        // Handle product images update
        $uploadedImages = [];
        if ($request->hasFile('new_images')) {
            $newImages = $request->file('new_images');

            foreach ($newImages as $image) {
                $imageName = Str::slug($product->name, '-') . '-' . hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
                Image::make($image)->resize(600, 600)->save('files/product/' . $imageName);
                $uploadedImages[] = $imageName;
            }
        }

        // Handle deletion of existing images
        if ($request->has('delete_images')) {
            $imagesToDelete = $request->delete_images;

            foreach ($imagesToDelete as $imageName) {
                $imagePath = 'files/product/' . $imageName;
                // File::delete($imagePath);

                // Ensure the image exists and delete it
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
        }

        // Merge the existing and new image names
        $allImages = array_merge($existingImages, $uploadedImages);


        // Convert the merged array to a JSON string
        $validatedData['images'] = json_encode(array_values($allImages));
        // Update the product data with the new validated data

        $product->update($validatedData);
        $notification = ['notification' => 'Product Updated!', 'alert-type' => 'success'];
        return redirect()->route('product.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

        // $product->delete();
        $notification = ['notification' => 'Product Deleted!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }
}

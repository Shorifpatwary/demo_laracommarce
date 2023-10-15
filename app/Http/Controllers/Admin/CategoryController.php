<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        // to avoid using subCategoryController .... 
        $data = Category::all();
        return view('category.category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parent_category = category::where('parent_id', null)->get();
        return view('category.category.create', compact('parent_category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)

    {

        $validatedData = $request->validate([
            'name' => 'required|unique:categories|max:55',
            'description' => 'min:55',
            'parent_id' => 'exists:categories,id|max:55',
            'icon' => 'required|max:100',
            'image' => 'required|image|max:300',
        ]);

        $validatedData['slug'] = Str::slug($validatedData['name'], '-');
        if ($request->image) {
            $image = $request->image;
            $photoname = $validatedData['slug'] . hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 200)->save('files/category-image/' . $photoname);
            $validatedData['image'] = $photoname;   // files/category-image/plus-point.jpg
        }
        //Eloquent ORM
        Category::create($validatedData);

        $notification = array('notification' => 'Category Inserted!', 'alert-type' => 'success');
        return redirect()->route('category.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $parent_category = Category::where('parent_id', null)->get();
        return view('category.category.edit', compact('category', 'parent_category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        // dd($request->all());
        $validatedData = $request->validate([
            'name' => 'max:55',
            'description' => 'min:55',
            'parent_id' => 'exists:categories,id|max:55|different:' . $category->id,
            'icon' => 'max:100',
            'image' => 'image|max:300',
        ]);
        $validatedData['slug'] = Str::slug($validatedData['name'], '-');
        if ($request->hasFile('image')) {
            // Delete the old image

            if (File::exists('files/category-image/' . $category->image)) {
                File::delete('files/category-image/' . $category->image);
            }
            // Upload and save the new image
            $image = $request->file('image');
            $photoname = $validatedData['slug'] . hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(300, 200)->save('files/category-image/' . $photoname);
            $validatedData['image'] = $photoname;
        } else {
            $validatedData['image'] = $category->image;
        }
        // update category
        // dd($validatedData);
        $category->update($validatedData);

        $notification = ['notification' => 'Category Updated!', 'alert-type' => 'success'];
        return redirect()->route('category.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // return view('category.category.create');

        $category->delete();

        $notification = ['notification' => 'Category Deleted!', 'alert-type' => 'success'];
        return redirect()->route('category.index')->with($notification);
    }

    // get child category 
    public function getChildCategory(string $id)
    {
        // return view('category.category.create');

        $data =  category::where('parent_id', $id)->get();

        return response()->json($data);
    }
}

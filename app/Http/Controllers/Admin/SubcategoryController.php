<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Subcategory::all();
        return view('category.sub-category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = Category::all();
        return view('category.sub-category.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|unique:subcategories|max:55',
            'category_id' => 'required|exists:categories,id',
            // 'icon' => 'required',
        ]);
        $slug = Str::slug($request->name, '-');

        Subcategory::insert([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            // 'home_page' => $request->home_page,
            // 'icon' => 'public/files/category/' . $photoname,
        ]);

        $notification = ['notification' => 'Sub Category Inserted!', 'alert-type' => 'success'];
        return redirect()->route('sub-category.index')->with($notification);
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
    public function edit(string $id)
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
    public function destroy(string $id)
    {
        Subcategory::where('id', $id)->delete();

        $notification = ['notification' => 'Category Deleted!', 'alert-type' => 'success'];
        return redirect()->route('sub-category.index')->with($notification);
    }
}

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
        if ($request->is('specific/form/route')) {
            // The request is coming from a specific form route
            // Your logic here
        } else {
            // The request is not coming from the specific form route
            // Your alternative logic here
        }
        $data = Category::where('parent_id', null)->get();
        return view('category.category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('category.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:categories|max:55',
            // 'icon' => 'required',
        ]);

        $slug = Str::slug($request->name, '-');
        // $photo = $request->icon;
        // $photoname = $slug . '.' . $photo->getClientOriginalExtension();
        // Image::make($photo)->resize(32, 32)->save('public/files/category/' . $photoname); //image intervention
        //Eloquent ORM
        Category::insert([
            'name' => $request->name,
            'slug' => $slug,
            // 'home_page' => $request->home_page,
            // 'icon' => 'public/files/category/' . $photoname,
        ]);

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
    public function edit(string $id)
    {
        $data = Category::findorfail($id);
        // return view('category.category.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $slug = Str::slug($request->name, '-');
        // $data = array();
        // $data['name'] = $request->name;
        // $data['slug'] = $slug;
        // $data['home_page'] = $request->home_page;
        // if ($request->icon) {
        //     if (File::exists($request->old_icon)) {
        //         unlink($request->old_icon);
        //     }
        //     $photo = $request->icon;
        //     $photoname = $slug . '.' . $photo->getClientOriginalExtension();
        //     Image::make($photo)->resize(32, 32)->save('public/files/category/' . $photoname);
        //     $data['icon'] = 'public/files/category/' . $photoname;
        //     DB::table('categories')->where('id', $request->id)->update($data);
        //     $notification = array('messege' => 'Category Update!', 'alert-type' => 'success');
        //     return redirect()->back()->with($notification);
        // } else {
        //     $data['icon'] = $request->old_icon;
        //     DB::table('categories')->where('id', $request->id)->update($data);
        //     $notification = ['messege' => 'Category Update!', 'alert-type' => 'success'];
        //     return redirect()->back()->with($notification);
        // }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // return view('category.category.create');

        category::where('id', $id)->delete();

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

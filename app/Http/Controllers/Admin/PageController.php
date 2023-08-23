<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $page = Page::latest()->get();
        return view('setting.page.index', compact('page'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('setting.page.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'position' => 'nullable|string',
            'name' => 'required|string|unique:pages,column,except,id|between:5,255',
            'title' => 'nullable|string|between:5,255',
            'description' => 'nullable|string|min:50',
        ]);
        // Create a slug from the name field
        $validatedData['slug'] = Str::slug($validatedData['name']);

        // Insert data into the database using the Page model's create method
        Page::create($validatedData);
        $notification = ['notification' => 'Page Created!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        $data = $page;
        return view('setting.page.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $validatedData = $request->validate([
            'position' => 'nullable|string',
            'name' => "required|string|between:5,255",
            'title' => 'nullable|string|between:5,255',
            'description' => 'nullable|string|min:50',
        ]);

        // Create a slug from the name field
        $validatedData['slug'] = Str::slug($validatedData['name'], '-');

        // Update data in the database using the Page model
        $page->update($validatedData);

        $notification = ['notification' => 'Page Updated!', 'alert-type' => 'success'];
        return redirect()->route('page.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();
        $notification = ['notification' => 'Page Deleted!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }
}

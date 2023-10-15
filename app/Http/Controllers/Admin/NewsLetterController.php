<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NewsLetterController extends Controller
{
    public function index(Request $request)
    {
        $data = NewsLetter::latest()->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->toJson();
        }
        // // return view 
        return view('shop.news_letter.index');
    }

    public function create(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'email|required|unique:news_letters'
        ]);

        // Attempt to create a new record in the database
        try {
            $newsletter = NewsLetter::create($validatedData);

            return response()->json(['message' => 'Newsletter subscription created', 'data' => $newsletter], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create newsletter subscription'], 400);
        }
    }
}

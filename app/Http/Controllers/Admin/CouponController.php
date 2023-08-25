<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use DataTables;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Coupon::latest()->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionbtn = '<div class="d-inline-flex gap-1">
                    <a href="' . route('coupon.edit', [$row->id]) . '" class="btn btn-info btn-sm edit"><i class="fas fa-edit"></i></a>
                    <form action="' . route('coupon.destroy', [$row->id]) . '" method="post">'
                        . csrf_field()  .
                        method_field('DELETE') .
                        '<button type="submit" href="' . route('coupon.destroy', [$row->id]) . '" class="btn btn-danger btn-sm" id="delete">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    </div>';
                    return $actionbtn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        // // return view 
        return view('shop.coupon.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shop.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'code' => 'required|unique:coupons',
            'valid_date' => 'nullable|date',
            'type' => 'nullable|in:1,2,3',
            'amount' => 'required|numeric|min:0',
            'status' => 'nullable|in:active,inactive,expired',
        ]);

        Coupon::create($validatedData);

        $notification = ['notification' => 'coupon Created!', 'alert-type' => 'success'];
        return redirect()->route('coupon.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coupon $coupon)
    {
        return view('shop.coupon.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Coupon $coupon)
    {
        $validatedData = $request->validate([
            'code' => 'required',
            'valid_date' => 'nullable|date',
            'type' => 'nullable|in:1,2,3',
            'amount' => 'required|numeric|min:0',
            'status' => 'nullable|in:active,inactive,expired',
        ]);

        $coupon->update($validatedData);

        $notification = ['notification' => 'coupon Updated!', 'alert-type' => 'success'];
        return redirect()->route('coupon.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();

        $notification = ['notification' => 'Coupon Deleted!', 'alert-type' => 'success'];
        return redirect()->route('coupon.index')->with($notification);
    }
}

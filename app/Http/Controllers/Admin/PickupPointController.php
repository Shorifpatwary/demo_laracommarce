<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PickupPoint;

use Illuminate\Http\Request;
use DataTables;

class PickupPointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = PickupPoint::latest()->get();

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionbtn = '<div class="d-inline-flex gap-1">
                    <a href="' . route('pickup-point.edit', [$row->id]) . '" class="btn btn-info btn-sm edit"><i class="fas fa-edit"></i></a>
                    <form action="' . route('pickup-point.destroy', [$row->id]) . '" method="post">'
                        . csrf_field()  .
                        method_field('DELETE') .
                        '<button type="submit" href="' . route('pickup-point.destroy', [$row->id]) . '" class="btn btn-danger btn-sm" id="delete">
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
        return view('shop.pickup-point.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shop.pickup-point.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|between:5,255|unique:pickup_points',
            'address' => 'required|string|between:5,255',
            'phone' => 'required|string|between:5,25',
            'phone_two' => 'nullable|string|between:5,25',
        ]);

        PickupPoint::create($validatedData);

        $notification = ['notification' => 'Pickup Point Created!', 'alert-type' => 'success'];
        return redirect()->route('pickup-point.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(PickupPoint $pickupPoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PickupPoint $pickupPoint)
    {
        return view('shop.pickup-point.edit', compact('pickupPoint'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PickupPoint $pickupPoint)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|between:5,255',
            'address' => 'required|string|between:5,255',
            'phone' => 'required|string|between:5,25',
            'phone_two' => 'nullable|string|between:5,25',
        ]);

        $pickupPoint->update($validatedData);

        $notification = ['notification' => 'Pickup Point Updated!', 'alert-type' => 'success'];
        return redirect()->route('pickup-point.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PickupPoint $pickupPoint)
    {
        $pickupPoint->delete();

        $notification = ['notification' => 'Pickup Point Deleted!', 'alert-type' => 'success'];
        return redirect()->route('pickup-point.index')->with($notification);
    }
}

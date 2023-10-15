<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class WarehouseController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$data = Warehouse::latest()->get();

		if ($request->ajax()) {
			return DataTables::of($data)
				// ->editColumn('DT_RowIndex', function ($row) {
				// 	return $row->id; // You can customize this as needed
				// })
				->addIndexColumn()
				->addColumn('action', function ($row) {
					$actionbtn = '<div class="d-inline-flex gap-1">
							<a href="' . route('warehouse.edit', [$row->id]) . '" class="btn btn-info btn-sm edit"><i class="fas fa-edit"></i></a>
							<form action="' .  route('warehouse.destroy', [$row->id]) . '" method="post">'
						. csrf_field()  .
						method_field('DELETE') .
						'<button type="submit" href="' . route('warehouse.destroy', [$row->id]) . '" class="btn btn-danger btn-sm" id="delete">
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
		return view('shop.warehouse.index');
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create()
	{
		return view('shop.warehouse.create');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$validatedData = $request->validate([
			'name' => 'required|string|between:5,100|unique:warehouses',
			'address' => 'string|between:5,200',
			'phone' => 'string|between:5,100|unique:warehouses',
		]);

		Warehouse::create($validatedData);

		$notification = ['notification' => 'Warehouse Created!', 'alert-type' => 'success'];
		return redirect()->route('warehouse.index')->with($notification);
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Warehouse $warehouse)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Warehouse $warehouse)
	{
		return view('shop.warehouse.edit', compact('warehouse'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, Warehouse $warehouse)
	{
		$validatedData = $request->validate([
			'name' => 'required|string|between:5,100,',
			'address' => 'string|between:5,200',
			'phone' => 'string|between:5,100',
		]);

		$warehouse->update($validatedData);

		$notification = ['notification' => 'Warehouse Updated!', 'alert-type' => 'success'];
		return redirect()->route('warehouse.index')->with($notification);
	}


	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Warehouse $warehouse)
	{
		$warehouse->delete();

		$notification = ['notification' => 'Warehouse Deleted!', 'alert-type' => 'success'];
		return redirect()->route('warehouse.index')->with($notification);
	}
}

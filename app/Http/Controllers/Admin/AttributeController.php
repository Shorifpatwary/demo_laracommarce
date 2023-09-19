<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    private $enumOptionsCacheKey = 'enum_options';
    private $enumOptions;

    public function __construct()
    {
        // Retrieve enum options from the cache, or fetch from the database and cache if not found
        $this->enumOptions = Cache::remember($this->enumOptionsCacheKey, now()->addHours(24), function () {
            return $this->enumOptions('attributes', 'type');
        });
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $data = Attribute::all();
        return view('shop.attribute.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function enumOptions(string  $tableName  = 'attributes', string  $columnName = 'type')
    {
        $databaseName = DB::getDatabaseName();

        $query = "
        SELECT TRIM(BOTH '\"'FROM REPLACE(SUBSTRING(COLUMN_TYPE, 6), '\'', '')) AS enum_values
        FROM information_schema.columns
        WHERE TABLE_SCHEMA = '$databaseName'
        AND TABLE_NAME = '$tableName'
        AND COLUMN_NAME = '$columnName' ";

        $results = DB::select($query);

        if (!empty($results)) {
            $enumValues = $results[0]->enum_values;
            // Remove single quotes and split the string into an array
            // Remove the trailing ')' character
            // $enumValues = rtrim($enumValues, ')');
            $enumValues = preg_replace("/[\)\('`]+/", '', $enumValues);

            // Convert the string to an array
            $enumArray = explode(",", $enumValues);
            // Now, $enumValues contains the enum values
            return $enumArray;
        } else {
            return "No enum values found";
        }
    }
    public function create()
    {

        $enumOptions =  $this->enumOptions;

        return view('shop.attribute.create', compact('enumOptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // Get the enum options for 'attributes' and 'type'

        $enumOptions =  $this->enumOptions;

        // Define a custom validation rule
        Validator::extend('valid_enum_type', function ($attribute, $value, $parameters, $validator) use ($enumOptions) {
            return in_array($value, $enumOptions);
        });

        // Add a custom error message for the rule
        $customMessages = [
            'type.valid_enum_type' => 'The selected type is invalid.',
        ];

        $validatedData = $request->validate([
            'type' => 'required|max:40|valid_enum_type',
            'name' => 'required|max:40',
        ], $customMessages);

        $validatedData['slug'] = Str::slug($validatedData['name'], '-');

        // Insert data into the database using the Page model's create method
        Attribute::create($validatedData);
        $notification = ['notification' => 'Attribute Created!', 'alert-type' => 'success'];
        return redirect()->route('attribute.index')->with($notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attribute $attribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $attribute)
    {
        // Get the enum options for 'attributes' and 'type'
        $enumOptions =  $this->enumOptions;

        return view('shop.attribute.edit', compact('attribute', 'enumOptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attribute $attribute)
    {
        // Get the enum options for 'attributes' and 'type'
        $enumOptions =  $this->enumOptions;

        // Define a custom validation rule
        Validator::extend('valid_enum_type', function ($attribute, $value, $parameters, $validator) use ($enumOptions) {
            return in_array($value, $enumOptions);
        });

        // Add a custom error message for the rule
        $customMessages = [
            'type.valid_enum_type' => 'The selected type is invalid.',
        ];

        $validatedData = $request->validate([
            'type' => 'required|max:40|valid_enum_type',
            'name' => 'required|max:40',
        ], $customMessages);

        $validatedData['slug'] = Str::slug($validatedData['name'], '-');

        // Update the attribute's data with the new validated data
        $attribute->update($validatedData);

        $notification = ['notification' => 'Attribute Updated!', 'alert-type' => 'success'];
        return redirect()->route('attribute.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        $attribute->delete();
        $notification = ['notification' => 'Attribute Deleted!', 'alert-type' => 'success'];
        return redirect()->back()->with($notification);
    }
}

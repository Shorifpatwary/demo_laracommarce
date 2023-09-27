<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
    const LOGIN_SUCCESS_MESSAGE = "Customer login successfully!";
    const PASSWORD_MISMATCH_MESSAGE = "Password mismatch";
    const CUSTOMER_NOT_FOUND_MESSAGE = "Customer does not exist";

    //  Registration 

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:5,255',
            'email' => 'required|string|email|between:5,255|unique:customers',
            'password' => 'required|string|between:6,50|confirmed',
            'phone' => 'string|between:5,50',
            'birth_date' => 'nullable|date|between:5,50'
        ]);
        if ($validator->fails()) {
            return response(
                [
                    'errors' => $validator->errors(),
                    'status' => config('custom.api_error_status_code')
                ],
                config('custom.api_error_status_code')
            );
        }
        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $customer = Customer::create($request->toArray());
        $token = $customer->createToken('Laravel Password Grant Client')->accessToken;
        $response = [
            "message" => "Customer created succesfully!", 'status' => config('custom.api_success_status_code'),
            'customer' => $customer,
            'token' => $token
        ];
        return response($response, config('custom.api_success_status_code'));
    }
    //  Login 
    function Login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|exists:customers,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            $response = [
                'message' => 'The given data was invalid.',
                'status' => config('custom.api_error_status_code'),
                'errors' => $validator->errors(),
            ];
            return response($response, config('custom.api_error_status_code'));
        }

        $customer = Customer::where('email', $request->email)->first();
        if ($customer && Hash::check($request->password, $customer->password)) {
            $token = $customer->createToken('Laravel Password Grant Client')->accessToken;

            return response()->json([
                'message' => self::LOGIN_SUCCESS_MESSAGE,
                'token' => $token,
                'customer' => $customer,
                'status' => config('custom.api_success_status_code')
            ], config('custom.api_success_status_code'));
        }

        return response()->json([
            'message' => self::PASSWORD_MISMATCH_MESSAGE,
            'status' => config('custom.api_error_status_code')
        ], config('custom.api_error_status_code'));
    }

    //   log out 
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!', 'status' => config('custom.api_success_status_code')];
        return response($response, config('custom.api_success_status_code'));
    }

    // profile 
    public function show(Request $request)
    {
        $customer = Auth::guard('api')->user();
        return response()->json([
            'message' => 'Customer profile details retrieved successfully',
            'status' => config('custom.api_success_status_code'),
            'customer' => $customer,
        ], config('custom.api_success_status_code'));
    }

    //  edit method 
    public function edit(Customer $customer)
    {
        $customer = Auth::guard('api')->user();
        return response()->json([
            'message' => 'Customer profile edit data retrieved successfully',
            'status' => config('custom.api_success_status_code'),
            'customer' => $customer,
        ], config('custom.api_success_status_code'));
    }

    public function update(Request $request)
    {
        $customer = Auth::guard('api')->user();
        // Log::error($request->input('image'));
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $customer->id,
            'phone' => 'nullable|string|max:20',
            // 'image' => 'nullable|max:2048', // Example image validation
            //'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Example image validation
            'birth_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'The given data was invalid.',
                'status' => config('custom.api_error_status_code'),
                'errors' => $validator->errors(),
            ], config('custom.api_error_status_code'));
        }
        // Handle image upload (if needed)
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');

        //     // Check for image validation errors again
        //     if ($image->isValid()) {
        //         $photoname = "profile-" . hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        //         Image::make($image)->resize(300, 300)->save('files/profile/' . $photoname);
        //         $customer->image = $photoname; // Set the new image filename
        //     } else {
        //         return response()->json([
        //             'message' => 'Image validation failed.',
        //             'status' => config('custom.api_error_status_code'),
        //             'errors' => ['image' => 'The image file is invalid.'],
        //         ], config('custom.api_error_status_code'));
        //     }
        // }

        // Update the customer's profile with the validated data
        $customer->fill($request->only(['name', 'email', 'phone', 'birth_date']));

        // Save the changes to the customer's profile
        $customer->save();

        return response()->json([
            'message' => 'Customer profile updated successfully',
            'status' => config('custom.api_success_status_code'),
            'customer' => $customer,
        ], config('custom.api_success_status_code'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    const LOGIN_SUCCESS_MESSAGE = "Customer login successfully!";
    const PASSWORD_MISMATCH_MESSAGE = "Password mismatch";
    const CUSTOMER_NOT_FOUND_MESSAGE = "Customer does not exist";

    //  Registration 

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:6|confirmed',
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
        // Check if the user is authenticated using the 'api' guard
        // if (Auth::guard('api')->check()) {
        //     $customer = Auth::guard('api')->user();
        //     return response()->json([
        //         'message' => 'Customer profile details retrieved successfully',
        //         'status' => config('custom.api_success_status_code'),
        //         'customer' => $customer,
        //     ]);
        // } else {
        //     return response()->json([
        //         'message' => 'Authentication failed',
        //         'status' => config('custom.api_unauthorized_status_code')
        //     ], config('custom.api_unauthorized_status_code'));
        //     // Return a 401 Unauthorized status code
        // }
        try {
            // Check if the user is authenticated using the 'api' guard
            if (Auth::guard('api')->check()) {
                $customer = Auth::guard('api')->user();
            } else {
                return response()->json([
                    'message' => 'Authentication failed',
                    'status' => config('custom.api_unauthorized_status_code')
                ], config('custom.api_unauthorized_status_code'));
                // Return a 401 Unauthorized status code
            }
        } catch (AuthorizationException $e) {
            // Handle invalid token here
            return response()->json([
                'message' => 'Invalid or expired API token',
                'status' => config('custom.api_unauthorized_status_code')
            ], config('custom.api_unauthorized_status_code')); // Return a 401 Unauthorized status code
        }
        return response()->json([
            'message' => 'Customer profile details retrieved successfully',
            'status' => config('custom.api_success_status_code'),
            'customer' => $customer,
        ], config('custom.api_success_status_code'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CustomerController extends Controller
{
    //  Registration 
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }
        $request['password'] = Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $customer = Customer::create($request->toArray());
        $token = $customer->createToken('Laravel Password Grant Client')->accessToken;
        $response = ["message" => "Customer created succesfully!", 'status' => 200, 'token' => $token];
        return response($response, 200);
    }

    //  Login 
    function Login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response(['errors' => $validator->errors()], 422);
        }

        $customer = Customer::where('email', $request->email)->first();
        if ($customer) {
            if (Hash::check($request->password, $customer->password)) {
                $token = $customer->createToken('Laravel Password Grant Client')->accessToken;

                $response = ["message" => "Customer login succesfully!", 'status' => 200, 'token' => $token];
                return response($response, 200);
            } else {
                $response = ["message" => "Password mismatch", 'status' => 422];
                return response($response, 422);
            }
        } else {
            $response = ["message" => 'Customer does not exist', 'status' => 422];
            return response($response, 422);
        }
    }

    //   log out 
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!', 'status' => 200];
        return response($response, 200);
    }
}
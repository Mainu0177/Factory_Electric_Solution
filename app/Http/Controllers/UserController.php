<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function UserRegistration(Request $request){
        // dd($request->all());
        try {
            $request->validate([
                "name" => "required|",
                "email" => "required|unique:users,email",
                "phone" => "nullable",
                "password" => "required",
            ]);
            $data = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => $request->password,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'User Registration successfully',
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "user registration failed",
            ]);
        }
    } // end user registration method
    public function UserLogin(Request $request){
        try {
            $count = User::where('email', $request->input('email'))->where('password', $request->input('password'))->select('id')->first();
            if($count !== null){
                $token = JWTToken::CreateToken($request->input('email'), $count->id);
                return response()->json([
                    'status' => 'success',
                    'message' => 'User login successfully',
                    'token' => $token
                ],200)->cookie('token', $token, 60*24*30);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User login failed',
            ]);
        }
    }
    public function UserLogout(Request $request){
        return response()->json([
            'status' => 'success',
            'message' => 'User successfully logged out',
        ], 200)->cookie('token', '', -1);
    }



    // Front end functionality
    public function LoginPage(){
        return Inertia::render('LoginPage');
    }
}

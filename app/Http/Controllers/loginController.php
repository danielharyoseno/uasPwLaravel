<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\RegisResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class loginController extends Controller
{
 //
    /**
     * Create User
     * @param Request $request
     * @return User
     */
    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => '!! The email or Password does not match  !!',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user->hasVerifiedEmail()) {
                return response()->json([
                    'status' => false,
                    "message" => "!! Email has not been verified !!"
                ], 400);
            }
            return response()->json([
                'status' => true,
                'message' => 'Logged In Successfully',
                'token' => $user->createToken("Token Api")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function logout()
    {
        try {
            auth()->user()->currentAccessToken()->delete();

            return response()->json([
                'status' => true,
                'message' => 'Logged Out Successfully',
            ], 200);
        } catch (\Throwable $p) {
            return response()->json([
                'status' => false,
                'message' => $p->getMessage()
            ], 500);
        }
    }
}
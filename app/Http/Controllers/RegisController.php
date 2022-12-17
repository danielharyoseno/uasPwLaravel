<?php

namespace App\Http\Controllers;

use App\Http\Resources\RegisResource;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class RegisController extends Controller
{
    public function register(Request $request)
    {
        try {
            $data = $request->all();
            $validateUser = Validator::make($data, User::$rules);

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);
            $user->sendEmailVerificationNotification();

            return response()->json([
                'status' => true,
                'message' => 'User Created',
                'token' => $user->createToken("Token Api")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
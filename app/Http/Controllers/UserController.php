<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function showProfile()
    {
        $user = auth()->user();
        return response()->json([
            'success' => true,
            'message' => 'User Profile',
            'data' => $user
        ], 200);
    }

    public function updateProfile(Request $request, $id)
    {
        $user = auth()->user();

        $user = User::find($id);
        if(is_null($user)){
            return response([
                'message' => 'User Not Found',
                'data' => null
            ],404);
        }

        $data = $request->all();
        $validate = Validator::make($data, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'required',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation Error',
                'data' => $validate->errors()
            ], 400);
        }
        $user->update($data);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Update Profile',
            'data' => $user
        ], 200);
    }
}
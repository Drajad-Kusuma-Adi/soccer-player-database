<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validation = $request->validate([
            'username' => 'required|string|min:4',
            'password' => 'required|string|min:8'
        ]);

        $user = Users::where('username', $request->username)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid username'
            ], 422);
        } else {
            if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
                $token = md5($request->passowrd);
                $login = Users::where('username', $request->username)->update([
                    "remember_token" => $token
                ]);
                if (!$login) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Something went wrong went inserting token'
                    ], 500);
                } else {
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Login successful'
                    ], 200);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid password'
                ], 422);
            }
        }
    }
    public function logout(Request $request)
    {
        $validation = $request->validate([
            'token' => 'required'
        ]);

        $user = Users::where('remember_token', $request->token)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token'
            ], 401);
        } else {
            return response()->json([
                'status' => 'success',
                'message' => 'Logout successful'
            ], 200);
        }
    }
}

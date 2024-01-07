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
    public function getAllUsers(Request $request) {
        $validation = $request->validate([
            'token' => 'required'
        ])

        $user = Users::where('remember_token', $request->token)->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid token'
            ], 401); 
        } else {
            $users = Users::all();
            if (!$users) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Error at getting users'
                ], 500);
            }
            return response()->json([
                'status' => 'success',
                'users' => $users
            ], 200);
        }
    }
    public function register(Request $request) {
        $validation = $request->validate([
          'username' => 'required|string|min:4',
          'password' => 'required|string|min:8'
        ]);

        $user = Users::where('username', $request->username)->first();
        if ($user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username already exists'
            ], 422);
        } else {
            $register = Users::create([
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);
            if (!$register) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Something went wrong'
                ], 500);
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Registration successful'
            ], 200);
        }
    }
    public function getUserById(Request $request) {
      $validation = $request->validate([
        'token' => 'required',
        'id' => 'required'
      ]);

      $token = Users::where('remember_token', $request->token)->first();
      if (!$token) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid token'
        ], 401);
      } else {
        $user = Users::where('id', $request->id)->first();
        if (!$user) {
          return response()->json([
              'status' => 'error',
              'message' => 'Error at getting user'
          ], 500);
        }
        return response()->json([
          'status' => 'success',
          'user' => $user
        ], 200);
      }
    }
    public function modifyUserById(Request $request) {
      $validation = $request->validate([
        'token' => 'required',
        'id' => 'required',
        'username' => 'required',
      ]);

      $token = Users::where('remember_token', $request->token)->first();
      if (!$token) {
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid token'
        ], 401);
      } else {
        $user = Users::where('id', $request->id)->first();
        if (!$user) {
          return response()->json([
              'status' => 'error',
              'message' => 'Error at getting user'
          ], 500);
        } else {
            $update = Users::where('id', $request->id)->update([
            'username' => $request->username
          ]);
          if (!$update) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error at updating user'
            ], 500);
          }
          return response()->json([
            'status' => 'success',
            'message' => 'Update successful'
            'new_user' => $update
          ], 200);
        }
      }
    }
    public function deleteUserById(Request $request) {
      $validatin = $request->validate([
        'token' => 'required',
        'id' => 'required'
      ]);

      $user = Users::where('remember_token', $request->token)->first();
      if (!$user) {
        return response()->json([
          'status' => 'error',
          'message' => 'Invalid token'
        ], 401);    
      } else {
        $delete = Users::where('id', $request->id)->delete();
        if (!$delete) {
          return response()->json([
            'status' => 'error',
            'message' => 'Error at deleting user'
          ], 500);
        }
        return response()->json([
          'status' => 'success',
          'message' => 'Delete successful'
        ], 200);
      }
    }
}

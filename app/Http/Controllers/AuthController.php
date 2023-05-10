<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
   public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = Auth::attempt($credentials);

        $user =  Auth::user();
        $user->active_status = 1;
        $user->save();

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }
        return response()->json([
                'status' => 'success',
                'token' => $token,
                'type' => 'bearer', 
            ]);
    }
    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['password'] = bcrypt($data['password']);
        User::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'New Account Created',
        ]);
    }
    public function logout()
    {   
        $user =  Auth::user();
        $user->active_status = 0;
        $user->save();
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }
    public function user()
    {
        $user = Auth::user();
        return response()->json([
            'user' => $user
        ]);
    }
    public function darkMode($id, Request $request)
    {
        $user = User::find($id);
        $user->update(['dark_mode' => $request->dark_mode]);
      
        return response()->json([
        'status' => 'success',
        'user' => $user
    ]);
    }
}

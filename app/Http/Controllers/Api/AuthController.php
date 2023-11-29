<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed'
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        $token =  $user->createToken('auth-token')->plainTextToken;

        return response()->json(['token' => $token, 'message' => 'user created successfully', 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();
        $token =  $user->createToken('auth-token')->plainTextToken;
        return response()->json(['token' => $token, 'user' => $user], 201);
    }

    public function logout()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 401);
        }

        $user->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully'], 201);
    }
}

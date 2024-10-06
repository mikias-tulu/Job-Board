<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Employer Registration
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),

    ]);


    $user->company_id = $user->id; 
    $user->save();

    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json(['token' => $token]);
}


    // Employer Login
    public function login(Request $request)
{
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    if (!Auth::attempt($request->only('email', 'password'))) {
        return response()->json(['message' => 'Invalid login credentials'], 401);
    }

    $user = Auth::user();
    $token = $user->createToken('token')->plainTextToken;

    // Redirect to the dashboard URL
    $dashboardUrl = route('dashboard');

    return response()->json([
        'token' => $token,
        'redirect' => $dashboardUrl,
    ]);
}

public function user()
{
    $user = Auth::user();

    if ($user) {
        return response()->json($user);
    } else {
        return response()->json(['message' => 'Unauthenticated'], 401);
    }
}



    // Employer Logout
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}

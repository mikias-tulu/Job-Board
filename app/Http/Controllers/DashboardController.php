<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    // Constructor to ensure only authenticated users can access the dashboard
    public function __construct()
    {
        $this->middleware('auth:sanctum'); 
    }

    // Show the dashboard
    public function index()
    {
        $user = Auth::user(); // Get the authenticated user

        return response()->json([
            'message' => 'Welcome to the company dashboard',
            'user' => $user,
            // 
        ]);
    }
}

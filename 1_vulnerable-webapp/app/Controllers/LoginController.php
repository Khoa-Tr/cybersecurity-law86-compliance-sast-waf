<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // VULNERABILITY 1: SQL Injection
        // The login endpoint directly concatenates user input into SQL queries without parameterization.
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $user = DB::select(DB::raw($query));

        if (!empty($user)) {
            // Login successful
            return view('dashboard', ['user' => $user[0]]);
        } else {
            return back()->withErrors(['message' => 'Invalid credentials']);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    // VULNERABILITY 4: INSECURE DIRECT OBJECT REFERENCES (IDOR)
    public function show($userId)
    {
        // No ownership verification
        $user = User::find($userId);  // Returns any user
        return view('profile.show', ['user' => $user]);
    }

    public function update(Request $request, $userId)
    {
        // No authorization check
        $user = User::find($userId);
        $user->email = $request->input('email');
        $user->save();  // Can modify any user
        
        return redirect()->back()->with('success', 'Profile updated');
    }
}

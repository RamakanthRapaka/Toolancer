<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class PublicController extends Controller
{
    public function signup(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'displayName' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'mobile' => 'nullable|string|max:20',
            'message' => 'nullable|string',
        ]);

        // Example: create user (adjust to your logic)
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt('temporary-password'), // change to real flow
        ]);

        // optionally send email / set flash message / assign role etc.
        return back()->with('success', 'Signup received. We will contact you.');
    }
}

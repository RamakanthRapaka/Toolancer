<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PublicController extends Controller
{
    public function signup(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'displayName' => 'nullable|string|max:255',
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'mobile' => [
                'nullable',
                'regex:/^[0-9]{10}$/',
                Rule::unique('users', 'mobile')
            ],
            'message' => 'nullable|string|max:500',
        ], [
            'mobile.regex' => 'Mobile must be a 10 digit number.',
            'mobile.unique' => 'This mobile number is already registered.',
        ]);


        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed.',
                    'errors' => $validator->errors(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        // Example: create user (adjust to your logic)
        $password = bcrypt(Str::random(10));
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'mobile' => $request->input('mobile'),
            'password' => $password,
        ]);

        // If you use Spatie roles, assign the role
        if (method_exists($user, 'assignRole')) {
            $user->assignRole('user');
        }

        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Signup received. We sent an email with next steps (example).'
            ]);
        }

        return back()->with('success', 'Signup received. Please check your email.');
    }
}

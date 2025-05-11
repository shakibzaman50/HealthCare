<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('admin.password.reset');
    }
    public function updatePassword(Request $request)
    {
        try {
            // Validate the request
            $validated = $request->validate([
                'password' => [
                    'required',
                    'string',
                    'min:8', // Minimum length of 8 characters
                    'confirmed', // Ensure password confirmation matches
                    'regex:/[a-z]/', // At least one lowercase letter
                    'regex:/[A-Z]/', // At least one uppercase letter
                    'regex:/[0-9]/', // At least one digit
                    'regex:/[@$!%*?&]/', // At least one special character
                ],
            ]);

            // Get the authenticated user
            $user = Auth::user();

            // Check if $user is an instance of the User model
            if (!$user instanceof \App\Models\User) {
                return redirect()->route('password.edit')->withErrors(['user' => 'Unable to find authenticated user.']);
            }

            // Update the user's password
            $user->update([
                'password' => Hash::make($validated['password']),
            ]);

            // Redirect with a success message
            return redirect()->route('password.edit')->with('success', 'Password reset successfully.');
        } catch (ValidationException $e) {
            logger('Error');
            // Return validation errors as a JSON response or handle as needed
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }

    public function update(Request $request)
    {
        return $request;
        logger('Hit here');
        // Validate the request
        $validated = $request->validate([
            'password' => 'required|string|min:4|confirmed',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Debugging: Check if $user is an instance of User
        if (!$user instanceof \App\Models\User) {
            // If $user is not an instance of User, handle the error
            return redirect()->route('password.edit')->withErrors(['user' => 'Unable to find authenticated user.']);
        }

        // Update the user's password
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Redirect with a success message
        return redirect()->route('password.edit')->with('success', 'Password reset successfully.');
    }
}

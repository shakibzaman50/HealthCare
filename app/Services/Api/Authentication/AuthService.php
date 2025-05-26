<?php

namespace App\Services\Api\Authentication;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    public function register(array $data)
    {
        DB::beginTransaction();
        try {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'phone'    => $data['phone'] ?? null,
                'password' => Hash::make($data['password']),
                'status'   => config('app.user_status.active'),
                'type'     => config('app.user_type.user'),
            ]);

            $profile = Profile::create([
                'user_id' => $user->id,
                'name'    => $data['name'] ?? $user->name,
                'age'     => $data['age'] ?? null,
                'weight'  => $data['weight'] ?? null,
                'height'  => $data['height'] ?? null,
                'dob'     => $data['dob'] ?? null,
                'bmi'     => $data['bmi'] ?? null,
            ]);

            DB::commit();

            return [
                'success' => true,
                'message' => 'Registration successful',
                'user'    => $user,
                'token'   => $user->createToken('Personal Access Token')->accessToken,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Registration failed',
                'error'   => $e->getMessage(),
                'code'    => 500,
            ];
        }
    }
    public function login($request)
    {
        $user = User::where('email', $request->email)
            ->where('type', config('app.user_type.user'))
            ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return [
                'code' => 401,
                'message' => 'Invalid credentials',
                'user' => null,
                'token' => null,
                'error' => 'Invalid credentials',
            ];
        }

        if ($user->status != config('app.user_status.active')) {
            return [
                'code' => 403,
                'message' => 'Your account is not active. Please activate your account first.',
                'user' => $user,
                'token' => null,
                'error' => 'Account is not active',
                'can_activate' => true
            ];
        }

        if ($user->deleted_at != null) {
            return [
                'code' => 403,
                'message' => 'This account is deleted.',
                'user' => $user,
                'token' => null,
                'error' => 'This account is deleted.',
            ];
        }

        return [
            'code'    => 200,
            'message' => 'Login successful',
            'user'    => $user,
            'token'   => $user->createToken('Personal Access Token')->accessToken,
        ];
    }


    public function authLogout()
    {
        try {
            $user = Auth::user();
            if ($user) {
                // Revoke all tokens for the user
                $user->tokens()->delete();
                return [
                    'success' => true,
                    'message' => 'Successfully logged out',
                    'code' => 200
                ];
            }
            return [
                'success' => false,
                'message' => 'No authenticated user found',
                'code' => 401
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Logout failed',
                'error' => $e->getMessage(),
                'code' => 500
            ];
        }
    }

    /**
     * Activate user account
     * 
     * @param string $email
     * @return array
     */
    public function activateAccount($email)
    {
        $user = User::where('email', $email)
            ->where('type', config('app.user_type.user'))
            ->first();

        if (!$user) {
            return [
                'success' => false,
                'code' => 404,
                'message' => 'User not found',
                'error' => 'Invalid email address'
            ];
        }

        // Update user status to active
        $user->status = config('app.user_status.active');
        $user->save();

        return [
            'success' => true,
            'code' => 200,
            'message' => 'Account activated successfully. You can now login.',
            'user' => $user
        ];
    }
}

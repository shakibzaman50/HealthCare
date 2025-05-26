<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getUserWithProfiles(int $userId)
    {
        return User::with('profiles')->findOrFail($userId);
    }

    public function updateUser(User $user, array $data)
    {
        $user->update($data);
        return $user->fresh(['profiles']);
    }

    public function updatePassword(User $user, string $newPassword)
    {
        $user->update([
            'password' => Hash::make($newPassword)
        ]);
        return $user->fresh(['profiles']);
    }
}

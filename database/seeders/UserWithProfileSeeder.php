<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserWithProfileSeeder extends Seeder
{
    public function run(): void
    {
        // Create user
        $user = User::create([
            'name'     => 'Shakib Al Hasan',
            'email'    => 'user@gmail.com',
            'phone'    => '01700000000',
            'password' => Hash::make('password'), // Always hash passwords
            'status'   => '1',
            'type'     => '3',
        ]);

        // Create profile for the user
        Profile::create([
            'user_id' => $user->id,
            'name'    => $user->name,
            'avatar'  => 'default.png',
            'age'     => 35,
            'weight'  => 75.5,
            'height'  => 175,
            'birth_year'     => '1990',
            'bmi'     => 24.7,
        ]);
    }
}

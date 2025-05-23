<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(['email' => 'admin@gmail.com'], [
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '01777777777',
            'type' => '1',
            'password' => bcrypt('12345678')
        ]);

        $role = Role::firstOrCreate(['name' => 'Super Admin']);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}

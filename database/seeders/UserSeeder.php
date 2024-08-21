<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['super-admin', 'admin', 'kasir', 'supplier'];
        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }

        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'username' => 'superadmin',
            'password' => Hash::make('superadmin@123'),
        ]);

        $user->assignRole('super-admin');
    }
}

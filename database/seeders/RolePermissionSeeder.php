<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissionsList = [
            'create-user',
            'edit-user',
            'delete-user',
            'actived-user',
            'give-permission',
            'view-role',
            'show-role',
            'delete-role',
            'view-permission',
            'delete-permission',
            'create-category',
            'edit-category',
            'delete-category',
            'create-product',
            'edit-product',
            'delete-product',
        ];

        $permissions = [];
        foreach ($permissionsList as $permission) {
            $permissions[] = Permission::create(['name' => $permission]);
        }

        $superAdmin = User::find(1);

        if ($superAdmin) {
            $superAdmin->givePermissionTo($permissions);
        }
    }
}

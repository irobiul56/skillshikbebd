<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $user = Role::create(['name' => 'user']);

        // Create permissions
        Permission::create(['name' => 'edit course']);
        Permission::create(['name' => 'delete course']);
        Permission::create(['name' => 'publish course']);
        Permission::create(['name' => 'unpublish course']);

        // Assign permissions to roles
        $admin->givePermissionTo(['edit course', 'delete course', 'publish course']);
        $user->givePermissionTo('edit course');
    }
}

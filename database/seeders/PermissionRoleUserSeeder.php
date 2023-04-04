<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionRoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // list permissions
        $permissions = [
            'List Permission',
            'List Role',
            'Create Role',
            'Update Role',
            'View Role',
            'Delete Role',
            'List User',
            'Create User',
            'Update User',
            'View User',
            'Delete User',
            'Impersonate User',
            'List Member',
            'Create Member',
            'Update Member',
            'View Member',
            'Delete Member',
            'Analytics Setting',
            'Password Setting',
            'Announcement Setting',
            'Maintenance Setting',
            'Header Setting',
            'Agent Setting',
        ];

        // create permissions
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // assign permissions to admin
        $roleAdmin = Role::create(['name' => 'admin']);
        foreach ($permissions as $permission) {
            $roleAdmin->givePermissionTo($permission);
        }

        // assign permissions to staff
        $staffAssigned = ['Member'];
        $roleStaff = Role::create(['name' => 'staff', 'default' => 1]);
        foreach ($permissions as $permission) {
            foreach ($staffAssigned as $assign) {
                if(strpos($permission, $assign) !== false) {
                    $roleStaff->givePermissionTo($permission);
                }
            }
        }

        // create admin
        $admin = \App\Models\User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@localhost.com',
            'picture' => 'default.png',
            'password' => Hash::make('admin123'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $admin->assignRole($roleAdmin);

        // create staff
        $staff = \App\Models\User::factory()->create([
            'name' => 'Staff',
            'email' => 'staff@localhost.com',
            'picture' => 'default.png',
            'password' => Hash::make('staff123'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
        $staff->assignRole($roleStaff);
    }
}

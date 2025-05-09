<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;

class PermissionAndRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create permissions for Basic, Medium, Large
        $permissionList = [
            [
                'group_name' => 'Basic',
                'name' => 'basic',
                'description' => 'Basic Permission',
            ],
            [
                'group_name' => 'Medium',
                'name' => 'medium',
                'description' => 'Medium Permission',
            ],
            [
                'group_name' => 'Large',
                'name' => 'large',
                'description' => 'Large Permission',
            ],
            [
                'group_name' => 'Admin',
                'name' => 'admin',
                'description' => 'Admin Permission',
            ],
        ];

        // Create permissions in the database
        foreach ($permissionList as $permission) {
            Permission::updateOrCreate(
                ['name' => $permission['name']],
                [
                    'group_name' => $permission['group_name'],
                    'description' => $permission['description'],
                ]
            );
        }

        // Assign permissions to specific users
        $users = User::all(); // You can filter this query to select specific users
        foreach ($users as $user) {
            // You can conditionally assign permissions based on a field in the user model (like user type or plan)
            if($user->name == 'Melih'){
                $user->syncPermissions('admin');
                $user->plan = 'admin';
                $user->save();
                return;
            }
            if ($user->plan == 'basic') {
                $user->syncPermissions('basic');
            } elseif ($user->plan == 'medium') {
                $user->syncPermissions('medium');
            } elseif ($user->plan == 'large') {
                $user->syncPermissions('large');
            }
        }
    }
}

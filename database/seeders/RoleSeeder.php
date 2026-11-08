<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Support\PermissionName;
use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::findOrCreate(Utils::getSuperAdminName());

        $roles = [
            'advanced_admin' => [
                User::class => ['view', 'viewAny', 'create', 'update'],
            ],
            'standard_admin' => [
                User::class => ['view', 'viewAny'],
            ],
        ];

        foreach ($roles as $role => $permissions) {
            $role = Role::findOrCreate($role);

            foreach ($permissions as $model => $actions) {
                foreach ($actions as $action) {
                    $permissionName = PermissionName::make($action, $model);
                    $permission = Permission::findOrCreate($permissionName);
                    $role->givePermissionTo($permission);
                }
            }
        }
    }
}

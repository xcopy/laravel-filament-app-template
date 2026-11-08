<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $roles = [
            Utils::getSuperAdminName(),
            'standard admin',
            'advanced admin',
        ];

        foreach ($roles as $role) {
            Role::findOrCreate($role);
        }
    }
}

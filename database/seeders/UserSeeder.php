<?php

namespace Database\Seeders;

use App\Models\User;
use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::withoutEvents(function () {
            /** @var User $user */
            $user = User::firstOrCreate([
                'email' => config('filament.superadmin.email'),
            ], [
                'first_name' => config('filament.superadmin.first_name'),
                'last_name' => config('filament.superadmin.last_name'),
                'email_verified_at' => now(),
                'password' => config('filament.superadmin.password'),
            ]);

            $user->assignRole(Utils::getSuperAdminName());
        });

        if (! app()->isLocal()) {
            return;
        }

        User::factory(2)->create();
    }
}

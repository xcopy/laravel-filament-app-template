<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::withoutEvents(function () {
            User::firstOrCreate([
                'first_name' => config('filament.superadmin.first_name'),
                'last_name' => config('filament.superadmin.last_name'),
                'email' => config('filament.superadmin.email'),
                'email_verified_at' => now(),
                'password' => config('filament.superadmin.password'),
            ]);
        });

        if (! app()->isLocal()) {
            return;
        }

        User::factory(1)
            ->unverified()
            ->create();
    }
}

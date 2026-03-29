<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\UserRole;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(['email' => 'admin@euverify.com'], [
            'name' => 'Admin User',
            'password' => Hash::make('password'),
            'role' => UserRole::Admin,
        ]);

        $mUser = User::firstOrCreate(['email' => 'manufacturer@test.com'], [
            'name' => 'Test Manufacturer',
            'password' => Hash::make('password'),
            'role' => UserRole::Manufacturer,
        ]);

        if ($mUser->wasRecentlyCreated || !$mUser->company) {
            $mUser->company()->create([
                'name' => 'Test Manufacturer',
                'registration_number' => 'ACME12345',
                'country' => 'United Kingdom',
                'city' => 'London',
                'postcode' => 'EC1A 1BB',
                'address' => '10 Downing Street',
                'status' => 0,
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@gatesecurity.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'), // Change this password!
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        if ($admin->wasRecentlyCreated) {
            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: admin@gatesecurity.com');
            $this->command->info('Password: password');
            $this->command->warn('⚠️  Please change the default password after first login!');
        } else {
            $this->command->info('Admin user already exists.');
        }
    }
}

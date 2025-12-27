<?php

namespace Database\Seeders;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ResidentUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Test Resident User
        $residentUser = User::firstOrCreate(
            ['email' => 'resident@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'), // Change this password!
                'role' => 'resident',
                'phone' => '+1234567890',
                'plate_number' => 'ABC123',
                'email_verified_at' => now(),
            ]
        );

        if ($residentUser->wasRecentlyCreated) {
            // Create resident profile
            Resident::create([
                'user_id' => $residentUser->id,
                'name' => 'John Doe',
                'age' => 35,
                'address' => '123 Main Street, Subdivision',
                'plate_number' => 'ABC123',
                'car_model' => 'Toyota Camry',
                'car_color' => 'White',
                'contact_number' => '+1234567890',
            ]);

            $this->command->info('Test resident user created successfully!');
            $this->command->info('Email: resident@example.com');
            $this->command->info('Password: password');
            $this->command->info('Plate Number: ABC123');
            $this->command->warn('⚠️  Please change the default password after first login!');
        } else {
            $this->command->info('Test resident user already exists.');
        }
    }
}

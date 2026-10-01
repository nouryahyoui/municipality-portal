<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Administrator
        $admin = User::firstOrCreate(
            ['email' => 'admin@commune.local'],
            [
                'name' => 'Admin User',
                'email' => 'admin@commune.local',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        // Editor
        $editor = User::firstOrCreate(
            ['email' => 'editor@commune.local'],
            [
                'name' => 'Jane Editor',
                'email' => 'editor@commune.local',
                'password' => Hash::make('password'),
            ]
        );
        $editor->assignRole('editor');

        // Official
        $official = User::firstOrCreate(
            ['email' => 'official@commune.local'],
            [
                'name' => 'Bob Official',
                'email' => 'official@commune.local',
                'password' => Hash::make('password'),
            ]
        );
        $official->assignRole('official');

        // Citizen
        $citizen = User::firstOrCreate(
            ['email' => 'citizen@commune.local'],
            [
                'name' => 'John Citizen',
                'email' => 'citizen@commune.local',
                'password' => Hash::make('password'),
            ]
        );
        $citizen->assignRole('citizen');

        // Additional test citizens
        for ($i = 1; $i <= 5; $i++) {
            User::firstOrCreate(
                ['email' => "citizen{$i}@commune.local"],
                [
                    'name' => "Citizen {$i}",
                    'email' => "citizen{$i}@commune.local",
                    'password' => Hash::make('password'),
                ]
            )->assignRole('citizen');
        }
    }
}

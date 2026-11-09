<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        //  Official account
        User::create([
            'name' => 'Barangay Official',
            'email' => 'official@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'official',
        ]);

        // Resident account
        User::create([
            'name' => 'Resident',
            'email' => 'resident@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'resident',
        ]);
    }
}

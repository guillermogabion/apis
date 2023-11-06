<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(1)->create();
        User::factory()->create([
            'lastname' => 'Admin',
            'firstname' => 'User',
            'address' => 'Admin Address',
            'contact' => 'Admin Contact',
            'username' => 'admin',
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123')
        ]);

    }
}

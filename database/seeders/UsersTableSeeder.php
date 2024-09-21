<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create the Owner
        User::create([
            'name' => 'Owner Name',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'owner',
            'branch_id' => null, // No branch for the owner
        ]);

        // Create the first staff member
        User::create([
            'name' => 'Jenny Doe',
            'email' => 'jenny@gmail.com',
            'password' => Hash::make('jenny123'),
            'role' => 'staff',
            'branch_id' => 9, // Assigned to branch 9
        ]);

        // Create the second staff member
        User::create([
            'name' => 'Johnny Doe',
            'email' => 'johnny@gmail.com',
            'password' => Hash::make('johnny123'),
            'role' => 'staff',
            'branch_id' => 11, // Assigned to branch 11
        ]);
    }
}

<?php

namespace Database\Seeders;
use App\Models\User;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $users = [
            // Admin     
            [
                'name' => "Admin",
                'username' => 'admin',
                'email'=> 'admin@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'admin',
                'status' => 'active'
            ],

            // Agent     
            [
                'name' => "Agent",
                'username' => 'agent',
                'email'=> 'agent@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'agent',
                'status' => 'active'
            ],

            // User     
            [
                'name' => "User",
                'username' => 'user',
                'email'=> 'user@gmail.com',
                'password' => Hash::make('111'),
                'role' => 'user',
                'status' => 'active'
            ],
        ];

        foreach ($users as $userData ){
            User::create($userData);
        }

    }
}

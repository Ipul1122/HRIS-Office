<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
         $email = 'admin@example.com';

        User::updateOrCreate(
            ['email' => $email],
            [
                'name'     => 'Administrator',
                'password' => Hash::make('password123'), 
                'role'     => 'admin',                   
            ]
        );

      
    }
}

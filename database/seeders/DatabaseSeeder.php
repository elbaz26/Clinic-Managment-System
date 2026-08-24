<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name'     => 'System Admin',
            'email'    => 'admin@clinic.com',
            'password' => Hash::make('12345678'), 
            'role'     => 'admin',
        ]);
    }
}
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [[
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'role' => 'admin',
            'password' => Hash::make('admin'), 
        ], [
            'name' => 'user',
            'email' => 'user@user.com',
            'role' => 'user',
            'password' => Hash::make('user'), 
            ]];
        foreach($users as $user){
            User::create($user);
        };
    }
}

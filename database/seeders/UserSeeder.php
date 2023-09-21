<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'username' => 'user',
            'email' => 'user@example.com',
            'name' => "Lorem ipsum dolor sit",
            'password' => bcrypt('password')
        ])
            ->assignRole('User');
        User::create([
            'username' => 'administrator',
            'email' => 'administrator@example.com',
            'name' => "Administrator",
            'password' => bcrypt('password')
        ])
            ->assignRole('Administrator');
        User::create([
            'username' => 'owner',
            'email' => 'owner@example.com',
            'name' => "Lorem ipsum dolor sit",
            'password' => bcrypt('password')
        ])
            ->assignRole('Owner');
        User::create([
            'username' => 'guide',
            'email' => 'guide@example.com',
            'name' => "Lorem ipsum dolor sit",
            'password' => bcrypt('password')
        ])
            ->assignRole('Guide');
        User::create([
            'username' => 'finance',
            'email' => 'finance@example.com',
            'name' => "Lorem ipsum dolor sit",
            'password' => bcrypt('password')
        ])
            ->assignRole('Finance');
    }
}

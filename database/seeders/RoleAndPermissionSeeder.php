<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'User']);
        Role::create(['name' => 'Administrator']);
        Role::create(['name' => 'Owner']);
        Role::create(['name' => 'Guide']);
        Role::create(['name' => 'Finance']);
    }
}

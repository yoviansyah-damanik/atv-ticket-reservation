<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Unit::create([
            'name' => 'ATV Blue',
            'register_number' => 'BB 1234 AA'
        ]);
        Unit::create([
            'name' => 'ATV Red',
            'register_number' => 'BB 321 AA'
        ]);
        Unit::create([
            'name' => 'ATV Silver',
            'register_number' => 'BB 999 AA'
        ]);
    }
}

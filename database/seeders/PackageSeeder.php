<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Package::create([
            'title' => 'Short Trip Single',
            'price' => 30000
        ]);
        Package::create([
            'title' => 'Short Trip Double',
            'price' => 50000
        ]);
        Package::create([
            'title' => 'Medium Trip Single',
            'price' => 50000
        ]);
        Package::create([
            'title' => 'Medium Trip Double',
            'price' => 80000
        ]);
        Package::create([
            'title' => 'Long Trip Single',
            'price' => 200000
        ]);
        Package::create([
            'title' => 'Long Trip Double',
            'price' => 350000
        ]);
    }
}

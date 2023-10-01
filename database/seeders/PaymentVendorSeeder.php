<?php

namespace Database\Seeders;

use App\Models\PaymentVendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentVendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PaymentVendor::create([
            'name' => 'OTS',
            'account_number' => '-',
            'description' => 'Pembayaran Ditempat'
        ]);
    }
}

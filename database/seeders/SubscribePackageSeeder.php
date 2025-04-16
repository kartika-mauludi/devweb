<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SubscribePackage;

class SubscribePackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SubscribePackage::create([
            'name' => 'Paket Bulanan',
            'price' => '125000',
            'discount' => '0',
            'days' => 30,
        ]);

        SubscribePackage::create([
            'name' => 'Paket 6 Bulan',
            'price' => '600000',
            'discount' => '0',
            'days' => 180,
        ]);

        SubscribePackage::create([
            'name' => 'Paket 12 Bulan',
            'price' => '1000000',
            'discount' => '0',
            'days' => 360,
        ]);
    }
}

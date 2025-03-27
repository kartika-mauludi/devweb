<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Super',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'referral_code' => Str::random(10),
            'bank_account' => '1234567890',
            'bank_name' => 'Bank XYZ',
            'is_superadmin' => true,
            'nomor' => 123
        ]);

        User::create([
            'name' => 'User Biasa',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'referral_code' => Str::random(10),
            'bank_account' => '0987654321',
            'bank_name' => 'Bank ABC',
            'is_superadmin' => false,
            'nomor' => 123
        ]);
    }
}

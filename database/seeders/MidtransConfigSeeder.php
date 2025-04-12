<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MidtranConfig;

class MidtransConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MidtranConfig::create([
            'environment' => 'sandbox',
            'sandbox_client_key' => 'SB-Mid-client-GbfIp9tJeR1K8oDx',
            'sandbox_server_key' => 'SB-Mid-server-t6ud01KUNiWtiQQKSExs0gW7',
            'production_client_key' => 'Mid-client-SxUwVH-k1Scbeuq-',
            'production_server_key' => 'Mid-server-ojkyd9RZuYENqAaOuaGceB52'
        ]);
    }
}

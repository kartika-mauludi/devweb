<?php

namespace Database\Seeders;

use App\Models\ConfigAccount;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ConfigAccount::create([
           'name_university' => 'Arizona State University',
           'name_config' => 'asu_1',
           'username' => 'ssenger7',
           'password' => 'Pejuang45!@!@',
           'address' => 'sslvpn.asu.edu',
        ]);

         ConfigAccount::create([
           'name_university' => 'Arizona State University',
           'name_config' => 'asu_2',
           'username' => 'wjune12',
           'password' => 'Pejuang45!@!@',
           'address' => 'sslvpn.asu.edu',
         ]);
        
        ConfigAccount::create([
           'name_university' => 'Universitas Airlangga',
           'name_config' => 'unair_1.ovpn',
           'username' => '131111058',
           'password' => 'Pejuang45!@!@',
           'address' => '210.57.216.4',
        ]);
        
        ConfigAccount::create([
           'name_university' => 'Universitas Airlangga',
           'name_config' => 'unair_2.ovpn',
           'username' => '132239147',
           'password' => '123indera456',
           'address' => '210.57.216.4',
        ]);
        
        ConfigAccount::create([
           'name_university' => 'Universitas Airlangga',
           'name_config' => 'unair_3.ovpn',
           'username' => '012111233031',
           'password' => 'imapalingcantik01',
           'address' => '210.57.216.4',
        ]);
        
        ConfigAccount::create([
           'name_university' => 'Universitas Airlangga',
           'name_config' => 'unair_4.ovpn',
           'username' => '131513143080',
           'password' => 'Yaya25082018',
           'address' => '210.57.216.4',
        ]);
    }
}

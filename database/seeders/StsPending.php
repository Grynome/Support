<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StsPending extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $multipleDataMerk = [
            ['ktgr_pending' => 'Partner'],
            ['ktgr_pending' => 'Pengiriman'],
            ['ktgr_pending' => 'User'],
            ['ktgr_pending' => 'Engineer'],
            ['ktgr_pending' => 'Part'],
            ['ktgr_pending' => 'DLL']
        ];

        DB::table('hgt_ktgr_pending')->insert($multipleDataMerk);
    }
}

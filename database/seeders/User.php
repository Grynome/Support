<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class User extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('hgt_users')->insert([
            'nik' => 'HGT-KR055',
            'full_name' => 'Bagus Sunggono',
            'username' => 'Bsunggono',
            'gender' => 'L',
            'role' => '16',
            'depart' => '5',
            'email' => 'nelson@hgt-services.com',
            'phone' => '081289687505',
            'verify' => '1',
            'verify_at' => '2023-06-15 01:35:10',
            'password' => Hash::make('Admin'),
            'terms' => 'Agree'
        ]);
    }
}

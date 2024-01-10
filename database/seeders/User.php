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
            'nik' => 'HGT-KR053',
            'full_name' => 'Franky Kumendong',
            'username' => 'franky',
            'gender' => 'L',
            'role' => '16',
            'depart' => '13',
            'email' => 'franky@hgt-services.com',
            'phone' => '08128154692',
            'verify' => '1',
            'verify_at' => '2023-06-15 01:35:10',
            'password' => Hash::make('Admin'),
            'terms' => 'Agree'
        ]);
    }
}

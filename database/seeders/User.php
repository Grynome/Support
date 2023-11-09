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
            'nik' => 'HGT-KR111',
            'full_name' => 'Master',
            'username' => 'Master',
            'gender' => 'L',
            'role' => '1',
            'depart' => '1',
            'email' => 'master@hgt-services.com',
            'verify' => '1',
            'verify_at' => '2023-06-21 16:30:12',
            'password' => Hash::make('Hagete.2023'),
            'terms' => 'Agree'
        ]);
    }
}

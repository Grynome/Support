<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Merk extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $multipleDataMerk = [
            ['merk'=>'HP','deleted'=>'0'],
            ['merk'=>'Lenovo','deleted'=>'0'],
            ['merk'=>'Acer','deleted'=>'0'],
            ['merk'=>'Dell','deleted'=>'0'],
            ['merk'=>'Epson','deleted'=>'0'],
            ['merk'=>'Fujitsu','deleted'=>'0'],
            ['merk'=>'Xerox','deleted'=>'0'],
            ['merk'=>'Infocus','deleted'=>'0']
        ];

        DB::table('hgt_merk_unit')->insert($multipleDataMerk); // Query Builder
            }
}

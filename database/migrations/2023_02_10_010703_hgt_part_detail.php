<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hgt_part_detail', function (Blueprint $table) {
            $table->id();
            $table->string('notiket', 25);
            $table->string('unit_name', 25);
            $table->string('so_num', 25);
            $table->string('awb_num', 25);
            $table->string('rma', 25);
            $table->string('pn', 25);
            $table->string('sn', 25);
            $table->integer('warranty');
            $table->integer('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hgt_part_detail');
    }
};

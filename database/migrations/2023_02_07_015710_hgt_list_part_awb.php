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
        Schema::create('hgt_list_part_awb', function (Blueprint $table) {
            $table->id();
            $table->string('notiket', 25);
            $table->string('part_id', 25);
            $table->integer('status');
            $table->string('nik', 25);
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
        Schema::dropIfExists('hgt_list_part_awb');
    }
};

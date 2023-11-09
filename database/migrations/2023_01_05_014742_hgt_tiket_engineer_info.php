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
        Schema::create('hgt_tiket_e_info', function (Blueprint $table) {
            $table->id();
            $table->string('en_info_id', 25);
            $table->string('en_id', 25);
            $table->string('notiket', 13);
            $table->dateTime('en_in');
            $table->dateTime('en_arrive');
            $table->dateTime('en_out');
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
        Schema::dropIfExists('hgt_tiket_e_info');
    }
};

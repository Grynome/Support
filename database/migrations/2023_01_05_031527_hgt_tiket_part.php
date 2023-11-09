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
        Schema::create('hgt_tiket_part', function (Blueprint $table) {
            $table->id();
            $table->string('tiket_part_id', 25);
            $table->string('notiket', 50);
            $table->integer('service_id');
            $table->integer('expedisi_id');
            $table->string('resi', 100);
            $table->dateTime('delivery_date');
            $table->dateTime('received_date');
            $table->string('part_sent', 100);
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
        Schema::dropIfExists('hgt_tiket_part');
    }
};

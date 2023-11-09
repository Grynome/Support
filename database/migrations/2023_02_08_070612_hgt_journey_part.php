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
        Schema::create('hgt_journey_part', function (Blueprint $table) {
            $table->id();
            $table->string('notiket', 25);
            $table->string('part_id', 25);
            $table->string('status', 25);
            $table->dateTime('dtime');
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
        Schema::dropIfExists('hgt_journey_part');
    }
};

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
        Schema::create('hgt_tiket_unit', function (Blueprint $table) {
            $table->id();
            $table->string('notiket', 50);
            $table->string('ctgr_unit_id', 25);
            $table->string('type_unit_id', 25);
            $table->string('unit_part_id', 25);
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
        Schema::dropIfExists('hgt_tiket_unit');
    }
};

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
        Schema::create('hgt_reqs_en_dt', function (Blueprint $table) {
            $table->id();
            $table->integer('id_dt_reqs');
            $table->integer('ctgr_reqs');
            $table->integer('nominal');
            $table->string('attach_rq', 255);
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
        Schema::dropIfExists('hgt_reqs_en_dt');
    }
};

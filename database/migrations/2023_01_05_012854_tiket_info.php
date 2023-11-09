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
        Schema::create('tiket_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tiket_info_id', 25);
            $table->string('notiket', 50);
            $table->string('solution', 100);
            $table->string('problem', 100);
            $table->string('ctgr_unit_id', 25);
            $table->string('type_unit_id', 25);
            $table->string('serial', 50);
            $table->string('keterangan', 25);
            $table->integer('warranty');
            $table->integer('void');
            $table->integer('part');
            $table->string('part_detail', 100);
            $table->string('part_ready', 25);
            $table->integer('service_id');
            $table->integer('group_id');
            $table->integer('engineer_id');
            $table->integer('status_id');
            $table->integer('lokasi_id');
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
        Schema::dropIfExists('tiket_info');
    }
};

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
        Schema::create('hgt_activity_l2engineer', function (Blueprint $table) {
            $table->id();
            $table->string('notiket', 25);
            $table->string('l2_id', 25);
            $table->integer('act_description');
            $table->text('note');
            $table->timestamp('act_time');
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->integer('visiting');
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
        Schema::dropIfExists('hgt_activity_l2engineer');
    }
};

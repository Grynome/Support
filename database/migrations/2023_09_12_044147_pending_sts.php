<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.P
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hgt_ktgr_pending', function (Blueprint $table) {
            $table->id();
            $table->text('ktgr_pending');
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
        Schema::dropIfExists('hgt_ktgr_pending');
    }
};

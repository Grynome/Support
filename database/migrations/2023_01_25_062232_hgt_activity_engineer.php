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
        Schema::create('hgt_activity_engineer', function (Blueprint $table) {
            $table->id();
            $table->string('notiket', 25);
            $table->string('en_id', 25);
            $table->string('description', 50);
            $table->datetime('time');
            $table->string('coordinate', 100);
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
        Schema::dropIfExists('hgt_project_info');
    }
};

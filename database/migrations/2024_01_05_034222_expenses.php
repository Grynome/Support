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
        Schema::create('hgt_expenses', function (Blueprint $table) {
            $table->id('id_expenses');
            $table->string('description', 255);
            $table->integer('category');
            $table->datetime('expenses_date');
            $table->integer('total');
            $table->integer('paid_by');
            $table->string('note', 255);
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
        Schema::dropIfExists('hgt_expenses');
    }
};

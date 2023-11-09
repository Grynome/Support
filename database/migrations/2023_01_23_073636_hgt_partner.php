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
        Schema::create('hgt_partner', function (Blueprint $table) {
            $table->id();
            $table->string('partner_id', 25);
            $table->string('partner', 25);
            $table->string('contact_person', 25);
            $table->string('telp', 13);
            $table->string('email', 25);
            $table->string('provinces', 25);
            $table->string('cities', 25);
            $table->string('districts', 25);
            $table->string('villages', 25);
            $table->string('address', 50);
            $table->integer('deleted');
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
        Schema::dropIfExists('hgt_partner');
    }
};

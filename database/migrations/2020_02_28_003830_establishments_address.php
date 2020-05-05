<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EstablishmentsAddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishment_address', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('establishment_id');
            $table->integer('zip_code');
            $table->string('street_name');
            $table->string('building_number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood');
            $table->unsignedInteger('city_id')->nullable();
            $table->timestamps();

            $table->foreign('establishment_id')
                ->references('id')
                ->on('establishment');

            $table->foreign('city_id')
                ->references('id')
                ->on('city');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('establishment_address');
    }
}

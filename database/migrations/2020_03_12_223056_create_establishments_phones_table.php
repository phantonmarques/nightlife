<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstablishmentsPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishments_phone', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('establishment_address_id');
            $table->unsignedInteger('establishment_id');
            $table->string('name');
            $table->string('phone_number');
            $table->boolean('whatsapp')->default(0);
            $table->boolean('favicon')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('establishment_address_id')
                ->references('id')
                ->on('establishment_address');

            $table->foreign('establishment_id')
                ->references('id')
                ->on('establishment');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('establishments_phones');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalledTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('called', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('establishment_request');
            $table->unsignedInteger('user_request');
            $table->unsignedInteger('user_attendant')->nullable();
            $table->string('title');
            $table->text('description');
            $table->string('situation');
            $table->date('data_service');
            $table->time('time_service');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->foreign('establishment_request')->references('id')->on('establishment')->onDelete('cascade');
            $table->foreign('user_request')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('user_attendant')->references('id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('called');
    }
}

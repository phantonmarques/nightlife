<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserLikedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_liked', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('establishment_id')->nullable();
            $table->unsignedInteger('event_id')->nullable();
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('establishment_id')->references('id')->on('establishment')->onDelete('cascade');
            $table->foreign('event_id')->references('id')->on('event')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_liked');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_access', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('class')->nullable();
            $table->integer('establishment_connect')->unsigned()->nullable();
            $table->string('description')->nullable();
            $table->json('content')->nullable();
            $table->dateTime('data_access');

            $table->foreign('user_id')->references('id')->on('user')->onDelete('cascade');
            $table->foreign('establishment_connect')->references('id')->on('establishment')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_accesses');
    }
}

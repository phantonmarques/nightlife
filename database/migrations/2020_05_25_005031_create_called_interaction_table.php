<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalledInteractionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('called_interaction', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->string('situation');
            $table->date('date_service')->nullable();
            $table->time('time_service')->default('00:00:00');
            $table->boolean('visible')->default(true);
            $table->unsignedInteger('called_id');
            $table->unsignedInteger('establishment_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('called_id')->references('id')->on('called')->onDelete('cascade');
            $table->foreign('establishment_id')->references('id')->on('establishment')->onDelete('cascade');
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
        Schema::dropIfExists('called_interaction');
    }
}

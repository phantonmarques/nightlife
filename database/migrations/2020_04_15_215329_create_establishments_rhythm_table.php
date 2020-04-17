<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstablishmentsRhythmTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('establishments_rhythm', function (Blueprint $table) {
            $table->unsignedInteger('establishment_id');
            $table->unsignedInteger('rhythm_id');

            $table->foreign('establishment_id')->references('id')->on('establishment')->onDelete('cascade');
            $table->foreign('rhythm_id')->references('id')->on('rhythm')->onDelete('cascade');

            $table->primary(['establishment_id','rhythm_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('establishments_rhythm');
    }
}

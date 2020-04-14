<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryMusicalRhythmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_musical_rhythms', function (Blueprint $table) {
            $table->unsignedInteger('category_id');
            $table->unsignedInteger('musical_rhythm_id');

            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
            $table->foreign('musical_rhythm_id')->references('id')->on('musical_rhythm')->onDelete('cascade');

            $table->primary(['category_id','musical_rhythm_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_musical_rhythms');
    }
}

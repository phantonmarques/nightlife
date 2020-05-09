<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRhythmStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rhythm_statistics', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('total_views_week')->default(0);
            $table->bigInteger('total_views_month')->default(0);
            $table->bigInteger('total_views_year')->default(0);
            $table->bigInteger('total_views_created')->default(0);
            $table->integer('month')->default(date('m'));
            $table->integer('year')->default(date('Y'));
            $table->unsignedInteger('rhythm_id');
            $table->timestamps();

            $table->foreign('rhythm_id')->references('id')->on('rhythm')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rhythm_statistics');
    }
}

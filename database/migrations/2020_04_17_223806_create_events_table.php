<?php

    use Illuminate\Support\Facades\Schema;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Database\Migrations\Migration;

    class CreateEventsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('event', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->date('date_event');
                $table->double('price', 10, 2);
                $table->time('start_time');
                $table->time('end_time');
                $table->string('cover_path')->unique();
                $table->longText('description');
                $table->boolean('status');
                $table->bigInteger('views')->default(0);
                $table->unsignedInteger('establishment_address_id');
                $table->unsignedInteger('establishment_id');
                $table->timestamps();

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
            Schema::dropIfExists('events');
        }
    }

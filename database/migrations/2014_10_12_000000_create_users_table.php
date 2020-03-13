<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('login');
            $table->string('password');
            $table->string('cpf_cnpj')->unique();
            $table->integer('city_id')->unsigned();
            $table->integer('state_id')->unsigned();
            $table->enum('type_user', ['a','f', 'e', 'ef', 'u']); //ADMINISTRADOR (a), funcionario (f), estabelecimento (e), estabelecimento funcionario (ef), usuário (u).
            $table->rememberToken();
            $table->timestamps();

            //FOREIGN KEYS
            $table->foreign('city_id')->references('id')->on('city');
            $table->foreign('state_id')->references('id')->on('state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}

<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->string('name');
            $table->string('username')->index();
            $table->string('email')->unique()->index();
            $table->string('role_id')->index();
            $table->string('password');
            $table->integer('max_ram')->unsigned();
            $table->integer('max_storage')->unsigned();
            $table->integer('max_cpu')->unsigned();
            $table->integer('available_ram')->unsigned();
            $table->integer('available_storage')->unsigned();
            $table->integer('available_cpu')->unsigned();
            $table->integer('user_assoc')->unsigned();
            
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('role_id')
                ->references('id')
                ->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}

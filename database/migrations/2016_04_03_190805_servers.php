<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Servers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->increments('id')->index();
            $table->integer('user_id')->unsigned()->index();
            $table->integer('sid')->index();
            $table->integer('ip');
            $table->integer('os');
            $table->integer('ram')->unsigned();
            $table->integer('storage')->unsigned();
            $table->integer('cpu')->unsigned();
            $table->json('used_ram')->nullable();
            $table->json('used_storage')->nullable();
            $table->json('used_cpu')->nullable();
            $table->string('label')->nullable();
            $table->string('name');
            $table->string('rdns')->nullable();
            $table->enum('status', [0, 1, -1])->nullable();
            $table->string('root_pass')->nullable();
            $table->integer('vnc_port')->nullable();
            $table->string('vnc_pass')->nullable();
            $table->string('mode', 6)->nullable();
            $table->longText('desc')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('servers');
    }
}

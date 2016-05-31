<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('desc');
            $table->json('data');
            $table->integer('action_code')->nullable()->index();
            $table->integer('ip');
            $table->string('status');
            $table->enum('type', [1, 2, 3, 4])->index();
            $table->integer('sid')->index()->nullable();
            $table->integer('user_id')->index()->nullable();
            $table->timestamps();

            $table->foreign('sid')
                ->references('sid')->on('servers')
                ->onDelete('cascade');

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
        Schema::drop('logs');
    }
}

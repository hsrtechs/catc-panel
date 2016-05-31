<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('link');
            $table->string('api_email');
            $table->string('api_key');
            $table->integer('total_ram');
            $table->integer('total_cpu');
            $table->integer('total_storage');
            $table->integer('used_ram');
            $table->integer('used_cpu');
            $table->integer('used_storage');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('nodes');
    }
}

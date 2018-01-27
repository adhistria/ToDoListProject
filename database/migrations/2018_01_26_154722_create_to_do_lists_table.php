<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateToDoListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('to_do_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',500);
            $table->integer('priority');
            $table->string('location',273);
            $table->timestamp('timeStart');
//            $table->integer('category_id')->unsigned();
//            $table->foreign('category_id')->references('id')->on('categories');

//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//            $table->foreign('user_id')
//                ->references('id')->on('users')
//                ->onDelete('cascade');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('to_do_lists');
    }
}

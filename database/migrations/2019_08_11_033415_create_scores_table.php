<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subcategory_id');
            $table->unsignedBigInteger('judge_id');
            $table->unsignedBigInteger('contestant_id');
            $table->integer('score')->nullable();
            $table->timestamps();
            $table->foreign('subcategory_id')->references('id')->on('subcategories')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('judge_id')->references('id')->on('judges')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('contestant_id')->references('id')->on('contestants')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('scores');
    }
}

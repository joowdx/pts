<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoresTable extends Migration {

    public function up() {
        Schema::create('scores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('judge_id')->nullable();
            $table->unsignedBigInteger('contestant_id')->nullable();
            $table->unsignedBigInteger('criterion_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->enum('type', ['raw', 'jud', 'sub', 'cat'])->default('raw');
            $table->double('score')->nullable();
            $table->double('rank')->nullable();
            $table->timestamps();
            $table->foreign('category_id')->references('id')->on('categories')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('criterion_id')->references('id')->on('criteria')
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

    public function down() {
        Schema::dropIfExists('scores');
    }
}

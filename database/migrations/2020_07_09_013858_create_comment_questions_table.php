<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_questions', function (Blueprint $table) {
            $table->bigIncrements('id_comment');
            $table->string('content');
            $table->timestamps();
            $table->unsignedBigInteger('id_question');
            $table->foreign('id_question')->references('id_question')->on('questions');
            $table->unsignedBigInteger('id');
            $table->foreign('id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_questions');
    }
}

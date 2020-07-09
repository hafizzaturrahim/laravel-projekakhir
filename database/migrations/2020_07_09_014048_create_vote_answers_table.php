<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVoteAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vote_answers', function (Blueprint $table) {
            $table->unsignedBigInteger('id_voter');
            $table->foreign('id_voter')->references('id')->on('users');
            $table->unsignedBigInteger('id_answer');
            $table->foreign('id_answer')->references('id_answer')->on('answers');
            $table->Integer('value');
            $table->unsignedBigInteger('id');
            $table->foreign('id')->references('id')->on('answers');
            $table->primary(['id_voter', 'id_answer']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vote_answers');
    }
}

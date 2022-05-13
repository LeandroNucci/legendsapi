<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersScoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_scores', function (Blueprint $table) {
         //   $table->id();

            $table->unsignedBigInteger('user_id');
            $table->integer("amount")->default(0);
            $table->integer("type")->default(0);

            $table->foreign('user_id')->references('id')->on('users');
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_scores');
    }
}

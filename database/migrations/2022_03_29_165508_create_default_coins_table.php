<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_coins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('coin_id');
            $table->integer('amount')->default(0);
            $table->boolean('enabled')->default(1);
            $table->timestamps();

            $table->foreign('coin_id')->references('id')->on('coins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('default_coins');
    }
}

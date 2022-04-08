<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacterPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_prices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('character_id');
            $table->unsignedBigInteger('coin_id');
            $table->integer('price')->default(0);
            
            $table->foreign('character_id')->references('id')->on('characters');
            $table->foreign('coin_id')->references('id')->on('coins');
       
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
        Schema::dropIfExists('character_prices');
    }
}

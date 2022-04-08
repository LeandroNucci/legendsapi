<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacterSkinsPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_skins_prices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('character_skin_id');
            $table->unsignedBigInteger('coin_id');
            $table->integer('price')->default(0);
            
            $table->foreign('character_skin_id')->references('id')->on('character_skins');
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
        Schema::dropIfExists('character_skins_prices');
    }
}

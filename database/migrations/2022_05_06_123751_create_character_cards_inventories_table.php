<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharacterCardsInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('character_cards_inventories', function (Blueprint $table) {
           // $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('character_id');
            
            $table->integer('amount')->default('0');
            
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('character_id')->references('id')->on('characters');

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
        Schema::dropIfExists('character_cards_inventories');
    }
}

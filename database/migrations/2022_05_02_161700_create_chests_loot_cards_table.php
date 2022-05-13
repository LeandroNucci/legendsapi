<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChestsLootCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chests_loot_cards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chest_id'); //Relacionamento com Chest

            $table->unsignedBigInteger('character_rarity_id'); //Relacionamento com Character Rarity
            
            $table->integer('probability')->default(100);
            $table->integer('min_drop')->default(1);
            $table->integer('max_drop')->default(10);
            $table->boolean('enabled')->default(0);
            
            $table->integer('min_different_drop')->default(1);
            $table->integer('max_different_drop')->default(1);
            
            $table->foreign('chest_id')->references('id')->on('chests');            
            $table->foreign('character_rarity_id')->references('id')->on('characters_rarity');

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
        Schema::dropIfExists('chests_loot_cards');
    }
}

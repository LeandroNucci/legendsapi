<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChestsLootCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chests_loot_coins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chest_id'); //Relacionamento com Chest
            $table->unsignedBigInteger('coin_id'); //Relacionamento com Coin
            
            $table->integer('probability')->default(100);
            $table->integer('min_drop')->default(1);
            $table->integer('max_drop')->default(10);
            $table->boolean('enabled')->default(0);
            
            $table->foreign('chest_id')->references('id')->on('chests');            
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
        Schema::dropIfExists('chests_loot_coins');
    }
}

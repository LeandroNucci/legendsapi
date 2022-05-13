<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('characters', function (Blueprint $table) {
            $table->id();

            $table->string('name', 100);
            $table->integer('min_level')->default(0);
            $table->unsignedBigInteger('character_rarity_id');
            $table->timestamps();
            
            $table->foreign('character_rarity_id')->references('id')->on('characters_rarity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('characters');
    }
}

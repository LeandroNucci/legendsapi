<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultCharactersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_characters', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->default('-');
            $table->unsignedBigInteger('character_id')->default(0);
            $table->boolean('enabled')->default(1);
            $table->timestamps();
            
            $table->foreign('character_id')->references('id')->on('characters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('default_characters');
    }
}

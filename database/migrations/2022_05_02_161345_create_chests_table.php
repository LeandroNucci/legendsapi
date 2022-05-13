<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rarity_id');
            $table->string('name', 100);
            $table->string('description', 100);
            $table->boolean('enabled')->default(0);
            $table->timestamps();
            
            $table->foreign('rarity_id')->references('id')->on('chests_rarity');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chests');
    }
}

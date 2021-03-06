<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            $table->string('nickname', 100);
            $table->string('tag', 10)->default("");
            $table->string('email')->nullable()->unique();
            $table->string('password')->nullable();
            
            $table->string('token_google')->nullable()->comment("Sera preenchido caso o usuario tenha logado pelo google");
            $table->boolean('enable')->default(true);

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}

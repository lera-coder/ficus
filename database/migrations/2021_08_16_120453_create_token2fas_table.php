<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToken2fasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('token2fas', function (Blueprint $table) {
            $table->id();
            $table->string("token")->nullable();
            $table->unsignedBigInteger('user_id');
            $table->boolean('is_confirmed')->default(false);

            $table->foreign('user_id')
                ->references('id')->on('users')->unique();

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
        Schema::dropIfExists('token2fas');
    }
}

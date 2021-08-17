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
            $table->string('name')->nullable();
            $table->string('login')->unique()->nullable();
            $table->string('password')->nullable();
            $table->boolean('is_2auth')->default(false);
            $table->unsignedBigInteger('network_id')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('network_id')
                ->references('id')->on('networks');
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

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->id();
            $table->char('phone_number', 20);
            $table->text('two_factor_options')->nullable();
            $table->boolean('is_active')->default(false);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('phone_country_code_id');


            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users');

            $table->foreign('phone_country_code_id')
            ->references('id')->on('phone_country_codes');
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phones');
    }
}

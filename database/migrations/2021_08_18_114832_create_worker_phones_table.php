<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkerPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('worker_phones', function (Blueprint $table) {
            $table->id();
            $table->string('phone_number');
            $table->string('operator')->nullable();
            $table->unsignedBigInteger('worker_id');

            $table->foreign('worker_id')
                ->references('id')->on('workers');

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
        Schema::dropIfExists('worker_phones');
    }
}

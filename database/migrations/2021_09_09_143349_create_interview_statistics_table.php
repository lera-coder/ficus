<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewStatisticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interview_statistics', function (Blueprint $table) {
            $table->id();
            $table->integer('interviews_all_time')->nullable();
            $table->integer('interviews_month')->nullable();
            $table->integer('interviews_week')->nullable();
            $table->integer('interviews_today')->nullable();
            $table->integer('interviews_tomorrow')->nullable();
            $table->integer('interviews_in_week')->nullable();
            $table->integer('interviews_in_month')->nullable();
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
        Schema::dropIfExists('interview_statistics');
    }
}

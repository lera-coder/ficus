<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->text('link')->nullable();
            $table->timestamp('interview_time')->nullable();
            $table->timestamp('sending_time')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unsignedBigInteger('interviewer_id');
            $table->unsignedBigInteger('status_id');

            $table->foreign('interviewer_id')
                ->references('id')->on('users');
            $table->foreign('status_id')
                ->references('id')->on('interview_statuses');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('interviews');
    }
}

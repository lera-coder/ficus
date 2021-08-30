<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicantsInterviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applicants_interviews', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('interview_id');
            $table->unsignedBigInteger('applicant_id');

            $table->foreign('interview_id')
                ->references('id')->on('interviews');
            $table->foreign('applicant_id')
                ->references('id')->on('applicants');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applicants_interviews');
    }
}

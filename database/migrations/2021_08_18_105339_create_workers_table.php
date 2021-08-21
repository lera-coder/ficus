<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('status_id')->default(1);
            $table->unsignedBigInteger('position_id')->nullable();

            $table->foreign('company_id')
                ->references('id')->on('companies');

            $table->foreign('status_id')
                ->references('id')->on('worker_statuses');

            $table->foreign('position_id')
                ->references('id')->on('worker_positions');

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
        Schema::dropIfExists('workers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowledgeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('knowledge', function (Blueprint $table) {
            $table->id();
            $table->year('year_start');
            $table->text('description')->nullable();
            $table->morphs('knowledgable');

            $table->unsignedBigInteger('technology_id')->nullable();
            $table->unsignedBigInteger('level_id')->nullable();

            $table->foreign('technology_id')
                ->references('id')->on('technologies');
            $table->foreign('level_id')
                ->references('id')->on('levels');

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
        Schema::dropIfExists('knowledge');
    }
}

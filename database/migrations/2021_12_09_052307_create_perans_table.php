<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('film_id');
            $table->foreign('film_id')->references('id')->on('films');
            $table->uuid('cast_id');
            $table->foreign('cast_id')->references('id')->on('casts');
            $table->string('name', 45);
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
        Schema::dropIfExists('perans');
    }
}

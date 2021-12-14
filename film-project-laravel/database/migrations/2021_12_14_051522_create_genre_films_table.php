<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGenreFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('genre_films', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('genre_id');
            $table->foreign('genre_id')->references('id')->on('genres');
            $table->uuid('film_id');
            $table->foreign('film_id')->references('id')->on('films');
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
        Schema::dropIfExists('genre_films');
    }
}

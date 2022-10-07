<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->text('title');
            $table->integer('pages');
            $table->text('language');
            $table->date('publication_date');
            $table->float('price');
            $table->string('image')->nullable();

            $table->unsignedBigInteger('author_id');
            $table->foreign('author_id')->references('id')->on('authors');

            $table->unsignedBigInteger('genre_id');
            $table->foreign('genre_id')->references('id')->on('genres');

            $table->unsignedBigInteger('publisher_id');
            $table->foreign('publisher_id')->references('id')->on('publishers');

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
        Schema::dropIfExists('books');
    }
};

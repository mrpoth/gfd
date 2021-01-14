<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVideogamesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create("videogames", function (Blueprint $table) {
      $table->id();
      $table->text("name");
      $table->text("slug");
      $table->text("cover_url")->nullable();
      $table
        ->unsignedBigInteger("igdb_id")
        ->index()
        ->nullable();
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
    Schema::dropIfExists("videogames");
  }
}

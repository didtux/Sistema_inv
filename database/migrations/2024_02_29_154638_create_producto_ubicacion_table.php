<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductoUbicacionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
  // producto_ubicacion migration file
  public function up()
  {
      Schema::create('producto_ubicacion', function (Blueprint $table) {
          $table->id();
          $table->foreignId('producto_id')->constrained();
          $table->unsignedBigInteger('ubicacion_id'); // Change to unsignedBigInteger
          $table->foreign('ubicacion_id')->references('id')->on('ubicaciones')->onDelete('cascade');
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
        Schema::dropIfExists('producto_ubicacion');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   // productos migration file
public function up()
{
    Schema::create('productos', function (Blueprint $table) {
        $table->id();
        $table->string('nombre');
        $table->string('codigo1');
        $table->string('codigo2')->nullable();
        $table->string('descripcion');
        $table->decimal('precio1', 10, 2);
        $table->decimal('precio2', 10, 2)->nullable();
        $table->string('marca');
        $table->string('foto');
        $table->integer('cantidad');
        $table->enum('estado', ['activo', 'inactivo'])->default('activo');
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
        Schema::dropIfExists('productos');
    }
}

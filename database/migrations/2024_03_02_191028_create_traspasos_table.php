<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraspasosTable extends Migration
{
    public function up()
    {
        Schema::create('traspasos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('producto_id');
            $table->unsignedBigInteger('ubicacion_origen_id');
            $table->unsignedBigInteger('ubicacion_destino_id');
            $table->integer('cantidad');
            $table->date('fecha');
            $table->enum('estado', ['enviado', 'recibido'])->default('enviado');
            $table->timestamps();
    
            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->foreign('ubicacion_origen_id')->references('id')->on('ubicaciones')->onDelete('cascade');
            $table->foreign('ubicacion_destino_id')->references('id')->on('ubicaciones')->onDelete('cascade');
        });
    }
    
    

    public function down()
    {
        Schema::dropIfExists('traspasos');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVentasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('producto_id');
            $table->foreignId('ubicacion_id')->constrained('ubicaciones')->onDelete('cascade'); // Cambiado a ubicacion_id
            $table->integer('cantidad');
            $table->date('fecha');
            $table->time('hora');
            $table->decimal('precio', 8, 2); // Precio unitario
            $table->decimal('precio_total', 8, 2);
            $table->timestamps();

            $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventas');
    }
}

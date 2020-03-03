<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCantidadInsumosAlmacenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cantidad_insumos_almacen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('almacen_id');
            $table->integer('insumo_id');
            $table->bigInteger('stock');
            $table->integer('creada_por');
            $table->integer('estado_id');
            $table->char('activo', 1);
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
        Schema::dropIfExists('cantidad_insumos_almacen');
    }
}

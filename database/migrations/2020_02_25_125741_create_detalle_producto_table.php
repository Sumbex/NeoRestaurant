<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleProductoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_producto', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('producto_id');
            $table->integer('insumo_id');
            $table->integer('cantidad');
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
        Schema::dropIfExists('detalle_producto');
    }
}

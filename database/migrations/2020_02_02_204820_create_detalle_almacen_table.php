<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleAlmacenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_almacen', function (Blueprint $table) {
            $table->bigIncrements('id');
            /* $table->integer('almacen_id'); */
            $table->integer('compra_detalle_almacen_id');
            $table->integer('insumo_id');
            /* $table->integer('proveedor_id'); */
            $table->integer('cantidad');
            $table->integer('precio_compra');
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
        Schema::dropIfExists('detalle_almacen');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompraDetalleAlmacenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra_detalle_almacen', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('almacen_id');
            $table->integer('proveedor_id');
            $table->integer('anio_id');
            $table->integer('mes_id');
            $table->integer('dia');
            $table->string('numero_comprobante');
            $table->text('archivo');
            $table->integer('total');
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
        Schema::dropIfExists('compra_detalle_almacen');
    }
}

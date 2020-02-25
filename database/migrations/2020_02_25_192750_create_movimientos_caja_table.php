<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientosCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos_caja', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('caja_id');
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_cierre')->nullable();
            $table->bigInteger('monto_inicio')->nullable();
            $table->bigInteger('monto_cierre')->nullable();
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
        Schema::dropIfExists('movimientos_caja');
    }
}

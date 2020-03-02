<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class DetallePedidos extends Model
{
    protected $table = "detalle_pedido";

    /* $table->integer('pedido_id');
            $table->integer('producto_id');
            $table->integer('cantidad');
            $table->bigInteger('precio');
            $table->integer('creada_por');
            $table->integer('estado_id');
            $table->char('activo', 1); */

    protected function ingresarDetallePedido($pedido_id, $pedidos)
    {
        $count = 0;
        DB::beginTransaction();
        foreach ($pedidos as $key) {
            $detalle = new DetallePedidos;
            $detalle->pedido_id = $pedido_id;
            $detalle->producto_id = $key['id_producto'];
            $detalle->cantidad = $key['cantidad'];
            $detalle->precio = $key['cantidad'];
            $detalle->creada_por = Auth::user()->id;
            $detalle->estado_id = 1;
            $detalle->activo = 'S';
            if ($detalle->save()) {
                $count++;
            }
        }
        if (count($pedidos) == $count) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }
    }
}

<?php

namespace App;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class DetallePedidos extends Model
{
    protected $table = "detalle_pedido";

    protected function ingresarDetallePedido($pedido_id, $pedidos)
    {
        $count = 0;
        DB::beginTransaction();
        foreach ($pedidos as $key) {
            $detalle = new DetallePedidos;
            $detalle->pedido_id = $pedido_id;
            $detalle->producto_id = $key['id_producto'];
            $detalle->cantidad = $key['cantidad'];
            $detalle->precio = $key['precio'];
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

    protected function actualizarDetallePedido($pedido_id, $pedidos)
    {
        $count = 0;
        DB::beginTransaction();
        foreach ($pedidos as $key) {
            if (Arr::has($key, 'id')) {
                $detalle = DetallePedidos::find($key['id']);
                $detalle->cantidad = $key['cantidad'];
                $detalle->precio = $key['precio'];
                if ($detalle->save()) {
                    $count++;
                }
            } else {
                $ingresar = new DetallePedidos;
                $ingresar->pedido_id = $pedido_id;
                $ingresar->producto_id = $key['id_producto'];
                $ingresar->cantidad = $key['cantidad'];
                $ingresar->precio = $key['precio'];
                $ingresar->creada_por = Auth::user()->id;
                $ingresar->estado_id = 1;
                $ingresar->activo = 'S';
                if ($ingresar->save()) {
                    $count++;
                }
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

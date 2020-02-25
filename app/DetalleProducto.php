<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class DetalleProducto extends Model
{
    protected $table = "detalle_producto";

    protected function ingresarDetalleProducto($carro, $prod_id)
    {
        $count = 0;
        DB::beginTransaction();
        foreach ($carro as $key) {
            $detalle = new DetalleProducto;
            $detalle->producto_id = $prod_id;
            $detalle->insumo_id = $key['insumo_id'];
            $detalle->cantidad = $key['cantidad'];
            $detalle->creada_por = Auth::user()->id;
            $detalle->estado_id = 1;
            $detalle->activo = 'S';
            if ($detalle->save()) {
                $count++;
            }
        }
        if (count($carro) == $count) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }
    }
}

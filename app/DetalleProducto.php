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

    protected function traerDetalleProducto($producto_id)
    {
        $detalle = DB::table('detalle_producto as dp')
            ->select([
                'dp.id',
                'i.insumo',
                'dp.cantidad',
                'i.unidad_id'
            ])
            ->join('insumos as i', 'i.id', 'dp.insumo_id')
            ->where([
                'dp.activo' => 'S',
                'dp.producto_id' => $producto_id
            ])
            ->get();
        if (!$detalle->isEmpty()) {

            return ['estado' => 'success', 'detalle' => $detalle];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentra el detalle del producto creado.'];
        }
    }
}

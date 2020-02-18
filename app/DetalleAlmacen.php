<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class DetalleAlmacen extends Model
{
    protected $table = "detalle_almacen";

    protected function traerAlmacenes()
    {
        $almacenes = DB::table('almacen as a')
            ->select([
                'a.id',
                's.sucursal'
            ])
            ->join('sucursal as s', 's.id', 'a.sucursal_id')
            ->where([
                'a.activo' => 'S',

            ])
            ->get();
        /* dd(count($almacenes)); */

        if (!$almacenes->isEmpty()) {
            return ['estado' => 'success', 'almacenes' => $almacenes, 'cantidad' => count($almacenes)];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran almacenes creados.'];
        }
    }

    protected function traerProveedores()
    {
        $proveedores = DB::table('proveedores')
            ->select([
                'id',
                'razon_social as razon'
            ])
            ->where([
                'activo' => 'S'
            ])
            ->get();

        if (!$proveedores->isEmpty()) {
            return ['estado' => 'success', 'proveedores' => $proveedores];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran proveedores creados.'];
        }
    }

    protected function traerInsumos()
    {
        $insumos = DB::table('insumos as i')
            ->select([
                'i.id',
                'i.insumo',
                'i.unidad_id',
                'ci.insumo as categoria',
                'i.medida_id',
                'i.cantidad',
                'i.precio_compra as precio'
            ])
            ->join('categoria_insumos as ci', 'ci.id', 'i.categoria_id')
            ->where([
                'i.activo' => 'S'
            ])
            ->get();
        if (!$insumos->isEmpty()) {
            return ['estado' => 'success', 'insumos' => $insumos];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran insumos creados.'];
        }
    }

    
}

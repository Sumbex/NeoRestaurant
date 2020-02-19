<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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

    protected function ingresarDetalleAlmacen($carro, $cda_id)
    {
        $count = 0;
        DB::beginTransaction();
        for ($i = 0; $i < count($carro); $i++) {
            $detalle = new DetalleAlmacen;
            $detalle->compra_detalle_almacen_id = $cda_id;
            $detalle->insumo_id = $carro[$i]['insumo_id'];
            $detalle->cantidad = $carro[$i]['cantidad'];
            $detalle->precio_compra = $carro[$i]['precio'];
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

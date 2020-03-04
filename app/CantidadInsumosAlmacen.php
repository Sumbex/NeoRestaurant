<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class CantidadInsumosAlmacen extends Model
{
    protected $table = "cantidad_insumos_almacen";

    protected function agregarStockInsumo($almacen, $insumos)
    {
        $count = 0;
        foreach ($insumos as $key) {
            $verificar = DB::table('cantidad_insumos_almacen')
                ->where([
                    'activo' => 'S',
                    'almacen_id' => $almacen,
                    'insumo_id' => $key['insumo_id']
                ])
                ->first();

            $insumo = DB::table('insumos')
                ->select([
                    'id',
                    'cantidad'
                ])
                ->where([
                    'activo' => 'S',
                    'id' => $key['insumo_id']
                ])
                ->first();

            if (!is_null($verificar)) {
                $actualizar = CantidadInsumosAlmacen::find($verificar->id);
                $actualizar->stock = $verificar->stock + ($key['cantidad'] * $insumo->cantidad);
                if ($actualizar->save()) {
                    DB::commit();
                    $count++;
                }
            } else {
                $cantidad = $key['cantidad'] * $insumo->cantidad;

                DB::beginTransaction();
                $stock = new CantidadInsumosAlmacen;
                $stock->almacen_id = $almacen;
                $stock->insumo_id = $key['insumo_id'];
                $stock->stock = $cantidad;
                $stock->creada_por = Auth::user()->id;
                $stock->estado_id = 1;
                $stock->activo = 'S';
                if ($stock->save()) {
                    DB::commit();
                    $count++;
                }
            }
        }

        if (count($insumos) == $count) {
            return true;
        } else {
            DB::rollBack();
            return false;
        }
    }
}

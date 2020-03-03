<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class CantidadInsumosAlmacen extends Model
{
    protected $table = "cantidad_insumos_almacen";
    /* $table->integer('almacen_id ');
            $table->integer('insumo_id');
            $table->bigInteger('stock');
            $table->integer('creada_por');
            $table->integer('estado_id');
            $table->char('activo', 1); */
    protected function agregarStockInsumo($almacen, $insumos)
    {
        /* dd($insumos); */
        $count = 0;
        foreach ($insumos as $key) {
            DB::beginTransaction();
            $insumo = DB::table('insumos')
                ->select([
                    'id',
                    'cantidad'
                ])
                ->where([
                    'activo' => 'S',
                    'id' => $key['insumo_id']
                ])
                ->get();


            $verificar = DB::table('cantidad_insumos_almacen')
                ->where([
                    'activo' => 'S',
                    'almacen_id' => $almacen,
                    'insumo_id' => $key['insumo_id']
                ])
                ->first();

            if (!is_null($verificar)) {
                $verificar->stock = $verificar->stock + ($key['cantidad'] * $insumo[0]->cantidad);
                if ($verificar->save()) {
                    $count++;
                }
            } else {
                $cantidad = $key['cantidad'] * $insumo[0]->cantidad;

                $stock = new CantidadInsumosAlmacen;
                $stock->almacen_id = $almacen;
                $stock->insumo_id = $key['insumo_id'];
                $stock->stock = $cantidad;
                $stock->creada_por = Auth::user()->id;
                $stock->estado_id = 2;
                $stock->activo = 'S';
                if ($stock->save()) {
                    $count++;
                }
            }
        }

       /*  dd(count($insumos) == $count); */
        if (count($insumos) == $count) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }
    }
}

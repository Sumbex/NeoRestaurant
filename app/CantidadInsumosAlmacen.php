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

    protected function verificarStockProducto($request)
    {
        $insumos = DB::table('productos as p')
            ->select([
                'dp.insumo_id',
                'dp.cantidad'
            ])
            ->join('detalle_producto as dp', 'dp.producto_id', 'p.id')
            ->join('almacen as a', 'a.id', 'p.almacen_id')
            ->where([
                'p.activo' => 'S',
                'p.id' => $request->producto['id'],
                'a.sucursal_id' => $request->sucursal
            ])
            ->get();

        $stock = DB::table('productos as p')
            ->select([
                'cia.insumo_id',
                'cia.stock'
            ])
            ->join('detalle_producto as dp', 'dp.producto_id', 'p.id')
            ->join('cantidad_insumos_almacen as cia', 'cia.insumo_id', 'dp.insumo_id')
            ->join('almacen as a', 'a.id', 'p.almacen_id')
            ->where([
                'p.activo' => 'S',
                'p.id' => $request->producto['id'],
                'a.sucursal_id' => $request->sucursal
            ])
            ->get();

        if (count($insumos) != count($stock)) {
            return ['estado' => 'failed', 'mensaje' => 'Producto sin stock.'];
        } else {
            $count = 0;
            $resta = 0;
            for ($i = 0; $i < count($insumos); $i++) {
                for ($e = 0; $e < count($stock); $e++) {
                    if ($stock[$e]->insumo_id == $insumos[$i]->insumo_id) {
                        $resta = $stock[$e]->stock - $insumos[$i]->cantidad;
                        if ($resta > 0) {
                            $count++;
                        }
                    }
                }
            }
            if (count($stock) == $count) {
                return ['estado' => 'success', 'mensaje' => 'Producto con stock'];
            } else {
                return ['estado' => 'failed', 'mensaje' => 'Producto sin stock.'];
            }
        }
    }
}

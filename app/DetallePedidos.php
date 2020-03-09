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

    protected function verficarStockProducto($sucursal, $producto)
    {
        //produto sucursal
        $insumos = DB::table('productos as p')
            ->select([
                'dp.insumo_id',
                'dp.cantidad'
            ])
            ->join('detalle_producto as dp', 'dp.producto_id', 'p.id')
            ->join('almacen as a', 'a.id', 'p.almacen_id')
            ->where([
                'p.activo' => 'S',
                'p.id' => $producto['id'],
                'a.sucursal_id' => $sucursal
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
                'p.id' => $producto['id'],
                'a.sucursal_id' => $sucursal
            ])
            ->get();

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
    }
    /* protected function verificarStockProducto($request)
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
    } */
}

<?php

namespace App;

use App\DetallePedidos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Pedidos extends Model
{
    protected $table = "pedido";

    protected function fechaActual()
    {
        $hora = DB::select("select now() as fecha");
        return $hora[0]->fecha;
    }

    protected function ingresarActualizarPedido($request)
    {
        //hacer la modificacion traer los datos del pedido, 
        //las mesas de mesapedido restar del stock verificar nuevamente si es que hay  stock al ingresar un pedido
        /* dd($request->all()); */

        $fecha = $this->fechaActual();
        if ($request->update == true) {
            DB::beginTransaction();
            $update = Pedidos::find($request->id);
            $update->total = $request->total;
            if ($update->save()) {
                $updDetalle = DetallePedidos::actualizarDetallePedido($request->id, $request->pedidos);
                if ($updDetalle == true) {
                    $updMesas = MesaPedido::actualizarMesa($request->id, $request->mesas, $request->mesas_borrar);
                    if ($updMesas == true) {
                        DB::commit();
                        return ['estado' => 'success', 'mensaje' => 'Pedido actualizado Correctamente.'];
                    } else {
                        DB::rollBack();
                        return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente 1.'];
                    }
                } else {
                    DB::rollBack();
                    return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente 2.'];
                }
            } else {
                DB::rollBack();
                return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente 3.'];
            }
        } else {
            DB::beginTransaction();
            $pedido = new Pedidos;
            $pedido->hora_pedido = $fecha;
            $pedido->total = $request->total;
            $pedido->creada_por = Auth::user()->id;
            $pedido->estado_id = 1;
            $pedido->activo = 'S';
            if ($pedido->save()) {
                $detalle = DetallePedidos::ingresarDetallePedido($pedido->id, $request->pedidos);
                if ($detalle == true) {
                    $mesas = MesaPedido::ingresarMesas($pedido->id, $request->mesas);
                    if ($mesas == true) {
                        $estadoMesa = Mesas::cambiarEstadoMesas($request->mesas);
                        if ($estadoMesa == true) {
                            DB::commit();
                            return ['estado' => 'success', 'mensaje' => 'Pedido realizado Correctamente.'];
                        }
                    } else {
                        DB::rollBack();
                        return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
                    }
                } else {
                    DB::rollBack();
                    return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
                }
            } else {
                DB::rollBack();
                return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
            }
        }
    }

    protected function traerPedido($sucursal, $mesa)
    {
        $pedido = DB::table('mesa_pedido as mp')
            ->select([
                'dp.id',
                'dp.pedido_id',
                'pr.id as producto_id',
                'pr.producto',
                'dp.cantidad',
                'pr.precio_venta',
                DB::raw("SUM(dp.cantidad*pr.precio_venta)as subtotal")
            ])
            ->join('pedido as p', 'p.id', 'mp.pedido_id')
            ->join('detalle_pedido as dp', 'dp.pedido_id', 'p.id')
            ->join('productos as pr', 'pr.id', 'dp.producto_id')
            ->join('almacen as a', 'a.id', 'pr.almacen_id')
            ->where([
                'p.activo' => 'S',
                'mp.mesa_id' => $mesa,
                'a.sucursal_id' => $sucursal
            ])
            ->groupBy('pr.producto', 'dp.cantidad', 'dp.precio', 'pr.id', 'dp.id')
            ->get();

        if (!$pedido->isEmpty()) {
            $datos = $this->traerDatosPedidos($pedido[0]->pedido_id);
            if ($datos['estado'] == 'success') {
                $mesas = $this->traerMesasPedido($pedido[0]->pedido_id);
                if ($mesas['estado'] == 'success') {
                    return ['estado' => 'success', 'datos' => $datos['datos'],  'mesas' => $mesas['mesas'], 'mesas_pedido' => $mesas['mesa_pedido'], 'pedido' => $pedido];
                } else {
                    return ['estado' => 'failed', 'mensaje' => 'No se encuentra el pedido.'];
                }
            } else {
                return ['estado' => 'failed', 'mensaje' => 'No se encuentra el pedido.'];
            }
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentra el pedido.'];
        }
    }

    protected function traerDatosPedidos($pedido)
    {
        $datos = DB::table('pedido as p')
            ->select([
                'p.id',
                'p.hora_pedido',
                'ep.descripcion as estado'
            ])
            ->join('estado_pedidos as ep', 'ep.id', 'p.estado_id')
            ->where([
                'p.activo' => 'S',
                'p.id' => $pedido
            ])
            ->first();
        if (!is_null($datos)) {
            return ['estado' => 'success', 'datos' => $datos];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran los datos.'];
        }
    }

    protected function traerMesasPedido($pedido)
    {
        /* select m.mesa from mesa_pedido as mp
inner join mesas as m on m.id = mp.mesa_id
where mp.pedido_id = 12 */
        $mesas = DB::table('mesa_pedido as mp')
            ->select([
                'm.id',
                'm.mesa'
            ])
            ->join('mesas as m', 'm.id', 'mp.mesa_id')
            ->where([
                'mp.pedido_id' => $pedido
            ])
            ->get();
        if (!$mesas->isEmpty()) {
            $mesa = '';
            foreach ($mesas as $key) {
                if ($mesa == '') {
                    $mesa = $key->mesa;
                } else {
                    if (count($mesas) > 2) {
                        $mesa = $mesa . ', ' . $key->mesa;
                    } else {
                        $mesa = $mesa . ' y ' . $key->mesa;
                    }
                }
            }
            return ['estado' => 'success', 'mesas' => $mesa, 'mesa_pedido' => $mesas];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran las mesas.'];
        }
    }
}

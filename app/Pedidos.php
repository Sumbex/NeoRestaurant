<?php

namespace App;

use App\DetallePedidos;
use Mike42\Escpos\Printer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;


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
        /* dd($request->all()); */
        $prod = array();
        $fecha = $this->fechaActual();
        foreach ($request->pedidos as $key) {
            $stock = CantidadInsumosAlmacen::verificarStockVenta($request->sucursal_id, $key);
            if ($stock['estado'] == 'failed') {
                $prod[] = $stock['producto'];
            }
        }
        if (empty($prod)) {
            /* return 'todo bien'; */
            if ($request->update == true) {
                /* return 'restar stock al update'; */
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
                /* return 'restar stock al ingreso'; */
                DB::beginTransaction();
                $pedido = new Pedidos;
                $pedido->sucursal_id = $request->sucursal_id;
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
                            return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente 2.'];
                        }
                    } else {
                        DB::rollBack();
                        return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente 3.'];
                    }
                } else {
                    DB::rollBack();
                    return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente 4.'];
                }
            }
        } else {
            $mensaje = '';
            foreach ($prod as $key) {
                if ($mensaje == '') {
                    $mensaje = $key;
                } else {
                    if (count($prod) > 2) {
                        $mensaje = $mensaje . ', ' . $key;
                    } else {
                        $mensaje = $mensaje . ' y ' . $key;
                    }
                }
            }
            if (count($prod) < 2) {
                return ['estado' => 'failed_prod',  'mensaje' => 'El siguiente producto se encuentra sin stock: ' . $mensaje];
            } else {
                return ['estado' => 'failed_prod', 'mensaje' => 'Los siguientes productos se encuentran sin stock: ' . $mensaje];
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
                'mp.activo' => 'S',
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
                    $test = $this->imprimirTicket();
                    dd($test);
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
        $mesas = DB::table('mesa_pedido as mp')
            ->select([
                'm.id',
                'm.mesa'
            ])
            ->join('mesas as m', 'm.id', 'mp.mesa_id')
            ->where([
                'mp.activo' => 'S',
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

    protected function imprimirTicket(/* $datos, $pedido */)
    {
        $nombreImpresora = "POS-58";
        $connector = new WindowsPrintConnector($nombreImpresora);
        $impresora = new Printer($connector);
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->setTextSize(2, 2);
        $impresora->text("Imprimiendo\n");
        $impresora->text("ticket\n");
        $impresora->text("desde\n");
        $impresora->text("Laravel\n");
        $impresora->setTextSize(1, 1);
        $impresora->text("https://restobar.neofox.cl");
        $impresora->feed(5);
        $impresora->close();
    }
}

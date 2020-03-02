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

    protected function ingresarPedido($request)
    {
        /* dd($request->all()); */
        /* $test = CompraDetalleAlmacen::verificarStock($request->pedidos);
        dd($test); */
        $fecha = $this->fechaActual();
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

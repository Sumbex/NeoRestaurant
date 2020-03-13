<?php

namespace App;

use App\PagosVentas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Ventas extends Model

{
    /*      $table->integer('pedido_id');
            $table->integer('total');
            $table->integer('creada_por');
            $table->integer('estado_id');
            $table->char('activo', 1); */
    protected $table = "ventas";

    protected function ingresarVenta($request)
    {
        DB::beginTransaction();
        $venta = new Ventas;
        $venta->pedido_id = $request->pedido_id;
        $venta->total = $request->total;
        $venta->creada_por = Auth::user()->id;;
        $venta->estado_id = 1;
        $venta->activo = 'S';
        if ($venta->save()) {
            $pagos = PagosVentas::ingresarPagos($venta->id, $request->pagos);
            if ($pagos == true) {
                $propina = Propinas::ingresarPropina($venta->id, $request->user, $request->propina);
                if ($propina == true) {
                    DB::commit();
                    return ['estado' => 'success', 'mensaje' => 'Sucursal creada Correctamente.'];
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

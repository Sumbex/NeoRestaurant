<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class PagosVentas extends Model
{
    protected $table = "pagos_venta";

    /* $table->integer('venta_id');
    $table->integer('tipo_pago_id');
    $table->integer('monto');
    $table->integer('creada_por');
    $table->integer('estado_id');
    $table->char('activo', 1); */

    protected function ingresarPagos($venta_id, $pagos)
    {
        $count = 0;
        DB::beginTransaction();
        foreach ($pagos as $key) {
            $pago = new PagosVentas;
            $pago->venta_id = $venta_id;
            $pago->tipo_pago_id = $key['tipo'];
            $pago->monto = $key['monto'];
            $pago->creada_por = Auth::user()->id;;
            $pago->estado_id = 1;
            $pago->activo = 'S';
            if ($pago->save()) {
                $count++;
            }
        }
        if (count($pago) == $count) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }
    }
}

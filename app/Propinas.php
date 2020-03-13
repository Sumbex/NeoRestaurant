<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Propinas extends Model
{
    protected $table = "propinas";

    /* $table->integer('user_id');
            $table->integer('monto');
            $table->integer('creada_por');
            $table->integer('estado_id');
            $table->char('activo', 1); */
    protected function ingresarPropina($venta, $user, $propina)
    {
        DB::beginTransaction();
        $propina = new Propinas;
        $propina->venta_id = $venta;
        $propina->user_id = $user;
        $propina->monto = $propina;
        $propina->creada_por = Auth::user()->id;;
        $propina->estado_id = 1;
        $propina->activo = 'S';
        if ($propina->save()) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }
    }
}

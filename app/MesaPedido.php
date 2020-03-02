<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class MesaPedido extends Model
{
    protected $table = "mesa_pedido";

    /* $table->integer('mesa_id');
            $table->integer('pedido_id');
            $table->integer('creada_por');
            $table->integer('estado_id'); */

    protected function ingresarMesas($pedido_id, $mesas)
    {
        $count = 0;
        DB::beginTransaction();
        foreach ($mesas as $key) {
            $mesa = new MesaPedido;
            $mesa->mesa_id = $key['id'];
            $mesa->pedido_id = $pedido_id;
            $mesa->creada_por = Auth::user()->id;
            $mesa->estado_id = 1;
            $mesa->activo = 'S';
            if ($mesa->save()) {
                $count++;
            }
        }
        if (count($mesas) == $count) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }
    }
}

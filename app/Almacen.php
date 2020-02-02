<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    protected $table = "almacen";

    protected function crearAlmacen($sucursal_id)
    {
        DB::beginTransaction();
        $almacen = new Almacen;
        $almacen->sucursal_id = $sucursal_id;
        $almacen->creada_por = Auth::user()->id;
        $almacen->estado_id = 1;
        $almacen->activo = 'S';
        if ($almacen->save()) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
        }
    }
}

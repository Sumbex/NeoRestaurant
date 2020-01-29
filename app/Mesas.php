<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Mesas extends Model
{
    protected $table = "mesas";

    protected function traerSucursales(){
        $sucursales = DB::table('sucursal')
        ->select([
            'id',
            'sucursal as descripcion',
        ])
        ->where([
            'activo' => 'S'
        ])
        ->get();

        if(!$sucursales->isEmpty()){
            return ['estado' => 'success', 'sucursales' => $sucursales];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran sucursales creadas.'];
        }
    }
}

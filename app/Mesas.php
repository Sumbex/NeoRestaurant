<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Mesas extends Model
{
    protected $table = "mesas";

    protected function traerSucursales()
    {
        $sucursales = DB::table('sucursal')
            ->select([
                'id',
                'sucursal as descripcion',
            ])
            ->where([
                'activo' => 'S'
            ])
            ->get();

        if (!$sucursales->isEmpty()) {
            return ['estado' => 'success', 'sucursales' => $sucursales];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran sucursales creadas.'];
        }
    }

    protected function ingresarMesas($request)
    {
        //radio = estado
        if ($request->estado == true) {
            $mesas = new Mesas;
            $mesas->mesa = $request->mesa;
            $mesas->sucursal_id = $request->sucursal;
            $mesas->zona_id = $request->zona;
            $mesas->creada_por = Auth::user()->id;
            $mesas->estado_id = 1;
            $mesas->activo = 'S';
            if ($mesas->save()) {
                return ['estado' => 'success', 'mensaje' => 'Mesa creada Correctamente.'];
            } else {
                return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
            }
        } else {
            //
        }
    }
}

<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Zonas extends Model
{
    protected $table = "zonas";

    protected function traerZonas()
    {
        $zonas = DB::table('zonas')
            ->select([
                'id',
                'zona',
            ])
            ->where([
                'activo' => 'S'
            ])
            ->get();

        if (!$zonas->isEmpty()) {
            return ['estado' => 'success', 'zonas' => $zonas];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran zonas creadas.'];
        }
    }

    protected function ingresarZona($request)
    {
        $zona = new Zonas;
        $zona->zona = $request->zona;
        $zona->creada_por = Auth::user()->id;
        $zona->estado_id = 1;
        $zona->activo = 'S';
        if ($zona->save()) {
            return ['estado' => 'success', 'mensaje' => 'Zona creada Correctamente.'];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
        }
    }
}

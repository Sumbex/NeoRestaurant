<?php

namespace App;

use Carbon\Carbon;
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

    protected function traerZonasModal()
    {
        $zonas = DB::table('zonas as z')
            ->select([
                'z.id',
                'z.zona',
                'u.nombre',
                'z.created_at'
            ])
            ->join('users as u', 'u.id', 'z.creada_por')
            ->where([
                'z.activo' => 'S'
            ])
            ->orderBy('z.created_at', 'desc')
            ->get();

        if (!$zonas->isEmpty()) {
            Carbon::setLocale('es');
            foreach ($zonas as $key) {
                $fecha = ucwords(Carbon::parse($key->created_at)->diffForHumans());
                $key->created_at = $fecha;
            }
            return ['estado' => 'success', 'zonas' => $zonas];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran zonas creadas.'];
        }
    }
}

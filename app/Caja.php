<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = "caja";

    protected function ingresarCaja($sucursal_id)
    {
        DB::beginTransaction();
        $caja = new Caja;
        $caja->sucursal_id = $sucursal_id;
        $caja->nombre = 'Caja Principal';
        $caja->monto = 0;
        $caja->creada_por = Auth::user()->id;
        $caja->estado_id = 2;
        $caja->activo = 'S';
        if ($caja->save()) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
        }
    }

    protected function crearCaja($request)
    {
        $caja = new Caja;
        $caja->sucursal_id = $request->id;
        $caja->nombre = $request->caja;
        $caja->monto = 0;
        $caja->creada_por = Auth::user()->id;
        $caja->estado_id = 2;
        $caja->activo = 'S';
        if ($caja->save()) {
            return ['estado' => 'success', 'mensaje' => 'Caja creada Correctamente.'];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
        }
    }

    protected function traerCajas()
    {
        $cajas = DB::table('caja as c')
            ->select([
                'c.id',
                'c.sucursal_id',
                'c.nombre as caja',
                'c.created_at',
                'u.nombre',
                'ec.descripcion as estado',
                'c.estado_id'
            ])
            ->join('users as u', 'u.id', 'c.creada_por')
            ->join('estados_caja as ec', 'ec.id', 'c.estado_id')
            ->where([
                'c.activo' => 'S',
            ])
            ->get();
        if (!$cajas->isEmpty()) {
            Carbon::setLocale('es');
            foreach ($cajas as $key) {
                $fecha = ucwords(Carbon::parse($key->created_at)->diffForHumans());
                $key->created_at = $fecha;
            }
            return ['estado' => 'success', 'cajas' => $cajas];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran cajas creadas.'];
        }
    }

    protected function abrirCerrarCaja($caja_id, $estado)
    {
        DB::beginTransaction();
        $caja = Caja::find($caja_id);
        if ($estado == 2) {
            $caja->estado_id = 1;
        } else {
            $caja->estado_id = 2;
        }
        if ($caja->save()) {
            DB::commit();
            return true;
        } else {
            DB::rollBack();
            return false;
        }
    }
}

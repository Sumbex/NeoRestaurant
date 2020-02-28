<?php

namespace App;

use Carbon\Carbon;
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
            DB::beginTransaction();
            $con = 0;
            for ($i = 0; $i < $request->cantMesa; $i++) {
                $mesas = new Mesas;
                $mesas->mesa = $i + 1;
                $mesas->sucursal_id = $request->sucursal;
                $mesas->zona_id = $request->zona;
                $mesas->creada_por = Auth::user()->id;
                $mesas->estado_id = 1;
                $mesas->activo = 'S';
                if ($mesas->save()) {
                    $con = $con + 1;
                }
            }
            /* dd($con = $request->cantMesa); */
            if ($con = $request->cantMesa) {
                DB::commit();
                return ['estado' => 'success', 'mensaje' => 'Mesas creadas Correctamente.'];
            } else {
                DB::rollBack();
                return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente o pruebe creando las mesas individualmente.'];
            }
        }
    }

    protected function traerMesas()
    {
        $mesas = DB::table('mesas as m')
            ->select([
                'm.id',
                'm.mesa',
                'm.estado_id',
                's.sucursal',
                'z.zona',
                'u.nombre',
                'm.created_at'
            ])
            ->join('users as u', 'u.id', 'm.creada_por')
            ->join('sucursal as s', 's.id', 'm.sucursal_id')
            ->join('zonas as z', 'z.id', 'm.zona_id')
            ->where([
                'm.activo' => 'S'
            ])
            ->orderBy('m.created_at', 'desc')
            ->get();

        if (!$mesas->isEmpty()) {
            Carbon::setLocale('es');
            foreach ($mesas as $key) {
                $fecha = ucwords(Carbon::parse($key->created_at)->diffForHumans());
                $key->created_at = $fecha;
            }
            return ['estado' => 'success', 'mesas' => $mesas];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran sucursales creadas.'];
        }
    }

    protected function traerMesasSucursal($id)
    {
        $mesas = DB::table('mesas as m')
            ->select([
                'm.id',
                'm.mesa',
                'm.zona_id',
                'z.zona',
                'm.estado_id'
            ])
            ->join('zonas as z', 'z.id', 'm.zona_id')
            ->where([
                'm.activo' => 'S',
                'm.sucursal_id' => $id
            ])
            ->orderBy('m.id', 'asc')
            ->get();
        if (!$mesas->isEmpty()) {
            $return = [];
            $zona = [];
            foreach ($mesas as $key) {
                $return[$key->zona][] = $key;
                $zona[] = $key->zona;
            }
            $zonas = array_values(array_unique($zona));
            return ['estado' => 'success', 'mesas' => $return, 'zonas' => $zonas];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran sucursales creadas.'];
        }
    }

    protected function abrirCerrarMesa($request)
    {
        /* dd($request->all()); */
        $mesa = Mesas::find($request->mesa);
        if ($request->estado == 2) {
            $mesa->estado_id = 1;
        } else {
            $mesa->estado_id = 2;
        }
        if ($mesa->save()) {
            return ['estado' => 'success', 'mensaje' => 'Mesa Abierta Correctamente.'];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente o pruebe creando las mesas individualmente.'];
        }
    }
}

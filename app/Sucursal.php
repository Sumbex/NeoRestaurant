<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Sucursal extends Model
{
    protected $table = "sucursal";

    protected function ingresarSucursal($request)
    {
        DB::beginTransaction();
        $sucursal = new Sucursal;
        $sucursal->sucursal = $request->sucursal;
        $sucursal->direccion = $request->direccion;
        $sucursal->observacion = $request->observacion;
        $sucursal->creada_por = Auth::user()->id;
        $sucursal->estado_id = 1;
        $sucursal->activo = 'S';
        if ($sucursal->save()) {
            $almacen = Almacen::crearAlmacen($sucursal->id);
            if ($almacen == true) {
                DB::commit();
                return ['estado' => 'success', 'mensaje' => 'Sucursal creada Correctamente.'];
            } else {
                DB::rollBack();
                return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
            }
        } else {
            DB::rollBack();
            return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
        }
    }

    protected function traerSucursales()
    {
        $sucursales = DB::table('sucursal as s')
            ->select([
                's.id',
                's.sucursal',
                's.direccion',
                's.observacion',
                'u.nombre',
                's.estado_id',
                's.created_at'
            ])
            ->join('users as u', 'u.id', 's.creada_por')
            ->where([
                's.activo' => 'S'
            ])
            ->orderBy('s.created_at', 'desc')
            ->get();
        if (!$sucursales->isEmpty()) {
            Carbon::setLocale('es');
            foreach ($sucursales as $key) {
                $fecha = ucwords(Carbon::parse($key->created_at)->diffForHumans());
                $key->created_at = $fecha;
            }
            return ['estado' => 'success', 'sucursales' => $sucursales];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran sucursales creadas.'];
        }
    }
}

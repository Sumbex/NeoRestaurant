<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    protected $table = "proveedores";

    protected function ingresarProveedor($request)
    {
        $proveedor = new Proveedores;
        $proveedor->rut = $request->rut;
        $proveedor->razon_social = $request->razon;
        $proveedor->direccion = $request->direccion;
        $proveedor->pagina = $request->pagina;
        $proveedor->contacto = $request->contacto;
        $proveedor->fono = $request->fono;
        $proveedor->correo = $request->correo;
        $proveedor->creada_por = Auth::user()->id;
        $proveedor->estado_id = 1;
        $proveedor->activo = 'S';
        if ($proveedor->save()) {
            return ['estado' => 'success', 'mensaje' => 'Proveedor creado Correctamente.'];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
        }
    }

    protected function traerProveedores()
    {
        $proveedores = DB::table('proveedores as p')
            ->select([
                'p.id',
                'p.rut',
                'p.razon_social as razon',
                'p.direccion',
                'p.pagina',
                'p.contacto',
                'p.fono',
                'p.correo',
                'u.nombre',
                'p.created_at'
            ])
            ->join('users as u', 'u.id', 'p.creada_por')
            ->where([
                'p.activo' => 'S'
            ])
            ->orderBy('p.created_at', 'desc')
            ->get();

        if (!$proveedores->isEmpty()) {
            Carbon::setLocale('es');
            foreach ($proveedores as $key) {
                $fecha = ucwords(Carbon::parse($key->created_at)->diffForHumans());
                $key->created_at = $fecha;
            }
            return ['estado' => 'success', 'proveedores' => $proveedores];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran proveedores creados.'];
        }
    }
}

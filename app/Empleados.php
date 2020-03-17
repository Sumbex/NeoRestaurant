<?php

namespace App;

use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    protected $table = "empleados";

    protected function crearUsuario($request)
    {
        /* dd($request->all()); */
        DB::beginTransaction();
        $empleado = new Empleados;
        $empleado->sucursal_id = $request->sucursal;
        $empleado->rut = $request->rut;
        $empleado->nombres = $request->nombres;
        $empleado->apellidos = $request->apellidos;
        $empleado->direccion = $request->direccion;
        $empleado->correo = $request->correo;
        $empleado->creada_por = Auth::user()->id;
        $empleado->estado_id = 1;
        $empleado->activo = 'S';
        if ($empleado->save()) {
            $nombre = explode(" ", $request->nombres);
            $apellido = explode(" ", $request->apellidos);
            $usuario = User::crearUsuario($request->rut, $nombre[0] . ' ' . $apellido[0], $request->rol);
            if ($usuario == true) {
                DB::commit();
                return ['estado' => 'success', 'mensaje' => 'Empleado creado Correctamente.'];
            } else {
                DB::rollBack();
                return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
            }
        } else {
            DB::rollBack();
            return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
        }
    }

    protected function traerUsuarios($sucursal)
    {
        $users = DB::table('empleados as e')
            ->select([
                'e.id',
                'e.rut',
                'e.nombres',
                'e.apellidos',
                'e.direccion',
                'e.correo',
                'e.estado_id'
            ])
            ->where([
                'e.activo' => 'S',
                'e.sucursal_id' => $sucursal
            ])
            ->get();
        if (!$users->isEmpty()) {
            return ['estado' => 'success', 'users' => $users];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran usuarios registrados.'];
        }
    }

    protected function bloquearUser($request)
    {
        DB::beginTransaction();
        $empleado = Empleados::find($request->sucursal, $request->id);
        if (!is_null($empleado)) {
            $empleado->estado_id = 2;
            if ($empleado->save()) {
                DB::commit();
                return ['estado' => 'success', 'mensaje' => 'Empleado bloqueado Correctamente.'];
            } else {
                DB::rollBack();
                return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
            }
        } else {
            return ['estado' => 'failed', 'mensaje' => 'Empleado no encontrado.'];
        }
    }
}

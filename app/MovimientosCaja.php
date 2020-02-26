<?php

namespace App;

use App\Caja;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class MovimientosCaja extends Model
{
    protected $table = "movimientos_caja";

    protected function fechaActual()
    {
        $hora = DB::select("select now() as fecha");
        return $hora[0]->fecha;
    }

    protected function abrirCerrarCaja($request)
    {
        $fecha = $this->fechaActual();
        if ($request->estado == 2) {
            DB::beginTransaction();
            $caja = new MovimientosCaja;
            $caja->caja_id = $request->caja;
            $caja->fecha_inicio = $fecha;
            $caja->monto_inicio = $request->monto;
            $caja->creada_por = Auth::user()->id;
            $caja->estado_id = 1;
            $caja->activo = 'S';
            if ($caja->save()) {
                $estadoCaja = Caja::abrirCerrarCaja($caja->caja_id, $request->estado);
                if ($estadoCaja == true) {
                    DB::commit();
                    return ['estado' => 'success', 'mensaje' => 'Caja Abierta Correctamente.'];
                } else {
                    DB::rollBack();
                    return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
                }
            } else {
                DB::rollBack();
                return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
            }
        } else {
            DB::beginTransaction();
            $movimiento = MovimientosCaja::where([
                'activo' => 'S'
            ])
                ->latest('id')->first();

            $movimiento->fecha_cierre = $fecha;
            $movimiento->monto_cierre = $request->monto;
            $movimiento->creada_por = Auth::user()->id;
            $movimiento->estado_id = 1;
            $movimiento->activo = 'S';
            if ($movimiento->save()) {
                $estadoCaja = Caja::abrirCerrarCaja($movimiento->caja_id, $request->estado);
                if ($estadoCaja == true) {
                    DB::commit();
                    return ['estado' => 'success', 'mensaje' => 'Caja Cerrada Correctamente.'];
                } else {
                    DB::rollBack();
                    return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
                }
            } else {
                DB::rollBack();
                return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
            }
        }
    }
}

<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Insumos extends Model
{
    protected $table = "insumos";

    protected function ingresarInsumo($request)
    {
        $insumo = new Insumos;
        $insumo->insumo = $request->insumo;
        $insumo->unidad_id = $request->unidad;
        $insumo->categoria_id = $request->categoria;
        $insumo->medida_id = $request->medida;
        $insumo->cantidad = $request->cantidad;
        $insumo->stock_minimo = $request->stock;
        $insumo->precio_compra = $request->precio;
        $insumo->creada_por = Auth::user()->id;
        $insumo->estado_id = 1;
        $insumo->activo = 'S';
        if ($insumo->save()) {
            return ['estado' => 'success', 'mensaje' => 'Insumo creada Correctamente.'];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
        }
    }

    protected function traerInsumos()
    {
        $insumos = DB::table('insumos as i')
            ->select([
                'i.id',
                'i.insumo',
                'i.unidad_id as unidad',
                'ci.insumo as categoria',
                'i.medida_id as medida',
                'i.cantidad',
                'u.nombre',
                'i.created_at'
            ])
            ->join('users as u', 'u.id', 'i.creada_por')
            ->join('categoria_insumos as ci', 'ci.id', 'i.categoria_id')
            ->where([
                'i.activo' => 'S'
            ])
            ->orderBy('i.created_at', 'desc')
            ->get();

        if (!$insumos->isEmpty()) {
            Carbon::setLocale('es');
            foreach ($insumos as $key) {
                $fecha = ucwords(Carbon::parse($key->created_at)->diffForHumans());
                $key->created_at = $fecha;
            }
            return ['estado' => 'success', 'insumos' => $insumos];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran sucursales creadas.'];
        }
    }
}

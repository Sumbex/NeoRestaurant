<?php

namespace App;

use App\DetalleAlmacen;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CompraDetalleAlmacen extends Model
{
    protected $table = "compra_detalle_almacen";

    protected function registrarCompra($request)
    {
        //falta funcion guardar archivo
        dd($request->all());
        $carro = json_decode($request->carro, true);
        $almacenes = explode(",", $request->almacenes);
        $count = 0;
        foreach ($almacenes as $key) {
            DB::beginTransaction();
            $compra = new CompraDetalleAlmacen;
            $compra->almacen_id = $key;
            $compra->proveedor_id = $request->proveedor;
            $compra->numero_comprobante = $request->comprobante;
            $compra->archivo = $request->comprobante;
            $compra->total = $request->total;
            if ($compra->save()) {
                $ingresarDetalle = DetalleAlmacen::ingresarDetalleAlmacen($carro, $compra->id);
                if ($ingresarDetalle == true) {
                    DB::commit();
                    $count++;
                } else {
                    DB::rollBack();
                }
            }
        }

        if (count($almacenes) == $count) {
            return ['estado' => 'success', 'mensaje' => 'Compra registrada Correctamente.'];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'A ocurrido un error, intenta nuevamente.'];
        }
    }

    protected function traerCompras($anio, $mes/* , $sucursal_id */)
    {
        $compras = DB::table('compra_detalle_almacen as cda')
            ->select([
                'cda.id',
                'cda.numero_comprobante as comprobante',
                'cda.archivo',
                'cda.total'
            ])
            ->where([
                'cda.activo' => 'S',
                'cda.anio_id' => $anio,
                'cda.mes_id' => $mes
            ])
            ->get();
        if (!$compras->isEmpty()) {
            return ['estado' => 'success', 'compras' => $compras];
        } else {
            return ['estado' => 'failed', 'mensaje' => 'No se encuentran compras registradas.'];
        }
    }
}

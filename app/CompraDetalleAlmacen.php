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
}

<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CompraDetalleAlmacen extends Model
{
    protected $table = "compra_detalle_almacen";

    protected function registrarCompra($request)
    {
        $carro = json_decode($request->carro, true);
        dd($carro);
        dd($request->all());
        $almacenes = explode(",", $request->almacenes);
        foreach ($almacenes as $key) {
            DB::beginTransaction();
            $compra = new CompraDetalleAlmacen;
            $compra->almacen_id = $key;
            $compra->proveedor_id = $request->proveedor;
            $compra->numero_comprobante = $request->comprobante;
            $compra->archivo = $request->comprobante;
            $compra->total = $request->total;
        }
    }
}

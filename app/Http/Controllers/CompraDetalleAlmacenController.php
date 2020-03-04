<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CompraDetalleAlmacen;
use App\CantidadInsumosAlmacen;

class CompraDetalleAlmacenController extends Controller
{
    public function RegistrarCompra(Request $request)
    {
        return CompraDetalleAlmacen::registrarCompra($request);
    }

    public function TraerCompras($anio, $mes, $sucursal_id)
    {
        return CompraDetalleAlmacen::traerCompras($anio, $mes, $sucursal_id);
    }

    public function TraerDetalleCompra($compra_id)
    {
        return CompraDetalleAlmacen::traerDetalleCompra($compra_id);
    }

    public function VerificarStockProducto(Request $request)
    {
        return CantidadInsumosAlmacen::verificarStockProducto($request);
    }
}

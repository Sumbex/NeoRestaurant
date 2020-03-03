<?php

namespace App\Http\Controllers;

use App\CompraDetalleAlmacen;
use Illuminate\Http\Request;

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

    public function VerificarStockProducto($sucursal, $produto)
    {
        return CompraDetalleAlmacen::verificarStockProducto($sucursal, $produto);
    }
}

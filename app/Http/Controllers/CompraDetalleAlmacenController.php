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
}

<?php

namespace App\Http\Controllers;

use App\DetalleAlmacen;
use Illuminate\Http\Request;

class DetalleAlmacenController extends Controller
{
    public function TraerAlmacenes()
    {
        return DetalleAlmacen::traerAlmacenes();
    }

    public function TraerInsumos()
    {
        return DetalleAlmacen::traerInsumos();
    }

    public function TraerProveedores()
    {
        return DetalleAlmacen::traerProveedores();
    }
}
